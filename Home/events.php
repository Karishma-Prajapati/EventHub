<?php

session_start();

include("../Authentication/db.php");

$result = $conn->query("SELECT * FROM events");
$search =
$_GET['search'] ?? '';

$sql =
"SELECT *
 FROM events
 WHERE name LIKE '%$search%'
 OR location LIKE '%$search%'";
?>

<!DOCTYPE html>
<html>
<head>
<title>Events</title>
<link rel="stylesheet" href="../assets/style.css">
<style>

body{
background:#f5f7fb;
font-family:Poppins,sans-serif;
}

.events-grid{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(320px,1fr));

gap:25px;

padding:40px;
}

.event-card{

background:white;

border-radius:20px;

overflow:hidden;

box-shadow:
0 8px 25px rgba(0,0,0,.08);

transition:.3s;
}

.event-card:hover{

transform:translateY(-10px);

box-shadow:
0 15px 35px rgba(0,0,0,.15);
}

.event-image{

width:100%;
height:220px;

object-fit:cover;
}

.event-content{

padding:20px;
}

.btn{

display:inline-block;

margin-top:15px;

padding:10px 20px;

background:#2563eb;

color:white;

text-decoration:none;

border-radius:10px;
}
.navbar{

display:flex;

justify-content:space-between;

padding:20px 50px;

background:#0f172a;

color:white;
}

.navbar a{

color:white;

text-decoration:none;

margin-left:20px;
}
</style>

</head>
<script>

function countdown(id,date){

let target=
new Date(date).getTime();

setInterval(()=>{

let now=
new Date().getTime();

let diff=
target-now;

let days=
Math.floor(
diff/(1000*60*60*24)
);

document.getElementById(id)
.innerHTML=
"⏳ "+days+" days left";

},1000);

}

</script>
<body>
    <nav class="navbar">

<h2>🎟 EventHub</h2>

<div>

<a href="../index.php">Home</a>

<a href="../User Panel/myevents.php">
My Events
</a>

<a href="../Authentication/logout.php">
Logout
</a>

</div>

</nav>
    <form method="GET">

<input
type="text"
name="search"
placeholder="Search Events">

<button class="btn">
Search
</button>

</form>

<h2>Available Events</h2>

<div class="events-grid">

<?php while($row=$result->fetch_assoc()){ ?>

<div class="event-card">

<img
src="../uploads/<?php echo $row['image']; ?>"
class="event-image">

<div class="event-content">

<h3><?php echo $row['name']; ?></h3>

<p>
📅 <?php echo $row['event_date']; ?>
</p>

<p>
📍 <?php echo $row['location']; ?>
</p>
<p id="countdown<?php echo $row['id']; ?>"></p>
<a
href="eventDetails.php?id=<?php echo $row['id']; ?>"
class="btn">
View Details
</a>

</div>

</div>
<?php } ?>

</div>

</body>
</html>