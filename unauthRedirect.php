<?php 
session_start();
if(empty($_SESSION['ID'])) {
    header("Location: login.html");
}
?>