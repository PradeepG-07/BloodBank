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
        $query="SELECT * from requests WHERE receiver_id IN( SELECT receiver_id from receivers WHERE user_id='$user_id')";
        $requests=mysqli_query($conn,$query);
        $requests_array=array();
        $hospitals_array=array();
        $request_count_array=array("request_made"=>0,"request_accepted"=>0,"request_pending"=>0,"request_rejected"=>0);
        $request_count_array['request_made']=mysqli_num_rows($requests);
        while($row = mysqli_fetch_assoc($requests)){
            $requests_array[]=$row;
            $curr_sample_id=$row['sample_id'];
            $hospital_name_query="SELECT hospital_name from hospitals WHERE hospital_id IN (SELECT hospital_id from bloodsamples WHERE sample_id='$curr_sample_id')";
            $hospital_name_result=mysqli_query($conn,$hospital_name_query);
            while($row1 = mysqli_fetch_assoc($hospital_name_result)){
                $hospitals_array[]=$row1;
            }
            if($row['status']=="pending"){
                $request_count_array['request_pending']+=1;
            }
            else if($row['status']=="approved"){
                $request_count_array['request_accepted']+=1;
            }
            else{
                $request_count_array['request_rejected']+=1;
            }
        }
        
    } 
?>

    