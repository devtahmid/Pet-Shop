<?php
//get all details from booking table for the booking id and display it
session_start();
require("project_connection.php");
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receipt</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body>
  <?php
  if ($_SESSION['userType'] == 'customer') {
    require('customernavbar.php');
  }
  ?>
  <br /><br /><br /> <br /><br /><br />

  <div class="container-xl d-flex justify-content-center flex-column align-items-center">

    <div class="d-flex justify-content-center flex-column align-items-center border border-secondary border-2 rounded ">
      <h1>Receipt</h1>
      <?php
      if ($result->rowcount() > 0) {
        echo "<b>Booking ID: " . $row['ID'] . "</b><br/>";
        echo "<b>Booking Date: " . $row['BOOKING_DATE'] . "</b><br/>";

        echo "<b>Service time slot: " . $row2['TIME_SLOT_START'] . "-" . $row2['TIME_SLOT_END'] . "</b><br/>";
        echo "<b>Service name: " . $row3['NAME'] . "</b><br/>";
        echo "<b>Service price: BHD " . $row3['PRICE'] . "</b><br/>";
        echo "<b>Service rating: " . $row3['RATING'] . "/5" . "</b><br/>";
      }
      ?>

    </div>

  </div>
</body>

</html>