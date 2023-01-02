<?php
//rate and review all the booked services that were received
session_start();
$userId = $_SESSION['userId'];
try {
  require("project_connection.php");
  $sql1 = "SELECT * FROM bookings WHERE USER_ID= :userId AND BOOKING_DATE <= CURDATE()";
  $result1 = $db->prepare($sql1);
  $result1->bindParam(':userId', $userId);
  $result1->execute();

  $sql2 = "SELECT * FROM services_slots WHERE ID= :id";
  $result2 = $db->prepare($sql2);

  $sql3 = "SELECT * FROM services WHERE ID= :id";
  $result3 = $db->prepare($sql3);

  $sql4 = "SELECT * FROM feedback WHERE BOOKING_ID= :bookingId";
  $result4 = $db->prepare($sql4);

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booked Services</title>
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- add styles in head -->
    <style>
      .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        overflow: hidden;
      }

      .rating>input {
        display: none;
      }

      .rating>label {
        position: relative;
        width: 1.1em;
        font-size: 2em;
        color: #ffcc00;
        cursor: pointer;
      }

      .rating>label::before {
        content: "\2605";
        position: absolute;
        opacity: 0;
      }

      .rating>label:hover:before,
      .rating>label:hover~label:before {
        opacity: 1 !important;
      }

      .rating>input:checked~label:before {
        opacity: 1;
      }

      .rating:hover>input:checked~label:before {
        opacity: 0.4;
      }
    </style>

  </head>

  <body>
    <?php
    if ($_SESSION['userType'] == 'customer')
      require('customernavbar.php');
    ?>
    <br><br><br>
    <div class='container-lg'>
      <h4 class="mt-3 mb-2 mx-auto"> Rating pending.. </h4>

      <div class="table-responsive text-center">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">Service Name</th>
              <th scope="col">Booked Date</th>
              <th scope="col">Booked Time</th>
              <th scope="col">Rate and Review</th>
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

              if (($booking['BOOKING_DATE'] < date('Y-m-d')) || ($booking['BOOKING_DATE'] == date('Y-m-d')) && ($slotRow['TIME_SLOT_END'] < date("h:i:s"))) { //booking date passed away, before today OR date is today and time slot has passed away

                $result4->bindParam(':bookingId', $booking['ID']);
                $result4->execute();

                if ($result4->rowCount() == 0) {
                  echo "<td scope='row'>" . $serviceRow['NAME'] . "</td>";
                  echo "<td>" . $booking['BOOKING_DATE']  . "</td>";
                  echo "<td>" . $slotRow['TIME_SLOT_START'] . " - " . $slotRow['TIME_SLOT_END'] . "</td>";
            ?>
                  <td>

                    <form method='post' action='feedback.php' onsubmit="return checkValidation()">
                      <!-- 5 stars for feedback with css-->
                      <div class="rating">

                        <input type="radio" name="rating" value="5" id="5" onclick="checkStar()"><label for="5">☆</label>
                        <input type="radio" name="rating" value="4" id="4" onclick="checkStar()"><label for="4">☆</label>
                        <input type="radio" name="rating" value="3" id="3" onclick="checkStar()"><label for="3">☆</label>
                        <input type="radio" name="rating" value="2" id="2" onclick="checkStar()"><label for="2">☆</label>
                        <input class="radioStar" type="radio" name="rating" value="1" id="1" onclick="checkStar()"><label for="1">☆</label>

                      </div>

                      <textarea class="fs-subtitle" style="height:40px; padding: 10px; resize: none;" name="review" minlength="3" maxlength="500" required placeholder="Let us know what you think..."></textarea>

                      <h6 class=".text-danger" id="errorMsg" style="color:rgb(240, 59, 14)"></h6>
                      <input type='hidden' name='serviceId' value='<?php echo $booking['SERVICES_ID'];  ?>'>
                      <input type='hidden' name='bookingId' value='<?php echo $booking['ID'];  ?>'>
                      <input class="btn btn-outline-info btn-sm" type="submit" name="submit" value="Submit" />
                    </form>


                  </td>
                  </tr>


          <?php
                }
              }
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
  <script>
    var starFlag = false; //if ratings selected
    //textarea uses required so we dont need js for that
    function checkStar() {
      starFlag = true;
      document.getElementById("errorMsg").innerHTML = "";
    }

    function checkValidation() {
      if (!starFlag) {
        document.getElementById("errorMsg").innerHTML = "Please select a star rating"
      }
      return starFlag;
    }
  </script>

  </html>