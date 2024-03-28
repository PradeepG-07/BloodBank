<?php  
    if(!defined('attached_with_index')){
        header("location: /index.php");
    }
    if(!isset($_SESSION) || !$_SESSION['role']=="hospital"){
        header("location:/BloodBank/index.php?page=login_as_hospital"); 
    }
     $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
     if(!preg_match("/hospitals\/index\.php/",$actual_link)){
      header("location:/BloodBank/hospitals/index.php/");
     }
    include "./database/server.php";
?>

<div class="container mt-4 d-flex flex-column justify-content-evenly" style="min-height: 80vh;min-height: 80dvh;">
    <h1 class="text-center">Welcome Back, <span class="text-info" style="white-space: nowrap;"><?php echo $_SESSION['hospital_name']?></span> </h1>
    <div class=" d-flex gap-4 flex-wrap justify-content-center">
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header text-center bg-primary">Available Blood Groups Count</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['available_blood_groups']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header text-center bg-primary">Requests Received Count</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_received']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header bg-success text-center">Requests Fullfilled Count</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_fullfilled']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header bg-warning text-center">Requests Pending Count</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_pending']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header bg-danger text-center">Requests Rejected Count</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_rejected']?></p>
            </div>
        </div>
    </div>
</div>