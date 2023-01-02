<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>PetPRism</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="pstyle.css">
  <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container">

    <?php
    session_start();
    if (!isset($_SESSION['userType']))
      require('landingnavbar.php');
    else if ($_SESSION['userType'] == 'admin')
      require('adminnavbar.php');
    else if ($_SESSION['userType'] == 'customer')
      require('customernavbar.php');
    ?>


    <section class="about" id="about">

      <div class="image">
        <img src="./assets/Aboutus.jpg" alt="">
      </div>

      <div class="content">
        <h2>Welcome to PetPrism</h2>
        <p>We endeavor to give your pets pleasant, personalized care. PetPrism  first opened its doors in 2022 as a
          single vet facility servicing pets and rescue animals. PetPrism has developed over the years and currently
          employs two veterinary surgeons, four veterinary technicians, and three highly skilled customer service and
          administrative personnel.</p>

      </div>
    </section>


    <section class="services" id="services">
      <center>
        <h2 class="heading"> Our Services </h2>
      </center>


      <div class="box-container">

        <div class="box">
          <i class="fas fa-dog"></i>
          <h3>dog boarding</h3>
          <a href="login_form.php" class="btn">read more</a>
        </div>

        <div class="box">
          <i class="fas fa-cat"></i>
          <h3>cat boarding</h3>
          <a href="login_form.php" class="btn">read more</a>
        </div>

        <div class="box">
          <i class="fas fa-bath"></i>
          <h3>spa & grooming</h3>
          <a href="login_form.php" class="btn">read more</a>
        </div>
      </div>
    </section>




  </div>
</body>

</html>