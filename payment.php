<?php
session_start();
include("db.php");

$msg = "";

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id = $_SESSION['user_id'];

/* get user phone number */
$sqlUser = "SELECT phone FROM users WHERE user_id='$user_id'";
$resultUser = mysqli_query($conn,$sqlUser);
$user = mysqli_fetch_assoc($resultUser);

$phone = $user['phone'];

if(isset($_POST['pay'])){

$amount = $_POST['amount'];
$method = $_POST['payment_method'];

$sql = "INSERT INTO payments (user_id,amount,payment_method,payment_status)
VALUES ('$user_id','$amount','$method','Success')";

if(mysqli_query($conn,$sql)){
$msg = "✅ Payment Successful! SMS confirmation sent to $phone";
}else{
$msg = "❌ Payment Failed";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Gym Payment</title>

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
color:white;
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

/* Card Container */

.payment-box{
background: rgba(255,255,255,0.08);
border:1px solid rgba(255,255,255,0.1);
padding:35px;
border-radius:20px;
width:380px;
backdrop-filter: blur(10px);
transition:0.3s;
}

.payment-box:hover{
transform:translateY(-6px);
border:1px solid #38bdf8;
box-shadow:0px 10px 25px rgba(56,189,248,0.2);
}

.payment-box h2{
text-align:center;
color:#38bdf8;
margin-bottom:20px;
}

/* Inputs */

input, select{
width:100%;
padding:10px;
margin:10px 0 18px 0;
border:none;
border-radius:10px;
background:rgba(255,255,255,0.12);
color:white;
}

input:focus, select:focus{
outline:none;
border:1px solid #38bdf8;
}

/* Dropdown fix */

select option{
background:#ffffff;
color:#000000;
}

/* Button */

button{
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:#38bdf8;
color:#0f172a;
font-weight:600;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#0ea5e9;
}

/* Message */

.msg{
margin-top:18px;
text-align:center;
font-weight:600;
}

.success{
color:#22c55e;
}

.error{
color:#f87171;
}

</style>

</head>

<body>

<div class="payment-box">

<h2>Gym Membership Payment</h2>

<form method="POST">

<label>Amount</label>
<input type="number" name="amount" value="500" readonly>

<label>Payment Method</label>

<select name="payment_method" required>
<option value="">Select Method</option>
<option value="UPI">UPI</option>
<option value="Debit Card">Debit Card</option>
<option value="Credit Card">Credit Card</option>
</select>

<button type="submit" name="pay">Pay Now</button>

</form>

<?php if($msg!=""){ ?>

<div class="msg <?php echo strpos($msg,'✅') !== false ? 'success' : 'error'; ?>">
<?php echo $msg; ?>
</div>

<?php } ?>

</div>

</body>
</html>

