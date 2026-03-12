<?php
session_start();

// Debugging (Remove later)
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Session not set. Please login again!');</script>";
    header("refresh:0;url=login.php");
    exit();
}

$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Workout Suggestion Platform</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            min-height: 100vh;
        }

        header{
            width: 100%;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        header h2{
            font-size: 22px;
            font-weight: 700;
            color: #38bdf8;
        }

        header .logout-btn{
            text-decoration: none;
            padding: 10px 18px;
            background: #ef4444;
            color: white;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.3s;
        }

        header .logout-btn:hover{
            background: #dc2626;
        }

        .container{
            padding: 40px;
        }

        .welcome-box{
            background: rgba(255,255,255,0.06);
            padding: 25px;
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 30px;
        }

        .welcome-box h1{
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome-box p{
            font-size: 14px;
            color: #cbd5e1;
        }

        .cards{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card{
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 18px;
            padding: 22px;
            transition: 0.3s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .card:hover{
            transform: translateY(-6px);
            border: 1px solid #38bdf8;
            box-shadow: 0px 10px 25px rgba(56,189,248,0.2);
        }

        .card h3{
            font-size: 18px;
            margin-bottom: 10px;
            color: #38bdf8;
        }

        .card p{
            font-size: 13px;
            color: #cbd5e1;
            margin-bottom: 15px;
        }

        .card a{
            display: inline-block;
            padding: 10px 15px;
            background: #38bdf8;
            color: #0f172a;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .card a:hover{
            background: #0ea5e9;
        }

        footer{
            text-align: center;
            padding: 20px;
            color: #94a3b8;
            font-size: 13px;
            margin-top: 40px;
        }

        .badge{
            position: absolute;
            top: 18px;
            right: 18px;
            background: rgba(56,189,248,0.2);
            color: #38bdf8;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<header>
    <h2>Workout Suggestion Platform</h2>
    <a href="logout.php" class="logout-btn">Logout</a>
</header>

<div class="container">

    <div class="welcome-box">
        <h1>Welcome, <?php echo htmlspecialchars($name); ?> 👋</h1>
        <p>Track your fitness details, calculate BMI, and get the best workout plan suggestion based on your goal.</p>
    </div>

    <div class="cards">

        <div class="card">
            <span class="badge">Step 1</span>
            <h3>Fill Fitness Details</h3>
            <p>Enter your age, height, weight, and fitness goal to start your workout plan journey.</p>
            <a href="fitness_form.php">Enter Details</a>
        </div>

        <div class="card">
            <span class="badge">Step 2</span>
            <h3>View BMI Result</h3>
            <p>Check your Body Mass Index (BMI) and know your health category.</p>
            <a href="bmi_result.php">View BMI</a>
        </div>

        <div class="card">
            <span class="badge">Step 3</span>
            <h3>Workout Suggestion</h3>
            <p>Get workout chart suggestions based on your BMI category and fitness goal.</p>
            <a href="workout_chart.php">Get Workout Plan</a>
        </div>


        <div class="card">
            <span class="badge">Step 4</span>
            <h3>Gym Slot Booking</h3>
            <p>Reserve your gym time slot to avoid crowd and manage your workout schedule.</p>
            <a href="book_slot.php">Book Gym Slot</a>
        </div>
 
        <div class="card">
            <h3>Gym Payment</h3>
            <p>Users can pay the gym membership fee using the payment module.</p>
            <a href="payment.php">Make Payment</a>
        </div>
        
        <div class="card">
            <span class="badge">User</span>
            <h3>My Profile</h3>
            <p>View your account details and check your saved fitness information.</p>
            <a href="profile.php">View Profile</a>
        </div>
        
        <div class="card">
            <span class="badge">History</span>
            <h3>Fitness History</h3>
            <p>View all your previous BMI calculations and fitness records.</p>
            <a href="fitness_history.php">View History</a>
        </div>


    </div>

</div>

<footer>
    © <?php echo date("Y"); ?> Workout Suggestion Platform | Developed by Sriharan
</footer>

</body>
</html>
