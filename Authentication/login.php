<?php

session_start();

include("db.php");

$message="";

if(isset($_POST['login'])){

    $email=$_POST['email'];
    $password=$_POST['password'];

    $sql="SELECT * FROM users WHERE email='$email'";

    $result=$conn->query($sql);

    if($result->num_rows>0){

        $user=$result->fetch_assoc();

        if(password_verify($password,$user['password'])){

            $_SESSION['user_id']=$user['id'];
            $_SESSION['name']=$user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role']=$user['role'];

            if($user['role']=="admin"){

                header("Location: ../Admin Panel/adminDashboard.php");

            }else{

                header("Location: ../User Panel/userDashboard.php");

            }

            exit();

        }else{

            $message="Wrong Password";

        }

    }else{

        $message="User Not Found";

    }

}

?>
<!DOCTYPE html>

<html>
<head>

<title>EventHub Login</title>

<link rel="stylesheet" href="../assets/style.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
url('https://images.unsplash.com/photo-1511578314322-379afb476865');

background-size:cover;
background-position:center;
}

.login-card{
width:420px;
padding:40px;
background:rgba(255,255,255,.12);
backdrop-filter:blur(15px);
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,.3);
color:white;
}

.logo{
text-align:center;
font-size:40px;
margin-bottom:10px;
}

.login-card h2{
text-align:center;
margin-bottom:10px;
}

.subtitle{
text-align:center;
margin-bottom:25px;
font-size:14px;
opacity:.9;
}

.error{
background:#ff4d4d;
padding:10px;
border-radius:8px;
margin-bottom:15px;
text-align:center;
}

input{
width:100%;
padding:14px;
margin:10px 0;
border:none;
outline:none;
border-radius:10px;
font-size:15px;
}

.password-box{
position:relative;
}
.password-box span{
position:absolute;
right:15px;
top:22px;
cursor:pointer;
color:black;
}

button{
width:100%;
padding:14px;
background:#2563eb;
border:none;
border-radius:10px;
color:white;
font-size:16px;
cursor:pointer;
transition:.3s;
}

button:hover{
background:#1d4ed8;
}

.links{
display:flex;
justify-content:space-between;
margin-top:15px;
font-size:14px;
}

.links a{
color:#93c5fd;
text-decoration:none;
}

.register{

text-align:center;

margin-top:20px;
}
.register a{
color:#93c5fd;
text-decoration:none;
}
</style>

</head>
<body>
<div class="login-card">

<div class="logo">🎟</div>
<h2>EventHub Login</h2>
<p class="subtitle">
Smart Event Management System
</p>

<?php
if(!empty($message)){
echo "<div class='error'>$message</div>";
}
?>

<form method="POST">

<input
type="email"
name="email"
placeholder="Enter Email"
required>

<div class="password-box">

<input
type="password"
name="password"
id="password"
placeholder="Enter Password"
required>

<span onclick="togglePassword()">
👁
</span>

</div>

<button
type="submit"
name="login">
Login </button>

</form>

<div class="links">

<a href="forgotPassword.php">
Forgot Password?
</a>

<a href="register.php">
Create Account
</a>

</div>

<div class="register">

<p>
Welcome to EventHub 🚀
</p>

</div>

</div>

<script>

function togglePassword(){
let pass =
document.getElementById("password");

if(pass.type==="password"){
pass.type="text";

}else{

pass.type="password";
}
}
</script>

</body>
</html>

