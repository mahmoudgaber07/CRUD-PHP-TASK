<?php
//Validation   
$error_fields = array();
if($_SERVER['REQUEST_METHOD'] =='POST'){   //check method
    if(!(isset($_POST['username']))){
        $error_fields[] = "username";
    }
    if(!(isset($_POST['email']) && filter_input(INPUT_POST , 'email',FILTER_VALIDATE_EMAIL))){
        $error_fields[] = "email";
    }
    if(!(isset($_POST['password']) && strlen($_POST['password']) > 5)){
        $error_fields[] = "password";
    }
    //connect to database
    //open connection
    if(!$error_fields){
        $conn = mysqli_connect("localhost","root","","users");
        if(!$conn){
            echo mysqli_error();
            exit;
        }

    //Escabe any special characters to avoid SQL Injection
    $name = mysqli_escape_string($conn,$_POST['username']);       
    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = sha1($_POST['password']);  
    $admin = isset($_POST['admin'])? 1:0;

    //upload file
    $upload_dir = './uploads';    //send to new dir because it was in a temp dir
    $avatar = '';

    //check if error or not
    if($_FILES['avatar']['error'] == UPLOAD_ERR_OK){  //UPLOAD_ERR_OK -> const return 0 or 1
        $temp_name = $_FILES['avatar']['tmp_name'];
        $avatar = basename($_FILES['avatar']['name']);  
        move_uploaded_file($temp_name,"$upload_dir/$name$avatar");
    }else {
        echo "File can't be uploaded";
        exit;
    }

    //insert Data
    $query = "INSERT INTO `customers`(`name`,`email`,`password`,`avatar`,`admin`) VALUES ('".$name."','".$email."','".$password."','".$name.$avatar."','".$admin."')";
    if(mysqli_query($conn,$query)){
        header("Location: listRegistedUsers.php"); 
        exit;                                      
    }else{
        echo $query;    
        echo mysqli_error($conn);
         }
    //close connection
    mysqli_close($conn);
    }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add user</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container pt-5">
    <form class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">
            <div class="d-flex flex-row align-items-center mb-4">
            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
            <div class="form-outline flex-fill mb-0">
                <input type="text" id="username" name="username" class="form-control" value ="<?php (isset($_POST['username'])? $_POST['username']:'') ?>"/>
                <label class="form-label" for="username" >User Name</label>
            </div>
            </div>
            <strong class="text-danger ps-5">
            <?php if(in_array("username",$error_fields)) echo "Please Enter Your Username" ?>
            </strong>

            <div class="d-flex flex-row align-items-center mb-4">
            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
            <div class="form-outline flex-fill mb-0">
                <input type="email" id="email"  name="email" class="form-control" value ="<?php (isset($_POST['email'])? $_POST['email']:'') ?>"/>
                <label class="form-label" for="email">Your Email</label>
            </div>
            </div>
            <strong class="text-danger ps-5">
            <?php if(in_array("email",$error_fields)) echo "Please Enter Your Email" ?>
            </strong>

            
            <div class="d-flex flex-row align-items-center mb-4">
            <div class="form-outline flex-fill mb-0">
                <input type="password" id="password" name="password" class="form-control"/>
                <label class="form-label" for="password">Password</label>
            </div>
            </div>
            <strong class="text-danger ps-5">
            <?php if(in_array("password",$error_fields)) echo "Please Enter Your Password not less 6 char" ?>
            </strong>
            
            <div class="d-flex flex-row align-items-center mb-4">
            <div class="form-outline flex-fill mb-0">
                <label class="form-label" for="avatar">Choose Image:</label>
                <input type="file" id="avatar" name="avatar" class="form-control"/>
            </div>
            </div>
            
            <div class="form-check d-flex justify-content-center mb-5">
            <label for="admin" id="admin">admin :</label><br/>
                <input class="form-check-input m-1" type="checkbox" name="admin" value ="<?php (isset($_POST['admin'])? 'checked':'') ?>">Admin
            </div>
            

            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
            <button type="submit" class="btn btn-primary btn-lg">Add User</button>
            </div>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>