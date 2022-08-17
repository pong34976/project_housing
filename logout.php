<?php 
session_start();
unset($_SESSION["id"]);
unset($_SESSION["fullname"]);
unset($_SESSION["level"]);
header("Location: login.php");