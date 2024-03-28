<?php  
    if(!defined('attached_with_index')){
        header("location: /index.php");
    }
    if(!isset($_SESSION) || !$_SESSION['role']=="receiver"){
        header("location:/BloodBank/index.php?page=login_as_receiver"); 
    }
    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(!preg_match("/receivers\/index\.php/",$actual_link)){
        header("location:/BloodBank/receivers/index.php");
    }
    include "./database/server.php";
    
?>

<div class="container mt-4 d-flex flex-column justify-content-evenly" style="min-height: 80vh;min-height: 80dvh;">
    <h1 class="text-center">Welcome Back, <span class="text-info"><?php echo $_SESSION['fullname']?></span> </h1>
    <div class=" d-flex gap-4 flex-wrap justify-content-center">
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header text-center bg-primary">Number of Requests Made</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_made']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header bg-success text-center">Number of Requests Accepted</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_accepted']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header bg-warning text-center">Number of Requests Pending</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_pending']?></p>
            </div>
        </div>
        <div class="card text-bg-secondary mb-3 flex-grow-1" style="max-width: 18rem;">
            <div class="card-header bg-danger text-center">Number of Requests Rejected</div>
            <div class="card-body">
                <p class="card-text text-center"><?php echo $request_count_array['request_rejected']?></p>
            </div>
        </div>
    </div>
</div>