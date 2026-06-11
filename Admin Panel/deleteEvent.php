<?php

session_start();

if(!isset($_SESSION['user_id']) ||
   $_SESSION['role']!="admin"){

    die("Access Denied");
}

include("../Authentication/db.php");

$id = $_GET['id'];

$conn->query(
"DELETE FROM events WHERE id=$id"
);

header("Location: manageevents.php");
exit();

?>