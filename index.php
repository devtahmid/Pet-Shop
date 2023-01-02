<?php

session_Start();

if (isset($_SESSION['activeUser']))
  header('location:browse.php');

else
  header('location:login_form.php');
