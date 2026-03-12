<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Fetch all fitness history
$sql = "SELECT * FROM user_fitness WHERE user_id='$user_id' ORDER BY fitness_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness History | Workout Platform</title>

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

        .logout{
            text-decoration:none;
            background:#ef4444;
            padding:10px 16px;
            border-radius:10px;
            color:white;
            font-weight:600;
        }

        .logout:hover{
            background:#dc2626;
        }

        .info{
            background: rgba(255,255,255,0.08);
            padding:20px;
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            margin-bottom:25px;
        }

        .info p{
            color:#cbd5e1;
            font-size:14px;
            margin-top:5px;
        }

        .table-box{
            background: rgba(255,255,255,0.08);
            padding:20px;
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse: collapse;
            min-width:900px;
        }

        th, td{
            padding:12px;
            text-align:left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            font-size:14px;
        }

        th{
            background: rgba(56,189,248,0.2);
            color:#38bdf8;
            font-weight:600;
        }

        td{
            color:#e2e8f0;
        }

        .badge{
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
            display:inline-block;
        }

        .underweight{
            background: rgba(250,204,21,0.2);
            color:#facc15;
        }

        .normal{
            background: rgba(34,197,94,0.2);
            color:#22c55e;
        }

        .overweight{
            background: rgba(251,146,60,0.2);
            color:#fb923c;
        }

        .obese{
            background: rgba(239,68,68,0.2);
            color:#ef4444;
        }

        .btn-back{
            display:inline-block;
            margin-top:20px;
            text-decoration:none;
            padding:12px 18px;
            background:#38bdf8;
            color:#0f172a;
            font-weight:600;
            border-radius:12px;
        }

        .btn-back:hover{
            background:#0ea5e9;
        }

        .no-data{
            text-align:center;
            padding:20px;
            color:#f87171;
            font-weight:600;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Fitness History</h2>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="info">
    <h3 style="color:#38bdf8;">Hello <?php echo htmlspecialchars($name); ?> 👋</h3>
    <p>Here you can view your full BMI and fitness records history.</p>
</div>

<div class="table-box">
    <table>
        <tr>
            <th>ID</th>
            <th>Age</th>
            <th>Height (cm)</th>
            <th>Weight (kg)</th>
            <th>Goal</th>
            <th>BMI</th>
            <th>BMI Category</th>
            <th>Date</th>
        </tr>

        <?php
        if(mysqli_num_rows($result) > 0){

            while($row = mysqli_fetch_assoc($result)){

                $class = "";
                if($row['bmi_category'] == "Underweight") $class = "underweight";
                if($row['bmi_category'] == "Normal") $class = "normal";
                if($row['bmi_category'] == "Overweight") $class = "overweight";
                if($row['bmi_category'] == "Obese") $class = "obese";

                echo "<tr>
                        <td>{$row['fitness_id']}</td>
                        <td>{$row['age']}</td>
                        <td>{$row['height']}</td>
                        <td>{$row['weight']}</td>
                        <td>{$row['goal']}</td>
                        <td>{$row['bmi']}</td>
                        <td><span class='badge $class'>{$row['bmi_category']}</span></td>
                        <td>{$row['created_at']}</td>
                      </tr>";
            }

        } else {
            echo "<tr>
                    <td colspan='8' class='no-data'>
                        No fitness history found! Please fill fitness form first.
                    </td>
                  </tr>";
        }
        ?>
    </table>
</div>

<a href="dashboard.php" class="btn-back">⬅ Back to Dashboard</a>

</body>
</html>
