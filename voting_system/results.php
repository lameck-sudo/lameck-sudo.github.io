<?php
session_start();
if(!isset($_SESSION['admin'])){
    die("Access denied. Admin only.");
}
$conn = new mysqli("localhost","root","","voting_db");
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

$totalVotes = $conn->query("SELECT COUNT(*) AS total FROM votes")->fetch_assoc()['total'];
$res = $conn->query("SELECT * FROM candidates");

echo "<h2>Voting Results</h2>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Name</th><th>Position</th><th>Votes</th><th>Percentage</th></tr>";
while($row = $res->fetch_assoc()){
    $percent = $totalVotes>0 ? round(($row['votes']/$totalVotes)*100,2) : 0;
    echo "<tr><td>{$row['name']}</td><td>{$row['position']}</td><td>{$row['votes']}</td><td>$percent%</td></tr>";
}
echo "</table>";
