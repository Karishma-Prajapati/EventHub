<?php

session_start();

if(!isset($_SESSION['user_id']) ||
   $_SESSION['role']!="admin"){

    die("Access Denied");
}

include("../Authentication/db.php");

$result = $conn->query("SELECT * FROM events");

?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Events</title>
<link rel="stylesheet" href="../assets/style.css">
<style>

/* Overall Page & Typography Reset */
body {
    font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
    background-color: #f4f6f9;
    color: #333;
    padding: 30px;
    margin: 0;
}

/* Modern Header Style */
h2 {
    color: #2c3e50;
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 25px;
    position: relative;
    padding-bottom: 8px;
}

h2::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 4px;
    background-color: #3498db;
    border-radius: 2px;
}

/* Elegant Table Wrapper & Layout */
table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    overflow: hidden; /* Ensures borders snap to the rounded corners */
}

/* Header Styling */
th {
    background: #2c3e50;
    color: #ffffff;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 16px;
    text-align: center;
    border: none;
}

/* Data Cell Styling */
td {
    padding: 14px 16px;
    font-size: 15px;
    color: #4f5d73;
    border-bottom: 1px solid #eef2f5;
    text-align: center;
}

/* Zebra Striping & Row Hover Effect */
tr:nth-child(even) td {
    background-color: #f9fbfd;
}

tr:hover td {
    background-color: #f1f4f9;
    transition: background-color 0.2s ease;
}

/* Base Link/Button Styling */
a {
    display: inline-block;
    text-decoration: none;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 4px;
    margin: 2px 4px;
    transition: all 0.2s ease;
}

/* Styled Edit Button */
.edit {
    background-color: #2ecc71;
    color: white !important;
}

.edit:hover {
    background-color: #27ae60;
    box-shadow: 0 2px 5px rgba(46, 204, 113, 0.4);
    transform: translateY(-1px);
}

/* Styled Delete Button */
.delete {
    background-color: #e74c3c;
    color: white !important;
}

.delete:hover {
    background-color: #c0392b;
    box-shadow: 0 2px 5px rgba(231, 76, 60, 0.4);
    transform: translateY(-1px);
}

</style>

</head>

<body>

<h2>Manage Events</h2>

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Date</th>
<th>Location</th>
<th>Seats</th>
<th>Action</th>
</tr>

<?php while($row=$result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['event_date']; ?></td>

<td><?php echo $row['location']; ?></td>

<td><?php echo $row['total_seats']; ?></td>

<td>

<a
class="edit"
href="editevent.php?id=<?php echo $row['id']; ?>">
Edit
</a>

<a
class="delete"
href="deleteEvent.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Are you sure you want to delete this event? You can\'t restore it later.');">
   Delete
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>