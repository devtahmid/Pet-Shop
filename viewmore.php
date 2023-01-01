<?php
require("connection.php");
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

if ($result->rowcount() > 0) {

  foreach ($result as $row) {

    echo $row['NAME'] . "<br/>" . "BD " . $row['PRICE'] . "<br/>" . "Rating: " . $row['RATING'] . "/5" . "<br /> <img src='./image/" . $row['PICTURE'] . "' width='100' height='100'>";

    echo "Timings:- <br />";
    echo "Time slot ---- Sunday ----Monday --- Tuesday ---- Wednesday ---- Thursday  <br/>";
    foreach ($result2 as $row2) {
      echo $row2['TIME_SLOT_START'] . "-" . $row2['TIME_SLOT_END'] . "----";
      echo $row2['SUNDAY'] . "----" . $row2['MONDAY'] . "----" . $row2['TUESDAY'] . "----" . $row2['WEDNESDAY'] . "----" . $row2['THURSDAY'];
      echo "<br/>";
    }


    echo "<form method='get' action='viewavailabilities.php'>";
    echo "<input type='hidden' name='id' value='" . $row["ID"] . "'/>";
    echo "<input type='submit' name='book' value='Book Service'/>";
    echo "</form>";
  }
}
