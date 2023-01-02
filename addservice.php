<?php
session_start();
extract($_POST);

if (isset($create)) {
  require("project_connection.php");
  $insertId = 0;
  try {
    $db->beginTransaction();
    $sql = "insert into services (NAME, PRICE, PICTURE, SERVICE_ACTIVE) values (:NAME, :PRICE, :PICTURE , 1)";
    $preparestatement = $db->prepare($sql);

    foreach ($_FILES["imagefile"]["name"] as $key => $val) {

      if ((($_FILES["imagefile"]["type"][$key] == "image/gif")
          || ($_FILES["imagefile"]["type"][$key] == "image/jpeg")
          || ($_FILES["imagefile"]["type"][$key] == "image/pjpeg")
          || ($_FILES["imagefile"]["type"][$key] == "image/png"))
        && ($_FILES["imagefile"]["size"][$key] < 6000000)
      ) {
        if ($_FILES["imagefile"]["error"][$key] > 0)
          echo "Return Code: " . $_FILES["imagefile"]["error"][$key] . "<br />";

        else {
          $fdetails = explode(".", $_FILES["imagefile"]["name"][$key]);
          $fext = end($fdetails);

          $fn = "img" . time() . uniqid(rand()) . ".$fext"; // to give name

          if (!move_uploaded_file($_FILES["imagefile"]["tmp_name"][$key], "image/$fn"))
            die("Failed to store file");

          $preparestatement->execute(['NAME' => $nop, 'PRICE' => $sprice, 'PICTURE' => $fn]);
          $insertId = $db->lastInsertId();
        }
      } else {
        die("Please upload a correct image file");
      }
    }
    $db->commit();
  } catch (PDOException $ex) {
    $db->rollback();
    die("Error Message" . $ex->getMessage());
  }
  //inserting into services_slots table
  try {
    $db->beginTransaction();
    $sql2 = "INSERT INTO services_slots (SERVICES_ID, TIME_SLOT_START, TIME_SLOT_END, SUNDAY, MONDAY, TUESDAY, WEDNESDAY, THURSDAY) VALUES (:SERVICES_ID, :TIME_SLOT_START, :TIME_SLOT_END, :SUNDAY, :MONDAY, :TUESDAY, :WEDNESDAY, :THURSDAY)";   //partially copilot
    $preparedStatement2 = $db->prepare($sql2); //copilot
    $SUNDAY = $MONDAY = $TUESDAY = $WEDNESDAY = $THURSDAY = 0;
    $valueExploded = explode('#', $DAY[0]);
    $index = $valueExploded[0]; //copilot

    if ($valueExploded[1] == 'SUNDAY')
      $SUNDAY = 1;
    else if ($valueExploded[1] == 'MONDAY')
      $MONDAY = 1; //copilot
    else if ($valueExploded[1] == 'TUESDAY') //copilot
      $TUESDAY = 1; //copilot
    else if ($valueExploded[1] == 'WEDNESDAY') //copilot
      $WEDNESDAY = 1;  //copilot
    else if ($valueExploded[1] == 'THURSDAY') //copilot
      $THURSDAY = 1;  //copilot

    foreach ($DAY as $value) {
      $valueExploded = explode("#", $value);
      if ($valueExploded[0] != $index) {
        $timeStart = $TIME[((int)$index - 1) * 2];
        $timeEnd = $TIME[(((int)$index - 1) * 2) + 1];
        echo $timeStart . "@@@" . $timeEnd;
        $preparedStatement2->execute(['SERVICES_ID' => $insertId, 'TIME_SLOT_START' => $timeStart, 'TIME_SLOT_END' => $timeEnd, 'SUNDAY' => $SUNDAY, 'MONDAY' => $MONDAY, 'TUESDAY' => $TUESDAY, 'WEDNESDAY' => $WEDNESDAY, 'THURSDAY' => $THURSDAY]);
        $SUNDAY = $MONDAY = $TUESDAY = $WEDNESDAY = $THURSDAY = 0;
        $index = $valueExploded[0];
      }

      if ($valueExploded[1] == 'SUNDAY')
        $SUNDAY = 1;
      else if ($valueExploded[1] == 'MONDAY')
        $MONDAY = 1;
      else if ($valueExploded[1] == 'TUESDAY')
        $TUESDAY = 1;
      else if ($valueExploded[1] == 'WEDNESDAY')
        $WEDNESDAY = 1;
      else if ($valueExploded[1] == 'THURSDAY')
        $THURSDAY = 1;
    }

    $timeStart = $TIME[((int)$index - 1) * 2];
    $timeEnd = $TIME[(((int)$index - 1) * 2) + 1];
    echo "<br/>, last one, timeslot start and end initialised, about to insert";
    $preparedStatement2->execute(['SERVICES_ID' => $insertId, 'TIME_SLOT_START' => $timeStart, 'TIME_SLOT_END' => $timeEnd, 'SUNDAY' => $SUNDAY, 'MONDAY' => $MONDAY, 'TUESDAY' => $TUESDAY, 'WEDNESDAY' => $WEDNESDAY, 'THURSDAY' => $THURSDAY]);
    echo "<br/>, last one, inserted and executed, insert id is " . $db->lastInsertId();
    $SUNDAY = $MONDAY = $TUESDAY = $WEDNESDAY = $THURSDAY = 0;
    echo "<br/>, last one , values reset";
    $index = $valueExploded[0];
    echo "<br/>, last one , new index" . $index;

    $db->commit();
  } catch (PDOException $ex) {
    $db->rollback();
    die("Error Message" . $ex->getMessage());
  }

  header("Location: viewmore.php?id=" . $insertId);
}

?>
<!-- head -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>Add Service</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <?php
  if ($_SESSION['userType'] == 'admin') {
    require('adminnavbar.php');
  }
  ?>
  <br /><br /><br />
  <section>
    <div class='container align-items-center font-weight-bold'>
      <form method="POST" id="addServiceForm" enctype="multipart/form-data" onSubmit="return checkeditedInputs();">
        <table class='table table-borderless'>
          <div class="form-group">
            <tr>
              <label class='col-form-label-lg'>
                <h3>Name of the service:</h3>
              </label>
              <input class="form-control" type='text' name='nop' onkeyup="checkName(this.value)" required />
              <span id='serviceName'></span>
            </tr>
          </div>

          <div class="form-group">
            <tr>
              <label class='col-form-label-lg'>
                <h3> Enter start price: </h3>
              </label>
              <input class="form-control" type="number" name="sprice" onkeyup="checkPrice(this.value)" step="0.1" min="0.1" required>
              <span id='servicePrice'></span>
            </tr>
          </div>

          <div class="form-group">
            <tr>
              <label class='col-form-label-lg'>
                <h3>Insert picture for service (<6mb): </h3>
              </label>
              <input class="form-control-file font-weight-bold text-white" type="file" name="imagefile[]" multiple required />
            </tr>
          </div>
        </table>


        <div id="slots">
          <div>
            <h4>Time Slot</h4>
            <label for="1#time1">Start time :</label>
            <input type="time" name="TIME[]" id="1#time1" required>
            &emsp;
            <label for="1#time2">End time :</label>
            <input type="time" name="TIME[]" id="1#time2" required>

            <h4>Select days of the week (atleast one required):</h4>
            <input type="checkbox" id="1#sunday" name="DAY[]" value="1#SUNDAY" checked>
            <label for="1#sunday">Sunday</label>
            &emsp;
            <input type="checkbox" id="1#monday" name="DAY[]" value="1#MONDAY">
            <label for="1#monday">Monday</label>
            &emsp;
            <input type="checkbox" id="1#tuesday" name="DAY[]" value="1#TUESDAY">
            <label for="1#tuesday">Tuesday</label>
            &emsp;
            <input type="checkbox" id="1#wednesday" name="DAY[]" value="1#WEDNESDAY">
            <label for="1#wednesday">Wednesday</label>
            &emsp;
            <input type="checkbox" id="1#thursday" name="DAY[]" value="1#THURSDAY">
            <label for="1#thursday">Thursday</label>

          </div>
          <br />


        </div> <!-- end of div.slots -->
        <input type='button' id='addSlotButton' class="btn btn-outline-primary mb-2" value="Add Time Slot">
        <div class="form-group">
          <input type='hidden' name='JSEnabled' value='false'>
          <input class='btn btn-secondary btn-lg btn-block' type='submit' name='create' value='Add' />
        </div>
      </form>
    </div>
  </section>
  <br />
  <!-- attach script.js -->
  <script src="./addslots_addservice.js"></script>
</body>
<script>
  var nameFlag = priceFlag = false;

  function checkName(name) {
    var nameRegex = /^([a-z]{2,}\s)*[a-z]+$/i;
    if (nameRegex.test(name)) {
      document.getElementById("serviceName").style.color = "green";
      document.getElementById("serviceName").innerHTML = "valid name";
      ajaxexists(name);
      nameFlag = true;

    } else {
      document.getElementById("serviceName").style.color = "red";
      document.getElementById("serviceName").innerHTML = "Service name can only be alphabetic and spaces, min 2 char long";
      nameFlag = false;
    }
  }

  function checkPrice(price) {
    var priceRegex = /^[0-9]+(\.[0-9]{1,1})?$/;
    if (priceRegex.test(price)) {
      document.getElementById("servicePrice").style.color = "green";
      document.getElementById("servicePrice").innerHTML = "valid price";
      priceFlag = true;
    } else {
      document.getElementById("servicePrice").style.color = "red";
      document.getElementById("servicePrice").innerHTML = "Price can only be numeric and max 1 decimal places";
      priceFlag = false;
    }
  }



  function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
      // Firefox, Opera 8.0+, Safari
      xmlHttp = new XMLHttpRequest();
    } catch (e) {
      // Internet Explorer
      try {
        xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
    }
    return xmlHttp;
  }

  function ajaxexists(word) {
    var xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
      alert("Your browser does not support AJAX!");
      return false;
    }

    var url = "./checkServiceName.php"
    url = url + "?name=" + word;

    xmlHttp.onreadystatechange = function() {
      if (xmlHttp.readyState == 4) {
        ajax_checking = xmlHttp.responseText;
        console.log(word + "---" + ajax_checking);
        reGajaxmsgs(ajax_checking);
      }
    }
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
  }

  function reGajaxmsgs(result) {
    if (result == "present") {
      document.getElementById('serviceName').style.color = "red";
      document.getElementById('serviceName').innerHTML = "Service name already registered";
      nameFlag = false;
    }
  }

  function checkeditedInputs() {
    document.getElementById('addServiceForm').JSEnabled.value = "TRUE";
    return (nameFlag && priceFlag);
  }
</script>

</html>