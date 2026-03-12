<?php
session_start();
include("db.php");

$msg = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['book_slot'])){

    $date = $_POST['booking_date'];
    $slot = $_POST['slot_time'];

    // Check if slot already booked
    $check = "SELECT * FROM gym_slots 
              WHERE booking_date='$date' 
              AND slot_time='$slot'";

    $result = mysqli_query($conn,$check);

    if(mysqli_num_rows($result) > 0){

        $msg = "❌ This slot is already booked. Please choose another time.";

    }
    else{

        $sql = "INSERT INTO gym_slots (user_id, booking_date, slot_time)
                VALUES ('$user_id','$date','$slot')";

        if(mysqli_query($conn,$sql)){
            $msg = "✅ Your gym slot has been booked successfully!";
        }else{
            $msg = "❌ Booking failed. Please try again.";
        }

    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Book Gym Slot</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background: linear-gradient(135deg,#0f172a,#1e293b);
    color:white;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Container */

.slot-box{
    background: rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);
    padding:35px;
    border-radius:20px;
    width:380px;
    backdrop-filter: blur(10px);
    transition:0.3s;
}

.slot-box:hover{
    transform:translateY(-6px);
    border:1px solid #38bdf8;
    box-shadow:0px 10px 25px rgba(56,189,248,0.2);
}

.slot-box h2{
    text-align:center;
    color:#38bdf8;
    margin-bottom:20px;
}

/* Inputs */

input, select{
    width:100%;
    padding:10px;
    margin:10px 0 18px 0;
    border:none;
    border-radius:10px;
    background:rgba(255,255,255,0.12);
    color:white;
}

input:focus, select:focus{
    outline:none;
    border:1px solid #38bdf8;
}

/* Dropdown fix */

select option{
    background:#ffffff;
    color:#000000;
}

/* Button */

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#38bdf8;
    color:#0f172a;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#0ea5e9;
}

/* Message */

.msg{
    margin-top:18px;
    text-align:center;
    font-weight:600;
}

.success{
    color:#22c55e;
}

.error{
    color:#f87171;
}

</style>

</head>

<body>

<div class="slot-box">

<h2>Book Gym Slot</h2>

<form method="POST">

<label>Select Date</label>
<input type="date" name="booking_date" min="<?php echo date('Y-m-d'); ?>" required>

<label>Select Time Slot</label>

<select name="slot_time" required>
<option value="">Choose Slot</option>
<option value="6AM - 8AM">6AM - 8AM</option>
<option value="8AM - 10AM">8AM - 10AM</option>
<option value="5PM - 7PM">5PM - 7PM</option>
<option value="7PM - 9PM">7PM - 9PM</option>
</select>

<button type="submit" name="book_slot">Book Slot</button>

</form>

<?php if($msg != ""){ ?>

<div class="msg <?php echo strpos($msg,'✅') !== false ? 'success' : 'error'; ?>">
<?php echo $msg; ?>
</div>

<?php } ?>

</div>

</body>
</html>

