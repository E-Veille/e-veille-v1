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

            // Clé d'API
            $apiKey = "feur"; // Remplacez par votre propre clé d'API

            // URL de votre API
            $apiUrl = "https://eligoal.com/e-veille/api/post";

            // Configuration de l'en-tête de la requête
            $options = [
                'http' => [
                    'header' => "X-API-Key: $apiKey\r\n",
                ],
            ];

            $context = stream_context_create($options);

            try {
                // Effectuer une requête GET à votre API avec l'en-tête de la clé d'API
                $apiResponse = file_get_contents($apiUrl, false, $context);

                // Vérifier si la réponse est valide
                if ($apiResponse !== false) {
                    $apiData = json_decode($apiResponse, true);

                    // Vérifier si des publications existent
                    if (!empty($apiData)) {
                        // Afficher chaque publication
                        foreach ($apiData as $post) {
                            echo "<article class='article'>";
                            echo "<div class='article_titre' name='title'><a>" . $post["title"] . "</a></div>";
                            echo "<div class='article_p' name='content'><p>" . substr($post["content"], 0, 1000) . "</p></div>";
                            echo "<div name='date' class='text-xs'><p>Publié le " . date('d/m/Y H:i', strtotime($post["timestamp"])) . " par " . $post["UserName"] . "</p></div>";
                            echo "</article>";
                        }
                    } else {
                        echo "<p>Aucune publication trouvée.</p>";
                    }
                } else {
                    echo "<p>Erreur lors de la récupération des publications depuis l'API.</p>";
                }
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage();
            }
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
