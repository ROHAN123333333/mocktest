<?php
require 'config.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$exam_id = intval($_GET['exam_id'] ?? 0);
$exam = $conn->query("SELECT * FROM exams WHERE id=$exam_id")->fetch_assoc();
if(!$exam){ echo 'Invalid exam'; exit; }
$limit = intval($exam['total_questions']);
$questions = $conn->query("SELECT * FROM questions WHERE exam_id=$exam_id ORDER BY RAND() LIMIT $limit");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $score = 0; $answers = $_POST['answers'] ?? [];
    foreach($answers as $qid => $ans){
        $qid = intval($qid);
        $q = $conn->query("SELECT correct_option FROM questions WHERE id=$qid")->fetch_assoc();
        if($q && $q['correct_option'] == $ans) $score++;
    }
    $total = count($answers);
    $stmt = $conn->prepare('INSERT INTO results (user_id,exam_id,score,total,attempt_date) VALUES (?,?,?,?,NOW())');
    $stmt->bind_param('iiii', $_SESSION['user_id'],$exam_id,$score,$total); $stmt->execute();
    header('Location: result.php?exam_id='.$exam_id.'&res_id='.$conn->insert_id); exit;
}
?>
<!doctype html><html><head><meta charset='utf-8'><title>Test - <?= htmlspecialchars($exam['exam_name']) ?></title>
<script>
// Simple timer that submits form when time ends
function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    var interval = setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);
        display.textContent = minutes + ":" + (seconds<10?"0":"") + seconds;
        if (--timer < 0) { clearInterval(interval); document.getElementById('testform').submit(); }
    }, 1000);
}
window.onload = function () {
    var duration = <?= intval($exam['duration']) ?> * 60;
    var display = document.querySelector('#time');
    startTimer(duration, display);
};
</script>
</head><body>
<h2>Test: <?= htmlspecialchars($exam['exam_name']) ?></h2>
<p>Time left: <span id='time'></span></p>
<form method='post' id='testform'>
<?php while($q = $questions->fetch_assoc()): ?>
  <div style='border:1px solid #ccc; padding:10px; margin:8px;'>
    <p><strong>Q<?= $q['id'] ?>.</strong> <?= htmlspecialchars($q['question']) ?></p>
    <label><input type='radio' name='answers[<?= $q['id'] ?>]' value='A'> <?= htmlspecialchars($q['option_a']) ?></label><br>
    <label><input type='radio' name='answers[<?= $q['id'] ?>]' value='B'> <?= htmlspecialchars($q['option_b']) ?></label><br>
    <label><input type='radio' name='answers[<?= $q['id'] ?>]' value='C'> <?= htmlspecialchars($q['option_c']) ?></label><br>
    <label><input type='radio' name='answers[<?= $q['id'] ?>]' value='D'> <?= htmlspecialchars($q['option_d']) ?></label><br>
  </div>
<?php endwhile; ?>
<button type='submit'>Submit Test</button>
</form>
</body></html>
