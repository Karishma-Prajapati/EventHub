<?php

session_start();

include("db.php");
include("../Email System/mailConfig.php");

if(isset($_POST['submit'])){

    $email = $_POST['email'];

    $user = $conn->query(
        "SELECT * FROM users
         WHERE email='$email'"
    );

    if($user->num_rows > 0){

        $otp = rand(100000,999999);

        $conn->query(
"UPDATE users
 SET otp='$otp',
     otp_expiry = DATE_ADD(NOW(), INTERVAL 10 MINUTE)
 WHERE email='$email'"
        );
        $subject =
        "EventHub Password Reset OTP";

        $body =
        "<h2>Your OTP is:</h2>
         <h1>$otp</h1>
         <p>Valid for 10 minutes.</p>";

        sendMail(
            $email,
            $subject,
            $body
        );

        $_SESSION['reset_email'] = $email;

        header(
        "Location: verifyOTP.php"
        );
        exit();

    }else{

        echo "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;

background:
linear-gradient(
rgba(0,0,0,.55),
rgba(0,0,0,.55)
),
url('https://images.unsplash.com/photo-1511578314322-379afb476865');

background-size:cover;
background-position:center;
}

.forgot-password-card{
width:420px;
padding:40px;
background:
rgba(255,255,255,.12);

backdrop-filter:blur(15px);
border-radius:20px;
box-shadow:
0 10px 30px rgba(0,0,0,.3);
color:white;
animation:fadeIn .6s ease;
}

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

h2{
text-align:center;
font-size:32px;
font-weight:700;
margin-bottom:10px;
color:white;
}

.subtitle{
text-align:center;
font-size:14px;
opacity:.8;
margin-bottom:25px;
}

.form-group{
margin-bottom:20px;
}

label{
display:block;
margin-bottom:8px;
font-size:14px;
font-weight:500;
color:#e5e7eb;
}

input[type="email"]{
width:100%;
padding:14px;
border:none;
outline:none;
border-radius:10px;
font-size:15px;
background:
rgba(255,255,255,.9);
transition:.3s;
}
input[type="email"]:focus{
box-shadow:
0 0 0 4px rgba(59,130,246,.3);
}

button{
width:100%;
padding:14px;
border:none;
border-radius:10px;
background:
linear-gradient(
135deg,
#2563eb,
#1d4ed8
);
color:white;
font-size:16px;
font-weight:600;
cursor:pointer;
transition:.3s;
}

button:hover{
transform:translateY(-2px);
box-shadow:
0 8px 20px rgba(37,99,235,.4);
}

.footer-text{
text-align:center;
margin-top:20px;
font-size:13px;
color:#d1d5db;
}

.footer-text a{
color:#93c5fd;
text-decoration:none;
}

.footer-text a:hover{
text-decoration:underline;
}
</style> 
</head>

<body>
<div class="forgot-password-card">

<h2>Forgot Password</h2>

<p class="subtitle">
Enter your registered email to receive an OTP
</p>

<form method="POST">

<div class="form-group">

<label>Email Address</label>

<input
type="email"
name="email"
placeholder="Enter your email"
required>

</div>

<button
type="submit"
name="submit">
📧 Send OTP
</button>

</form>

<div class="footer-text">

Remember your password?

<a href="login.php">
Login Here
</a>

</div>

</div>
</body>
</html>
