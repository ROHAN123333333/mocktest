<?php
require 'config.php';

function is_logged_in(){ return isset($_SESSION['user_id']); }

function check_free_days($user_id){
    global $conn;
    $stmt = $conn->prepare("SELECT join_date FROM users WHERE id=?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if(!$res) return false;
    $join = new DateTime($res['join_date']);
    $now = new DateTime();
    $diff = $join->diff($now)->days;
    return $diff <= 30;
}

?>
