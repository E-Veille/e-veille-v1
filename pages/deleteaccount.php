<?php 
if($_SESSION['role'] == 'admin'){ 
?>

<?php

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];


    require_once('app/db.conn.php');
    global $conn;

    $query = "DELETE FROM users WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    header('Location: backoffice.php?page=account');
    exit();
} else {
    echo "<p>L'ID de l'utilisateur n'est pas spécifié.</p>";
}
?>

<?php
}
else{
	header("Location: backoffice.php");
   	exit;
}
?>