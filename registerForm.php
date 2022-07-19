<?php 
//check for errors
$errors_arr = array();
if(isset($_GET['error_fields'])){
  $errors_arr = explode(",",$_GET['error_fields']);
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
   <title>Register</title>
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

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form class="mx-1 mx-md-4" method="post" action="registerForm_valid.php">
                  <strong class="text-danger ps-5">
                    <?php if(in_array("username",$errors_arr)) echo "Please Enter Your Username" ?>
                  </strong>
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="username" name="username" class="form-control" />
                      <label class="form-label" for="username" >User Name</label>
                    </div>
                  </div>
                  
                  <strong class="text-danger ps-5">
                  <?php if(in_array("email",$errors_arr)) echo "Please Enter Your Email" ?>
                  </strong>
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="email" id="email"  name="email" class="form-control" />
                      <label class="form-label" for="email">Your Email</label>
                    </div>
                  </div>

                  <strong class="text-danger ps-5">
                    <?php if(in_array("password",$errors_arr)) echo "Please Enter Your Password not less 6 char" ?>
                  </strong>
                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="password" name="password" class="form-control" />
                      <label class="form-label" for="password">Password</label>
                    </div>
                  </div>
                  
                  <strong class="text-danger ps-5">
                    <?php if(in_array("gender",$errors_arr)) echo "Please Sellect Gender" ?>
                  </strong>
                  <div class="form-check d-flex justify-content-center mb-5">
                  <label for="gender" id="gender">Gender :</label><br/>
                   <input class="form-check-input m-1" type="radio" name="gender" value="male">Male
                     <input class="form-check-input m-1" type="radio" name="gender" value="female">Female
                  </div>
                 

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                  </div>

                  <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="loginForm.php"
                    class="fw-bold text-body"><u>Login here</u></a></p>

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