<?php
session_start();

if (!isset($_SESSION['username'])) {
    include '../views/login.php';
} else {
    include '../views/home.php';
}
