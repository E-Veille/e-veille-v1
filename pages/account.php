<?php 
if($_SESSION['role'] == 'admin'){ 
?>

<div name="container" class="bg-white rounded-lg p-6 w-3/4 h-3/4">
    <div name="titre">
        <h2 class="text-lg font-bold mb-4">Utilisateurs</h2>
    </div>
    <div name="list-user" class="p-2 h-5/6 overflow-y-auto">
    <?php
    $query = "SELECT u.*
            FROM users u
            ORDER BY u.name ASC";

    try {
        $stmt = $conn->query($query);

        // Vérification si des utilisateurs existent
        if ($stmt->rowCount() > 0) {
            // Tableau pour stocker les utilisateurs par rôle
            $usersByRole = array(
                'admin' => array(),
                'user' => array(),
                'influenceur' => array(),
                'intervenant' => array()
            );

            // Séparation des utilisateurs par rôle
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $role = $row['role'];
                $usersByRole[$role][] = $row;
            }

            // Affichage des utilisateurs par catégorie
            foreach ($usersByRole as $role => $users) {
                if (!empty($users)) {
                    echo "<h3 class='font-bold mt-4'>$role</h3>";

                    foreach ($users as $user) {
                        echo '<div name="user" class="user">';
                        echo '<p>' . $user['name'] . ' ' . $user['username'] . ' ';
                        echo '<p class="text-sm text-gray-600">Dernière connexion : ' . $user['last_seen'] . '</p>';
                        echo '<a href="../app/reset" class="text-blue-500">Réinitialiser les informations</a>';
                        echo '<a href="backoffice.php?page=deleteaccount&id=' . $user["user_id"] . '" class="text-red-500 ml-2">Supprimer le compte</a>';
                        echo '</div>';
                    }

                    echo '<hr class="my-4">';
                }
            }
        } else {
            echo "<p>Aucun utilisateur trouvé.</p>";
        }
    } catch (PDOException $e) {
        echo 'Erreur lors de l\'exécution de la requête : ' . $e->getMessage();
    }
    ?>
    </div>
    <?php
    echo "<div name='interactions' class='flex justify-center bg white text-center'> <a href='backoffice.php?page=addaccount' class='w-full admin_btn'>Ajouter un utilisateur</a></div>";
    // Fermeture de la connexion à la base de données
    $conn = null;
    ?>
</div>

<?php
}
else{
	header("Location: backoffice.php");
   	exit;
}
?>
