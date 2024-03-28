<?php
    session_start();
    define('attached_with_index',true);
    if(!isset($_SESSION) || !$_SESSION['loggedin'] ){
        header("location: /BloodBank/index.php?page=login_as_receiver");
    }
    else{
        if($_SESSION['role']!="receiver"){
            echo "You are not allowed to request a sample.";
            echo "<a href='/BloodBank/index.php?page=available_samples'> Go Back</a>";
            exit();
        }
    } 
?>

<?php
    if(!isset($_GET['sample_id'])){
        echo "Invalid sample id.";
        echo "<a href='/BloodBank/index.php?page=available_samples'> Go Back</a>";
        exit();
    }
    
    include '../database/server.php';
    $sample_id=mysqli_real_escape_string($conn,$_GET['sample_id']);
    $blood_samples_array=array();
    $bloodsamples_check_query="SELECT * from bloodsamples WHERE sample_id='$sample_id'";
    $bloodsamples_result=mysqli_query($conn,$bloodsamples_check_query);
    if(!$bloodsamples_result || mysqli_num_rows($bloodsamples_result)==0){
        echo "Invalid sample id.";
        echo "<a href='/BloodBank/index.php?page=available_samples'> Go Back</a>";
        exit();
    }
    while($row = mysqli_fetch_assoc($bloodsamples_result)){
        $curr_sample_id=$row['sample_id'];
        $hospital_name_query="SELECT hospital_name,contact_number from hospitals WHERE hospital_id IN (SELECT hospital_id from bloodsamples WHERE sample_id='$curr_sample_id')";
        $hospital_name_result=mysqli_query($conn,$hospital_name_query);
        while($row1 = mysqli_fetch_assoc($hospital_name_result)){
            $hospital_name=$row1['hospital_name'];
        }
        $blood_samples_array['blood_type']=$row['blood_type'];
        $blood_samples_array['avail_quantity']=$row['quantity'];
    }
?>

<?php
    if(isset($_POST["submit_request"])){
        if(isset($_POST["quantity"])){
            $quantity=mysqli_real_escape_string($conn,$_POST['quantity']);
            if($quantity>$blood_samples_array['avail_quantity']){
                array_push($errors,"Insufficient Blood Sample");
            }
            else{
                $receiver_id=$_SESSION['receiver_id'];
                $blood_type=$blood_samples_array['blood_type'];
                $request_query="INSERT INTO requests(receiver_id,sample_id,quantity,blood_type,status,message) values('$receiver_id','$sample_id','$quantity','$blood_type','pending','Requested.');";
                $result=mysqli_query($conn,$request_query);
                if($result){
                    array_push($success,"Successfully submitted the request");
                }
                else{
                    array_push($errors,"Failed to make a request. Please try again.");
                }
            }
        }
        else{
            array_push($errors,"Invalid quantity");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        *{
            font-family: Poppins;
        }
    </style>
</head>
<body>
    <?php  include "./navbar.php"; ?>
    <div class="container mt-4" style="min-height: 80vh;">
        <?php include '../database/errors.php'?>
        <?php include '../database/success.php'?>
    <h1 class="text-center text-success">Request Sample</h1>
    <form class="p-2 needs-validation" action="<?php echo $_SERVER['PHP_SELF']."?sample_id=$sample_id"; ?>" method="POST" autocomplete="on"  novalidate>
    <div class="mb-3">
      <label for="blood_type" class="form-label">Blood Group</label>
      <input type="text" class="form-control border border-dark" id="blood_type" name="blood_type" minlength="3" value="<?php echo $blood_samples_array['blood_type']; ?>" required disabled>
      <div class="valid-feedback">
        Looks good!
      </div>
      <div class="invalid-feedback">
        Please provide valid blood group
      </div>
    </div>
    <div class="mb-3">
      <label for="hospital_name" class="form-label">Hospital Name</label>
      <input type="text" class="form-control border border-dark" id="hospital_name" name="hospital_name" minlength="3" value="<?php echo $hospital_name ?>" required disabled>
      <div class="valid-feedback">
        Looks good!
      </div>
      <div class="invalid-feedback">
        Please provide valid blood group
      </div>
    </div>
    <div class="mb-3">
      <label for="avail_quantity" class="form-label">Available Quantity</label>
      <input type="number" class="form-control border border-dark" id="avail_quantity" name="avail_quantity" minlength="3" required value="<?php echo $blood_samples_array['avail_quantity']; ?>" disabled>
      <div class="valid-feedback">
        Looks good!
      </div>
      <div class="invalid-feedback">
        Please provide quantity
      </div>
    </div>
    <div class="mb-3">
      <label for="quantity" class="form-label">Required Quantity</label>
      <input type="number" class="form-control border border-dark" id="quantity" name="quantity" minlength="3" required>
      <div class="valid-feedback">
        Looks good!
      </div>
      <div class="invalid-feedback">
        Please provide quantity
      </div>
    </div>
    <button type="submit" class="btn btn-primary" id="submit_request" name="submit_request">Submit Request</button>
  </form>
  </div>
  <?php  include "./footer.html"; ?>
  
  <script>
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()   
  </script>
</body>