<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = $_POST['name']; $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $join_date = date('Y-m-d');
    $stmt = $conn->prepare('INSERT INTO users (name,email,password,join_date) VALUES (?,?,?,?)');
    $stmt->bind_param('ssss',$name,$email,$pass,$join_date);
    if($stmt->execute()) echo "Signup successful! <a href='login.php'>Login</a>";
    else echo 'Error: '.$conn->error;
}
?>
<form method='post'>
Name: <input name='name' required><br>
Email: <input name='email' type='email' required><br>
Password: <input name='password' type='password' required><br>
<button type='submit'>Signup</button>
</form>
