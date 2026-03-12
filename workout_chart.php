<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Fetch latest user fitness details
$sqlFitness = "SELECT * FROM user_fitness WHERE user_id='$user_id' ORDER BY fitness_id DESC LIMIT 1";
$resultFitness = mysqli_query($conn, $sqlFitness);

if(mysqli_num_rows($resultFitness) > 0){
    $fitness = mysqli_fetch_assoc($resultFitness);

    $goal = $fitness['goal'];
    $bmi = $fitness['bmi'];
    $category = $fitness['bmi_category'];

} else {
    header("Location: fitness_form.php");
    exit();
}

// Fetch workout plans based on bmi_category and goal
$sqlWorkout = "SELECT * FROM workout_plans WHERE bmi_category='$category' AND goal='$goal' ORDER BY plan_id ASC";
$resultWorkout = mysqli_query($conn, $sqlWorkout);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Chart | Workout Platform</title>

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
            color:white;
            padding:30px;
        }

        .header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:25px;
        }

        .header h2{
            color:#38bdf8;
            font-size:24px;
        }

        .header a{
            text-decoration:none;
            background:#ef4444;
            padding:10px 16px;
            border-radius:10px;
            color:white;
            font-weight:600;
        }

        .header a:hover{
            background:#dc2626;
        }

        .info-box{
            background: rgba(255,255,255,0.08);
            padding:20px;
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            margin-bottom:25px;
        }

        .info-box h3{
            color:#38bdf8;
            margin-bottom:10px;
        }

        .info-box p{
            font-size:14px;
            color:#cbd5e1;
            margin:5px 0;
        }

        .workout-container{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap:20px;
        }

        .workout-card{
            background: rgba(255,255,255,0.08);
            padding:22px;
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            transition:0.3s;
        }

        .workout-card:hover{
            transform: translateY(-6px);
            border: 1px solid #38bdf8;
            box-shadow:0px 10px 25px rgba(56,189,248,0.2);
        }

        .workout-card h4{
            color:#38bdf8;
            font-size:18px;
            margin-bottom:10px;
        }

        .workout-card p{
            font-size:14px;
            color:#e2e8f0;
            margin-bottom:8px;
        }

        .tag{
            display:inline-block;
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            background: rgba(56,189,248,0.2);
            color:#38bdf8;
            margin-bottom:12px;
        }

        .btn-back{
            display:inline-block;
            margin-top:25px;
            text-decoration:none;
            padding:12px 18px;
            background:#38bdf8;
            color:#0f172a;
            font-weight:600;
            border-radius:12px;
            transition:0.3s;
        }

        .btn-back:hover{
            background:#0ea5e9;
        }

        .no-data{
            text-align:center;
            padding:25px;
            background: rgba(255,255,255,0.08);
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            color:#f87171;
            font-weight:600;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Workout Suggestion Chart</h2>
    <a href="logout.php">Logout</a>
</div>

<div class="info-box">
    <h3>Hello <?php echo htmlspecialchars($name); ?> 👋</h3>
    <p><b>Your BMI:</b> <?php echo $bmi; ?></p>
    <p><b>BMI Category:</b> <?php echo $category; ?></p>
    <p><b>Your Goal:</b> <?php echo $goal; ?></p>
</div>

<h3 style="margin-bottom:15px; color:#38bdf8;">Your Recommended Workout Plan</h3>

<div class="workout-container">

<?php
if(mysqli_num_rows($resultWorkout) > 0){

    while($workout = mysqli_fetch_assoc($resultWorkout)){
        echo "
        <div class='workout-card'>
            <span class='tag'>{$workout['day']}</span>
            <h4>{$workout['workout_name']}</h4>
            <p><b>Exercises:</b> {$workout['exercises_text']}</p>
            <p><b>Duration:</b> {$workout['duration']}</p>
        </div>
        ";
    }

} else {
    echo "<div class='no-data'>No workout plan found for your BMI category and goal!</div>";
}
?>

</div>

<a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>

</body>
</html>
