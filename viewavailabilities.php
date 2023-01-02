<?php
session_start();
if (!isset($_SESSION['userId']))
  header('location:../login_form.php');

extract($_GET); // $id which represents ID of services table

if (isset($check)) {
  $currentDate = date('Y-m-d');
  if ($date <= $currentDate)
    die("Please choose a valid date");

  require('project_connection.php');
  $dayOfWeek = date("l", strtotime($date));

  $dayOfWeek = strtoupper($dayOfWeek);

  if ($dayOfWeek != "FRIDAY" && $dayOfWeek != "SATURDAY") {
    try {
      $sql = "SELECT * FROM services_slots WHERE SERVICES_ID=:id AND " . $dayOfWeek . "= 1";
      $result = $db->prepare($sql);
      $result->bindParam(':id', $id);
      $result->execute();

      //select * from bookings where SERVICES_ID=$id
      $sql2 = "SELECT * FROM bookings WHERE SERVICES_ID=:id2 AND BOOKING_DATE=:date";
      $result2 = $db->prepare($sql2);
      $result2->bindParam(':id2', $id);
      $result2->bindParam(':date', $date);
      $result2->execute();

      $result2rows = $result2->fetchAll();

      $db = null;
    } catch (PDOException $e) {
      die("Error Message" . $e->getMessage());
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


<body>
  <?php
  if ($_SESSION['userType'] == 'customer') {
    require('customernavbar.php');
  }
  ?>
  <br /><br /><br />

  <div class="container-lg d-flex justify-content-center flex-column align-items-center">
    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 d-flex justify-content-center flex-column align-items-center border border-secondary border-2 rounded ">
      <form method='get'>
        <div class="mt-2 mb-3">
          <input type="date" name='date' min="<?php echo Date('Y-m-d', strtotime('+1 days')); ?>" max="<?php echo Date('Y-m-d', strtotime('+14 days')); ?>">
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div><input type="submit" name='check' value='Check Availabilities' class="mb-2"></div>

      </form>
    </div>
  </div>


  <?php
  if (isset($check)) {

    $dayOfWeek = strtoupper(date("l", strtotime($date)));
    if (isset($check) && $dayOfWeek != "FRIDAY" && $dayOfWeek != "SATURDAY") {
  ?>
      <div class="container-md text-center">
        <h4 class='mt-3 mb-2'> Timings for <?php echo $date; ?></h4>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">Timing Slot</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
          <?php
          foreach ($result as $row) {
            /*
fetch all ($result) the timeslots (i.e each slot is $row) for the service. then fetch all the bookedslots for that service ON THAT DAY.

For every timeslot ($row) check if it exists in the booking table for that day. To do this, we go through all the slots in the booking table for that service on that day. And we compare each bookedslot for that service on that day (bookedRows) to the timeslot ($row). If they are equal, meaning the slot is booked on that day, FOR THAT SERVICE, then we skip.
When the loop ends but we did not find the timeslot in the bookingtable for that service on that day ($result2rows) then we exit teh loop and display that slot in the table.
*/
            /*       echo "%%%%%%%%%a";
      echo $row['ID'];
      echo "a%%%%%%%%%";
      echo var_dump($result2);
      $test = $result2->fetch();
      echo var_dump($test); */
            $booked = false;
            foreach ($result2rows as $bookedRows) {
              /*         echo "-------------";
        echo $bookedRows['SERVICES_SLOTS_ID'];
        echo "-------------";
        echo $row['ID'];
        echo "-------------"; */
              if ($bookedRows['SERVICES_SLOTS_ID'] == $row['ID'])
                $booked = true;
            }

            if (!$booked) {
              echo "<tr>";
              echo "<th scope='row'>" . $row['TIME_SLOT_START'] . "-" . $row['TIME_SLOT_END'] . "</th>";

              echo "<td>";
              echo "<form method='get' action='book.php'>";
              echo "<input type='hidden' name='id' value='" . $row["ID"] . "'/>";
              echo "<input type='hidden' name='date' value='" . $date . "'/>";
              echo "<input type='hidden' name='sid' value='" . $row["SERVICES_ID"] . "'/>";
              echo "<input type='submit' class='btn btn-primary btn-sm' name='book' value='Book timing'/>";
              echo "</form>";
              echo "</td>";
              echo "</tr>";
            }
          }
          echo "</tbody>";
          echo "</table>";
          echo "</div>";
        } else if (isset($check) && ($dayOfWeek == "FRIDAY" || $dayOfWeek == "SATURDAY"))
          echo "Weekends are are not available for booking";
      }
          ?>
        </div>

</body>