<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];
// check free
$stmt = $conn->prepare('SELECT join_date,name FROM users WHERE id=?'); $stmt->bind_param('i',$user_id); $stmt->execute(); $u = $stmt->get_result()->fetch_assoc();
$join = new DateTime($u['join_date']); $now = new DateTime(); $days = $join->diff($now)->days;
?>
<!doctype html><html><head><meta charset='utf-8'><title>Dashboard</title></head><body>
<h2>Welcome, <?= htmlspecialchars($u['name']) ?></h2>
<p>Free days used: <?= $days ?> / 30</p>
<a href='start_test.php'>Start Test</a> | <a href='leaderboard.php'>Leaderboard</a> | <a href='profile.php'>Profile</a> | <a href='logout.php'>Logout</a>
</body></html>
