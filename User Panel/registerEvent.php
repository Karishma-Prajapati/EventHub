<?php

session_start();
include("../Authentication/db.php");

if(!isset($_SESSION['user_id'])){
    die("Access Denied");
}

$user_id = $_SESSION['user_id'];

$event_id = isset($_GET['id'])
? intval($_GET['id'])
: 0;

if($event_id <= 0){
    die("Invalid Event");
}

/* Check if already registered */

$check = $conn->query(
"SELECT * FROM registrations
 WHERE user_id='$user_id'
 AND event_id='$event_id'"
);

if($check->num_rows > 0){

    die("
    <h2 style='text-align:center;margin-top:50px;color:red;'>
    You have already registered for this event.
    </h2>
    ");
}
/* Save Registration */

$conn->query(
"INSERT INTO registrations(user_id,event_id)
 VALUES('$user_id','$event_id')"
);

/* Create Ticket */

$ticket_code =
"EVT".time().rand(100,999);

/* Temporary QR image */

$qr_image =
"default-ticket.png";

/* Save Ticket */

$conn->query(
"INSERT INTO tickets
(user_id,event_id,ticket_code,qr_image)
VALUES
('$user_id',
 '$event_id',
 '$ticket_code',
 '$qr_image')"
);
include("../Email System/mailConfig.php");

$subject = "Event Registration Confirmation";

$body = "
<h2>Registration Successful</h2>

<p>Your registration has been confirmed.</p>

<p>
Ticket Code:
<b>$ticket_code</b>
</p>

<p>
Thank you for using EventHub.
</p>
";
$userResult = $conn->query(
"SELECT email FROM users
 WHERE id='$user_id'"
);

$userData = $userResult->fetch_assoc();

$user_email = $userData['email'];

sendMail(
$user_email,
$subject,
$body
);

header(
"Location: registrationSuccess.php?id=".$event_id
);

exit();

?>
