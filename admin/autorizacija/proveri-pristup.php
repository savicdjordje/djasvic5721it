<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /djasvic5721it/admin/autorizacija/login.php");
    exit();
}