<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$admin_name = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Workout Platform</title>

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
            color:white;
            min-height:100vh;
        }

        header{
            width:100%;
            padding:20px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            background: rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
        }

        header h2{
            font-size:22px;
            font-weight:700;
            color:#38bdf8;
        }

        header a{
            text-decoration:none;
            padding:10px 18px;
            background:#ef4444;
            color:white;
            border-radius:10px;
            font-weight:600;
            transition:0.3s;
        }

        header a:hover{
            background:#dc2626;
        }

        .container{
            padding:40px;
        }

        .welcome{
            background: rgba(255,255,255,0.08);
            padding:25px;
            border-radius:18px;
            border: 1px solid rgba(255,255,255,0.1);
            margin-bottom:30px;
        }

        .welcome h1{
            font-size:28px;
            margin-bottom:8px;
        }

        .welcome p{
            font-size:14px;
            color:#cbd5e1;
        }

        .cards{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap:20px;
        }

        .card{
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
            padding:22px;
            border-radius:18px;
            transition:0.3s;
        }

        .card:hover{
            transform: translateY(-6px);
            border: 1px solid #38bdf8;
            box-shadow:0px 10px 25px rgba(56,189,248,0.2);
        }

        .card h3{
            color:#38bdf8;
            font-size:18px;
            margin-bottom:10px;
        }

        .card p{
            font-size:13px;
            color:#cbd5e1;
            margin-bottom:15px;
        }

        .card a{
            display:inline-block;
            padding:10px 15px;
            background:#38bdf8;
            color:#0f172a;
            border-radius:10px;
            text-decoration:none;
            font-weight:600;
            transition:0.3s;
        }

        .card a:hover{
            background:#0ea5e9;
        }

        footer{
            text-align:center;
            padding:20px;
            color:#94a3b8;
            font-size:13px;
            margin-top:40px;
        }
    </style>
</head>
<body>

<header>
    <h2>Admin Panel - Workout Platform</h2>
    <a href="admin_logout.php">Logout</a>
</header>

<div class="container">

    <div class="welcome">
        <h1>Welcome Admin, <?php echo htmlspecialchars($admin_name); ?> 👋</h1>
        <p>Manage workout plans, users, and provide the best workout suggestions for your platform.</p>
    </div>

    <div class="cards">

        <div class="card">
            <h3>Add Workout Plan</h3>
            <p>Add new workout plan for users based on BMI category and goals.</p>
            <a href="add_workout.php">Add Workout</a>
        </div>

        <div class="card">
            <h3>View Workout Plans</h3>
            <p>View all workout plans stored in database and manage them.</p>
            <a href="view_workout.php">View Workouts</a>
        </div>

        <div class="card">
            <h3>View Users</h3>
            <p>View registered users and their fitness details.</p>
            <a href="view_users.php">View Users</a>
        </div>

    </div>

</div>

<footer>
    © <?php echo date("Y"); ?> Workout Suggestion Platform | Admin Panel
</footer>

</body>
</html>
