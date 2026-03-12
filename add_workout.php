<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if(isset($_POST['add'])){

    $bmi_category = $_POST['bmi_category'];
    $goal = $_POST['goal'];
    $day = $_POST['day'];
    $workout_name = $_POST['workout_name'];
    $exercises = $_POST['exercises'];
    $duration = $_POST['duration'];

    $sql = "INSERT INTO workout_plans (bmi_category, goal, day, workout_name, exercises_text, duration)
            VALUES ('$bmi_category', '$goal', '$day', '$workout_name', '$exercises', '$duration')";

    if(mysqli_query($conn, $sql)){
        $success = "Workout Plan Added Successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout Plan | Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            background: linear-gradient(135deg,#0f172a,#1e293b);
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
            color:white;
        }

        .form-box{
            width:500px; 
            background: rgba(255,255,255,0.08);
            padding:35px;
            border-radius:20px;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            box-shadow:0px 10px 30px rgba(0,0,0,0.4);
        }

        h2{
            text-align:center;
            color:#38bdf8;
            margin-bottom:10px;
        }

        p{
            text-align:center;
            font-size:14px;
            color:#cbd5e1;
            margin-bottom:20px;
        }

        label{
            font-size:14px;
            font-weight:500;
        }

        input, select, textarea{
            width:100%;
            padding:12px;
            margin:10px 0 18px 0;
            border:none;
            border-radius:10px;
            outline:none;
            font-size:14px;
        }

        textarea{
            height:90px;
            resize:none;
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
        }

        button:hover{
            background:#0ea5e9;
        }

        .msg-success{
            margin-top:15px;
            padding:10px;
            border-radius:10px;
            text-align:center;
            background: rgba(34,197,94,0.2);
            color:#86efac;
            font-size:14px;
        }

        .msg-error{
            margin-top:15px;
            padding:10px;
            border-radius:10px;
            text-align:center;
            background: rgba(239,68,68,0.2);
            color:#fecaca;
            font-size:14px;
        }

        .back{
            display:block;
            margin-top:18px;
            text-align:center;
            text-decoration:none;
            color:#cbd5e1;
            font-size:14px;
        }

        .back:hover{
            color:#38bdf8;
        }
    </style>
</head>
<body>

<div class="form-box">

    <h2>Add Workout Plan</h2>
    <p>Admin can add workout plans based on BMI category and goal.</p>

    <form method="POST">

        <label>BMI Category</label>
        <select name="bmi_category" required>
            <option value="">-- Select BMI Category --</option>
            <option value="Underweight">Underweight</option>
            <option value="Normal">Normal</option>
            <option value="Overweight">Overweight</option>
            <option value="Obese">Obese</option>
        </select>

        <label>Goal</label>
        <select name="goal" required>
            <option value="">-- Select Goal --</option>
            <option value="Lose Weight">Lose Weight</option>
            <option value="Gain Muscle">Gain Muscle</option>
            <option value="Maintain Fitness">Maintain Fitness</option>
        </select>

        <label>Day</label>
        <input type="text" name="day" placeholder="Example: Day 1" required>

        <label>Workout Name</label>
        <input type="text" name="workout_name" placeholder="Example: Chest & Triceps" required>

        <label>Exercises</label>
        <textarea name="exercises" placeholder="Example: Pushups, Squats, Plank" required></textarea>

        <label>Duration</label>
        <input type="text" name="duration" placeholder="Example: 45 Minutes" required>

        <button type="submit" name="add">Add Workout Plan</button>

        <?php
        if(isset($success)){
            echo "<div class='msg-success'>$success</div>";
        }

        if(isset($error)){
            echo "<div class='msg-error'>$error</div>";
        }
        ?>

        <a href="admin_dashboard.php" class="back">⬅ Back to Admin Dashboard</a>

    </form>

</div>

</body>
</html>
