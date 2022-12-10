<?php 
include 'connection.php';

function addNewUser(){
    if(isset($_POST['submit'])){

        global $con;
        global $errors;
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);


        $errors = [];
        if(empty($username)){
            $errors[] = "Username is required.";
        }if(empty($email)){
            $errors[] = "Email is required.";
        }if(empty($password)){
            $errors[] = "Password is required.";
        }


            if(empty($errors)){
                // Make the query :
                $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password');";
            
                // Send the data :
                $result = mysqli_query($con, $sql);
            
                // Check sending data :
                if($result){
                    echo "user created successfully";
                }
            }else{
                return $errors;
            }
    
    
    }
}


function login(){

    if(isset($_POST['submit'])){

        global $con;
        global $errors;
        // global $success;
        $errors = [];
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);


        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' ";
    
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        if(empty($row)){
            $errors[] = "Username or password is not correct";
            return $errors;
        }else{
            $_SESSION['user'] = $row;
            header("Location: home.php");

        }
        
    }


}

function addPortfolio(){
        
          if(isset($_POST['submit'])){
        
            global $con;
            global $errors;
            global $success;
        
          $name = mysqli_real_escape_string($con, $_POST['name']);
          $description = mysqli_real_escape_string($con, $_POST['description']);
          $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        
          $tmp = $_FILES['image']['tmp_name'];   // image = name that you gave it in the input
          $fileName = $_FILES['image']['name'];
          move_uploaded_file($tmp, "uploads/".$fileName);
        
        
          $errors = [];
          if(empty($name)){
              $errors[] = "Project name is required.";
            }if(empty($description)){
                $errors[] = "Description is required.";
            }if(empty($fileName)){
                $errors[] = "Must upload project image.";
            }
            
            if(!empty($errors)){
                return $errors;
            }else{
                $sql = "INSERT INTO portfolio (name, image, description, user_id) VALUES  ('$name',  '$fileName',  '$description', $user_id); ";
                $result = mysqli_query($con, $sql);
                
                if(!$result){
                    $errors[] = "Something went wrong";
                }else{
                  $success = [];
                  $success[] = "Project added successfully.";
                  return $success;
              }
          }
        
        
        
        }

}


function getUsernameWithPortfolio(){

    global $con;
    $sql = "SELECT username, name, image, description, p.id FROM users u , portfolio p WHERE u.id = p.user_id; ";

    $result = mysqli_query($con, $sql);

    $projects = [];
    while($row = mysqli_fetch_assoc($result)){
        $projects[] = $row;
    }
    return $projects;

}

function deletePortfolio(){
    if(isset($_GET['portfolio_id'])){

        global $con;
        global $deletePortolio;
        
        $portfolioId =  $_GET['portfolio_id'];

        $sql = "DELETE FROM portfolio WHERE id = $portfolioId; ";

        $result = mysqli_query($con, $sql);
        $deletePortolio = [];
        if($result){
            $_SESSION['deletePortfolio'] = "Porfolio deleted successfilly.";
            header("LOCATION: allportfolios.php?deleteMsg");
        }else{
            $_SESSION['deletePortfolio'] = "Porfolio not deleted.";
            header("LOCATION: allportfolios.php");
        }

    }else{
        header("LOCATION: allportfolios.php");
    }
}


function getPortfolioById($id){

    global $con;
    global $projects;
    $sql = "SELECT * FROM portfolio WHERE id = $id; ";

    $result = mysqli_query($con, $sql);

    $projects = [];
    $row = mysqli_fetch_assoc($result);
        $projects[] = $row;
    return $projects;

}


function updatePortfolio($id){
        
    
  
      global $con;
  
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
  
    $tmp = $_FILES['image']['tmp_name'];   // image = name that you gave it in the input
    $fileName = $_FILES['image']['name'];
    move_uploaded_file($tmp, "uploads/".$fileName);
  
  

          $sql = "UPDATE portfolio SET name = '$name', image = '$fileName', description = '$description', user_id = $user_id WHERE id = $id; ";
          $result = mysqli_query($con, $sql);
          
          if(!$result){
              echo "Something went wrong";die();
          }else{
            header("LOCATION: allportfolios.php?updateMsg");
        }

  }


function addSettings($avatarName, $job_title, $about, $cvName, $user_id){
    global $con;
    $sql = "INSERT INTO settings (avatar, job_title, about, cv, user_id) VALUES ('$avatarName', '$job_title', '$about', '$cvName', $user_id); ";
    $result = mysqli_query($con, $sql);

    if(!$result){
        header('LOCATION: settings.php?error');
    }else{
        header('LOCATION: settings.php?success');
    }

    
}

function getAllContactMessages(){

    global $con;
    global $messages;
    $sql = "SELECT * FROM contact";
    $result = mysqli_query($con, $sql);
    $messages = [];
    while( $rows = mysqli_fetch_assoc($result)){
        $messages[] = $rows;
    }
    return $messages;

}

function showAllSettings(){

    global $con;
    global $settings;
    $sql = "SELECT * FROM settings";
    $result = mysqli_query($con, $sql);
    $settings = [];
    while( $rows = mysqli_fetch_assoc($result)){
        $settings[] = $rows;
    }
    return $settings;

}


function updateSettings($id){
        
    
  
    global $con;

  $job_title = mysqli_real_escape_string($con, $_POST['job_title']);
  $about = mysqli_real_escape_string($con, $_POST['about']);
  $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

  $avatarName = $_FILES['avatar']['name'];
  $cvName = $_FILES['cv']['name'];



        $sql = "UPDATE settings SET avatar = '$avatarName', job_title = '$job_title', about = '$about', user_id = $user_id WHERE id = $id; ";
        $result = mysqli_query($con, $sql);
        
        if(!$result){
            header("LOCATION: showsettings.php?updateSettingsError");
        }else{
          header("LOCATION: showsettings.php?updateSettingsSuccess");
      }

}



