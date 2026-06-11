<?php

session_start();

include("../Authentication/db.php");

if($_SESSION['role']!="admin"){
    die("Access Denied");
}

$sql="
SELECT
users.name,
users.email,
events.name AS event_name,
registrations.registered_at

FROM registrations

JOIN users
ON registrations.user_id=users.id

JOIN events
ON registrations.event_id=events.id
";

$result=$conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
<title>Registrations</title>
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
    background-color: #3498db; /* Elegant blue accent line */
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
    background: #2c3e50; /* Deep professional slate blue */
    color: #ffffff;
    font-weight: 600;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 16px;
    text-align: center;
    border: none;
}

/* Data Cell Styling */
td {
    padding: 14px 16px;
    font-size: 14px;
    color: #3a3f46;
    border-bottom: 1px solid #eef2f5;
    text-align: center;
}

/* Zebra Striping (Alternating row colors) */
tr:nth-child(even) td {
    background-color: #f9fbfd;
}

/* Smooth Row Hover Effect */
tr:hover td {
    background-color: #f1f4f9;
    color: #1a252f; /* Slightly darkens text on hover */
    transition: all 0.15s ease;
}

/* Highlight important columns subtly (Optional but looks great) */
td:nth-child(3) {
    font-weight: 500; /* Makes the Event Name stand out slightly */
    color: #394754;
}

/* Responsive Container for smaller screens */
@media (max-width: 768px) {
    body {
        padding: 15px;
    }
    table {
        display: block;
        overflow-x: auto;
    }
}

</style>

</head>

<body>

<h2>Event Registrations</h2>

<table>

<tr>
<th>Name</th>
<th>Email</th>
<th>Event</th>
<th>Registration Date</th>
</tr>

<?php while($row=$result->fetch_assoc()) { ?>

<tr>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['event_name']; ?></td>

<td><?php echo $row['registered_at']; ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>