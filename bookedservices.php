<?php
//view all the booked services for a specific customer from services table
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
?>



  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Services</title>
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <?php
    if ($_SESSION['userType'] == 'customer')
      require('customernavbar.php');
    ?>
    <br><br><br>
    <div class='container-lg'>
      <h4 class="mt-3 mb-2 mx-auto"> Booked Services </h4>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Service Name</th>
              <th scope="col">Booked Date</th>
              <th scope="col">Booked Time</th>
              <th scope="col">Status</th>
              <th scope="col">Receipt</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
          <?php

          foreach ($result1 as $booking) {

            $result2->bindParam(':id', $booking['SERVICES_SLOTS_ID']);
            $result2->execute();
            $slotRow = $result2->fetch();

            $result3->bindParam(':id', $slotRow['SERVICES_ID']);
            $result3->execute();
            $serviceRow = $result3->fetch();
            echo "<tr>";

            echo "<td scope='row'>" . $serviceRow['NAME'] . "</td>";
            echo "<td>" . $booking['BOOKING_DATE']  . "</td>";
            echo "<td>" . $slotRow['TIME_SLOT_START'] . " - " . $slotRow['TIME_SLOT_END'] . "</td>";

            if (($booking['BOOKING_DATE'] < date('Y-m-d'))) {
              echo "<td> Received </td>";
            } elseif (($booking['BOOKING_DATE'] == date('Y-m-d')) && ($slotRow['TIME_SLOT_END'] < date("h:i:s"))) {
              echo "<td> Received </td>";
            } else
              echo "<td> Upcoming </td>";


            echo "<td> <a href='receipt.php?bookingId=" . $booking['ID'] . "'>Receipt</a> </td>";
            echo "</tr>";
          }
          echo "</tbody>";
          echo "</table>";
          echo "</div>";
          $db = null;
        } catch (PDOException $e) {
          die("Error Message" . $e->getMessage());
        }
        echo "</div>";
          ?>
  </body>

  </html>