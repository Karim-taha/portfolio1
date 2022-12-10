<?php 

$dbHoost = "localhost";
$dbUser  = "u616252661_portfolio1proj";
$dbPassword  = "G^6eU7>a";
$dbName  = "u616252661_portfolio1";



// Connect to database :
$con = mysqli_connect($dbHoost, $dbUser, $dbPassword, $dbName);

// Check Connection :
if(!$con)
{
    die("QUERY FAILED");
}
