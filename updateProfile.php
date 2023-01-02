<?php
  // profile.php form submited and need to edit details
  require("noCache.php");
  session_start();
  if (!isset($_SESSION['userId']))
    header('location:login_form.php?error=1');
  extract($_POST);

$sid=$_SESSION['userId'];

  $nameFlag=$emailFlag=$passwordFlag=$cnfmpasswordFlag=$mobileFlag=$fileUploadFlag=false;
  $namePattern ='/^([a-z]+\s)*[a-z]+$/i';
  $mailPattern ='/^[a-zA-Z0-9._-]+@([a-zA-Z0-9-]+\.)+[a-zA-Z.]{2,5}$/';
  $pwdPattern='/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/';
  $country_code="+973";
  if ($country_code=='+973') {
    $mobilePattern= '/^(32|33|34|35|36|37|38|39)[0-9]{6}$/';
    $country="Bahrain";
  }
  else if ($country_code=='+966') {
    $mobilePattern= '/^(54|56|57|58|59)[0-9]{6,8}$/';
    $country="Saudi Arabia";
  }
  else if($country_code=='+971') {
    $mobilePattern= '/^(50|52|54|55|56|58)[0-9]{6,8}$/';
    $country="United Arab Emirates";
  }
if(preg_match($namePattern, $fname) && preg_match($namePattern, $lname))
$nameFlag=true;

if(preg_match($mailPattern, $email)){
  $emailFlag=true;
}


if(preg_match($mobilePattern, $mobile)){
  $mobileFlag=true;
}

if (strlen($password)==0) {
  $passwordChanged=false;
}
else{
  if(preg_match($pwdPattern, $password))
  $passwordFlag=true;
  if(($password==$cnfm_password)) // removed &&preg_match($pwdPattern, $cnfm_password)
  $cnfmpasswordFlag=true;
  $passwordChanged=true;
}

if ($passwordChanged) {
  if (!($nameFlag&&$emailFlag&&$passwordFlag&&$cnfmpasswordFlag&&$mobileFlag))
  //validation not done on client side and values!=pattern
  header('location:profile.php?error=2');
}
else { //dont check passwordflag if password not changed
  if (!($nameFlag&&$emailFlag&&$usernameFlag&&$mobileFlag))
  header('location:profile.php?error=2');
}
//echo "line 65";

require('./project_connection.php');
$sql="SELECT PROFILE_PIC FROM users WHERE ID=".$sid;
$result=$db->query($sql);
$row=$result->fetch();
//echo $_FILES["picfile"]["name"]."<br>";
//echo $row['Profile_pic']."<br>";
//die();
if ($_FILES["picfile"]["name"] != $row['PROFILE_PIC'] ) { //if statement to decide if new pic uploaded
  if((($_FILES["picfile"][ "type"] == "image/gif")
  || ($_FILES["picfile"]["type"] == "image/jpeg")
  || ($_FILES["picfile"]["type"] == "image/png")
  || ($_FILES["picfile"]["type"] == "image/pjpeg"))
  && ($_FILES["picfile"]["size"] < 5000000)) {
      if($_FILES["picfile"]["error"] > 0){
        echo "Return Code:". $_FILES["picfile"]["error"]. "<br>";
        }
      else {
        echo "line 76";
        $fdetails=explode(".", $_FILES["picfile"]["name"]);
        $fext=end($fdetails) ;
        $fn="pic".$fdetails[0].time().uniqid(rand()).".$fext";  //file name
        if (move_uploaded_file($_FILES["picfile"]["tmp_name"], "./images/$fn" )) {
          //Storage: profile_pictures/$fn;
          //didnt enter img details into db yet
          $fileUploadFlag=true;
          echo "line 84";
        }
        else {
          $fileUploadFlag=false;
          echo "line88";
          header('location:profile.php?error=1');
        }
      }
  }
else{
echo "Invalid file type or bigger than 5MB";
header('location:profile.php?error=1');
}
}//end of new-file-upload if stmnt

//need to insert into DB now

//echo "line108";

$db->beginTransaction();
  try{
//user table
  if ($passwordChanged){ //update user table with password
    $sql_userTable="UPDATE users SET NAME=:uname, PASSWORD=:hpwd,EMAIL=:email, PHONE=:phone WHERE ID= :sid";
    $conn = $db->prepare($sql_userTable);
    $conn->bindValue(':hpwd',$password);
  }
  else{  //update user table without password
    $sql_userTable="UPDATE users SET Username=:uname,Email=:email WHERE ID= :sid";
    $conn = $db->prepare($sql_userTable);
  }
  $conn->bindValue(':sid',$sid);
  $conn->bindValue(':uname',$username);
  $conn->bindValue(':email',$email);
  $conn->execute();
echo "user table execute";
//customer table
if ($fileUploadFlag) { //update customer table with pfp
  $sql_customerTable="UPDATE customer SET Fname=:fname, Lname=:lname, Mobile=:mobile, Building=:building, Block=:block, Profile_Pic=:pfp WHERE UID= :sid";
  $conn = $db->prepare($sql_customerTable);
  $conn->bindValue(':pfp',$fn);
}
else { //update customer table without pfp
  $sql_customerTable="UPDATE customer SET Fname=:fname, Lname=:lname, Mobile=:mobile, Building=:building, Block=:block WHERE UID= :sid";
  $conn = $db->prepare($sql_customerTable);
}
  $conn->bindValue(':sid',$sid);
  $conn->bindValue(':fname',$fname);
  $conn->bindValue(':lname',$lname);
  $conn->bindValue(':mobile',$mobile);
  $conn->bindValue(':block',$block);
  $conn->bindValue(':building',$building);
  $conn->execute();
echo "customer table exeute";
  /*
  if ($passwordChanged&&!$fileUploadFlag) { //only password
    $sql_userTable="UPDATE user SET Username= :uname, Password=:hpwd,Email=:email WHERE UID= :sid";
    $conn = $db->prepare($sql);
    $h_password=password_hash($password,PASSWORD_DEFAULT);
    $conn->bindValue(':hpwd' , $h_password);
  }
  else if (!$passwordChanged&&$fileUploadFlag) { //only file
    $sql="UPDATE users SET USERNAME= :uname, NAME=:name, CONTACT_NUM=:mobile,EMAIL=:email, COUNTRY=:country, PROFILE_PIC=:pfp WHERE USER_ID= :sid";
    $conn = $db->prepare($sql);
    $conn->bindValue(':pfp', $fn);
    echo "line 110";
  }
  else if ($passwordChanged&&$fileUploadFlag) { //both password and file
    $sql="UPDATE users SET USERNAME= :uname, PASSWORD=:hpwd, NAME=:name, CONTACT_NUM=:mobile,EMAIL=:email, COUNTRY=:country, PROFILE_PIC=:pfp WHERE USER_ID= :sid";
    $conn = $db->prepare($sql);
    $h_password=password_hash($password,PASSWORD_DEFAULT);
    $conn->bindValue(':hpwd' , $h_password);
    $conn->bindValue(':pfp', $fn);
    echo "line 118";
  }
  else{ //neither password nor file
    $sql="UPDATE users SET USERNAME=:uname, NAME=:name, CONTACT_NUM=:mobile,EMAIL=:email, COUNTRY=:country WHERE USER_ID= :sid";
    $conn = $db->prepare($sql);
  }
  $conn->bindValue(':uname' , $username);
  $conn->bindValue(':name' , $name);
  $conn->bindValue(':mobile' , $mobile);
  $conn->bindValue(':email' , $email);
  $conn->bindValue(':country' , $country);
  $conn->bindValue(':sid' , $sid);
  $conn->execute();
  */


  $db->commit();
  if ($conn->rowCount()==0) {
    header('location:profile.php?error=31');
    var_dump($conn);
  }
  elseif ($conn->rowCount()==1) {
    header('location:profile.php');
  }
  }catch(PDOException $e){
    $db->rollBack();
    echo "error message:".$e->getMessage();
    //will show msg on reg_loginform.php with refreshing + error
    //die();
    header('location:profile.php?error=3');

  }

  echo("if you see this then there's something wrong");
