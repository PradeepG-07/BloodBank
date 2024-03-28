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


    // Register as Receiver
    if(isset($_POST['signup_as_receiver'])){

        if (!isset($_POST['username'])) { array_push($errors, "Username is required."); }
        if (!isset($_POST['email'])) { array_push($errors, "Email is required."); }
        if (!isset($_POST['password'])) { array_push($errors, "Password is required."); }
        if (!isset($_POST['confirm_password'])) { array_push($errors, "Confirm Password is required."); }
        if (!isset($_POST['blood_group'])) { array_push($errors, "Blood Group is required."); }
        if (!isset($_POST['fullname'])) { array_push($errors, "Full name is required."); }
        if (!isset($_POST['address'])) { array_push($errors, "Address is required."); }
        if (!isset($_POST['contact_number'])) { array_push($errors, "Contact Number is required."); }


       // receive all input values from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
        $role="receiver";
        $fullname=mysqli_real_escape_string($conn, $_POST['fullname']);
        $address=mysqli_real_escape_string($conn, $_POST['address']);
        $contact_number=mysqli_real_escape_string($conn, $_POST['contact_number']);


        // Form Validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error into $errors array
        if (empty($username)) { array_push($errors, "Username is required."); }
        if (empty($email)) { array_push($errors, "Email is required."); }
        if (empty($password_1)) { array_push($errors, "Password is required."); }
        if (empty($password_2)) { array_push($errors, "Confirm Password is required."); }
        if (empty($blood_group)) { array_push($errors, "Blood Group is required."); }
        if (empty($fullname)) { array_push($errors, "Full name is required."); }
        if (empty($address)) { array_push($errors, "Address is required."); }
        if (empty($contact_number)) { array_push($errors, "Contact Number is required."); }
        if ($password_1 != $password_2) {
            array_push($errors, "The passwords do not match");
        }
        if(!preg_match("/^[6-9][0-9]{9}$/",$contact_number)){
            array_push($errors,"Invalid Contact Number");
        }
        $valid_blood_group=array("A+","B+","O+","AB+","A-","B-","O-","AB-");
        if(!in_array($blood_group, $valid_blood_group)){
            array_push($errors,"Invalid Blood Group");
        }

        // If errors not exists in the received input data continue with signup of user.
        if(!count($errors)>0){
           
            // first check the database to make sure
            // a user does not already exist with the same username and/or email
            $receiver_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
            $result = mysqli_query($conn, $receiver_check_query);
            $receiver = mysqli_fetch_assoc($result);

            if ($receiver) { // if user exists
                if ($receiver['username'] === $username) {
                array_push($errors, "Username already exists.");
                }

                if ($receiver['email'] === $email) {
                array_push($errors, "Email already exists.");
                }
            }
            else{ //Registering the receiver
                $secured_password=password_hash($password_1,PASSWORD_BCRYPT);
                mysqli_query($conn,"START TRANSACTION");
                $user_insert_query="INSERT INTO users(username,email,password,role) values ('$username','$email','$secured_password','$role')";
                $result=mysqli_query($conn,$user_insert_query);
                if(!$result){
                    $result=mysqli_query($conn,"ROLLBACK");
                    while(!$result){
                        $result=mysqli_query($conn,"ROLLBACK");
                    }
                    die("Failed to signup");
                }
                $get_user_id_query="SELECT user_id from users WHERE username='$username'";
                $user_id=mysqli_query($conn,$get_user_id_query);
                $user_id=mysqli_fetch_assoc($user_id)['user_id'];
                if(!$user_id){
                    $result=mysqli_query($conn,"ROLLBACK");
                    while(!$result){
                        $result=mysqli_query($conn,"ROLLBACK");
                    }
                    die("Failed to signup");
                }
                $receiver_insert_query="INSERT INTO receivers(user_id,blood_group,fullname,address,contact_number) values ('$user_id','$blood_group','$fullname','$address','$contact_number')";
                $result=mysqli_query($conn, $receiver_insert_query);
                if($result){
                    $result=mysqli_query($conn,"COMMIT");
                    array_push($success,"Account Created Successfully. Please Login to Continue");

                }
                else{
                    $result=mysqli_query($conn,"ROLLBACK");
                    while(!$result){
                        $result=mysqli_query($conn,"ROLLBACK");
                    }
                    array_push($errors,"Failed to signup. Please try again.");
                }
            }  
        }
    }

    // Register Hospital
    if(isset($_POST['signup_as_hospital'])){
        if (!isset($_POST['username'])) { array_push($errors, "Username is required."); }
        if (!isset($_POST['email'])) { array_push($errors, "Email is required."); }
        if (!isset($_POST['password'])) { array_push($errors, "Password is required."); }
        if (!isset($_POST['confirm_password'])) { array_push($errors, "Confirm Password is required."); }
        if (!isset($_POST['hospital_name'])) { array_push($errors, "Hospital name is required."); }
        if (!isset($_POST['address'])) { array_push($errors, "Address is required."); }
        if (!isset($_POST['contact_number'])) { array_push($errors, "Contact Number is required."); }

        // receive all input values from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_1 = mysqli_real_escape_string($conn, $_POST['password']);
        $password_2 = mysqli_real_escape_string($conn, $_POST['confirm_password']);
        $role="hospital";
        $hospital_name=mysqli_real_escape_string($conn, $_POST['hospital_name']);
        $address=mysqli_real_escape_string($conn, $_POST['address']);
        $contact_number=mysqli_real_escape_string($conn, $_POST['contact_number']);


        // Form Validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error into $errors array
        if (empty($username)) { array_push($errors, "Username is required."); }
        if (empty($email)) { array_push($errors, "Email is required."); }
        if (empty($password_1)) { array_push($errors, "Password is required."); }
        if (empty($password_2)) { array_push($errors, "Confirm Password is required."); }
        if (empty($hospital_name)) { array_push($errors, "Hospital name is required."); }
        if (empty($address)) { array_push($errors, "Address is required."); }
        if (empty($contact_number)) { array_push($errors, "Contact Number is required."); }
        if ($password_1 != $password_2) {
            array_push($errors, "The passwords do not match");
        }
        if(!preg_match("/^[6-9][0-9]{9}$/",$contact_number)){
            array_push($errors,"Invalid Contact Number");
        }

        // If errors not exists in the received input data continue with signup of user.
        if(!count($errors)>0){
           
            // first check the database to make sure
            // a user does not already exist with the same username and/or email
            $hospital_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
            $result = mysqli_query($conn, $hospital_check_query);
            $hospital = mysqli_fetch_assoc($result);

            if ($hospital) { // if hospital exists
                if ($hospital['username'] === $username) {
                array_push($errors, "Username already exists.");
                }

                if ($hospital['email'] === $email) {
                array_push($errors, "Email already exists.");
                }
            }
            else{ //Registering the hospital
                $secured_password=password_hash($password_1,PASSWORD_BCRYPT);
                mysqli_query($conn,"START TRANSACTION");
                $user_insert_query="INSERT INTO users(username,email,password,role) values ('$username','$email','$secured_password','$role')";
                $result=mysqli_query($conn,$user_insert_query);
                if(!$result){
                    $result=mysqli_query($conn,"ROLLBACK");
                    while(!$result){
                        $result=mysqli_query($conn,"ROLLBACK");
                    }
                    die("Failed to signup");
                }
                $get_user_id_query="SELECT user_id from users WHERE username='$username'";
                $user_id=mysqli_query($conn,$get_user_id_query);
                $user_id=mysqli_fetch_assoc($user_id)['user_id'];
                if(!$user_id){
                    $result=mysqli_query($conn,"ROLLBACK");
                    while(!$result){
                        $result=mysqli_query($conn,"ROLLBACK");
                    }
                    die("Failed to signup");
                }
                $hospital_insert_query="INSERT INTO hospitals(user_id,hospital_name,address,contact_number) values ('$user_id','$hospital_name','$address','$contact_number')";
                $result=mysqli_query($conn, $hospital_insert_query);
                if($result){
                    $result=mysqli_query($conn,"COMMIT");
                    array_push($success,"Account Created Successfully. Please Login to Continue");
                }
                else{
                    $result=mysqli_query($conn,"ROLLBACK");
                    while(!$result){
                        $result=mysqli_query($conn,"ROLLBACK");
                    }
                    array_push($errors,"Failed to signup. Please try again.");
                }
            }  
        }
    }
    

    else if(isset($_POST['login_as_receiver'])){
        if(!isset($_POST['username']) || !isset($_POST['password'])){
            array_push($errors,"Failed to signup. Credentails Missing");
            die("Failed to signup. Credentails Missing");
        }
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        if(empty($username) || empty($password)){
            array_push($errors,"Invalid Credentials!!");
        }
        else{
             $query="SELECT * FROM users WHERE username='$username'";
             $result=mysqli_query($conn,$query);
             if(mysqli_num_rows($result)==1){
                 $user = mysqli_fetch_assoc($result);
                 $is_password_matched=password_verify($password,$user['password']);
                 if(!$is_password_matched || $user['role']=='hospital'){
                    array_push($errors,"Invalid Credentials!!");
                }
                else{
                    $user_id=$user['user_id'];
                    $query="SELECT * FROM receivers WHERE user_id='$user_id'";
                    $result=mysqli_query($conn,$query);
                    if(!$result){
                        array_push($errors,"Failed to fetch personal data. Please try again to login.");
                        die("Failed to fetch personal data");
                    }
                    $receiver_info = mysqli_fetch_assoc($result);
                    session_start();
                    $_SESSION['loggedin']=true;
                    $_SESSION['role']="receiver";
                    $_SESSION['username']=$user['username'];
                    $_SESSION['user_id']=$user_id;
                    $_SESSION['fullname']=$receiver_info['fullname'];
                    $_SESSION['receiver_id']=$receiver_info['receiver_id'];
                    $_SESSION['address']=$receiver_info['address'];
                    $_SESSION['contact_number']=$receiver_info['contact_number'];
                    header("location:/BloodBank/receivers/index.php");
                }
             }
             else
             { 
                array_push($errors,"Invalid Credentials!!");
             }
         }
     }
    else if(isset($_POST['login_as_hospital'])){
        if(!isset($_POST['username']) || !isset($_POST['password'])){
            array_push($errors,"Failed to signup. Credentails Missing");
            die("Failed to signup. Credentails Missing");
        }
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $password=mysqli_real_escape_string($conn,$_POST['password']);
        if(empty($username) || empty($password)){
            array_push($errors,"Invalid Credentials!!");
        }
        else{
             $query="SELECT * FROM users WHERE username='$username'";
             $result=mysqli_query($conn,$query);
             if(mysqli_num_rows($result)==1){
                 $user = mysqli_fetch_assoc($result);
                 $is_password_matched=password_verify($password,$user['password']);
                 if(!$is_password_matched || $user['role']=='receiver'){
                    array_push($errors,"Invalid Credentials!!");
                }
                else{
                    $user_id=$user['user_id'];
                    $query="SELECT * FROM hospitals WHERE user_id='$user_id'";
                    $result=mysqli_query($conn,$query);
                    if(!$result){
                        array_push($errors,"Failed to fetch personal data. Please try again to login.");
                    }
                    else{
                        $hospital_info = mysqli_fetch_assoc($result);
                        session_start();
                        $_SESSION['loggedin']=true;
                        $_SESSION['role']="hospital";
                        $_SESSION['username']=$user['username'];
                        $_SESSION['user_id']=$user_id;
                        $_SESSION['hospital_name']=$hospital_info['hospital_name'];
                        $_SESSION['hospital_id']=$hospital_info['hospital_id'];
                        $_SESSION['address']=$hospital_info['address'];
                        $_SESSION['contact_number']=$hospital_info['contact_number'];
                        header("location:/BloodBank/hospitals/index.php");
                    }
                }
             }
             else
             { 
                array_push($errors,"Invalid Credentials!!");
             }
         }
     }

?>
