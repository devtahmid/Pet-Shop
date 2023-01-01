//view all the booked services for a specific customer from services table
<?php
session_start();
$userId = $_SESSION['userId'];
try {
  require("project_connection.php");
  $sql1 = "SELECT * FROM bookings WHERE USER_ID= :userId";
  $result1 = $db->prepare($sql1);
  $result1->bindParam(':userId', $userId);
  $result1->execute();

  $sql2 = "SELECT * FROM services_slots WHERE ID= :id";
  $result2 = $db->prepare($sql2);

  $sql3 = "SELECT * FROM services WHERE ID= :id";
  $result3 = $db->prepare($sql3);

  foreach ($result1 as $booking) {

    $result2->bindParam(':id', $booking['SERVICES_SLOTS_ID']);
    $result2->execute();
    $slotRow = $result2->fetch();

    $result3->bindParam(':id', $slotRow['SERVICES_ID']);
    $result3->execute();
    $serviceRow = $result3->fetch();

    echo "Service name:" . $serviceRow['NAME'] . "<br>";
    echo "Service date:" . $booking['BOOKING_DATE'] . "<br>";
    echo "Service time:" . $slotRow['TIME_SLOT_START'] . " - " . $slotRow['TIME_SLOT_START'] . "<br>";
    echo "Status: ";

    if ($booking['BOOKING_DATE']<=date('Y-m-d')) {
    /*   if (condition) {
        # code...
      } */
    }
  }
  $db = null;
} catch (PDOException $e) {
  die("Error Message" . $e->getMessage());
}

?>