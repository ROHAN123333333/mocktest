<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$res_id = intval($_GET['res_id'] ?? 0);
$result = $conn->query("SELECT r.*, e.exam_name, u.name FROM results r JOIN exams e ON r.exam_id=e.id JOIN users u ON r.user_id=u.id WHERE r.id=$res_id")->fetch_assoc();
if(!$result){ echo 'Result not found'; exit; }
?>
<!doctype html><html><head><meta charset='utf-8'><title>Result</title></head><body>
<h2>Result for <?= htmlspecialchars($result['exam_name']) ?></h2>
<p>Student: <?= htmlspecialchars($result['name']) ?></p>
<p>Score: <?= $result['score'] ?> / <?= $result['total'] ?></p>
<a href='dashboard.php'>Back to Dashboard</a>
</body></html>
