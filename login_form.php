<!doctype html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signin</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom style -->
  <link href="loginForm.css" rel="stylesheet">


  <script src="reg_loginformvalidation.js"> </script>
</head>

<body>
  <?php
  session_start();
  if (!isset($_SESSION['userType']))
    require('notloggedinnavbar.php');
  else if ($_SESSION['userType'] == 'admin')
    require('adminnavbar.php');
  else if ($_SESSION['userType'] == 'customer')
    require('customernavbar.php');


  ?>
  <br /><br />
  <div class="container">
    <main class="form-signin w-100 m-auto">
      <div class="border border-secondary border-2 rounded">
        <form onSubmit="return checkLoginInputs();" action='verifyunameandpwd.php' method='post' class="m-4">

          <h1 class="h3 mb-3 fw-normal text-center">Sign in</h1>

          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Email address</label>

            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@petshop.com" onkeyup="checkMAIL(this.value, 'loginemail')" size='20' required value="<?php if (isset($_GET['fillemail'])) echo $_GET['fillemail']; ?>">
            <span id='mail_msg'></span>

          </div>

          <div class="mb-2">
            <label for="exampleInputPassword1" class="form-label">Password</label>

            <input type="password" class="form-control" id="exampleInputPassword1" name='password' onkeyup="checkPWD(this.value,'login_pwd_msg')" required value="<?php if (isset($_GET['fillpwd'])) echo $_GET['fillpwd']; ?>">

            <div id="login_pwd_msg" class="form-text">min 6 char, 1 uppercase, 1 lowercase, 1 number</div>

          </div>

          <input type='hidden' name='JSEnabled' value='false'>
          <button class="w-100 btn btn-lg btn-primary" type='submit' name='login_user'>Sign in</button>
          <!-- Modal button -->
          <button class="w-100 btn btn-lg btn-info mt-1" data-bs-toggle="modal" data-bs-target="#exampleModal">Sample Credentials</button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Sample Credentials</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Email: admin@petshop.com </br>
                  Password: Admin1</br>
                  <hr>
                  Email: joyone1187@vpsrec.com </br>
                  Password: Ahmed1
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>


          <p class="mt-1">Dont have an account? <br /> <b><a href="registration_form.php">Sign up here!</a></b> </p>
        </form>
      </div>
    </main>
  </div>
  <?php
  $error = null;
  extract($_GET);
  if ($error == 1) {
    echo "<script> alert('Need to log in before acessing the page!'); </script>";
  } elseif ($error == 2) {
    echo "<script> alert('Please enter valid inputs, perhaps turn on client side scripting'); </script>";
  } elseif ($error == 3) {
    echo "<script> alert('Invalid credentials!'); </script>";
  } elseif ($error == 4) {
    echo "<script> alert('Database error :('); </script>";
  }
  ?>
</body>

</html>
