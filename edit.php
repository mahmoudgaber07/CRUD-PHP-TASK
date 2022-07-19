<?php
$error_fields = array();
//connect to db
$conn = mysqli_connect("localhost","root","","users");
if(!$conn){
    echo mysqli_connect_error();
    exit;
}

//select the user
//a href==>//edit.php?id = 1 =>$_GET['id'] //remmber that in listRegistedUser.php
$id = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$select = "SELECT * FROM customers WHERE id='$id ' LIMIT 1";  
$result = mysqli_query($conn,$select);
$row = mysqli_fetch_assoc($result);  

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //validation
    if(!(isset($_POST['username']) && !empty($_POST['username']) )){
        $error_fields[] = "username";
    }
    if(!(isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
        $error_fields[] = "email";
    }
    if(!$error_fields){
    //Escape any special char
    $id = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    $name = mysqli_escape_string($conn,$_POST['username']);
    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = (!empty($_POST['password']))? sha1($_POST['password']) : $row['password'];
    $admin = (isset($_POST['admin']))? 1:0;

    //update the data
    $query = "UPDATE customers SET name =' $name', email =' $email', password =' $password', admin =' $admin' WHERE id =' $id' "; 
    if(mysqli_query($conn,$query)){
        header("Location: listRegistedUsers.php"); 
        exit;                                      
    }else{
        //echo $query;    //for debug
        echo mysqli_error($conn);
         }
    }
}

//close connection 
mysqli_free_result($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container pt-5">
<p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Edit</p>
    <form class="mx-1 mx-md-4" method="post">
            <div class="d-flex flex-row align-items-center mb-4">
            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
            <div class="form-outline flex-fill mb-0">
                <input type="text" id="username" name="username" class="form-control" value ="<?php echo(isset($row['name'])) ? $row['name']:'' ?>"/>
                <!--Note: i add hidden input to id-->
                 <input type="hidden" name="id" id="id" value="<?php echo(isset($row['id']))? $row['id']:'' ?>">    
                <label class="form-label" for="username">User Name</label>
            </div>
            </div>
            <strong class="text-danger ps-5">
            <?php if(in_array("username",$error_fields)) echo "Please Enter Your Username" ?>
            </strong>
                
          
            <div class="d-flex flex-row align-items-center mb-4">
            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
            <div class="form-outline flex-fill mb-0">
                <input type="email" id="email"  name="email" class="form-control" value ="<?php echo(isset($row['email'])) ? $row['email']:'' ?>"/>
                <label class="form-label" for="email">Your Email</label>
            </div>
            </div>
            <strong class="text-danger ps-5">
            <?php if(in_array("email",$error_fields)) echo "Please Enter Your Email" ?>
            </strong>

            
            <div class="d-flex flex-row align-items-center mb-4">
            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
            <div class="form-outline flex-fill mb-0">
                <input type="password" id="password" name="password" class="form-control"/>
                <label class="form-label" for="password">Password</label>
            </div>
            </div>
    
            <!-- <div class="d-flex flex-row align-items-center mb-4">
            <div class="form-outline flex-fill mb-0">
                <label class="form-label" for="avatar">Choose Image:</label>
                <input type="file" id="avatar" name="avatar" class="form-control"/>
            </div>
            </div> -->

            <div class="form-check d-flex justify-content-center mb-5">
            <label for="admin" id="admin">admin :</label><br/>
                <input class="form-check-input m-1" type="checkbox" name="admin" value ="<?php echo(isset($row['admin']))? 'checked':'' ?>">Admin
            </div>
            

            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
            <button type="submit" name="submit" class="btn btn-primary btn-lg">Edit User</button>
            </div>
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>