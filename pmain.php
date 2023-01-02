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


    <nav class="navbar navbar-expand-md bg-body-tertiary fixed-top border border-dark-subtle border-top-0 border-end-0 border-start-0">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
          <img src="./assets/pet_logo1.png" alt="Logo" width="40" height="34" class="d-inline-block">
          PetPrism</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#services">Services</a>
            </li>
          </ul>

        </div>
      </div>

    </nav>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>



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