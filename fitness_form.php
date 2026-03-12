<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

if(isset($_POST['submit'])){

    $age = $_POST['age'];
    $height = $_POST['height']; // in cm
    $weight = $_POST['weight']; // in kg
    $goal = $_POST['goal'];

    // BMI Calculation
    $height_m = $height / 100;
    $bmi = $weight / ($height_m * $height_m);
    $bmi = round($bmi, 2);

    // BMI Category
    if($bmi < 18.5){
        $category = "Underweight";
    }
    elseif($bmi >= 18.5 && $bmi <= 24.9){
        $category = "Normal";
    }
    elseif($bmi >= 25 && $bmi <= 29.9){
        $category = "Overweight";
    }
    else{
        $category = "Obese";
    }
    

    // Insert into database
    $sql = "INSERT INTO user_fitness (user_id, age, height, weight, goal, bmi, bmi_category)
            VALUES ('$user_id', '$age', '$height', '$weight', '$goal', '$bmi', '$category')";

    if(mysqli_query($conn, $sql)){
        header("Location: bmi_result.php");
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
    <title>Fitness Details | Workout Platform</title>

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

        .form-card{
            width:400px;
            background: rgba(255,255,255,0.08);
            padding:35px;
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            box-shadow:0px 10px 25px rgba(0,0,0,0.4);
        }

        .form-card h2{
            text-align:center;
            margin-bottom:10px;
            color:#38bdf8;
        }

        .form-card p{
            text-align:center;
            font-size:13px;
            margin-bottom:20px;
            color:#cbd5e1;
        }

        label{
            font-size:14px;
            font-weight:500;
        }

        input, select{
            width:100%;
            padding:12px;
            margin:10px 0 18px 0;
            border:none;
            border-radius:10px;
            outline:none;
            font-size:14px;
        }

        button{
            width:100%;
            padding:12px;
            border:none;
            border-radius:10px;
            background:#38bdf8;
            font-size:16px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#0ea5e9;
        }

        .back-btn{
            display:block;
            margin-top:15px;
            text-align:center;
            text-decoration:none;
            color:#cbd5e1;
            font-size:14px;
        }

        .back-btn:hover{
            color:#38bdf8;
        }

        .error{
            margin-top:15px;
            background: rgba(255,0,0,0.2);
            padding:10px;
            border-radius:10px;
            text-align:center;
            font-size:14px;
        }
    </style>
</head>
<body>

<div class="form-card">
    <h2>Fitness Details Form</h2>
    <p>Hello <b><?php echo htmlspecialchars($name); ?></b> 👋 Fill your details to get BMI & Workout Plan.</p>

    <form method="POST">

        <label>Age</label>
        <input type="number" name="age" placeholder="Enter your age" required>

        <label>Height (in CM)</label>
        <input type="number" step="0.01" name="height" placeholder="Example: 170" required>

        <label>Weight (in KG)</label>
        <input type="number" step="0.01" name="weight" placeholder="Example: 65" required>

        <label>Goal</label>
        <select name="goal" required>
            <option value="">-- Select Goal --</option>
            <option value="Lose Weight">Lose Weight</option>
            <option value="Gain Muscle">Gain Muscle</option>
            <option value="Maintain Fitness">Maintain Fitness</option>
        </select>

        <button type="submit" name="submit">Submit & Calculate BMI</button>

        <a href="dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

        <?php
        if(isset($error)){
            echo "<div class='error'>$error</div>";
        }
        ?>

    </form>
</div>

</body>
</html>
