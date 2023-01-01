<?php
require("project_connection.php");
extract($_GET); //$id of services table
try {
  $db->beginTransaction();
  $sql1 = "UPDATE services
SET SERVICE_ACTIVE = 0 WHERE ID = :id";
  $result = $db->prepare($sql1);
  $result->bindParam(':id', $id);
  $result->execute();

  $db->commit();
} catch (PDOException $e) {
  $db->rollBack();
  die("Error Message" . $e->getMessage());
}

header("Location: browse.php");
