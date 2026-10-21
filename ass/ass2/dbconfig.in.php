<?php

$host = "localhost";
$dbname = "web1230667_db";
$username = "web1230667_dbuser";
$password = 'B3mh$pU!nT';

$connString = "mysql:host=$host;dbname=$dbname";

$pdo = new PDO($connString, $username, $password);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>