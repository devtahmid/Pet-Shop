// get booking data from viewavailabilities.php and insert into bookings table into database
<?php
require("connection.php");
extract($_GET); //$id of services_slots , $date
try {
  $db->beginTransaction();
  $sql1 = "INSERT INTO bookings (SERVICES_SLOTS_ID, BOOKING_DATE, SERVICES_ID) VALUES (:id, :date, :sid)";
  $result = $db->prepare($sql1);
  $result->bindParam(':id', $id);
  $result->bindParam(':date', $date);
  $result->bindParam(':sid', $sid);
  $result->execute();
  $bookingId = $db->lastInsertId();

  $db->commit();
} catch (PDOException $e) {
  $db->rollBack();
  die("Error Message" . $e->getMessage());
}

header("Location: receipt.php?bookingId=$bookingId");

?>