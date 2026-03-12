<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "DELETE FROM workout_plans WHERE plan_id='$id'";

    if(mysqli_query($conn, $sql)){
        header("Location: view_workout.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

} else {
    header("Location: view_workout.php");
    exit();
}
?>
