<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

switch ($_SESSION["user_type"]) {

    case "manager":
        header("Location: manager.php");
        exit();

    case "customer":
        header("Location: customer.php");
        exit();

    default:
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
}