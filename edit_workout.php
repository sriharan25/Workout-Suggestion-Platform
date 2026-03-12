<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if(!isset($_GET['id'])){
    header("Location: view_workout.php");
    exit();
}

$id = $_GET['id'];

// Fetch old workout data
$sql = "SELECT * FROM workout_plans WHERE plan_id='$id'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){
    header("Location: view_workout.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

// Update workout plan
if(isset($_POST['update'])){

    $bmi_category = $_POST['bmi_category'];
    $goal = $_POST['goal'];
    $day = $_POST['day'];
    $workout_name = $_POST['workout_name'];
    $exercises = $_POST['exercises'];
    $duration = $_POST['duration'];

    $update_sql = "UPDATE workout_plans SET 
                    bmi_category='$bmi_category',
                    goal='$goal',
                    day='$day',
                    workout_name='$workout_name',
                    exercises='$exercises',
                    duration='$duration'
                   WHERE plan_id='$id'";

    if(mysqli_query($conn, $update_sql)){
        header("Location: view_workout.php");
        exit();
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
    <title>Edit Workout Plan | Admin</title>

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
            margin-bottom:15px;
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
            background:#22c55e;
            color:white;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#16a34a;
        }

        .error{
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
    <h2>Edit Workout Plan</h2>

    <form method="POST">

        <label>BMI Category</label>
        <select name="bmi_category" required>
            <option value="Underweight" <?php if($row['bmi_category']=="Underweight") echo "selected"; ?>>Underweight</option>
            <option value="Normal" <?php if($row['bmi_category']=="Normal") echo "selected"; ?>>Normal</option>
            <option value="Overweight" <?php if($row['bmi_category']=="Overweight") echo "selected"; ?>>Overweight</option>
            <option value="Obese" <?php if($row['bmi_category']=="Obese") echo "selected"; ?>>Obese</option>
        </select>

        <label>Goal</label>
        <select name="goal" required>
            <option value="Lose Weight" <?php if($row['goal']=="Lose Weight") echo "selected"; ?>>Lose Weight</option>
            <option value="Gain Muscle" <?php if($row['goal']=="Gain Muscle") echo "selected"; ?>>Gain Muscle</option>
            <option value="Maintain Fitness" <?php if($row['goal']=="Maintain Fitness") echo "selected"; ?>>Maintain Fitness</option>
        </select>

        <label>Day</label>
        <input type="text" name="day" value="<?php echo $row['day']; ?>" required>

        <label>Workout Name</label>
        <input type="text" name="workout_name" value="<?php echo $row['workout_name']; ?>" required>

        <label>Exercises</label>
        <textarea name="exercises" required><?php echo $row['exercises']; ?></textarea>

        <label>Duration</label>
        <input type="text" name="duration" value="<?php echo $row['duration']; ?>" required>

        <button type="submit" name="update">Update Workout Plan</button>

        <?php
        if(isset($error)){
            echo "<div class='error'>$error</div>";
        }
        ?>

        <a href="view_workout.php" class="back">⬅ Back to View Workouts</a>

    </form>
</div>

</body>
</html>
