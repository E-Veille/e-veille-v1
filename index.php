<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/output.css">
    <link rel="icon" href="img/logo.png">
</head>

<body class="body">

    <div class="flex items-center justify-center h-screen">
        <div class="bg-white shadow-lg border-2 border-blue-100">
            <form method="post" action="app/http/auth.php">

                <div class="flex justify-center items-center flex-col mb-6">
                    <img src="img/logo.png" class="w-full h-40" alt="Logo">
                </div>

                <div class="p-4">
                    <div class="mb-4">
                        <label class="login_label">
                            Pseudo
                        </label>
                        <input type="text" class="login_input" name="username">
                    </div>

                    <div class="mb-4">
                        <label class="login_label">
                            Mot de passe
                        </label>
                        <input type="password" class="login_input" name="password">
                    </div>

                    <button type="submit" class="login_btn">Connexion</button>
                    <?php if (isset($_GET['error'])) { ?>
                    <div class="bg-yellow-200 text-yellow-800 p-3 rounded mb-4">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                    <div class="bg-green-200 text-green-800 p-3 rounded">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                    </div>
                <?php } ?>

                </div>
            </form>
        </div>
    </div>
</body>

</html>
