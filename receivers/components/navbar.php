<?php
if(!defined('attached_with_index')){
  header("location: /index.php");
}
 if(!isset($_SESSION) || !$_SESSION['role']=="receiver"){
  header("location:/BloodBank/index.php?page=login_as_receiver"); 
}
?>
<nav id="navbar" class="navbar navbar-expand-lg bg-body-tertiary bg-dark navbar-dark sticky-top" data-bs-theme="dark">
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
                <a class="nav-link links" href="/BloodBank/receivers/index.php">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link links" href="/BloodBank/receivers/index.php?page=requests">Requests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link links" href="/BloodBank/index.php?page=available_samples">Make request</a>
            </li>
        </ul>
        <ul class="nav nav-pills sm-d-flex justify-content-center lg-d-block gap-2">
            <li class="nav-item dropdown dropdown-center">
                <a class="nav-link dropdown-toggle text-truncate" style="max-width: 250px" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Logged in as: <i ><?php echo $_SESSION['fullname']?></i>
                </a>
                <ul class="dropdown-menu" style="max-width: 250px">
                  <li><a class="dropdown-item" href="?page=profile">Profile</a></li>
                  <hr class="m-2">
                  <li><a class="dropdown-item" href="?page=logout">Logout</a></li>
                </ul>
            </li>
            
        </ul>
      </div>
    </div>
  </nav>
