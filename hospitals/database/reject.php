<?php
    session_start();
    if(!isset($_SESSION) || $_SESSION['role']=='receiver'){
        session_unset();
        session_destroy();
        header("location:/BloodBank/index.php?page=login_as_hospital");
        exit();
    }
    include "server.php";
    if(isset($_GET['request_id'])){
        $request_id=mysqli_real_escape_string($conn,$_GET['request_id']);
        $user_id_check_query="SELECT user_id from hospitals WHERE hospital_id IN (SELECT hospital_id from bloodsamples WHERE sample_id IN (SELECT sample_id from requests WHERE request_id='$request_id'))";
        $result=mysqli_query($conn,$user_id_check_query);
        if(!$result){
            echo "Failed to reject the request. <br>";
            echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Please try again.</a>";
        }
        else{
            while($row = mysqli_fetch_assoc($result)){
                $user_id=$row['user_id'];
            }
            if($user_id!=$_SESSION['user_id']){
                echo "Not Authorised to reject the request.<br>";
                echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Go back.</a>";
            }
            else{
                $update_reject_the_request_query="UPDATE requests SET status='rejected', message='Rejected' WHERE request_id='$request_id';"."UPDATE bloodsamples SET quantity='$remaining_quantity' WHERE sample_id IN (SELECT sample_id from requests WHERE request_id='$request_id'))";
                $result=mysqli_multi_query($conn,$update_reject_the_request_query);
                if($result){
                    echo "Request Rejected.<br>";
                    header("location:/BloodBank/hospitals/index.php?page=requests");
                }
                else{
                    echo "Failed to reject the request. <br>";
                    echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Please try again.</a>";
                }
            }
            }
    }
    else{
        echo "Invalid request id.<br>";
        echo "<a href='/BloodBank/hospitals/index.php?page=requests'>Please try again.</a>";
    }
?>