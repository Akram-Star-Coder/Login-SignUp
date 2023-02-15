<?php 
    require_once('userDatabase/database.php'); 
    include("registerScript.php");  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <!--Creation de la HERO de notre website Login&Register-->
        <nav>
            <ul>
                <li>
                    <a href="home.php">Home</a>
                </li>
                <li>
                    <a href="login.php">Login</a>
                </li>
                <li>
                    <a href="register.php">Register</a>
                </li>
            </ul>
        </nav>
    </header>