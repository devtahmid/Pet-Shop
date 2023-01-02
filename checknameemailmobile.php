<?php
require("noCache.php");
//validate username and password
extract($_GET);
try {
require('project_connection.php');
if (isset($email)) {
$conn = $db->prepare("SELECT * FROM users WHERE EMAIL= :mail");
$conn->bindParam(':mail' , $email);
}
elseif (isset($mobile)) {
$conn = $db->prepare("SELECT * FROM users WHERE PHONE= :num");
$conn->bindParam(':num' , $mobile);
}
$conn->execute();
$row=$conn->fetchAll();
if (sizeof($row)==0)
  echo "absent";
else
  echo "present";
} catch (PDOException $e) {
echo "Error Message ".$e->getMessage();
}
?>
