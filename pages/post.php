<?php 
if($_SESSION['role'] != 'intervenant'){ 
?>

<div name="container" class="w-3/4  bg-white shadow-md rounded-lg p-6">
    <h2 class="text-lg font-bold mb-2 ">Fil d'actualité</h2>
    <hr>
    <div class="overflow-y-auto h-[600px]" name="post-list">
        <?php

        $role = $_SESSION['role'];
        $query = "SELECT p.*, u.name AS UserName
                    FROM posts p
                    LEFT JOIN users u ON p.user_id = u.user_id
                    ORDER BY p.timestamp DESC";

        try {
            $stmt = $conn->query($query);

            // Vérification si des publications existent
            if ($stmt->rowCount() > 0) {
                // Afficher chaque publication
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    echo "<article>";   
                    echo "<div class='article'>";
                    echo "<a class='article_titre'>" . $row["title"] . "</a>";
                    echo "<br>";
                    echo "<br>";
                    echo "<p>" . substr($row["content"], 0, 1000) . "</p>";
                    echo "<div class='metadata'>Publié le " . date('d/m/Y H:i', strtotime($row["timestamp"])) . " par " . $row["UserName"] . "</div>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='post_id' value='" . $row["post_id"] . "'>";
                    echo "</form>";
                    echo "<br>";
                    echo "<div class='flex place-content-around'>";
                    echo '<a href="backoffice.php?page=updatepost&id=' . $row["post_id"] . '"class="admin_post_btn hover:bg-green-400">Modifier le post</a>';
                    echo '<a href="backoffice.php?page=deletepost&id=' . $row["post_id"] . '"class="admin_post_btn hover:bg-red-400">Supprimer le post</a>';
                    echo "</div>";
                    echo "</div>";
                    echo "</article>";
                }
            } else {
                echo "<p>Aucune publication trouvée.</p>";
            }
        } catch (PDOException $e) {
            echo 'Erreur lors de l\'exécution de la requête : ' . $e->getMessage();
        }


        // Fermeture de la connexion à la base de données
        $conn = null;
        ?>

    </div>

    <?php
    if ($role == 'admin' || $role == 'influenceur') {
            echo "<br>";
            echo "<div class='flex place-content-center'>";
            echo "<a href='backoffice.php?page=addpost' class='w-full admin_btn text-center'>Ajouter des publications</a>";
            echo "</div>";
        }
    ?>
</div>

<?php
}
else{
	header("Location: backoffice.php");
   	exit;
}
?>