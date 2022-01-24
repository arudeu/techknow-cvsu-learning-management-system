<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "techknowdb";
/*
$servername = "localhost";
$dbusername = "techgsih_aldouscnd";
$dbpassword = "9Lf5gaMsEr99HZDdm3JZkSjYbxJBBYxcNEW2ASqW";
$dbname = "techgsih_techknowdb";
*/
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if (!$conn)
{
  die("Connection failed: ".mysqli_connect_error()) ;
}

if(!isset($_SESSION))
{
    session_start();
}
