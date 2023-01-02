<?php
require("noCache.php");
extract($_POST);
if (isset($login_user) && $login_user == 'Login') { //form submited and wants to login
  //send details to verifyunameandpwd.php again as user could disable scripting
  $url = "verifyunameandpwd.php?email=" . $email . "&password=" . $password;
  header('location:' . $url);
} elseif (isset($register_user) && $register_user == 'Register') {
  $nameFlag = $emailFlag = $passwordFlag = $cnfmpasswordFlag = $mobileFlag = false;
  $namePattern = '/^([a-z]+\s)*[a-z]+$/i';
  $mailPattern = '/^[a-zA-Z0-9._-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z.]{2,5}$/';
  $pwdPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
  $country_code = '+973';
  if ($country_code == '+973') {
    $mobilePattern = '/^(32|33|34|35|36|37|38|39)[0-9]{6}$/';
    $country = "Bahrain";
  } else if ($country_code == '+966') {
    $mobilePattern = '/^(54|56|57|58|59)[0-9]{6,8}$/';
    $country = "Saudi Arabia";
  } else if ($country_code == '+971') {
    $mobilePattern = '/^(50|52|54|55|56|58)[0-9]{6,8}$/';
    $country = "United Arab Emirates";
  }


  if (preg_match($namePattern, $name))
    $nameFlag = true;
  if (preg_match($mailPattern, $email))
    $emailFlag = true;
  if (preg_match($pwdPattern, $password))
    $passwordFlag = true;
  if ($password == $cnfm_password)
    $cnfmpasswordFlag = true;
  if (preg_match($mobilePattern, $mobile))
    $mobileFlag = true;



  if (!($nameFlag && $emailFlag && $passwordFlag && $cnfmpasswordFlag && $mobileFlag))
    //validation not done on client side and values!=pattern
    header('location:registration_form.php?error=2');
  else { //good values, now need to insert into DB
    try {
      require('project_connection.php');
      /* $h_password = password_hash($password, PASSWORD_DEFAULT); */ //ignoring hash for this project
      $h_password = $password;
      $profilepic = 'default.jpg';
      //$mobile=$country_code.$mobile; will display like that otherwise searching for num becomes difficult in ajax registration
      $sql = "insert into users(NAME,EMAIL,PASSWORD,PHONE, TYPE, PROFILE_PIC) values (:name,:email,:password,:mobile, 'customer', 'default.jpg')";
      //default profile pic for new user is 'default.jpg'
      $db->beginTransaction();
      $conn = $db->prepare($sql);

      $conn->bindParam(':name', $name);
      $conn->bindParam(':email', $email);
      $conn->bindParam(':password', $h_password);
      $conn->bindParam(':mobile', $mobile);
      $conn->execute();

      $Sid = $db->lastInsertId();
      $db->commit();
      if ($conn->rowCount() == 0) {
        header('location:registration_form.php?error=4');
      } elseif ($conn->rowCount() == 1) {
        //successful registration

        echo "<script>alert(" . $Sid . ")</script>";
        session_start();
        $_SESSION['activeUser'] = $email;
        $_SESSION['userId'] = $Sid;
        $_SESSION['userType'] = 'customer'; //only customer will use registration form
        header('location:browse.php');
      }
    } catch (PDOException $e) {
      $db->rollBack();
      echo "errorrrr:" . $e->getMessage();
      //will show alert on reg_loginform.php with refreshing + error
      header('location:registration_form.php?error=4');
    }
  }
}
echo ("if you see this then there's something wrong");
