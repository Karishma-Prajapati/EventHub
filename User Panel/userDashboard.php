<?php

session_start();

include("../Authentication/db.php");

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

$totalEvents =
$conn->query(
"SELECT COUNT(*) total
 FROM events"
)->fetch_assoc()['total'];

$myRegistrations =
$conn->query(
"SELECT COUNT(*) total
 FROM registrations
 WHERE user_id='$user_id'"
)->fetch_assoc()['total'];

$totalTickets =
$conn->query(
"SELECT COUNT(*) total
 FROM tickets
 WHERE user_id='$user_id'"
)->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f1f5f9;
min-height:100vh;
}

/* HEADER */

.header{
background:
linear-gradient(
135deg,
#2563eb,
#1e40af
);
color:white;
padding:60px 30px;
text-align:center;
box-shadow:
0 5px 20px rgba(0,0,0,.15);
}

.header h1{
font-size:42px;
margin-bottom:10px;
}

.header p{
font-size:18px;
opacity:.9;
}

/* STAT CARDS */

.cards{
display:flex;
justify-content:center;
gap:25px;
flex-wrap:wrap;
margin:40px;
}

.card{
background:white;
width:260px;
padding:30px;
border-radius:20px;
text-align:center;
box-shadow:
0 10px 25px rgba(0,0,0,.08);
transition:.3s;
}

.card:hover{
transform:translateY(-10px);
box-shadow:
0 15px 35px rgba(0,0,0,.15);
}

.card h2{
font-size:42px;
color:#2563eb;
margin-bottom:10px;
}

.card p{
font-size:16px;
color:#64748b;
}

/* BUTTON SECTION */

.buttons{
display:flex;
justify-content:center;
gap:20px;
flex-wrap:wrap;
margin:40px;
}

.buttons a{
text-decoration:none;
padding:14px 24px;
border-radius:12px;
font-weight:600;
color:white;
transition:.3s;
}

.buttons a:nth-child(1){
background:#2563eb;
}

.buttons a:nth-child(2){
background:#10b981;
}

.buttons a:nth-child(3){
background:#ef4444;
}

.buttons a:hover{
transform:translateY(-3px);
}

/* RECENT REGISTRATIONS */

.recent{
width:85%;
max-width:1000px;
margin:30px auto;
background:white;
padding:30px;
border-radius:20px;
box-shadow:
0 10px 25px rgba(0,0,0,.08);
}

.recent h2{
margin-bottom:20px;
color:#1e293b;
}

.registration-item{
padding:15px;
background:#f8fafc;
margin-bottom:12px;
border-left:5px solid #2563eb;
border-radius:10px;
font-size:16px;
}

/* WELCOME BANNER */

.banner{
width:85%;
margin:30px auto;
padding:30px;
border-radius:20px;
background:
linear-gradient(
135deg,
#7c3aed,
#4f46e5
);

color:white;
text-align:center;
box-shadow:
0 10px 25px rgba(0,0,0,.15);
}

.banner h2{
font-size:32px;
margin-bottom:10px;
}

.banner p{
font-size:17px;
}

.footer{
margin-top:50px;
background:#0f172a;
color:white;
text-align:center;
padding:20px;
}

/* MOBILE */

@media(max-width:768px){

.header h1{
font-size:28px;
}

.cards{
margin:20px;
}

.card{
width:100%;
}

}

</style>

</head>

<body>

<div class="header">

<h1>
Welcome,
<?php echo $name; ?> 👋
</h1>
<div class="banner">

<h2>🎉 Welcome to EventHub</h2>

<p>
Discover events, manage registrations,
download QR tickets and stay connected.
</p>

</div>
</div>

<div class="cards">

<div class="card">
<h2><?php echo $totalEvents; ?></h2>
<p>Available Events</p>
</div>

<div class="card">
<h2><?php echo $myRegistrations; ?></h2>
<p>My Registrations</p>
</div>

<div class="card">
<h2><?php echo $totalTickets; ?></h2>
<p>My Tickets</p>
</div>

</div>

<div class="buttons">

<a href="../Home/events.php">
Browse Events
</a>

<a href="myevents.php">
My Events
</a>

<a href="../Authentication/logout.php">
Logout
</a>

</div>

<br><br>

<div class="recent">

<h2>My Recent Registrations</h2>

<?php

$events = $conn->query(
"SELECT events.name
 FROM registrations
 JOIN events
 ON registrations.event_id=events.id
 WHERE registrations.user_id='$user_id'
 ORDER BY registrations.id DESC
 LIMIT 5"
);

while($row = $events->fetch_assoc()){

    echo "
    <div class='registration-item'>
    ✅ ".$row['name']."
    </div>";
}

?>

</body>
</html>