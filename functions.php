<?php 

include 'dashboard/connection.php';

function showAllPortfolios(){

    global $con;
    $sql = "SELECT * FROM portfolio";

    $result = mysqli_query($con, $sql);

    $projects = [];
    while($row = mysqli_fetch_assoc($result)){
        $projects[] = $row;
    }
    return $projects;


}

function showSettings(){

    global $con;
    $sql = "SELECT * FROM settings";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if(!$result){
        echo "Something is wrong, please try again later.";
    }else{
        return $row;
    }

}

function sendContactUs(){

    if(isset($_POST['submit'])){

        global $con;
        $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $message = mysqli_real_escape_string($con, $_POST['message']);
        
        $sql = "INSERT INTO contact (full_name, email, phone, message) VALUES ('$full_name', '$email', '$phone', '$message'); ";
        $result = mysqli_query($con, $sql);

        if(!$result){
            header("LOCATION: index.php?messageError");
        }else{
            header("LOCATION: index.php?messageSuccess");
        }
        
        }


}














