<?php
require("project_connection.php");
session_start();
extract($_GET); //$id
try {
  $sql1 = "SELECT * FROM services WHERE ID= :id";
  $result = $db->prepare($sql1);
  $result->bindParam(':id', $id);
  $result->execute();

  $sql2 = "SELECT * FROM services_slots WHERE SERVICES_ID= :id";
  $result2 = $db->prepare($sql2);
  $result2->bindParam(':id', $id);
  $result2->execute();

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
  <title>View Item</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <?php
  if ($_SESSION['userType'] == 'admin') {
    require('adminnavbar.php');
  } /* else if(){
}
 */
  ?>

  <br /><br /><br /><br />

  <main class="container-xl">
    <?php

    if ($result->rowcount() > 0) {

      foreach ($result as $row) {
    ?>
        <div class="row">
          <div class="col">
            <img class="img-fluid" src='./image/<?php echo $row['PICTURE'] ?>'>
          </div>
          <div class="col">
            <div class="row text-center">
              <div class="col-xs-12 mb-3">
                <h3> <?php echo $row['NAME']; ?> </h3>
              </div>
              <div class="col-xs-12 mb-3">
                <b>Price:</b> BHD <?php echo  $row['PRICE']; ?>
              </div>
              <div class="col-xs-12">
                <b>Rating:</b> <?php echo $row['RATING']; ?> / 5
              </div>
            </div>
          </div>
        </div>
        <h4 class="mt-3 mb-2"> Working hours (Check availabilitites to book a time):-</h4>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Time Slot</th>
                <th scope="col">Sunday</th>
                <th scope="col">Monday</th>
                <th scope="col">Tuesday</th>
                <th scope="col">Wednesday</th>
                <th scope="col">Thursday</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              <?php
              foreach ($result2 as $row2) {

                echo "<tr>";
                echo "<th scope='row'>" . $row2['TIME_SLOT_START'] . "-" . $row2['TIME_SLOT_END'] . "</th>";
                echo "<td>" . $row2['SUNDAY'] . "</td>";
                echo "<td>" . $row2['MONDAY'] . "</td>";
                echo "<td>" . $row2['TUESDAY'] . "</td>";
                echo "<td>" . $row2['WEDNESDAY'] . "</td>";
                echo "<td>" . $row2['THURSDAY'] . "</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="container-xl text-center">
          <form method='get' action='viewavailabilities.php'>
            <input type='hidden' name='id' value='<?php echo $row["ID"]; ?>' />
            <input type='submit' name='book' class="btn btn-primary" value='Check Availabilities' />
          </form>
        </div>
    <?php
      }
    }
    ?>