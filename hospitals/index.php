<?php 
    define('attached_with_index',true);
    session_start();
    if(!isset($_SESSION) || !$_SESSION['loggedin'] ){
        header("location: /BloodBank/index.php?page=login_as_hospital");
    }
    else{
        if($_SESSION['role']!="hospital"){
            header("location: /BloodBank/receivers/index.php");
        }
    }
    include "./database/server.php";
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
    <?php
        // NavBar
        include "./components/navbar.php";

        // Changing Pages according to Url param 'page'
        if(isset($_GET['page'])){
            // Sanitizing the 'page' param
            $page=htmlspecialchars($_GET['page']);
            if($page == "requests") {
               include "./components/requests.php";
            }
            else if($page == "logout") {
                include "./components/logout.php";
            }
            else if($page == "blood_info") {
                include "./components/blood_info.php";
            }
            else {
                echo "Error page";
            }
        }
        else{
            include "./components/dashboard.php";
        }

        include "./components/footer.html"; 
    ?>
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
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const navlinks = document.querySelectorAll('.links');
        const urlParams = new URLSearchParams(window.location.search);
        const page= urlParams.get('page');
        console.log(page);
        // Loop over them and prevent submission
        if(page){
            Array.from(navlinks).forEach(link => {
              if(link.innerText.toLowerCase()===page.toLowerCase()){
                link.classList.add("active");
            }
            else{
                link.classList.remove("active");
              }
            })
        }
        else{
            navlinks[0].classList.add("active");
        }
    </script>
</body>
</html>