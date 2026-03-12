<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

// Fetch user details
$sqlUser = "SELECT * FROM users WHERE user_id='$user_id'";
$resultUser = mysqli_query($conn, $sqlUser);
$user = mysqli_fetch_assoc($resultUser);

// Fetch latest fitness details
$sqlSlot = "SELECT * FROM gym_slots WHERE user_id='$user_id' ORDER BY slot_id DESC LIMIT 1";
$resultSlot = mysqli_query($conn,$sqlSlot);

$slot = null;

if(mysqli_num_rows($resultSlot) > 0){
    $slot = mysqli_fetch_assoc($resultSlot);
}

$sqlFitness = "SELECT * FROM user_fitness WHERE user_id='$user_id' ORDER BY fitness_id DESC LIMIT 1";
$resultFitness = mysqli_query($conn, $sqlFitness);

$fitness = null;
if(mysqli_num_rows($resultFitness) > 0){
    $fitness = mysqli_fetch_assoc($resultFitness);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Workout Platform</title>

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

        .profile-box{
            max-width:800px;
            margin:auto;
            background: rgba(255,255,255,0.08);
            padding:30px;
            border-radius:20px;
            border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            box-shadow:0px 10px 30px rgba(0,0,0,0.4);
        }

        .profile-box h3{
            color:#38bdf8;
            margin-bottom:15px;
            font-size:20px;
        }

        .info-grid{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap:15px;
            margin-bottom:25px;
        }

        .info-card{
            background: rgba(255,255,255,0.06);
            padding:18px;
            border-radius:15px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .info-card p{
            font-size:14px;
            color:#cbd5e1;
        }

        .info-card span{
            color:white;
            font-weight:600;
        }

        .bmi-box{
            text-align:center;
            margin-top:20px;
            padding:25px;
            border-radius:18px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .bmi-box h1{
            font-size:50px;
            color:#38bdf8;
            margin:10px 0;
        }

        .bmi-box h4{
            font-size:18px;
            color:#22c55e;
        }

        .btn-group{
            display:flex;
            justify-content:space-between;
            gap:10px;
            margin-top:25px;
            flex-wrap:wrap;
        }

        .btn{
            flex:1;
            min-width:180px;
            text-align:center;
            text-decoration:none;
            padding:12px;
            border-radius:12px;
            font-weight:600;
            transition:0.3s;
        }

        .btn-dashboard{
            background: rgba(255,255,255,0.15);
            color:white;
        }

        .btn-dashboard:hover{
            background: rgba(255,255,255,0.25);
        }

        .btn-form{
            background:#38bdf8;
            color:#0f172a;
        }

        .btn-form:hover{
            background:#0ea5e9;
        }

        .btn-workout{
            background:#22c55e;
            color:white;
        }

        .btn-workout:hover{
            background:#16a34a;
        }

        .note{
            text-align:center;
            margin-top:20px;
            color:#94a3b8;
            font-size:13px;
        }
    </style>
</head>
<body>

<div class="header">
    <h2>My Profile</h2>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="profile-box">

    <h3>User Information</h3>

    <div class="info-grid">

    <div class="info-card">
        <p><span>Name:</span> <?php echo htmlspecialchars($user['username']); ?></p>
    </div>

    <div class="info-card">
        <p><span>Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <div class="info-card">
        <p><span>Phone:</span> <?php echo htmlspecialchars($user['phone']); ?></p>
    </div>

    <div class="info-card">
        <p><span>Address:</span> <?php echo htmlspecialchars($user['address']); ?></p>
    </div>

</div>
    <h3>Fitness Information</h3>

    <?php if($fitness != null){ ?>

        <div class="info-grid">
            <div class="info-card">
                <p><span>Age:</span> <?php echo $fitness['age']; ?> years</p>
            </div>

            <div class="info-card">
                <p><span>Height:</span> <?php echo $fitness['height']; ?> cm</p>
            </div>

            <div class="info-card">
                <p><span>Weight:</span> <?php echo $fitness['weight']; ?> kg</p>
            </div>

            <div class="info-card">
                <p><span>Goal:</span> <?php echo $fitness['goal']; ?></p>
            </div>
        </div>

        <div class="bmi-box">
            <p style="color:#cbd5e1;">Your Latest BMI</p>
            <h1><?php echo $fitness['bmi']; ?></h1>
            <h4><?php echo $fitness['bmi_category']; ?></h4>
        </div>

        <h3>Gym Slot Booking</h3>

    <?php if($slot != null){ ?>

        <div class="info-grid"> 
        <div class="info-card">
            <p><span>Booking Date:</span> <?php echo $slot['booking_date']; ?></p>
        </div>

        <div class="info-card">
            <p><span>Slot Time:</span> <?php echo $slot['slot_time']; ?></p>
        </div>

        </div>

    <?php } else { ?>

        <div class="info-card">
            <p style="color:#f87171;">No gym slot booked yet.</p>
        </div>

    <?php } ?>

    <?php } else { ?>

        <div class="bmi-box">
            <p style="color:#f87171; font-weight:600;">Fitness details not submitted yet!</p>
            <p style="color:#cbd5e1; margin-top:8px;">Please fill your fitness details to calculate BMI.</p>
        </div>

    <?php } ?>

    <div class="btn-group">
        <a href="dashboard.php" class="btn btn-dashboard">⬅ Dashboard</a>
        <a href="fitness_form.php" class="btn btn-form">Fill Fitness Form</a>
        <a href="workout_chart.php" class="btn btn-workout">Workout Plan</a>
    </div>

    <div class="note">
        Your profile is updated automatically when you submit fitness form.
    </div>

</div>

</body>
</html>
