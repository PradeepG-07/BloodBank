<?php
    // For time being to complete the temporary assignment the sensitive content username and password are hard coded.
    // For efficient usage we have to use environment variables
    $server_name='localhost';
    $username='root';
    $password='';
    $db_name='bloodbank';
    $errors = array();
    $success = array();

    // Connecting to DataBase
    try {
        $conn=mysqli_connect($server_name,$username,$password,$db_name);
        if(!$conn){
            die("Connection Failed: ".mysqli_connect_error());
        }
    } catch (Exception $e) {
        echo "Server Error: ".$e->getMessage();
        exit();
    }

    if(isset($_SESSION)) 
    {   
        $user_id=$_SESSION['user_id'];

        $request_count_array=array("request_received"=>0,"request_fullfilled"=>0,"request_pending"=>0,"request_rejected"=>0);
        $requests_array=array();
        $users_array=array();
        $blood_samples_array=array();
       
        // Count Number of Blood Samples Available
        $bloodsamples_check_query="SELECT * from bloodsamples WHERE hospital_id IN (SELECT hospital_id from hospitals WHERE user_id='$user_id')";
        $bloodsamples_result=mysqli_query($conn,$bloodsamples_check_query);
        while($row = mysqli_fetch_assoc($bloodsamples_result)){
            $blood_samples_array[]=$row;
        }
        $request_count_array['available_blood_groups']=mysqli_num_rows($bloodsamples_result);
        
        $requests_check_query="SELECT * from requests WHERE sample_id IN (SELECT sample_id from bloodsamples WHERE hospital_id IN (SELECT hospital_id from hospitals WHERE user_id='$user_id'))";
        $requests=mysqli_query($conn,$requests_check_query);
        $request_count_array['request_received']=mysqli_num_rows($requests);

        while($row = mysqli_fetch_assoc($requests)){
            $requests_array[]=$row;
            $curr_receiver_id=$row['receiver_id'];
            $users_name_query="SELECT * from receivers WHERE receiver_id='$curr_receiver_id'";
            $users_name_result=mysqli_query($conn,$users_name_query);
            while($row1 = mysqli_fetch_assoc($users_name_result)){
                $users_array[]=$row1;
            }
            if($row['status']=="pending"){
                $request_count_array['request_pending']+=1;
            }
            else if($row['status']=="approved"){
                $request_count_array['request_fullfilled']+=1;
            }
            else{
                $request_count_array['request_rejected']+=1;
            }
        }
        
        $available_samples_array=array();
        $available_samples_query="SELECT * from bloodsamples WHERE hospital_id IN (SELECT hospital_id from hospitals WHERE user_id='$user_id')";
        $available_samples_result=mysqli_query($conn,$available_samples_query);
        while($row = mysqli_fetch_assoc($available_samples_result)){
            $sample_id=$row['sample_id'];
            $quantity=$row['quantity'];
            $available_samples_array[$sample_id]=$quantity;
        }
    } 

?>