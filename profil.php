<?php
session_start();
if (isset($_SESSION['username'])) {
    // Fichier de connexion à la base de données
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/conversations.php';
    include 'app/helpers/timeAgo.php';
    include 'app/helpers/last_chat.php';
    // Obtenir les données de l'utilisateur
    $user = getUser($_SESSION['username'], $conn);
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>

        <!-- Lien css/style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="dist/output.css">
    </head>

    <body class="body h-screen mt-16">
        <!-- Barre de navigation -->
        <nav class="bg-white shadow-lg absolute inset-x-0 top-0 h-16">
            <div class="flex items-center justify-center m-2">
                <a href="chat_home.php" class="icone mr-4">
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
                        <span class="material-symbols-outlined">construction</span>
                    </a>
                <?php endif; ?>
                <!-- Logout -->
                <a href="logout.php" class="icone p-2">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        </nav>

        <!-- Informations sur l'utilisateur -->
        <div class="w-3/4 h-screen flex items-center justify-center" >
        <div class="bg-white w-full rounded-lg shadow-lg">
            <div class="px-6 py-8">
                <!-- Photo de profil -->
                <div name="photo de profil" class="flex items-center justify-center">
                    <img class="w-18 h-18 p-4 rounded-full border-4 border-white shadow-md" src="uploads/<?=$user['p_p']?>" alt="Profile Picture">
                </div>
                <div class="text-center mt-4 p-12">
                    <h1 class="text-4xl font-semibold text-gray-800"><?php echo ucfirst($user['username']) . ' ' . ucfirst($user['name']); ?></h1>
                    <br>
                    <p class="text-lg text-gray-600"><?php echo ucfirst($user['role']); ?></p>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>

<?php
} else {
    
    header("Location: index.php");
    exit;
}
?>