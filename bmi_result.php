<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Fetch latest fitness record of user
$sql = "SELECT * FROM user_fitness WHERE user_id='$user_id' ORDER BY fitness_id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);

    $age = $row['age'];
    $height = $row['height'];
    $weight = $row['weight'];
    $goal = $row['goal'];
    $bmi = $row['bmi'];
    $category = $row['bmi_category'];

} else {
    header("Location: fitness_form.php");
    exit();
}

// BMI color and message
if($category == "Underweight"){
    $color = "#facc15"; // yellow
    $message = "You are underweight. Focus on healthy calories and strength training.";
}
elseif($category == "Normal"){
    $color = "#22c55e"; // green
    $message = "Your BMI is normal. Maintain your fitness with balanced workouts.";
}
elseif($category == "Overweight"){
    $color = "#fb923c"; // orange
    $message = "You are overweight. Cardio and fat loss workouts are recommended.";
}
else{
    $color = "#ef4444"; // red
    $message = "You are in obese category. Consult doctor and follow a proper workout plan.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI Result | Workout Platform</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: linear-gradient(135deg,#0f172a,#1e293b);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            color:white;
        }

        .result-card{
            width:500px;
            background: rgba(255,255,255,0.08);
            padding:35px;
            border-radius:20px;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            box-shadow:0px 10px 30px rgba(0,0,0,0.4);
            text-align:center;
        }

        h2{
            color:#38bdf8;
            margin-bottom:10px;
        }

        .bmi-value{
            font-size:55px;
            font-weight:700;
            margin:20px 0;
            color: <?php echo $color; ?>;
        }

        .category{
            font-size:18px;
            font-weight:600;
            padding:10px;
            border-radius:12px;
            background: rgba(255,255,255,0.1);
            display:inline-block;
            margin-bottom:15px;
            color: <?php echo $color; ?>;
        }

        .message{
            font-size:14px;
            color:#cbd5e1;
            margin-bottom:25px;
        }

        .details{
            text-align:left;
            margin-top:20px;
            background: rgba(255,255,255,0.06);
            padding:18px;
            border-radius:15px;
        }

        .details p{
            font-size:14px;
            margin:8px 0;
            color:#e2e8f0;
        }

        .details span{
            font-weight:600;
            color:#38bdf8;
        }

        .btn-group{
            margin-top:25px;
            display:flex;
            justify-content:space-between;
            gap:10px;
        }

        .btn{
            flex:1;
            text-decoration:none;
            padding:12px;
            border-radius:12px;
            font-weight:600;
            transition:0.3s;
            text-align:center;
        }

        .btn-dashboard{
            background: rgba(255,255,255,0.15);
            color:white;
        }

        .btn-dashboard:hover{
            background: rgba(255,255,255,0.25);
        }

        .btn-workout{
            background:#38bdf8;
            color:#0f172a;
        }

        .btn-workout:hover{
            background:#0ea5e9;
        }
    </style>
</head>
<body>

<div class="result-card">

    <h2>BMI Result</h2>
    <p style="color:#cbd5e1; font-size:14px;">Hello <b><?php echo htmlspecialchars($name); ?></b> 👋 Here is your BMI analysis.</p>

    <div class="bmi-value"><?php echo $bmi; ?></div>

    <div class="category"><?php echo $category; ?></div>

    <p class="message"><?php echo $message; ?></p>

    <div class="details">
        <p><span>Age:</span> <?php echo $age; ?> years</p>
        <p><span>Height:</span> <?php echo $height; ?> cm</p>
        <p><span>Weight:</span> <?php echo $weight; ?> kg</p>
        <p><span>Goal:</span> <?php echo $goal; ?></p>
    </div>

    <div class="btn-group">
        <a href="dashboard.php" class="btn btn-dashboard">⬅ Dashboard</a>
        <a href="workout_chart.php" class="btn btn-workout">View Workout Plan ➜</a>
    </div>

</div>

</body>
</html>
