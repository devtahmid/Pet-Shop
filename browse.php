<?php
require("project_connection.php");

session_start();
if (!isset($_SESSION['userId']))
  header('location:../login_form.php');

try {
  $sql = "SELECT * FROM SERVICES WHERE SERVICE_ACTIVE = 1";
  $result = $db->query($sql);

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
  <title>Browse</title>
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <?php
  if ($_SESSION['userType'] == 'admin')
    require('adminnavbar.php');
  else if ($_SESSION['userType'] == 'customer')
    require('customernavbar.php');

  ?>
  <br /><br /><br />

  <main class="container-xl text-center">
    <div class="row">
      <?php

      if ($result->rowcount() > 0) {

        foreach ($result as $row) {

      ?>
          <div class="col mt-3  mx-auto">
            <div class="card" style="width: 18rem;">
              <img src="./image/<?php echo $row['PICTURE']; ?>">
              <div class="card-body">


                <h3 class="card-title"> <?php echo $row['NAME']; ?></h3>
                <p class="card-text">BHD <?php echo $row['PRICE']; ?></p>
                <form method='get' action='viewmore.php'>
                  <input type='hidden' name='id' value='<?php echo $row["ID"]; ?>' />
                  <input type='submit' class="btn btn-primary" name='view' value='View More Details' />
                </form>
              </div>
            </div>
          </div>
      <?php

        }
      }
      ?>
    </div>
  </main>




</body>

</html>