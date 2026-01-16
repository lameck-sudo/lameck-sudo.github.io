<?php
session_start();
if(!isset($_SESSION['student_id'])){
    header("Location: student_login.php");
    exit;
}

$conn = new mysqli("localhost","root","","voting_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

// Handle vote submission
if(isset($_POST['vote'])){
    $candidate_id = $_POST['candidate'];

    // Prevent double voting
    $res = $conn->query("SELECT has_voted FROM students WHERE id=$student_id");
    $student = $res->fetch_assoc();
    if($student['has_voted']){
        die("You have already voted. Thank you!");
    }

    // Record vote
    $conn->query("INSERT INTO votes(student_id, candidate_id) VALUES($student_id, $candidate_id)");
    $conn->query("UPDATE candidates SET votes = votes + 1 WHERE id=$candidate_id");
    $conn->query("UPDATE students SET has_voted=1 WHERE id=$student_id");

    echo "<h3>Thank you, $student_name! Your vote has been submitted.</h3>";
    echo "<a href='student_logout.php'>Exit</a>";
    exit;
}

// Fetch candidates
$candidates = $conn->query("SELECT * FROM candidates");
?>

<h2>Voting Page</h2>
<form method="post">
    <?php while($c = $candidates->fetch_assoc()): ?>
        <input type="radio" name="candidate" value="<?= $c['id'] ?>" required> <?= $c['name'] ?> (<?= $c['position'] ?>)<br>
    <?php endwhile; ?>
    <button type="submit" name="vote">Submit Vote</button>
</form>
