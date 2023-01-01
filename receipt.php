<?php
//get all details from booking table for the booking id and display it
require("connection.php");
extract($_GET); //$bookingId
try {
  $sql = "SELECT * FROM bookings WHERE ID=:id";
  $result = $db->prepare($sql);
  $result->bindParam(':id', $bookingId);
  $result->execute();
  $row = $result->fetch();

  $sql2 = "SELECT * FROM services_slots WHERE ID=:id";
  $result2 = $db->prepare($sql2);
  $result2->bindParam(':id', $row['SERVICES_SLOTS_ID']);
  $result2->execute();
  $row2 = $result2->fetch();

  $sql3 = "SELECT * FROM services WHERE ID=:id";
  $result3 = $db->prepare($sql3);
  $result3->bindParam(':id', $row2['SERVICES_ID']);
  $result3->execute();
  $row3 = $result3->fetch();

  $db = null;
} catch (PDOException $e) {
  die("Error Message" . $e->getMessage());
}

if ($result->rowcount() > 0) {
  echo "Booking ID: " . $row['ID'] . "<br/>";
  echo "Booking Date: " . $row['BOOKING_DATE'] . "<br/>";

  echo "Service time slot: " . $row2['TIME_SLOT_START'] . "-" . $row2['TIME_SLOT_END'] . "<br/>";
  echo "Service name: " . $row3['NAME'] . "<br/>";
  echo "Service price: " . $row3['PRICE'] . "<br/>";
  echo "Service rating: " . $row3['RATING'] . "/5" . "<br/>";
}
