<?php
session_start();
include("../Authentication/db.php");

// Debugging check: If the session isn't set, tell the admin exactly what went wrong
if (!isset($_SESSION['reset_email'])) {
    die("<div style='font-family:sans-serif; padding:20px; color:#c0392b; background:#fcedeb; border-radius:5px; margin:20px;'>
            <strong>Access Denied:</strong> Your session does not contain a reset email.<br><br>
            <em>Fix:</em> Make sure your forgot password script has <code>session_start();</code> at the very top and sets <code>\$_SESSION['reset_email'] = \$email;</code> before redirecting here.
         </div>");
}

$email = $_SESSION['reset_email'];
$error_message = "";

if (isset($_POST['verify'])) {
    $otp = trim($_POST['otp']);

    // SECURE: Use prepared statements instead of directly injecting variables into SQL
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND otp = ? AND otp_expiry > NOW()");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['otp_verified'] = true;
        header("Location: resetPassword.php");
        exit();
    } else {
        $error_message = "Invalid or Expired OTP code.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <style>
        /* Modern, professional CSS interface styling */
        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .otp-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 380px;
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 10px;
        }

        p {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            font-size: 16px;
            letter-spacing: 4px; /* Spaces out digits elegantly */
            text-align: center;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #fff;
            color: #333;
            box-sizing: border-box;
            transition: all 0.2s ease-in-out;
            margin-bottom: 20px;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
        }

        button {
            width: 100%;
            background-color: #3498db;
            color: #ffffff;
            border: none;
            padding: 12px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        button:active {
            transform: scale(0.98);
        }

        .error-box {
            background-color: #fcedeb;
            color: #c0392b;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h2>Verify OTP</h2>
    <p>We sent a verification code to your email. Enter it below to proceed.</p>

    <?php if(!empty($error_message)): ?>
        <div class="error-box"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input 
            type="text" 
            name="otp" 
            placeholder="••••••" 
            maxlength="6" 
            required 
            autocomplete="off">

        <button type="submit" name="verify">Verify OTP</button>
    </form>
</div>

</body>
</html>