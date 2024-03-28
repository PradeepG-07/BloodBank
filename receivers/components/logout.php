<?php
    if(!defined('attached_with_index')){
        header("location: /index.php");
    }
    session_start();
    session_unset();
    session_destroy();
    header("location:/BloodBank/index.php?page=login_as_receiver"); 
?>