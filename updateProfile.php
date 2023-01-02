<?php
// profile.php form submited and need to edit details
require("noCache.php");
session_start();
if (!isset($_SESSION['userId']))
  header('location:login_form.php?error=1');
extract($_POST);

$sid = $_SESSION['userId'];

$nameFlag = $emailFlag = $passwordFlag = $cnfmpasswordFlag = $mobileFlag = $fileUploadFlag = false;
$namePattern = '/^([a-z]+\s)*[a-z]+$/i';
$mailPattern = '/^[a-zA-Z0-9._-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z.]{2,5}$/';
$pwdPattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
$mobilePattern = '/^(32|33|34|35|36|37|38|39|17|66|16)[0-9]{6}$/';
$country = "Bahrain";

if (preg_match($namePattern, $name))
  $nameFlag = true;

if (preg_match($mailPattern, $email)) {
  $emailFlag = true;
}


if (preg_match($mobilePattern, $mobile)) {
  $mobileFlag = true;
}

if (strlen($password) == 0) {
  $passwordChanged = false;
} else {
  if (preg_match($pwdPattern, $password))
    $passwordFlag = true;
  if (($password == $cnfm_password)) // removed &&preg_match($pwdPattern, $cnfm_password)
    $cnfmpasswordFlag = true;
  $passwordChanged = true;
}

if ($passwordChanged) {
  if (!($nameFlag && $emailFlag && $passwordFlag && $cnfmpasswordFlag && $mobileFlag))
    //validation not done on client side and values!=pattern
    header('location:profile.php?error=2');
} else { //dont check passwordflag if password not changed
  if (!($nameFlag && $emailFlag && $mobileFlag))
    header('location:profile.php?error=2');
}
//echo "line 65";

require('./project_connection.php');
$sql = "SELECT PROFILE_PIC FROM users WHERE ID=" . $sid;
$result = $db->query($sql);
$row = $result->fetch();
//echo $_FILES["picfile"]["name"]."<br>";
//echo $row['Profile_pic']."<br>";
//die();
if (isset($_FILES["picfile"]["name"]) && $_FILES["picfile"]["name"] != $row['PROFILE_PIC']) { //if statement to decide if new pic uploaded
  if ((($_FILES["picfile"]["type"] == "image/gif")
      || ($_FILES["picfile"]["type"] == "image/jpeg")
      || ($_FILES["picfile"]["type"] == "image/png")
      || ($_FILES["picfile"]["type"] == "image/pjpeg"))
    && ($_FILES["picfile"]["size"] < 5000000)
  ) {
    if ($_FILES["picfile"]["error"] > 0) {
      echo "Return Code:" . $_FILES["picfile"]["error"] . "<br>";
    } else {
      echo "line 76";
      $fdetails = explode(".", $_FILES["picfile"]["name"]);
      $fext = end($fdetails);
      $fn = "pic" . $fdetails[0] . time() . uniqid(rand()) . ".$fext";  //file name
      if (move_uploaded_file($_FILES["picfile"]["tmp_name"], "./image/$fn")) {
        //Storage: image/$fn;
        //we didnt enter img details into db yet
        $fileUploadFlag = true;
        echo "line 84";
      } else {
        $fileUploadFlag = false;
        echo "line88";
        header('location:profile.php?error=1');
      }
    }
  } else {
    echo "Invalid file type or bigger than 5MB";
    header('location:profile.php?error=1');
  }
} //end of new-file-upload if stmnt

//need to insert everything into DB now

//echo "line108";

$db->beginTransaction();
try {

  if ($passwordChanged&&!$fileUploadFlag) { //update users table, password changed but profilepic not changed
    $sql_userTable = "UPDATE users SET NAME=:name,EMAIL=:email, PHONE=:mobile, PASSWORD=:hpwd WHERE ID= :sid";
    $conn = $db->prepare($sql_userTable);
    $conn->bindValue(':hpwd', $password);
  } elseif ($fileUploadFlag&&!$passwordChanged) {  //update users table, profilepic changed but password not changed
    $sql_userTable = "UPDATE users SET NAME=:name,EMAIL=:email, PHONE=:mobile, PROFILE_PIC=:pfp WHERE ID= :sid";
    $conn = $db->prepare($sql_userTable);
    $conn->bindValue(':pfp', $fn);
  }elseif ($passwordChanged && $fileUploadFlag) { //update users table, profilepic and password change
    $sql_userTable = "UPDATE users SET NAME=:name,EMAIL=:email, PHONE=:mobile, PASSWORD=:hpwd, PROFILE_PIC=:pfp WHERE ID= :sid";
    $conn = $db->prepare($sql_userTable);
    $conn->bindValue(':hpwd', $password);
    $conn->bindValue(':pfp', $fn);
  }
  else {  //update user table without password or profilepic
    $sql_userTable = "UPDATE users SET NAME=:name,EMAIL=:email, PHONE=:mobile WHERE ID= :sid";
    $conn = $db->prepare($sql_userTable);
  }
  $conn->bindValue(':sid', $sid);
  $conn->bindValue(':name', $name);
  $conn->bindValue(':email', $email);
  $conn->bindValue(':mobile', $mobile);
  $conn->execute();
  echo "user table execute";

  $db->commit();
  if ($conn->rowCount() == 0) {
    header('location:profile.php?error=3');
    var_dump($conn);
  } elseif ($conn->rowCount() == 1) {
    header('location:profile.php');
  }
} catch (PDOException $e) {
  $db->rollBack();
  echo "error message:" . $e->getMessage();
  //will show msg on reg_loginform.php with refreshing + error
  //die();
  header('location:profile.php?error=3');
}

echo ("if you see this then there's something wrong");
