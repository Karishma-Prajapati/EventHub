<?php

session_start();

include("../Authentication/db.php");

$user_id = $_SESSION['user_id'];

$event_id = $_GET['event_id'];

$ticket = $conn->query(
"SELECT * FROM tickets
 WHERE user_id='$user_id'
 AND event_id='$event_id'"
)->fetch_assoc();

$event = $conn->query(
"SELECT * FROM events
 WHERE id='$event_id'"
)->fetch_assoc();
if(!$event){
    die("Event not found.");
}
$eventDateTime = strtotime(
    $event['event_date']." ".$event['event_time']
);

if(time() >= $eventDateTime){
    die("Event already started. Cancellation not allowed.");
}
if($ticket){

    $file =
    "../tickets/".$ticket['qr_image'];

    if(file_exists($file)){
        unlink($file);
    }

    $conn->query(
    "DELETE FROM tickets
     WHERE id='".$ticket['id']."'"
    );
}

$conn->query(
"DELETE FROM registrations
 WHERE user_id='$user_id'
 AND event_id='$event_id'"
);

echo "

<div class='cancel-wrapper'>

<div class='cancel-card'>

<div class='success-icon'>
✓
</div>

<h1>Registration Cancelled</h1>

<p>
Your registration has been cancelled successfully.
The QR ticket associated with this event has also been removed.
</p>

<div class='info-box'>

<strong>Event:</strong> ".$event['name']."<br><br>

<strong>Date:</strong> ".$event['event_date']."<br><br>

<strong>Location:</strong> ".$event['location']."

</div>

<div class='actions'>

<a href='myevents.php'
class='btn primary'>
My Events
</a>

<a href='../Home/events.php'
class='btn secondary'>
Browse Events
</a>

</div>

</div>

</div>

";
?>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f8fafc;
display:flex;
justify-content:center;
align-items:center;
min-height:100vh;
}

.cancel-wrapper{
width:100%;
max-width:700px;
padding:20px;
}

.cancel-card{

background:white;

padding:50px;

border-radius:24px;

text-align:center;

box-shadow:
0 20px 40px rgba(0,0,0,.08);
}

.success-icon{

width:90px;
height:90px;

margin:auto;

border-radius:50%;

background:#dcfce7;

display:flex;
justify-content:center;
align-items:center;

font-size:45px;

margin-bottom:25px;
}

.cancel-card h1{

color:#0f172a;

font-size:34px;

margin-bottom:10px;
}

.cancel-card p{

color:#64748b;

font-size:17px;

line-height:1.7;
}

.info-box{

margin-top:25px;

padding:20px;

background:#f1f5f9;

border-radius:12px;
}

.info-box strong{

color:#2563eb;
}

.actions{

margin-top:30px;

display:flex;

justify-content:center;

gap:15px;

flex-wrap:wrap;
}

.btn{

padding:14px 28px;

border-radius:12px;

text-decoration:none;

font-weight:600;

transition:.3s;
}

.primary{

background:#2563eb;

color:white;
}

.primary:hover{

background:#1d4ed8;
}

.secondary{

background:#e2e8f0;

color:#0f172a;
}

.secondary:hover{

background:#cbd5e1;
}

</style>
