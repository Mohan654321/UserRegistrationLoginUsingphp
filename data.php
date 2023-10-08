<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "form";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Went wrong please check;");
}

?>