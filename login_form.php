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
  require('notloggedinnavbar.php');
  ?>
  <br /><br />
  <div class="container">
    <main class="form-signin w-100 m-auto">
      <div class="border border-secondary border-2 rounded">
        <form onSubmit="return checkLoginInputs();" action='verifyunameandpwd.php' method='post' class="m-4">

          <h1 class="h3 mb-3 fw-normal text-center">Sign in</h1>

          <div class="mb-2">
            <label for="exampleInputEmail1" class="form-label">Email address</label>

            <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@petshop.com" onkeyup="checkMAIL(this.value, 'loginemail')" size='20' required>
            <span id='mail_msg'></span>

          </div>

          <div class="mb-2">
            <label for="exampleInputPassword1" class="form-label">Password</label>

            <input type="password" class="form-control" id="exampleInputPassword1" name='password' onkeyup="checkPWD(this.value,'login_pwd_msg')" required>

            <div id="login_pwd_msg" class="form-text">min 6 char, 1 uppercase, 1 lowercase, 1 number</div>

          </div>

          <input type='hidden' name='JSEnabled' value='false'>
          <button class="w-100 btn btn-lg btn-primary" type='submit' name='login_user'>Sign in</button>

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