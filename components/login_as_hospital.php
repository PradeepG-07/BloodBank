<?php
    if(!defined('attached_with_index')){
        header("location: /BloodBank/index.php");
    }
    if(isset($_SESSION) && isset($_SESSION['loggedin'])){
        if( $_SESSION['role']=="receiver"){
            header("location:/BloodBank/receivers/index.php");
        } 
        else if( $_SESSION['role']=="hospital"){
            header("location:/BloodBank/hospitals/index.php");
        }
    }
?>

<div class="container mt-4 justify-content-center d-flex flex-column" style="min-height: 80vh;min-height: 80dvh;">
    <h1 class="text-center text-success">LOGIN AS HOSPITAL</h1>
    <?php
        include './database/errors.php';
        include './database/success.php';
    ?>
    <form class="p-2 needs-validation" action="<?php echo $_SERVER['PHP_SELF'].'?page=login_as_hospital'; ?>" method="POST" autocomplete="on"  novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control border border-dark" id="username" name="username" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please provide username
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control border border-dark" id="password" name="password" required>
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Please provide password
            </div>
        </div>
        <button type="submit" class="btn btn-primary" id="login_as_hospital" name="login_as_hospital">Login</button>
    </form>
</div>