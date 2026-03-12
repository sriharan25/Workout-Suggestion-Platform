<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch users + fitness + payment
$sql = "SELECT 
        u.user_id,
        u.username,
        u.email,
        f.age,
        f.height,
        f.weight,
        f.goal,
        f.bmi,
        f.bmi_category,
        f.created_at,
        p.payment_date,
        p.payment_status
    FROM users u
    LEFT JOIN user_fitness f 
        ON u.user_id = f.user_id
        AND f.fitness_id = (
            SELECT fitness_id 
            FROM user_fitness 
            WHERE user_id = u.user_id 
            ORDER BY fitness_id DESC 
            LIMIT 1
        )
    LEFT JOIN payments p
        ON u.user_id = p.user_id
    ORDER BY u.user_id DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Users | Admin Panel</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

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
color:white;
padding:30px;
}

h2{
text-align:center;
color:#38bdf8;
margin-bottom:20px;
}

.table-box{
background: rgba(255,255,255,0.08);
padding:20px;
border-radius:18px;
border:1px solid rgba(255,255,255,0.1);
overflow-x:auto;
}

table{
width:100%;
border-collapse:collapse;
min-width:1100px;
}

th,td{
padding:12px;
text-align:left;
border-bottom:1px solid rgba(255,255,255,0.1);
font-size:14px;
}

th{
background:rgba(56,189,248,0.2);
color:#38bdf8;
font-weight:600;
}

td{
color:#e2e8f0;
}

.badge{
padding:5px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
display:inline-block;
}

.underweight{background:rgba(250,204,21,0.2);color:#facc15;}
.normal{background:rgba(34,197,94,0.2);color:#22c55e;}
.overweight{background:rgba(251,146,60,0.2);color:#fb923c;}
.obese{background:rgba(239,68,68,0.2);color:#ef4444;}
.not-filled{background:rgba(255,255,255,0.15);color:#cbd5e1;}

.back{
display:inline-block;
margin-top:20px;
text-decoration:none;
padding:12px 18px;
background:#38bdf8;
color:#0f172a;
font-weight:600;
border-radius:12px;
}

.back:hover{
background:#0ea5e9;
}

</style>
</head>

<body>

<h2>Registered Users & Fitness Details</h2>

<div class="table-box">
<table>

<tr>
<th>User ID</th>
<th>Name</th>
<th>Email</th>
<th>Age</th>
<th>Height</th>
<th>Weight</th>
<th>Goal</th>
<th>BMI</th>
<th>BMI Category</th>
<th>Last Updated</th>
<th>Payment Date</th>
<th>Valid Until</th>
<th>Status</th>
</tr>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

// PAYMENT LOGIC
if($row['payment_status'] == 'Success'){

$payment_date = $row['payment_date'];
$valid_until = date("Y-m-d", strtotime("+1 month", strtotime($payment_date)));
$today = date("Y-m-d");

if($today > $valid_until){
$status = "Expired";
}else{
$status = "Active";
}

}else{

$payment_date = "No Payment";
$valid_until = "-";
$status = "Inactive";

}

// BMI BADGE
$categoryClass = "not-filled";
if($row['bmi_category'] == "Underweight") $categoryClass = "underweight";
if($row['bmi_category'] == "Normal") $categoryClass = "normal";
if($row['bmi_category'] == "Overweight") $categoryClass = "overweight";
if($row['bmi_category'] == "Obese") $categoryClass = "obese";

echo "<tr>
<td>{$row['user_id']}</td>
<td>{$row['username']}</td>
<td>{$row['email']}</td>
<td>".($row['age'] ?? "-")."</td>
<td>".($row['height'] ?? "-")."</td>
<td>".($row['weight'] ?? "-")."</td>
<td>".($row['goal'] ?? "-")."</td>
<td>".($row['bmi'] ?? "-")."</td>
<td>";

if($row['bmi_category'] != NULL){
echo "<span class='badge $categoryClass'>{$row['bmi_category']}</span>";
}else{
echo "<span class='badge not-filled'>Not Filled</span>";
}

echo "</td>
<td>".($row['created_at'] ?? "-")."</td>
<td>".$payment_date."</td>
<td>".$valid_until."</td>
<td>".$status."</td>
</tr>";

}

}else{

echo "<tr>
<td colspan='13' style='text-align:center;color:#f87171;font-weight:600;'>
No Users Found!
</td>
</tr>";

}

?>

</table>
</div>

<a href="admin_dashboard.php" class="back">⬅ Back to Admin Dashboard</a>

</body>
</html>

