<?php 
if($_SESSION['role'] != 'influenceur'){ 
?>

<?php

if (isset($_SESSION['username'])) {
    # database connection file
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/conversations.php';
    include 'app/helpers/timeAgo.php';
    include 'app/helpers/last_chat.php';

    # Getting User data data
    $user = getUser($_SESSION['username'], $conn);

    # Getting User conversations
    $conversations = getConversation($user['user_id'], $conn);

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css%22%3E
        <title>Chat App - Home</title>
        <link rel="stylesheet" href="style/styles.css">
        <link rel="icon" href="img/logo.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body class="chat_body">

        <div name="chat" class="w-3/4 h-3/4 m-auto">
            <div name="container" class="container mx-auto rounded shadow-lg bg-white p-20">

            <!-- Informations de l'utilisateur en haut + bouton logout -->
            <div name="users-informations" class="text-center pb-10">
                <div class="flex items-center justify-center">
                    <img src="uploads/<?=$user['p_p']?>" class="w-12 h-12 rounded-full">
                    <h3 class="text-lg font-semibold ml-2"><?=$user['name']?></h3>
                </div>
            </div>
            <!-- Barre de recherche utilisateur -->
            <div class="mb-4">
                <input type="text" placeholder="Search..." id="searchText" class="p-2 w-11/12 border-solid border-2 border-indigo-200">
                <button class="btn btn-primary" id="serachBtn"><i class="fa fa-search"></i></button>
            </div>
            <!-- Liste des utilisateurs -->
                <ul id="chatList" class="h-80 overflow-auto">
                    <?php if (!empty($conversations)) { ?>
                        <?php foreach ($conversations as $conversation) { ?>
                            <li class="list-group-item">
                                <a href="chat.php?user=<?= $conversation['username'] ?>" class="flex justify-between items-center p-2">
                                    <div class="flex items-center">
                                        <img src="uploads/<?= $conversation['p_p'] ?>" class="w-10 rounded-circle">
                                        <h3 class="text-xs m-2">
                                            <?= $conversation['name'] ?><br>
                                            <small>
                                                <?php
                                                echo lastChat($_SESSION['user_id'], $conversation['user_id'], $conn);
                                                ?>
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
                            <i class="fa fa-comments d-block text-4xl"></i>
                            No messages yet, Start the conversation
                        </div>
                    <?php } ?>
                </ul>
                <div name="Buttons" class="mt-6">
                <a href="logout.php" class="admin_btn mt-4">Deconnexion</a>
            </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <script>
            $(document).ready(function() {

                // Search
                $("#searchText").on("input", function() {
                    var searchText = $(this).val();
                    if (searchText == "") return;
                    $.post('app/ajax/search.php', {
                            key: searchText
                        },
                        function(data, status) {
                            $("#chatList").html(data);
                        });
                });

                // Search using the button
                $("#serachBtn").on("click", function() {
                    var searchText = $("#searchText").val();
                    if (searchText == "") return;
                    $.post('app/ajax/search.php', {
                            key: searchText
                        },
                        function(data, status) {
                            $("#chatList").html(data);
                        });
                });


                /**
                 * auto update last seen
                 * for logged in user
                 **/
                let lastSeenUpdate = function() {
                    $.get("app/ajax/update_last_seen.php");
                }
                lastSeenUpdate();
                /**
                 * auto update last seen
                 * every 10 sec
                 **/
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

<?php
}
else{
	header("Location: backoffice.php");
   	exit;
}
?>
