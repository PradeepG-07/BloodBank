<?php
    session_start();
    if(!isset($_SESSION) || $_SESSION['role']=='receiver'){
        session_unset();
        session_destroy();
        header("location:/BloodBank/index.php?page=login_as_hospital");
        exit();
    }
    include "server.php";
    if(isset($_GET['request_id']) && isset($_GET['quantity'])){
        $request_id=mysqli_real_escape_string($conn,$_GET['request_id']);
        $user_id_check_query="SELECT user_id from hospitals WHERE hospital_id IN (SELECT hospital_id from bloodsamples WHERE sample_id IN (SELECT sample_id from requests WHERE request_id='$request_id'))";
        $result=mysqli_query($conn,$user_id_check_query);
        if(!$result){
            echo "Failed to accept the request.<br>";
            echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Please try again</a>";
        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                $user_id=$row['user_id'];
            }
            if($user_id!=$_SESSION['user_id']){
                echo "Not Authorised to Accept the request.<br>";
                echo "<a href='/BloodBank/hospitals/index.php?page=requests'> Go Back</a>";
            }
            else{
                // Availability check query
                $availability_check_query="SELECT quantity from bloodsamples WHERE sample_id IN (SELECT sample_id from requests WHERE request_id='$request_id')";
                $result=mysqli_query($conn,$availability_check_query);
                if($result){
                    while($row = mysqli_fetch_assoc($result)){
                        $available=$row['quantity'];
                    }
                    if($available<mysqli_real_escape_string($conn,$_GET['quantity'])){
                        echo "Insufficient Quantity of Blood to fulfill the request.<br>";
                        echo "<a href='/BloodBank/hospitals/index.php?page=requests'> Go Back</a>";
                    }
                    else{
                        $remaining_quantity=$available-mysqli_real_escape_string($conn,$_GET['quantity']);
                        $update_accept_the_request_query="UPDATE requests SET status='approved', message='Accepted' WHERE request_id='$request_id';"."UPDATE bloodsamples SET quantity=$remaining_quantity WHERE sample_id IN (SELECT sample_id from requests WHERE request_id='$request_id')";
                        $result=mysqli_multi_query($conn,$update_accept_the_request_query);
                        if($result){
                            header("location:/BloodBank/hospitals/index.php?page=requests");
                        }
                        else{
                            echo "Failed to accept the Request.<br>";
                            echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Please try again</a>";
                        }
                    }
                }
                else{
                    echo "Availability check failed.<br>";
                    echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Please try again</a>";
                }
            }
        }
    }
    else{
        echo "Invalid request id or quantity.<br>";
        echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Go back</a>";
    }
?>