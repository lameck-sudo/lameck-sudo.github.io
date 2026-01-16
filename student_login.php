<?php
session_start();
$conn = new mysqli("localhost","root","","voting_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

// Handle form submission
if(isset($_POST['login'])){
    $name = trim($_POST['name']);

    // Check if student exists
    $res = $conn->query("SELECT * FROM students WHERE name='$name'");
    if($res->num_rows == 0){
        // Create new student
        $conn->query("INSERT INTO students(name,has_voted) VALUES('$name',0)");
        $student_id = $conn->insert_id;
    } else {
        $student = $res->fetch_assoc();
        $student_id = $student['id'];
        if($student['has_voted']){
            die("You have already voted. Thank you!");
        }
    }

    // Store student_id in session
    $_SESSION['student_id'] = $student_id;
    $_SESSION['student_name'] = $name;

    // Redirect to voting page
    header("Location: vote.php");
    exit;
}
?>

<h2>Student Login / Registration</h2>
<form method="post">
    <input type="text" name="name" placeholder="Enter Your Name" required>
    <button type="submit" name="login">Enter Voting</button>
</form>
