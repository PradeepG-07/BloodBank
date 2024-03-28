<?php
    session_start();
    if(!isset($_SESSION) || $_SESSION['role']=='receiver'){
        session_unset();
        session_destroy();
        header("location:/BloodBank/index.php?page=login_as_hospital");
        exit();
    }
    include "server.php";
    if(isset($_POST['add_blood_info'])){
        if(!isset($_POST['blood_type'])||!isset($_POST['quantity'])){
            echo "Parameters missing. <br>";
            echo "<a href='/BloodBank/hospitals/index.php?page=blood_info'> Go Back</a>";
        }
        else{
            $blood_type=mysqli_real_escape_string($conn,$_POST['blood_type']);
            $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
            $user_id=mysqli_real_escape_string($conn,$_SESSION['user_id']);
            $hospital_id_query="SELECT hospital_id from hospitals WHERE user_id='$user_id'";
            $result=mysqli_query($conn,$hospital_id_query);
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    $hospital_id=$row['hospital_id'];
                }
                $available_check_query="SELECT * from bloodsamples WHERE hospital_id='$hospital_id' AND blood_type='$blood_type'";
                $result=mysqli_query($conn,$available_check_query);
                if($result){
                    if(mysqli_num_rows($result)==1){
                        $add_info_query="UPDATE bloodsamples SET quantity='$quantity' WHERE hospital_id='$hospital_id' AND blood_type='$blood_type'";
                        $result=mysqli_query($conn,$add_info_query);
                        if($result){
                            header("location: /BloodBank/hospitals/index.php?page=blood_info");
                        }
                        else{
                            echo "Error occurred. <br>";
                            echo "<a href='/BloodBank/hospitals/index.php?page=blood_info'>Please try again.</a>";
                        }
                    }
                    else{
                        $add_info_query="INSERT INTO bloodsamples(hospital_id,blood_type,quantity) values('$hospital_id','$blood_type','$quantity')";
                        $result=mysqli_query($conn,$add_info_query);
                        if($result){
                            header("location: /BloodBank/hospitals/index.php?page=blood_info");
                        }
                        else{
                            echo "Error occurred. <br>";
                            echo "<a href='/BloodBank/hospitals/index.php?page=blood_info'>Please try again.</a>";
                        }
                    }
                }else{
                    echo "Error occurred. <br>";
                    echo "<a href='/BloodBank/hospitals/index.php?page=blood_info'>Please try again.</a>";
                }
                
            }
            else{
                echo "Error occurred. <br>";
                echo "<a href='/BloodBank/hospitals/index.php?page=blood_info'>Please try again.</a>";
            }
        }
    }

?>