<?php

session_start();

if(!isset($_SESSION['user_id'])){

header("Location: login.php");

exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<h2>
Welcome
<?php
echo $_SESSION['name'];
?>
</h2>

<p>
Role:
<?php
echo $_SESSION['role'];
?>
</p>

<a href="../User Panel/myevents.php">
My Events
</a>

<a href="logout.php">
Logout
</a>

</body>
</html>