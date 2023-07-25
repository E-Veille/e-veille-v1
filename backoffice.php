<?php
    session_start();
if (isset($_SESSION['username'])) {
    if($_SESSION['role'] != 'user'){
        
    require_once('app/db.conn.php');
    require_once('app/http/create_password.php');
    $role = $_SESSION['role'];

    $pages = scandir('pages/');
    if(!empty(isset($_GET['page']))){
        if(in_array($_GET['page'].'.php', $pages)){
           $page = $_GET['page'] ;
        }else{
            $page= 'backoffice';
        }
    }else{
        if($role == 'influenceur'){
            $page = 'post';
        }elseif($role == 'intervenant'){
            $page = 'chat_home';
        }elseif($role == 'admin'){
            $page = 'post';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eveil - Backoffice</title>
    <link rel="stylesheet" href="dist/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>
<body class="admin">

    <div class="flex h-screen">
        <!-- Sidebar, cette partie concerne uniquement la BARRE DE NAVIGATION A GAUCHE DE L'ECRAN --> 
        
        <div name ="Liste des sections"class="w-64 bg-white border-r">
            <div name="titre" class="flex items-center justify-center h-14 border-b">
                <span class="font-medium text-lg text-gray-800">Administration</span>
            </div>
            <nav class="flex-grow">
                <!-- UL pour la liste des catégories  -->
                <ul class="admin_ul">

                    <li class="px-5">
                        <a href="home.php" class="admin_section_a">
                            <span class="admin_span">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6 4a6 6 0 110-12 6 6 0 010 12zm-4-6a2 2 0 100-4 2 2 0 000 4zm4-8a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                            <span class="ml-3">Accueil</span>
                        </a>
                    </li>

                    <?php if($role == 'admin'  || $role == 'intervenant'): ?>

                        <li class="px-5">
                            <a href="backoffice.php?page=chat_home" class="admin_section_a">
                                <span class="admin_span">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v1h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h2V5zm7 0a1 1 0 00-1-1H6a1 1 0 00-1 1v1h7V5zM6 16a1 1 0 100 2h8a1 1 0 100-2H6z" />
                                    </svg>
                                </span>
                                <span class="ml-3">Chat</span>
                            </a>
                        </li>

                    <?php endif ?>

                    <?php if($role == 'admin'  || $role == 'influenceur'): ?>

                        <li class="px-5">
                            <a href="backoffice.php?page=post" class="admin_section_a">
                                <span class="admin_span">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6 4a6 6 0 110-12 6 6 0 010 12zm-4-6a2 2 0 100-4 2 2 0 000 4zm4-8a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </span>
                                <span class="ml-3">Publications</span>
                            </a>
                        </li>

                    <?php endif ?>

                    <?php if($role == 'admin'): ?>
                        <li class="px-5">
                            <a href="backoffice.php?page=account" class="admin_section_a">
                                <span class="admin_span">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v1h2a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h2V5zm7 0a1 1 0 00-1-1H6a1 1 0 00-1 1v1h7V5zM6 16a1 1 0 100 2h8a1 1 0 100-2H6z" />
                                    </svg>
                                </span>
                                <span class="ml-3">Utilisateurs</span>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
        <main class="flex-1 flex justify-center items-center">
            <?php require_once('pages/' . $page . '.php'); ?>
        </main>
</body>
</html>
<?php
    }else{
        header("Location: home.php");
    }
}else{
  header("Location: index.php");
  exit;
}
?>