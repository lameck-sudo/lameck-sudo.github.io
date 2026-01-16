<?php
session_start();
$conn = new mysqli("localhost","root","","voting_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);
define("ADMIN_PASSWORD","Admin@1234");
if(isset($_POST['password'])){
    if($_POST['password']===ADMIN_PASSWORD){
        $_SESSION['admin']=true;
    } else $error="Incorrect password!";
}
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: admin.php");
    exit;
}
if(!isset($_SESSION['admin']) && !isset($_POST['password'])){
?>
<h2>Admin Login</h2>
<form method="post">
<input type="password" name="password" placeholder="Enter Admin Password" required>
<button type="submit">Login</button>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form>
<?php exit; } ?>
<h2>Voting Admin Panel</h2>
<a href="admin.php?logout=1">Logout</a>
<?php
if(isset($_POST['add_candidate'])){
    $name=$_POST['name'];
    $pos=$_POST['position'];
    $conn->query("INSERT INTO candidates(name,position) VALUES('$name','$pos')");
}
$result=$conn->query("SELECT * FROM candidates");
echo "<h3>Candidates</h3><table border='1'><tr><th>ID</th><th>Name</th><th>Position</th></tr>";
while($row=$result->fetch_assoc()){
    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td><td>{$row['position']}</td></tr>";
}
echo "</table>";
?>
<h3>Add Candidate</h3>
<form method="post">
<input type="text" name="name" placeholder="Candidate Name" required>
<input type="text" name="position" placeholder="Position" required>
<button type="submit" name="add_candidate">Add</button>
</form>
