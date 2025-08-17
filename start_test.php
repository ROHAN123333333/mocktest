<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$exams = $conn->query('SELECT * FROM exams');
?>
<!doctype html><html><head><meta charset='utf-8'><title>Choose Exam</title></head><body>
<h2>Choose Exam</h2>
<?php while($e = $exams->fetch_assoc()): ?>
  <div>
    <h3><?= htmlspecialchars($e['exam_name']) ?></h3>
    <p>Duration: <?= $e['duration'] ?> minutes</p>
    <a href='test.php?exam_id=<?= $e['id'] ?>'>Start Test</a>
  </div>
<?php endwhile; ?>
</body></html>
