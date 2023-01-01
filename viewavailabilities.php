<?php

extract($_GET); // $id which represents ID of services table

if (isset($check)) {
  $currentDate = date('Y-m-d');
  if ($date <= $currentDate)
    die("Please choose a valid date");

  require('connection.php');
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

<body>

  <form method='get'>
    <input type="date" name='date' min="<?php echo Date('Y-m-d', strtotime('+1 days')); ?>" max="<?php echo Date('Y-m-d', strtotime('+14 days')); ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <input type="submit" name='check' value='Check Availabilities'>

  </form>

  <?php
  $dayOfWeek = strtoupper(date("l", strtotime($date)));
  if (isset($check) && $dayOfWeek != "FRIDAY" && $dayOfWeek != "SATURDAY") {
    echo "Timings for " . $date . ":- <br />";
    echo "Time slot ---- Sunday ----Monday --- Tuesday ---- Wednesday ---- Thursday  <br/>";
    foreach ($result as $row) {
      /*       echo "%%%%%%%%%a";
      echo $row['ID'];
      echo "a%%%%%%%%%";
      echo var_dump($result2);
      $test = $result2->fetch();
      echo var_dump($test); */
      foreach ($result2rows as $bookedRows) {
        /*         echo "-------------";
        echo $bookedRows['SERVICES_SLOTS_ID'];
        echo "-------------";
        echo $row['ID'];
        echo "-------------"; */
        if ($bookedRows['SERVICES_SLOTS_ID'] == $row['ID']) {
          goto skip;
        }
      }
      echo $row['TIME_SLOT_START'] . "-" . $row['TIME_SLOT_END'] . "----";
      echo $row['SUNDAY'] . "----" . $row['MONDAY'] . "----" . $row['TUESDAY'] . "----" . $row['WEDNESDAY'] . "----" . $row['THURSDAY'];

      echo "<form method='get' action='book.php'>";
      echo "<input type='hidden' name='id' value='" . $row["ID"] . "'/>";
      echo "<input type='hidden' name='date' value='" . $date . "'/>";
      echo "<input type='hidden' name='sid' value='" . $row["SERVICES_ID"] . "'/>";
      echo "<input type='submit' name='book' value='Book timing'/>";
      echo "</form>";
      echo "<br/>";
      skip:
    }
  } else
    echo "Weekends are are not available for booking";
  ?>

</body>