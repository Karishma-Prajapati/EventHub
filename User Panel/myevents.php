<?php
session_start();
include("../Authentication/db.php");

// Kick out non-logged-in users safely
if (!isset($_SESSION['user_id'])) {
    die("Access Denied. Please log in.");
}

$user_id = $_SESSION['user_id'];

// Fetch the events the user registered for
$sql = "SELECT events.*, registrations.event_id 
        FROM registrations 
        JOIN events ON registrations.event_id = events.id 
        WHERE registrations.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Registered Events</title>
    <style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{

background:
linear-gradient(
135deg,
#eef2ff,
#f8fafc
);

min-height:100vh;
padding:40px;
}

.container{
max-width:1400px;
margin:auto;
}

.page-title{
font-size:38px;
font-weight:700;
color:#0f172a;
margin-bottom:35px;
}

.events-grid{
display:grid;
grid-template-columns:
repeat(auto-fill,minmax(400px,1fr));
gap:30px;
}

.card{
background:white;
border-radius:10px;
overflow:hidden;
box-shadow:
0 10px 30px rgba(0,0,0,.08);
transition:.3s;
}

.card:hover{
transform:translateY(-8px);
box-shadow:
0 20px 40px rgba(0,0,0,.15);
}

.event-banner{
height:180px;
background:
linear-gradient(
135deg,
#383c46,
#383748
);
display:flex;
justify-content:center;
align-items:center;
color:white;
font-size:55px;
}

.card-body{
padding:30px;
}

.event-info h3{
font-size:24px;
margin-bottom:15px;
color:#0f172a;
}

.event-details{
display:flex;
flex-direction:column;
gap:10px;
margin-bottom:20px;
color:#475569;
}

.ticket-box{
display:flex;
align-items:center;
gap:20px;
padding:15px;
background:#f8fafc;
border-radius:15px;
margin-bottom:20px;
}

.qr-code{
width:100px;
height:100px;
border-radius:10px;
background:white;
padding:5px;
}

.ticket-meta p{
font-weight:600;
color:#2563eb;
word-break:break-all;
}

.card-actions{
display:flex;
gap:15px;
}

.btn{

flex:1;
text-align:center;
padding:12px;
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
}

.btn-danger{
background:#ef4444;
color:white;
}

.btn-danger:hover{
background:#dc2626;
}
.empty-state{
background:white;
padding:60px;
text-align:center;
border-radius:20px;
box-shadow:
0 10px 30px rgba(0,0,0,.08);
}
.empty-state h3{
font-size:28px;
margin-bottom:10px;
}
.empty-state p{
color:#64748b;
}
</style>

</head>
<body>

<div class="container">
    <h2 class="page-title">My Registered Events</h2>
    
    <div class="events-grid">
        <?php while($row = $result->fetch_assoc()) { 
            // FIX: Query the ticket details BEFORE rendering the component layout
            $ticket_sql = "SELECT * FROM tickets WHERE user_id = ? AND event_id = ?";
            $t_stmt = $conn->prepare($ticket_sql);
            $t_stmt->bind_param("si", $user_id, $row['event_id']);
            $t_stmt->execute();
            $ticket = $t_stmt->get_result()->fetch_assoc();
        ?>
            <div class="card">
                <div class="event-info">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    
                    <div class="event-details">
                        <span>📅 <?php echo $row['event_date']; ?></span>
                        <span>📍 <?php echo htmlspecialchars($row['location']); ?></span>
                    </div>
                </div>

                <?php if($ticket): ?>
                    <div class="ticket-box">
                        <img class="qr-code" src="../tickets/<?php echo $ticket['qr_image']; ?>" alt="Ticket QR">
                        <div class="ticket-meta">
                            <h5>Ticket Reference</h5>
                            <p><?php echo htmlspecialchars($ticket['ticket_code']); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="ticket-box">
                        <p class="no-ticket-msg">Ticket Processing / Manual verification required</p>
                    </div>
                <?php endif; ?>

                <div class="card-actions">
                    <?php if($ticket): ?>
                        <a href="../tickets/<?php echo $ticket['qr_image']; ?>" download class="btn btn-primary">
                            Download Ticket
                        </a>
                    <?php else: ?>
                        <button class="btn btn-primary" style="opacity: 0.5; cursor: not-allowed;" disabled>
                            No Ticket
                        </button>
                    <?php endif; ?>

                    <a href="cancelRegistration.php?event_id=<?php echo $row['event_id']; ?>" 
                       onclick="return confirm('Are you sure you want to cancel your registration for this event?');" 
                       class="btn btn-danger">
                        Cancel Registration
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>