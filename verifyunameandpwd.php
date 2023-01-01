<?php
//USED TO VERIFY USERNAME AND PASSWORD AFTER USER SUBMITS LOG IN FORM...COMES FROM reg_login.php
require("noCache.php");
//validate email and password
extract($_POST);
$emailFlag = $pwdFlag = false;
$emailPattern = '/^[a-zA-Z0-9._-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z.]{2,5}$/';
$pwdPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
if (preg_match($emailPattern, $email))
  $emailFlag = true;
if (preg_match($pwdPattern, $password))
  $pwdFlag = true;

if (!($emailFlag && $pwdFlag)) //validation not done on client side and values!=pattern
  header('location:login_form.php?error=2');
else { //good values, now need to check if they're in DB
  try {
    require('project_connection.php');

    $conn = $db->prepare("SELECT * FROM users WHERE EMAIL= '$email'");
    //  $conn->bindParam(':un' , $username);
    $conn->execute();

    if ($conn->rowCount() == 0) {
      header('location:login_form.php?error=3');
    } elseif ($conn->rowCount() == 1) {
      $row = $conn->fetch();
      $h_password = $row['PASSWORD'];
      if ($h_password == $password) {
        //successful login
        session_start();
        $_SESSION['activeUser'] = $email;
        $_SESSION['userId'] = $row['ID'];
        $_SESSION['userType'] = $row['TYPE'];
        header('location:browse.php');
      } else {
        header('location:login_form.php?error=3');
      }
    }
    $db = null;
  } catch (PDOException $e) { //will say "DB issues" on reg_loginform.php without refreshing
    echo "Error Message " . $e->getMessage();
    //header('location:login_form.php?error=4');
  }
}
