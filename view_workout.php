<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all workout plans
$sql = "SELECT * FROM workout_plans ORDER BY plan_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workout Plans | Admin</title>

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

        h2{
            text-align:center;
            color:#38bdf8;
            margin-bottom:20px;
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

        .btn{
            text-decoration:none;
            padding:8px 12px;
            border-radius:8px;
            font-size:13px;
            font-weight:600;
            margin-right:5px;
            display:inline-block;
        }

        .edit{
            background:#22c55e;
            color:white;
        }

        .edit:hover{
            background:#16a34a;
        }

        .delete{
            background:#ef4444;
            color:white;
        }

        .delete:hover{
            background:#dc2626;
        }

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

<h2>All Workout Plans</h2>

<div class="table-box">
    <table>
        <tr>
            <th>ID</th>
            <th>BMI Category</th>
            <th>Goal</th>
            <th>Day</th>
            <th>Workout Name</th>
            <th>Exercises</th>
            <th>Duration</th>
            <th>Actions</th>
        </tr>

        <?php
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>{$row['plan_id']}</td>
                        <td>{$row['bmi_category']}</td>
                        <td>{$row['goal']}</td>
                        <td>{$row['day']}</td>
                        <td>{$row['workout_name']}</td>
                        <td>{$row['exercises_text']}</td>
                        <td>{$row['duration']}</td>
                        <td>
                            <a class='btn edit' href='edit_workout.php?id={$row['plan_id']}'>Edit</a>
                            <a class='btn delete' href='delete_workout.php?id={$row['plan_id']}' 
                               onclick=\"return confirm('Are you sure you want to delete this workout plan?');\">
                               Delete
                            </a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8' style='text-align:center; color:#f87171;'>No workout plans found!</td></tr>";
        }
        ?>
    </table>
</div>

<a href="admin_dashboard.php" class="back">⬅ Back to Admin Dashboard</a>

</body>
</html>
