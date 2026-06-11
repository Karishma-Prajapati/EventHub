<?php

session_start();

include("../Authentication/db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role']!="admin"){
    die("Access Denied");
}

$totalUsers = $conn->query(
"SELECT COUNT(*) AS total FROM users"
)->fetch_assoc()['total'];

$totalEvents = $conn->query(
"SELECT COUNT(*) AS total FROM events"
)->fetch_assoc()['total'];

$totalRegistrations = $conn->query(
"SELECT COUNT(*) AS total FROM registrations"
)->fetch_assoc()['total'];

$registrationData = $conn->query("
SELECT events.name,
COUNT(registrations.id) AS total
FROM events
LEFT JOIN registrations
ON events.id = registrations.event_id
GROUP BY events.id
");

$recentEvents = $conn->query("
SELECT *
FROM events
ORDER BY id DESC
LIMIT 3
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#f4f7fc;
}

.sidebar{
    position:fixed;
    width:250px;
    height:100vh;
    background:#1e293b;
    left:0;
    top:0;
}

.sidebar h2{
    color:white;
    text-align:center;
    padding:25px 0;
    border-bottom:1px solid #334155;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:15px 25px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#334155;
}

.main{
    margin-left:250px;
    padding:30px;
}

.header{
    background:white;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    margin-bottom:25px;
}

.header h1{
    color:#1e293b;
}

.header p{
    color:gray;
    margin-top:5px;
}

.stats{
    display:flex;
    gap:20px;
    margin-bottom:30px;
}

.card{
    flex:1;
    background:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 3px 12px rgba(0,0,0,0.1);
}

.card h2{
    font-size:38px;
    color:#2563eb;
    margin-bottom:10px;
}

.card p{
    color:#555;
}

.section{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 3px 12px rgba(0,0,0,0.1);
    margin-bottom:30px;
}

.section h2{
    margin-bottom:15px;
    color:#1e293b;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#2563eb;
    color:white;
    padding:12px;
}

table td{
    padding:12px;
    border-bottom:1px solid #ddd;
}

.events-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.event-card{
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 3px 10px rgba(0,0,0,0.1);
}

.event-card img{
    width:100%;
    height:180px;
    object-fit:cover;
}

.event-card-content{
    padding:15px;
}

.event-card h3{
    margin-bottom:10px;
}

.event-card p{
    color:#666;
    margin-bottom:5px;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    border-radius:8px;
    margin-top:10px;
}

.btn:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>

<div class="sidebar">

    <h2>EventHub</h2>

    <a href="adminDashboard.php">Dashboard</a>

    <a href="addEvent.php">Add Event</a>

    <a href="manageEvents.php">Manage Events</a>

    <a href="viewRegistrations.php">View Registrations</a>

    <a href="../Authentication/logout.php">Logout</a>

</div>

<div class="main">

    <div class="header">

        <h1>Welcome Admin 👋</h1>

        <p>Manage events, users and registrations from one place.</p>

    </div>

    <div class="stats">

        <div class="card">
            <h2><?php echo $totalUsers; ?></h2>
            <p>Total Users</p>
        </div>

        <div class="card">
            <h2><?php echo $totalEvents; ?></h2>
            <p>Total Events</p>
        </div>

        <div class="card">
            <h2><?php echo $totalRegistrations; ?></h2>
            <p>Total Registrations</p>
        </div>

    </div>

    <div class="section">

        <h2>📊 Registration Analytics</h2>

        <table>

            <tr>
                <th>Event Name</th>
                <th>Registrations</th>
            </tr>

            <?php while($row = $registrationData->fetch_assoc()){ ?>

            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['total']; ?></td>
            </tr>

            <?php } ?>

        </table>

    </div>

    <div class="section">

        <h2>🎉 Recent Events</h2>

        <div class="events-grid">

        <?php while($event = $recentEvents->fetch_assoc()){ ?>

            <div class="event-card">

                <img
                src="../uploads/<?php echo $event['image']; ?>"
                alt="Event Image">

                <div class="event-card-content">

                    <h3><?php echo $event['name']; ?></h3>

                    <p>📅 <?php echo $event['event_date']; ?></p>

                    <p>📍 <?php echo $event['location']; ?></p>

                    <a
                    href="../Home/eventDetails.php?id=<?php echo $event['id']; ?>"
                    class="btn">
                    View Event
                    </a>

                </div>

            </div>

        <?php } ?>

        </div>

    </div>

</div>

</body>
</html>