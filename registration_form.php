<!doctype html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="loginForm.css" rel="stylesheet">
  <script src="reg_loginformvalidation.js"> </script>
  <style>
    #register {
      margin-top: 135px;
      margin-left: auto;
      margin-right: auto;
      margin-bottom: 70px;
      width: 700px;
      padding: 80px;
      padding-bottom: 25px;
      padding-top: 40px;
      border-radius: 5%;
      border: 5px solid black;
    }

    .register {
      font-size: 40px;
    }

    .form-control {
      font-size: 18px;
      font-weight: bolder;
    }

    .form-control::placeholder {
      font-weight: 20;
    }
  </style>
</head>

<body>
  <?php
  require('notloggedinnavbar.php');
  ?>
  <br /><br />
  <div class="container">
    <main class="form-signin w-100 m-auto">
      <div class="border border-secondary border-2 rounded">
        <form onSubmit="return checkRegistrationInputs();" id="registration_form" action='reg_login.php' method='post' class="m-4">

          <h1 class="h3 mb-3 fw-normal text-center">Sign up</h1>

          <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input class='form-control' type='text' name='name' id="name" placeholder="maximum 50 characters" onkeyup="checkFN(this.value)" size='50' required><span id='name_msg'></span>
          </div>

          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Email address</label>

            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@petshop.com" onkeyup="checkMAIL(this.value, 'registrationemail')" size='20' required>
            <span id='mail_msg'></span>

          </div>

          <div class="mb-2">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name='password' onkeyup="checkPWD(this.value,'reg_pwd_msg')" required>
            <div id="reg_pwd_msg" class="form-text">min 6 char, 1 uppercase, 1 lowercase, 1 number</div>
          </div>

          <div>
            <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword2" name='cnfm_password' onkeyup="confirmPWD(this.value)" required>
            <div id="cfmpwd_msg" class="form-text"></div>
          </div>

          <div>
            <label for="phonenumber" class="form-label">Phone Number</label>
            <input class='form-control' type='text' name='mobile' placeholder="8 digits for Bahrain, 8-10 others" onkeyup="checkMBL(this.value)" size='10' required>
            <div id="mobile_msg" class="form-text"></div>
          </div>

          <input type='hidden' name='JSEnabled' value='false'>
          <button class="w-100 btn btn-lg btn-primary mt-2" type='submit' name='register_user' value='Register'>Sign up</button>

          <p class="mt-1">Have an account? <br /> <b><a href="login_form.php">Sign in here!</a></b> </p>
        </form>
      </div>
    </main>
  </div>
  <?php

  $error = null;
  extract($_GET);
  if ($error == 2) {
    echo "<script> alert('Please enter valid inputs, perhaps turn on client side scripting'); </script>";
  } elseif ($error == 3) {
    echo "<script> alert('Invalid credentials!'); </script>";
  } elseif ($error == 4) {
    echo "<script> alert('Database error :('); </script>";
  }
  ?>
</body>

</html>