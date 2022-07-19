<?php 
//we will use it for storing the signed in user data
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//connect to db
    $conn = mysqli_connect("localhost","root","","users");
    if(!$conn){
        echo mysqli_connect_error();
        exit;
    }
//Escabe any special characters to avoid SQL Injection
    $email = mysqli_escape_string($conn,$_POST['email']);
    $password = sha1($_POST['password']);

    //select
    $query = "SELECT * FROM customers WHERE email=' $email' AND password =' $password ' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if($row = mysqli_fetch_assoc($result)){      //check if return assoc_array if user found
        $_SESSION['id'] = $row['id'];           //save in session
        $_SESSION['email'] = $row['email'];
        header("Location: listRegistedUsers.php");
        exit;
      }else{
        $error = "Invalid email or password";
    }

    //close connection 
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <title>Login</title>
</head>
<body>
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">LOGIN</p>
              
                <form class="mx-1 mx-md-4" method="post">
        
                  <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                          <input type="email" id="email"  name="email" class="form-control" value="<?php (isset($_POST['email']))? $_POST['email']:'' ?>" />
                          <label class="form-label" for="email">Your Email</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                        <input type="password" id="password" name="password" class="form-control" />
                        <label class="form-label" for="password">Password</label>
                    </div>
                  </div>



                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                        <!---print error message here-->
                        <strong class="text-danger text-center p-5">
                        <?php if(isset($error)) echo $error ?>
                        </strong>
                    </div>
                  </div>
                 
               

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
                  </div>

                  <p class="text-center text-muted mt-5 mb-0">I Don't have an account? <a href="registerForm.php"
                    class="fw-bold text-body"><u>Register here</u></a></p>

                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>