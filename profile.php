<?php
require 'config.php'; if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$user_id = $_SESSION['user_id'];
$user = $conn->query('SELECT * FROM users WHERE id='.$user_id)->fetch_assoc();
$results = $conn->query('SELECT r.*, e.exam_name FROM results r JOIN exams e ON r.exam_id=e.id WHERE r.user_id='.$user_id.' ORDER BY r.attempt_date DESC');
$join = new DateTime($user['join_date']); $now = new DateTime(); $days = $join->diff($now)->days;
?>
<!doctype html><html><head><meta charset='utf-8'><title>Profile</title></head><body>
<h2>Profile: <?= htmlspecialchars($user['name']) ?></h2>
<p>Email: <?= htmlspecialchars($user['email']) ?></p>
<p>Free days used: <?= $days ?> / 30</p>
<h3>Attempts</h3>
<ul>
<?php while($r = $results->fetch_assoc()): ?>
  <li><?= htmlspecialchars($r['exam_name']) ?> — <?= $r['score'] ?>/<?= $r['total'] ?> on <?= $r['attempt_date'] ?></li>
<?php endwhile; ?>
</ul>
<a href='dashboard.php'>Dashboard</a>
</body></html>
