<?php 
$dbHost = "localhost";
$dbUser = "lucile17";
$dbPass = "lucile17";
$dbName = "lucile17";
$connect = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);// c'est la 
//fameuse clée de connexion à nos database
//sans elle rien ne se passe ... ^^

//$connect obtient un true si c'est connecté et un false sinon 
if(!$connect){
    die('Error, Connection Failed.');
}
//else on ne fait rien 
//donc pas besoin de mettre le else car ca ne serait pas pratique 
//voir explication en cahier de notes




