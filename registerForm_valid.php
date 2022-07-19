<?php
//Validation   
$error_fields = array();
if(!(isset($_POST['username']) && !empty($_POST['username']))){
    $error_fields [] = "username";
}
if(!(isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){ 
    $error_fields [] = "email";
}
if(!(isset($_POST['password']) && strlen($_POST['password']) > 5)){   
    $error_fields [] = "password";
}
if(!(isset($_POST['gender']) && !empty($_POST['gender']))){   
    $error_fields [] = "gender";
}
if($error_fields){
    header("Location: registerForm.php?error_fields=".implode(",",$error_fields));
    exit;
}

//connect to database
//open connection
$conn = mysqli_connect("localhost","root","","users");   
if(!$conn){
    echo mysqli_connect_error();
    exit;
}

//Escabe any special characters to avoid SQL Injection
$name = mysqli_escape_string($conn,$_POST['username']);        
$email = mysqli_escape_string($conn,$_POST['email']);
$password = mysqli_escape_string($conn,sha1($_POST['password'])); 

//insert Data
$query = "INSERT INTO `customers`(`name`,`email`,`password`) VALUES ('".$name."','".$email."','".$password."')";
if(mysqli_query($conn,$query)){
    echo "Thank You, information has been saved";
    header("Location: loginForm.php");
}else{
    echo $query;    //for debug
    echo mysqli_error($conn);
}
//close connection
mysqli_close($conn);