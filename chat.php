<?php 
  session_start();

  if (isset($_SESSION['username'])) {
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/chat.php';
    include 'app/helpers/opened.php';
    include 'app/helpers/timeAgo.php';

    if (!isset($_GET['user'])) {
      header("Location: home.php");
      exit;
    }

    $chatWith = getUser($_GET['user'], $conn);

    if (empty($chatWith)) {
      header("Location: home.php");
      exit;
    }

    $chats = getChats($_SESSION['user_id'], $chatWith['user_id'], $conn);

    opened($chatWith['user_id'], $conn, $chats);
  } else {
    header("Location: index.php");
    exit;
  }
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

<body class="chat_body mt-16">
  
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

  <!-- Container -->
  <div name="container" class="w-3/4 shadow p-4 rounded bg-white">
    <div name="Interaction">
      <a <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'intervenant'): ?>href="backoffice.php?page=chat_home"<?php else: ?>href="chat_home.php"<?php endif; ?> class="text-2xl text-gray-600">&#8592;</a>
    </div>

    <!-- users-informations -->
    <div name="users-informations" class="p-12 flex items-center mt-4">
      <img src="uploads/<?=$chatWith['p_p']?>" class="w-12 rounded-circle">
      <div name="user" class="ml-2">
        <h3 class="text-lg font-semibold"><?=$chatWith['name']?></h3>
        <div class="flex items-center" title="online">
          <?php if (last_seen($chatWith['last_seen']) == "Active"): ?>
            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
            <small class="ml-1 text-green-500">Online</small>
          <?php else: ?>
            <small class="ml-1">
              Last seen: <?=last_seen($chatWith['last_seen'])?>
            </small>
          <?php endif; ?>
        </div>
      </div>
    </div>


    <!-- Chat box -->
    <div id="chatBox" class="mt-4 h-96 p-12 overflow-y-scroll">
      <?php if (!empty($chats)): ?>
        <?php foreach($chats as $chat): ?>
          <?php if ($chat['from_id'] == $_SESSION['user_id']): ?>

            <!-- Messages de droite -->
            <div name="message">
              <p class="message">
                <?=$chat['message']?>
                <small class="date"><?=date('d/m/Y H:i', strtotime($chat['created_at']))?></small>
              </p>
            </div>
          <?php else: ?>

            <!-- Messages de gauche -->
            <div name="message">
              <p class="py-2 mb-2 pl-4 border rounded bg-white">
                <?=$chat['message']?>
                <small class="date"><?=date('d/m/Y H:i', strtotime($chat['created_at']))?></small>
              </p>
            </div>

          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>

        <!-- Message indiquant qu'aucun message est disponible -->
        <div class="alert alert-info text-center">
          <i class="fa fa-comments text-5xl block mb-2"></i>
          <span class="block">Pas de message pour le moment.</span>
        </div>
      <?php endif; ?>
    </div>


    <!-- Envoyer un message  -->
    <div class="mt-4">
      <textarea id="message" cols="3" class="w-full p-2 border rounded" placeholder="Votre message"></textarea>
      <button id="sendBtn" class="chat_button">
        <i class="fa fa-paper-plane mr-2"></i>Envoyer</button>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script>
    var scrollDown = function() {
      let chatBox = document.getElementById('chatBox');
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    scrollDown();

    $(document).ready(function() {
      $("#sendBtn").on('click', function() {
        message = $("#message").val();
        if (message == "") return;

        $.post("app/ajax/insert.php", {
          message: message,
          to_id: <?=$chatWith['user_id']?>
        }, function(data, status) {
          $("#message").val("");
          $("#chatBox").append(data);
          scrollDown();
        });
      });

      let lastSeenUpdate = function() {
        $.get("app/ajax/update_last_seen.php");
      }

      lastSeenUpdate();

      setInterval(lastSeenUpdate, 10000);

      let fetchData = function() {
        $.post("app/ajax/getMessage.php", {
          id_2: <?=$chatWith['user_id']?>
        }, function(data, status) {
          $("#chatBox").append(data);
          if (data != "") scrollDown();
        });
      }

      fetchData();

      setInterval(fetchData, 500);
    });
  </script>


</body>
</html>
