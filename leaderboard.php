<?php
require 'config.php';
$top = $conn->query('SELECT u.name, r.score, e.exam_name FROM results r JOIN users u ON r.user_id=u.id JOIN exams e ON r.exam_id=e.id ORDER BY r.score DESC LIMIT 10');
?>
<!doctype html><html><head><meta charset='utf-8'><title>Leaderboard</title></head><body>
<h2>Top 10 Results</h2>
<ol>
<?php while($t = $top->fetch_assoc()): ?>
  <li><?= htmlspecialchars($t['name']) ?> — <?= $t['score'] ?> (<?= htmlspecialchars($t['exam_name']) ?>)</li>
<?php endwhile; ?>
</ol>
<a href='dashboard.php'>Dashboard</a>
</body></html>
