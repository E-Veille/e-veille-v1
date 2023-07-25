<?php
session_start();

if (isset($_SESSION['username'])) {
    // Inclusion des fichiers de connexion à la base de données et des assistants
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/conversations.php';
    include 'app/helpers/timeAgo.php';
    include 'app/helpers/last_chat.php';

    // Obtention des données de l'utilisateur
    $user = getUser($_SESSION['username'], $conn);

    // Obtention des conversations de l'utilisateur
    $conversations = getConversation($user['user_id'], $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
    <link rel="stylesheet" href="dist/output.css">
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
</head>
<!-- Container -->
<body class="chat_body">

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
            <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'influenceur' || $_SESSION['role'] == 'intervenant'): ?>
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
    <div class="w-9/12 m-auto">
        <div name="container" class="container mx-auto rounded shadow-lg bg-white p-20">
            <!-- Informations de l'utilisateur en haut + bouton logout -->
            <div name="users-informations" class="text-center pb-10">
                <div class="flex items-center justify-center">
                    <img src="uploads/<?=$user['p_p']?>" class="w-12 h-12 rounded-full">
                    <h3 class="text-lg font-semibold ml-2"><?=$user['name']?></h3>
                </div>
            </div>
            <!-- La barre de recherche d'utilisateur -->
            <div id="searchbar" class="mb-4">
                <div class="input-group">
                    <input type="text" placeholder="Search..." id="searchText" class="p-2 w-11/12 border-solid border-2 border-indigo-200">
                    <button class="btn btn-primary p-4" id="searchBtn"> <i class="fa fa-search"></i></button>
                </div>
            </div>

            <!-- Liste des utilisateurs -->
            <ul id="users-list" class="h-64 overflow-auto">
                <?php if (!empty($conversations)) { ?>
                    <?php foreach ($conversations as $conversation) { ?>
                        <li class="list-group-item">
                            <a href="chat.php?user=<?=$conversation['username']?>" class="flex justify-between items-center p-2 hover_user">
                                <div class="flex items-center">
                                    <img src="uploads/<?=$conversation['p_p']?>" class="w-10 h-10 rounded-full">
                                    <h3 class="text-sm font-medium ml-2">
                                        <?=$conversation['name']?><br>
                                        <small>
                                            <?php echo lastChat($_SESSION['user_id'], $conversation['user_id'], $conn); ?>
                                        </small>
                                    </h3>
                                </div>
                                <?php if (last_seen($conversation['last_seen']) == "Active") { ?>
                                    <div title="online">
                                        <div class="online"></div>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-comments text-5xl"></i>
                        No messages yet, Start the conversation
                    </div>
                <?php } ?>
            </ul>
            <div name="Buttons" class="mt-6">
                <a href="logout.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Deconnexion</a>
            </div>
        </div>
    </div>
</body>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Recherche
            $("#searchText").on("input", function () {
                var searchText = $(this).val();
                if (searchText == "") return;
                $.post('app/ajax/search.php', {
                    key: searchText
                }, function (data, status) {
                    $("#users-list").html(data); // Mettre à jour l'ID ici
                });
            });

            // Recherche en utilisant le bouton
            $("#searchBtn").on("click", function () {
                var searchText = $("#searchText").val();
                if (searchText == "") return;
                $.post('app/ajax/search.php', {
                    key: searchText
                }, function (data, status) {
                    $("#users-list").html(data); // Mettre à jour l'ID ici
                });
            });


            // Mise à jour automatique de la dernière connexion pour l'utilisateur connecté
            let lastSeenUpdate = function () {
                $.get("app/ajax/update_last_seen.php");
            }
            lastSeenUpdate();

            // Mise à jour automatique de la dernière connexion toutes les 10 secondes
            setInterval(lastSeenUpdate, 10000);
        });
    </script>
</body>
</html>

<?php
} else {
    header("Location: ./index.php");
    exit;
}
?>
