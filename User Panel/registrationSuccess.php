<?php
session_start();
include("../Authentication/db.php"); // Double check this path to your db connection

// 1. Protection: Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access Denied. Please log in.");
}

$user_id = $_SESSION['user_id'];

// 2. Fetch the logged-in user's real email address
$user_stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_res = $user_stmt->get_result()->fetch_assoc();
$user_email = $user_res['email'] ?? 'your registered email';
$user_stmt->close();

// 3. Capture the Event ID from the URL string (?id=X)
if (!isset($_GET['id'])) {
    die("Invalid Request: Missing Event ID.");
}
$event_id = intval($_GET['id']);

// 4. FIX: Fetch the Ticket Code and QR image matching this user and event
$ticket_stmt = $conn->prepare("SELECT ticket_code, qr_image FROM tickets WHERE user_id = ? AND event_id = ?");
$ticket_stmt->bind_param("ii", $user_id, $event_id);
$ticket_stmt->execute();
$ticket_result = $ticket_stmt->get_result();

// Default fallbacks if the ticket isn't generated instantly by your system yet
$ticket_code = "Processing...";
$qr_image = ""; 

if ($ticket_result->num_rows > 0) {
    $ticket_data = $ticket_result->fetch_assoc();
    $ticket_code = $ticket_data['ticket_code'];
    $qr_image = $ticket_data['qr_image'];
}
$ticket_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;

background:
linear-gradient(
0deg,
#627a96,
#738fa0,
#6184a1
);

padding:30px;
}

/* Main Card */

.success-card{

width:900px;
max-width:100%;

background:rgba(255,255,255,.1);

backdrop-filter:blur(20px);

border:1px solid rgba(255,255,255,.15);

border-radius:30px;

overflow:hidden;

box-shadow:
0 25px 60px rgba(0,0,0,.35);

animation:fadeIn .6s ease;
}

/* Banner */

.banner{

height:250px;

overflow:hidden;
}

.banner img{

width:100%;
height:100%;

object-fit:cover;
}

/* Content */

.content{

padding:40px;
text-align:center;
}

/* Success Icon */

.success-icon{

width:110px;
height:110px;

background:#22c55e;

color:white;

border-radius:50%;

display:flex;
justify-content:center;
align-items:center;

font-size:55px;

margin:auto;
margin-top:-90px;

border:6px solid white;

box-shadow:
0 10px 25px rgba(34,197,94,.4);
}

.success-card h1{

font-size:38px;

font-weight:700;

color:white;

margin-top:20px;
margin-bottom:10px;
}

.success-card p{

font-size:16px;

line-height:1.8;

color:#cbd5e1;
}

/* Email */

.email-box{

margin-top:20px;

padding:15px;

background:rgba(255,255,255,.08);

border:1px solid rgba(255,255,255,.1);

border-radius:12px;

font-weight:600;

color:#2563eb;
}

/* Ticket Section */

.ticket-section{

display:flex;

justify-content:space-between;
align-items:center;

gap:40px;

margin-top:35px;

padding:25px;

background:rgba(255,255,255,.08);

border:1px solid rgba(255,255,255,.08);

border-radius:20px;
}

/* QR */

.qr-image{

width:220px;

background:white;

padding:10px;

border-radius:15px;

box-shadow:
0 10px 20px rgba(0,0,0,.15);
}

/* Ticket Details */

.ticket-details{

text-align:left;
flex:1;
}

.ticket-details h3{

font-size:30px;

color:white;

margin-bottom:20px;
}

.ticket-details p{

margin:12px 0;

font-size:16px;

color:#e2e8f0;
}

.ticket-id{

display:inline-block;

margin-top:15px;

padding:12px 18px;

background:#2563eb;

border-radius:10px;

font-weight:600;

color:white;
}

/* Status Cards */

.info-grid{

display:grid;

grid-template-columns:
repeat(3,1fr);

gap:15px;

margin-top:25px;
}

.info-card{

background:rgba(255,255,255,.08);

padding:18px;

border-radius:15px;

text-align:center;
}

.info-card h4{

font-size:13px;

color:#cbd5e1;

margin-bottom:6px;
}

.info-card p{

font-size:18px;

font-weight:600;

color:white;
}

/* Buttons */

.actions{

margin-top:35px;

display:flex;

justify-content:center;

gap:15px;
}

.btn{

padding:14px 28px;

border-radius:12px;

text-decoration:none;

font-weight:600;

transition:.3s;
}

.btn-primary{

background:#2563eb;

color:white;
}

.btn-primary:hover{

background:#1d4ed8;

transform:translateY(-3px);
}

.btn-secondary{

background:rgba(255,255,255,.12);

color:white;

border:1px solid rgba(255,255,255,.1);
}

.btn-secondary:hover{

background:rgba(255,255,255,.18);

transform:translateY(-3px);
}

/* Animation */

@keyframes fadeIn{

from{
opacity:0;
transform:translateY(20px);
}

to{
opacity:1;
transform:translateY(0);
}

}

/* Mobile */

@media(max-width:768px){

.ticket-section{

flex-direction:column;
text-align:center;
}

.ticket-details{

text-align:center;
}

.info-grid{

grid-template-columns:1fr;
}

.actions{

flex-direction:column;
}

.success-card h1{

font-size:30px;
}

.qr-image{

width:180px;
}

}

</style>
</head>
<body>
    <div class="content">

<div class="success-icon">✓</div>

<h1>Registration Successful!</h1>

<p>
Your registration has been confirmed.
A confirmation email has been sent to:
</p>

<div class="email-box">
<?php echo htmlspecialchars($user_email); ?>
</div>

<div class="ticket-section">

<div>
<img
src="../tickets/<?php echo $qr_image_filename; ?>"
class="qr-image">
</div>

<div class="ticket-details">

<h3>Event Ticket</h3>

<p>🎫 Access Granted</p>

<p>📧 Registered User</p>

<div class="ticket-id">
<?php echo $ticket_code; ?>
</div>

</div>

</div>

<div class="info-grid">

<div class="info-card">
<h4>Status</h4>
<p>Confirmed</p>
</div>

<div class="info-card">
<h4>Entry</h4>
<p>QR Pass</p>
</div>

<div class="info-card">
<h4>Ticket</h4>
<p>Active</p>
</div>

</div>

<div class="actions">

<a href="../tickets/<?php echo $qr_image_filename; ?>"
download
class="btn btn-primary">
Download Ticket
</a>

<a href="myevents.php"
class="btn btn-secondary">
My Events
</a>

</div>

</div>
</body>
</html>