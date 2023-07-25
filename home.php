<?php
session_start();
if (isset($_SESSION['username'])) {
    # fichier de connexion à la base de données
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/conversations.php';
    include 'app/helpers/timeAgo.php';
    include 'app/helpers/last_chat.php';

    # Obtenir les données de l'utilisateur
    $user = getUser($_SESSION['username'], $conn);
    $adminRole = 'admin';
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>

        <!-- link css/style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
        <link rel="stylesheet" href="dist/output.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    </head>

    <body class="body h-screen mt-12">
    <!-- Barre de navigation -->

    <nav class="bg-white shadow-lg absolute inset-x-0 top-0 h-16">
        <div class="flex items-center justify-center m-2">
            <a href="chat.php?user=intervenant" class="icone mr-4">
                <span class="material-symbols-outlined">hearing</span>
            </a>
            <!-- Icone Home -->
            <a href="home.php" class="icone mr-4 p-2">
                <span class="material-symbols-outlined">home</span>
            </a>
            <!-- Account icone  -->
            <a href="profil.php" class="icone mr-4 p-2">
                <span class="material-symbols-outlined">account_circle</span>
            </a>
            <!-- Admin icone -->
            <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'influenceur' || $_SESSION['role'] == 'intervenant'): ?>
                <a href="./backoffice.php" class="icone mr-4 p-2">
                    <span class="material-symbols-outlined"> construction</span>
                </a>
            <?php endif; ?>
            <!-- Logout -->
            <a href="logout.php" class="icone p-2">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </div>
    </nav>
    
    <!-- Contenu principal -->

    <main name="container" class="w-4/5">

        <div name="fil d'actualité" class="col-span-2 bg-white shadow-md rounded-lg p-12 mx-auto">
            <div name="titre">
                <h2 class="text-lg font-bold mb-4">Fil d'actualité</h2>
            </div>
            <div class="overflow-y-auto h-[600px]" name="post-list">
                <?php
                $role = $_SESSION['role'];

                // Récupérer le nombre de posts affichés précédemment
                $postsDisplayed = 0;
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postsDisplayed'])) {
                    $postsDisplayed = intval($_POST['postsDisplayed']);
                }

                // Requête SQL avec la limitation des posts
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

                            echo "<article class='article'>";
                            echo "<div class='article_titre' name='title'><a>" . $row["title"] . "</a></div>";
                            echo "<div class='article_p' name='content'><p>" . substr($row["content"], 0, 1000) . "</p></div>";
                            echo "<div name='date' class='text-xs'><p>Publié le " . date('d/m/Y H:i', strtotime($row["timestamp"])) . " par " . $row["UserName"] . "</p></div>";
                            echo "<form method='post'>";
                            echo "<input type='hidden' name='post_id' value='" . $row["post_id"] . "'>";
                            echo "</form>";
                            echo "</article>";
                        }

                        $postsDisplayed += 3; // Incrémenter le nombre de posts affichés
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
        </div>
    </main>

    </body>


    </html>
    <?php
} else {
    header("Location: index.php");
    exit;
}
?>
