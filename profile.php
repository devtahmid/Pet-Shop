<?php
session_start();
if (!isset($_SESSION['userId']))
  header('Location: login_form.php?error=1');
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
  <!-- <script src="reg_loginformvalidation.js"> </script> -->
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
        <form id='profileForm' onSubmit="return checkeditedInputs();" action='updateProfile.php' method='post' class="m-4" enctype="multipart/form-data">
          <h1 class="h3 mb-3 fw-normal text-center">Sign up</h1>

          <div class="mx-auto">
            <img src='./image/<?php echo $profile_pic; ?>' class='profile-pic img-fluid w-100 border border-secondary border-2 rounded ' alt='profilepic'>
          </div>
          <input type="file" name="picfile" id='fileUpload' /><span> (images<=5MB) </span><br><br>

              <div class="mb-2">
                <label for="name" class="form-label">Name</label>
                <input class='form-control' type='text' name='name' id="name" placeholder="maximum 50 characters" onkeyup="checkFN(this.value, 'name_msg')" size='50' value='<?php echo htmlspecialchars("$name"); ?>' required><span id='name_msg'></span>
              </div>

              <div class="mb-2">
                <label for="exampleInputEmail1" class="form-label">Email address</label>

                <input type="email" class="form-control" name="email" value='<?php echo htmlspecialchars("$email"); ?>' id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name@petshop.com" onkeyup="checkMAIL(this.value)" size='20' required>
                <span id='mail_msg'></span>

              </div>

              <div class="mb-2">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name='password' onkeyup="checkPWD(this.value)">
                <div id="profile_pwd_msg" class="form-text">min 6 char, 1 uppercase, 1 lowercase, 1 number</div>
              </div>

              <div>
                <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="exampleInputPassword2" name='cnfm_password' onkeyup="confirmPWD(this.value)">
                <div id="cfmpwd_msg" class="form-text"></div>
              </div>

              <div>
                <label for="phonenumber" class="form-label">Phone Number</label>
                <input class='form-control' type='text' name='mobile' value='<?php echo htmlspecialchars("$mobile"); ?>' placeholder="8 digits for Bahrain" onkeyup="checkMBL(this.value)" size='10' required>
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
  if ($error == 1) {
    echo "<script> alert('File could not be uploaded'); </script>";
  } elseif ($error == 2) {
    echo "<script> alert('Please enter valid inputs, perhaps turn on client side scripting'); </script>";
  } elseif ($error == 3) {
    echo "<script> alert('Database error :('); </script>";
  }
  ?>
</body>
<script>
  <?php
  echo "var name=\"" . $name . "\";\n";
  echo "var email=\"" . $email . "\";\n";
  echo "var mobile=\"" . $mobile . "\";\n";
  ?>

  var nameFlag = emailFlag = passwordFlag = cnfmpasswordFlag = mobileFlag = fileUploadFlag = true; //true by default

  function checkFN(name1, id) { //check full name
    var nameExp = /^([a-z]{2,}\s)*[a-z]+$/i;
    if (name1.length == 0) {
      msg = "Enter name!";
      color = "red";
      nameFlag = false;
    } else if (!nameExp.test(name1)) {
      msg = "Invalid Name";
      color = "red";
      nameFlag = false;
    } else {
      msg = "Valid Name";
      color = "green";
      nameFlag = true;
    }
    document.getElementById(id).style.color = color;
    document.getElementById(id).innerHTML = msg;
  }


  function checkMAIL(mail) { //check mail format
    var mailExp = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z.]{2,5}$/;
    console.log(mail)
    if (mail.length == 0) {
      msg = "Need to add an email!";
      color = "red";
      emailFlag = false;
    } else if (!mailExp.test(mail)) {
      msg = "Invalid mail format";
      //msg =mailExp.test(mail) ;
      color = "red";
      emailFlag = false;
    } else {
      if (mail.toLowerCase() == email.toLowerCase()) {
        msg = "";
        color = "green";
        emailFlag = true;
      } else {
        msg = "Valid mail";
        color = "green";
        emailFlag = true;
        ajaxexists(mail, "email");
      }
    }
    document.getElementById('mail_msg').style.color = color;
    document.getElementById('mail_msg').innerHTML = msg;
  }

  function checkPWD(pwd) { //check password
    console.log(pwd);
    var pwdExp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    if (pwd.length == 0) {
      msg = ""; //accepted to retain original values
      color = "red";
      passwordFlag = true;
    } else if (!pwdExp.test(pwd)) {
      msg = "Invalid password";
      color = "red";
      passwordFlag = false;
    } else {
      msg = "Valid password";
      color = "green";
      passwordFlag = true;
    }
    document.getElementById('profile_pwd_msg').style.color = color;
    document.getElementById('profile_pwd_msg').innerHTML = msg;
    confirmPWD(document.getElementById('profileForm').cnfm_password.value);
  }

  function confirmPWD(cpassword) { //check 2nd password
    if ((cpassword.length == 0) && (document.getElementById('profileForm').password.value.length == 0)) { //both passwords empty
      msg = "";
      cnfmpasswordFlag = true;
    } else if (cpassword.length == 0) { //confirmpassword empty but firstpassword not empty
      msg = "";
      cnfmpasswordFlag = false;
    } else if (document.getElementById('cfmpwd_msg').innerHTML == 'Invalid password') {  //typing confirm password but first password is not valid
      msg = "enter valid password first";
      color = "red";
      cnfmpasswordFlag = false;
    } else { //cpassword not empty and firstpassword is valid
      var firstPwd = document.getElementById('profileForm').password.value;

      if (firstPwd.length == 0) {
        msg = "";
        cnfmpasswordFlag = false;
        color = "white"; //need to enter or gives not defined error
      } else if (cpassword != firstPwd) {
        msg = "passwords don't match";
        color = "red";
        cnfmpasswordFlag = false;

      } else {
        msg = "they match";
        color = "green";
        cnfmpasswordFlag = true;
      }
    }
    document.getElementById('cfmpwd_msg').style.color = color;
    document.getElementById('cfmpwd_msg').innerHTML = msg;
  }

  function checkMBL(mobileEntered) { //check mobile num

    var numExp = /^(32|33|34|35|36|37|38|39|17|66|16)[0-9]{6}$/;

    if (mobileEntered.length == 0) {
      msg = "Need to enter a number!";
      color = "red";
      mobileFlag = false;
    } else if (!numExp.test(mobileEntered)) {
      msg = "Invalid mobile number";
      color = "red";
      mobileFlag = false;
    } else {
      if (mobileEntered == mobile) { //mobile was initialised with mobile from db using php
        msg = "";
        color = "green";
        mobileFlag = true;
      } else {
        msg = "Valid mobile number";
        color = "green";
        mobileFlag = true;
        ajaxexists(mobileEntered, "mobile");
      }
    }
    document.getElementById('mobile_msg').style.color = color;
    document.getElementById('mobile_msg').innerHTML = msg;
  }

  function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
      // Firefox, Opera 8.0+, Safari
      xmlHttp = new XMLHttpRequest();
    } catch (e) {
      // Internet Explorer
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    return xmlHttp;
  }

  function ajaxexists(word, type) {
    var xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
      alert("Your browser does not support AJAX!");
      return false;
    }

    var url = "./checknameemailmobile.php"
    if (type == "email")
      url = url + "?email=" + word;
    else if (type == "mobile")
      url = url + "?mobile=" + word;

    xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState == 4) {
        ajax_checking = xmlHttp.responseText;
        console.log(word + "---" + type + "---" + ajax_checking); //only for testing
        reGajaxmsgs(word, type, ajax_checking);
      }
    }
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
  }

  function reGajaxmsgs(word, type, result) {
    if (type == "email" && result == "present") {
      console.log(word);
      document.getElementById('mail_msg').style.color = "red";
      document.getElementById('mail_msg').innerHTML = "Email already registered";
      emailFlag = false;
    } else if (type == "mobile" && result == "present") {
      console.log(word);
      document.getElementById('mobile_msg').style.color = "red";
      document.getElementById('mobile_msg').innerHTML = "Number already registered";
      mobileFlag = false;
    }
  }

  function checkeditedInputs() {
    document.getElementById('profileForm').JSEnabled.value = "TRUE";
    return (nameFlag && mobileFlag && emailFlag && passwordFlag && cnfmpasswordFlag);
  }
</script>

</html>