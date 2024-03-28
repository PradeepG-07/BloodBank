<?php
    if(!defined('attached_with_index')){
        header("location: /BloodBank/index.php");
    }
?>
<nav id="navbar-example2" class="navbar navbar-expand-lg bg-body-tertiary bg-dark navbar-dark sticky-top" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRuseoRQwX2ENQs-V17p1pAvNfq8VAv9Tbgag&usqp=CAU" alt="Logo" width="30" height="24"
                class="d-inline-block align-text-top">
            Blood Bank
        </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav m-auto mb-lg-0 mb-2 align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="/BloodBank/index.php/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/BloodBank/index.php/#About">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/BloodBank/index.php/?page=available_samples">Available Blood Samples</a>
            </li>
        </ul>
        <?php 
            if(!isset($_SESSION)){
              session_start();
            }
            if(isset($_SESSION) && isset($_SESSION['loggedin'])){
              if($_SESSION['role']=='receiver'){
                echo '<a class="nav-link text-light bg-primary p-2 rounded text-center" href="/BloodBank/receivers/index.php/">Go to Dashboard</a>';
              }
              else if($_SESSION['role']=='hospital'){
                echo '<a class="nav-link text-light bg-primary p-2 rounded text-center" href="/BloodBank/hospitals/index.php/">Go to Dashboard</a>';
              }
            }else {
        ?>
        <ul class="nav nav-pills sm-d-flex justify-content-center lg-d-block gap-2">
            <li class="nav-item dropdown dropdown-center">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Signup or Login
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="?page=signup_as_receiver">Signup as receiver</a></li>
                  <li><a class="dropdown-item" href="?page=signup_as_hospital">Signup as hospital</a></li>
                  <hr class="m-2">
                  <li><a class="dropdown-item" href="?page=login_as_receiver">Login as receiver</a></li>
                  <li><a class="dropdown-item" href="?page=login_as_hospital">Login as hospital</a></li>
                </ul>
            </li>
        </ul>
        <?php }?>
      </div>
    </div>
  </nav>
