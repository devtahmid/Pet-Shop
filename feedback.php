<?php

use function PHPSTORM_META\sql_injection_subst;

session_start();
extract($_POST);

try {
  require("project_connection.php");
  $sql = "INSERT INTO feedback (SERVICE_ID, RATING, REVIEW, BOOKING_ID) VALUES (:serviceId, :rating, :review ,:bookingId)";

  $result = $db->prepare($sql);
  $result->bindParam(':serviceId', $serviceId);
  $result->bindParam(':rating', $rating);
  $result->bindParam(':review', $review);
  $result->bindParam(':bookingId', $bookingId);
  $result->execute();
  header("Location: browse.php");
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
