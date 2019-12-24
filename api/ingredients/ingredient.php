<?php

$servername = "jawtoch.ddns.net";
$username = "guest";
$password = "";
$dbname = "db";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET["name"])) {
    $name = $_GET["name"];
} else {
    $name = "";
}

$sql = "SELECT DISTINCT ingredient FROM ingredients WHERE ingredient LIKE '%$name%'";

$array = array();

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_row()) {
        array_push($array, $row[0]);
    }
}

print json_encode($array);

$conn->close();