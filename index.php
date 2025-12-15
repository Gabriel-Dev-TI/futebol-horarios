<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header("Location:login.php");
    exit();
}
else {
    header("Location:dashboard.php");
    exit();
}

?>