<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les nouveaux mots de passe depuis le formulaire
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];

  // Vérifications de validation et de sécurité
  if (empty($newPassword) || empty($confirmPassword)) {
    $error = '<div class="flex justify-center bg-red-200 text-yellow-800 p-3 rounded">
    Veuillez remplir tous les champs.
  </div>';
  } elseif ($newPassword !== $confirmPassword) {
    $error = "Les nouveaux mots de passe ne correspondent pas.";
  } else {
    // Le mot de passe est valide, procéder au traitement

    // Traitement du formulaire de changement de mot de passe
    // Assurez-vous de valider et de sécuriser les données soumises

    // Inclure le fichier de connexion à la base de données
    include 'app/db.conn.php';

    // Hasher le nouveau mot de passe
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Mettre à jour le mot de passe dans la base de données pour l'utilisateur actuel
    $userId = $_SESSION['rotabois'];
    $sql = "UPDATE users SET password=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$hashedPassword, $userId]);

    // Réinitialiser la valeur de "reset" dans la base de données
    $sqlReset = "UPDATE users SET reset=0 WHERE user_id=?";
    $stmtReset = $conn->prepare($sqlReset);
    $stmtReset->execute([$userId]);

    // Redirection vers la page de connexion avec un message de succès
    header("Location: index.php?success=Votre mot de passe a été modifié avec succès.");
    exit;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Changer le mot de passe</title>
  <link rel="stylesheet" href="dist/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.7/tailwind.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
</head>

<body class="body">
  <div name="container" class="w-2/4 flex justify-center items-center h-screen">
    <div name="inputs" class="w-full text-black bg-white p-4 rounded-lg">
      <h2 class="text-lg font-bold m-8 text-center">Changer le mot de passe</h2>
      <form method="POST" action="">
      <div name="new-mdp" class="flex place-content-around">
        <label for="new_password">Nouveau mot de passe :</label><br>
        <input type="password" id="new_password" name="new_password" class="border border-gray-300 rounded-md px-2 py-1 mb-2 ml-24"><br><br>
      </div>
      <div name="new-mdp-confirm" class="flex place-content-around">
        <label for="confirm_password">Confirmez le nouveau mot de passe :</label><br>
        <input type="password" id="confirm_password" name="confirm_password" class="border border-gray-300 rounded-md px-2 py-1 mb-2 ml-2"><br><br>
        </div>
        <?php if (isset($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
      <?php endif; ?>
        <div name="interaction" class="flex justify-center">
          <input type="submit" value="Appliquer les changements" class="admin_btn">
        </div>

      </form>

    </div>
  </div>
</body>

</html>