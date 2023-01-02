<?php
session_start();
if (!isset($_SESSION['userId']))
  header('Location: ../login_form.php?error=1');
$sid = $_SESSION['userId'];
try {
  require('project_connection.php');
  $userResult = $db->prepare("SELECT * FROM users WHERE ID= :id");
  $userResult->bindParam(':id', $sid);
  $userResult->execute();
  $userRow = $userResult->fetch();
  $password = $userRow['PASSWORD'];
  $name = $userRow['NAME'];
  $mobile = $userRow['PHONE'];
  $email = $userRow['EMAIL'];
  $country = "Bahrain"; //check comment under form.select in above if statement
  $profile_pic = $userRow['PROFILE_PIC'];
  $db = null;
} catch (PDOException $e) {
  echo "<script>alert('Error " . $e->getMessage() . "\\nPlease refresh');</script>"; //paste in b/w ".$e->getMessage()."  to see errror

}
?>


<!doctype html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile</title>
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
  require('customernavbar.php');
  ?>
  <br /><br /> <br />
  <div class="container">
    <main class="form-signin w-100 m-auto">
      <div class="border border-secondary border-2 rounded">
        <form onSubmit="return checkeditedInputs();" action='updateProfile.php' method='post' class="m-4" enctype="multipart/form-data">
          <h1 class="h3 mb-3 fw-normal text-center">Sign up</h1>

          <img src='./image/<?php echo $profile_pic; ?>' class='profile-pic border border-secondary border-2 rounded' alt='profilepic'>
          <input type="file" name="picfile" id='fileUpload' /><span> (images<=5MB) </span><br><br>

              <div class="mb-2">
                <label for="name" class="form-label">Name</label>
                <input class='form-control' type='text' name='name' id="name" placeholder="maximum 50 characters" onkeyup="checkFN(this.value, 'name_msg1')" size='50' value='<?php echo htmlspecialchars("$name"); ?>' required><span id='name_msg'></span>
              </div>

              <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Email address</label>

                <input type="email" class="form-control" name="email" value='<?php echo htmlspecialchars("$email"); ?>' id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@petshop.com" onkeyup="checkMAIL(this.value)" size='20' required>
                <span id='mail_msg'></span>

              </div>

              <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name='password' onkeyup="checkPWD(this.value)" required>
                <div id="profile_pwd_msg" class="form-text">min 6 char, 1 uppercase, 1 lowercase, 1 number</div>
              </div>

              <div>
                <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="exampleInputPassword2" name='cnfm_password' onkeyup="confirmPWD(this.value)" required>
                <div id="cfmpwd_msg" class="form-text"></div>
              </div>

              <div>
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input class='form-control' type='text' name='mobile' value='<?php echo htmlspecialchars("$mobile"); ?>' placeholder="8 digits for Bahrain, 8-10 others" onkeyup="checkMBL(this.value)" size='10' required>
                <div id="mobile_msg" class="form-text"></div>
              </div>

              <input type='hidden' name='JSEnabled' value='false'>
              <input class="w-100 btn btn-lg btn-primary mt-2" type='submit' name='edit_user' value='Edit'>
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