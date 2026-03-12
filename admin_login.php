<?php
session_start();
include("db.php");

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        // Normal password check (admin123)
        if($password == $row['password']){

            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['admin_username'] = $row['username'];

            header("Location: admin_dashboard.php");
            exit();

        } else {
            $error = "Invalid Password!";
        }

    } else {
        $error = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Workout Platform</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg,#0f172a,#1e293b);
        }

        .login-box{
            width:380px;
            padding:40px;
            border-radius:18px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow:0px 10px 30px rgba(0,0,0,0.4);
            text-align:center;
            color:white;
        }

        h2{
            color:#38bdf8;
            margin-bottom:10px;
        }

        p{
            color:#cbd5e1;
            font-size:14px;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:12px;
            border:none;
            border-radius:10px;
            outline:none;
            margin:10px 0;
            font-size:14px;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:10px;
            background:#38bdf8;
            color:#0f172a;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
            margin-top:10px;
        }

        button:hover{
            background:#0ea5e9;
        }

        .error{
            margin-top:15px;
            background: rgba(255,0,0,0.2);
            padding:10px;
            border-radius:10px;
            color:#ffb4b4;
            font-size:14px;
        }

        .back{
            margin-top:20px;
            display:block;
            color:#cbd5e1;
            text-decoration:none;
            font-size:14px;
        }

        .back:hover{
            color:#38bdf8;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>
    <p>Login to manage workout plans</p>

    <form method="POST">
        <input type="text" name="username" placeholder="Enter Admin Username" required>
        <input type="password" name="password" placeholder="Enter Admin Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <?php
    if(isset($error)){
        echo "<div class='error'>$error</div>";
    }
    ?>

    <a href="login.php" class="back">⬅ Back to User Login</a>
</div>

</body>
</html>
