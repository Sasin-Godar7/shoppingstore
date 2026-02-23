<?php
session_start();
include 'config.php';

if(isset($_POST['login']))
{
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);

        if($password == $row['password'])   // simple check (we will improve later)
        {
            $_SESSION['username'] = $row['name'];
            $_SESSION['role'] = $row['user_type'];

            header("Location: index.php");
            exit();
        }
        else
        {
            $error = "Incorrect Password!";
        }
    }
    else
    {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    padding:20px;
}

.login-box{
    background:#fff;
    padding:30px 35px;
    width:100%;
    max-width:420px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

.login-box h2{
    text-align:center;
    margin-bottom:20px;
    color:#333;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    color:#555;
    font-weight:600;
    font-size:14px;
}

.form-group input{
    width:100%;
    padding:11px 12px;
    border:1px solid #ccc;
    border-radius:6px;
    outline:none;
    font-size:14px;
}

.form-group input:focus{
    border-color:#4facfe;
}

.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:6px;
    background:#4facfe;
    color:#fff;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#2f9cf4;
}

.error{
    background:#ffdddd;
    color:#d8000c;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    text-align:center;
    font-size:14px;
}

.register-link{
    text-align:center;
    margin-top:15px;
    font-size:14px;
}

.register-link a{
    color:#4facfe;
    text-decoration:none;
    font-weight:bold;
}

.register-link a:hover{
    text-decoration:underline;
}

/* Mobile */
@media (max-width: 480px){
    .login-box{
        padding:20px;
    }
}
</style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if(isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form  method="post" >
        
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="user_email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="user_password" placeholder="Enter your password" required>
        </div>

        <button type="submit" name="login" class="btn">Login</button>
    </form>

    <div class="register-link">
        Don't have an account? <a href="register.php">Register</a>
    </div>
</div>

</body>
</html>