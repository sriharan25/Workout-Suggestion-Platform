
<?php
session_start();
include("db.php");

$error = "";

if(isset($_POST['login'])){

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){

$user = mysqli_fetch_assoc($result);

if(password_verify($password,$user['password'])){

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['name'] = $user['username'];

header("Location: dashboard.php");
exit();

}else{
$error = "Invalid Password!";
}

}else{
$error = "Email not found!";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Login</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background: linear-gradient(135deg,#0f172a,#1e293b);
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
color:white;
}

/* Glass Card */

.login-box{
background: rgba(255,255,255,0.08);
border:1px solid rgba(255,255,255,0.1);
padding:40px;
border-radius:20px;
width:360px;
backdrop-filter: blur(10px);
transition:0.3s;
}

.login-box:hover{
transform:translateY(-6px);
border:1px solid #38bdf8;
box-shadow:0px 10px 25px rgba(56,189,248,0.2);
}

.login-box h2{
text-align:center;
color:#38bdf8;
margin-bottom:25px;
}

/* Inputs */

input{
width:100%;
padding:12px;
margin-bottom:18px;
border:none;
border-radius:10px;
background:rgba(255,255,255,0.12);
color:white;
}

input:focus{
outline:none;
border:1px solid #38bdf8;
}

/* Button */

button{
width:100%;
padding:12px;
background:#38bdf8;
border:none;
border-radius:10px;
font-weight:600;
color:#0f172a;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#0ea5e9;
}

/* Error */

.error{
margin-top:15px;
text-align:center;
color:#f87171;
font-weight:600;
}

/* Register Link */

.link{
text-align:center;
margin-top:15px;
font-size:14px;
}

.link a{
color:#38bdf8;
text-decoration:none;
font-weight:600;
}

.link a:hover{
text-decoration:underline;
}

</style>

</head>

<body>

<div class="login-box">

<h2>User Login</h2>

<form method="POST">

<input type="email" name="email" placeholder="Enter Email" required>

<input type="password" name="password" placeholder="Enter Password" required>

<button type="submit" name="login">Login</button>

</form>

<?php if($error!=""){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<div class="link">
Don't have an account? <a href="register.php">Register</a>
</div>

</div>

</body>
</html>

