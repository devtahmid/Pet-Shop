<?php
require("connection.php");



try {
  $sql = "SELECT * FROM SERVICES";
  $result = $db->query($sql);

  $db = null;
} catch (PDOException $e) {
  die("Error Message" . $e->getMessage());
}

if ($result->rowcount() > 0) {

  foreach ($result as $row) {

    echo $row['NAME'] . "<br/>" . "BD " . $row['PRICE'] . "<br /> <img src='./image/" . $row['PICTURE'] . "' width='100' height='100'>";
    echo "<form method='get' action='viewmore.php'>";
    echo "<input type='hidden' name='id' value='" . $row["ID"] . "'/>";
    echo "<input type='submit' name='view' value='View More Details'/>";
    echo "</form>";
  }
}
