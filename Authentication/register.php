<?php

include("db.php");

$message="";

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    $check =
    $conn->query(
    "SELECT * FROM users WHERE email='$email'"
    );

    if($check->num_rows > 0){

        $message = "Email already exists";

    }else{

        $sql =
        "INSERT INTO users
        (name,email,password)
        VALUES
        ('$name','$email','$password')";

        if($conn->query($sql)){

            $message =
            "Registration Successful";

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
rgba(0,0,0,.6),
rgba(0,0,0,.6)
),
url('https://images.unsplash.com/photo-1511578314322-379afb476865');
background-size:cover;
background-position:center;
}

.register-card{
width:450px;
padding:40px;
background:
rgba(255,255,255,.12);
backdrop-filter:blur(15px);
border-radius:20px;
box-shadow:
0 10px 30px rgba(0,0,0,.3);
color:white;
}

.register-card h2{
text-align:center;
margin-bottom:25px;
}

.register-card input{
width:100%;
padding:14px;
margin:10px 0;
border:none;
outline:none;
border-radius:10px;
}

.register-card button{
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

.register-card button:hover{
background:#1d4ed8;
}
.register-card a{
color:#93c5fd;
text-decoration:none;
}

.login-link{
text-align:center;
margin-top:20px;
}

</style>

</head>
<body>

<div class="register-card">

<h2>Create Account</h2>
    
    <form action="register_process.php" method="POST">
        <input type="text" name="name" placeholder="Enter Name" required>
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        
        <input type="submit" value="Register">
    </form>

    <div class="login-link">
        <a href="login.php">Already have account?</a>
    </div>
</div>

<p><?php echo $message; ?></p>

</body>
</html>