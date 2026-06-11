<?php

session_start();

include("db.php");

if(
!isset($_SESSION['otp_verified'])
){

    die("Access Denied");
}

$email =
$_SESSION['reset_email'];

if(isset($_POST['reset'])){

    $password = password_hash(
    $_POST['password'],
    PASSWORD_DEFAULT
    );

    $conn->query(
    "UPDATE users
     SET password='$password',
         otp=NULL,
         otp_expiry=NULL
     WHERE email='$email'"
    );

    session_destroy();
    $success=true;
}
?>
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
rgba(0,0,0,.6),
rgba(0,0,0,.6)
),
url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3');

background-size:cover;
background-position:center;
}

.reset-card{
width:420px;
padding:40px;
background:
rgba(255,255,255,.12);
backdrop-filter:blur(15px);
border-radius:20px;
box-shadow:
0 10px 30px rgba(0,0,0,.3);
color:white;
}

.reset-card h2{
text-align:center;
margin-bottom:25px;
}

.reset-card input{
width:100%;
padding:14px;
margin:12px 0;
border:none;
outline:none;
border-radius:10px;
}

.reset-card button{
width:100%;
padding:14px;
background:#10b981;
border:none;
border-radius:10px;
color:white;
font-size:16px;
cursor:pointer;
transition:.3s;
}

.reset-card button:hover{
background:#059669;
}

.success-box{
text-align:center;
background:rgba(16,185,129,.2);
padding:20px;
border-radius:12px;
margin-top:20px;
}

.login-btn{
display:inline-block;
margin-top:10px;
padding:10px 20px;
background:#2563eb;
color:white;
text-decoration:none;
border-radius:8px;
}
</style>

<div class="reset-card">
<h2>Reset Password</h2>

<?php if(isset($success)){ ?>

<div class="success-box">

✅ Password Changed Successfully

<br><br>

<a href="login.php" class="login-btn">
Login Now
</a>

</div>

<?php } ?>
<?php if(!isset($success)){ ?>

<form method="POST">

<input
type="password"
name="password"
placeholder="New Password"
required>

<button
type="submit"
name="reset">
Change Password
</button>

</form>

<?php } ?>
</div>