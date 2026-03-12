<?php
include("db.php");

if(isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($result) > 0){
        $error = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (username, email, password, phone, address)
                VALUES ('$username', '$email', '$password', '$phone', '$address')";

        if(mysqli_query($conn, $sql)){
            $success = "Registration Successful! You can login now.";
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | Workout Platform</title>
    <style>
        body{
            margin:0;
            font-family: Arial, sans-serif;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg,#1d2b64,#f8cdda);
        }

        .card{
            background: rgba(255,255,255,0.15);
            padding:40px;
            width:350px;
            border-radius:15px;
            backdrop-filter: blur(10px);
            box-shadow:0 10px 25px rgba(0,0,0,0.3);
            color:white;
            text-align:center;
        }

        .card h2{
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:10px;
            margin:10px 0;
            border:none;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:10px;
            background:#ff4b2b;
            border:none;
            border-radius:8px;
            color:white;
            font-size:16px;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#ff416c;
        }

        a{
            color:#fff;
            text-decoration:none;
        }

        .msg{
            margin-top:10px;
            font-size:14px;
        }

        .success{ color: #00ffcc; }
        .error{ color: #ffdddd; }
    </style>
</head>
<body>

<div class="card">
    <h2>Create Account</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>
        <button type="submit" name="register">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>

    <?php
        if(isset($error)) echo "<div class='msg error'>$error</div>";
        if(isset($success)) echo "<div class='msg success'>$success</div>";
    ?>
</div>

</body>
</html>
