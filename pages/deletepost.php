<?php 
if($_SESSION['role'] != 'intervenant'){ 
?>


<?php

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];


    require_once('app/db.conn.php');
    global $conn;

    $query = "DELETE FROM posts WHERE post_id = :post_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: backoffice.php?page=post');
    exit();
} else {
    echo "<p>L'ID du post n'est pas spécifié.</p>";
}
?>

<?php
}
else{
	header("Location: backoffice.php");
   	exit;
}
?>