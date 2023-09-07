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
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'influenceur' || $_SESSION['role'] == 'intervenant') : ?>
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

        <main>
            <h1>Liste des Articles</h1>
            <ul id="articleList"></ul>

            <script>
                // Fonction pour récupérer et afficher la liste des articles
                function fetchArticles() {
                    // Créez une demande JSON pour récupérer tous les articles
                    const requestData = {
                        endpoint: 'post',
                        method: 'GET',
                        data: {}
                    };

                    fetch('app/http/proxy.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(requestData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Traitez les données et affichez-les dans la liste
                            const articleList = document.getElementById('articleList');
                            articleList.innerHTML = ''; // Effacez le contenu précédent

                            if (data && data.length > 0) {
                                data.forEach(article => {
                                    const listItem = document.createElement('li');
                                    listItem.textContent = `ID: ${article.id}, Titre: ${article.title}, Contenu: ${article.content}`;
                                    articleList.appendChild(listItem);
                                });
                            } else {
                                const listItem = document.createElement('li');
                                listItem.textContent = 'Aucun article trouvé.';
                                articleList.appendChild(listItem);
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des articles:', error);
                        });
                }

                // Appelez la fonction pour afficher la liste des articles lors du chargement de la page
                fetchArticles();
            </script>
        </main>




    </body>


    </html>
<?php
} else {
    header("Location: index.php");
    exit;
}
?>