<?php
require("noCache.php");
//validate name
extract($_GET);
try {
require('project_connection.php');
$conn = $db->prepare("SELECT * FROM services WHERE NAME= :name");
$conn->bindParam(':name' , $name);

$conn->execute();
$row=$conn->fetchAll();
if (sizeof($row)==0)
  echo "absent";
else
  echo "present";
} catch (PDOException $e) {
echo "Error Message ".$e->getMessage();
}
