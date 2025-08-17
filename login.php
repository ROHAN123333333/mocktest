<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email']; $pass = $_POST['password'];
    $stmt = $conn->prepare('SELECT * FROM users WHERE email=?');
    $stmt->bind_param('s',$email); $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($pass,$user['password'])){
        $_SESSION['user_id'] = $user['id']; $_SESSION['is_admin'] = $user['is_admin'];
        // free check
        $join = new DateTime($user['join_date']); $now = new DateTime(); $diff = $join->diff($now)->days;
        if ($diff > 30){ echo "Your Free Trial expired. Please Subscribe!"; exit; }
        header('Location: dashboard.php'); exit;
    } else { echo 'Invalid Login!'; }
}
?>
<form method='post'>
Email: <input name='email' type='email' required><br>
Password: <input name='password' type='password' required><br>
<button type='submit'>Login</button>
</form>
