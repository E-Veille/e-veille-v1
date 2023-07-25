<?php
session_start();

# vérifier si le nom d'utilisateur et le mot de passe ont été soumis
if (
  isset($_POST['username']) &&
  isset($_POST['password'])
) {

  # fichier de connexion à la base de données
  include '../db.conn.php';

  # récupérer les données de la requête POST et les stocker dans des variables
  $password = $_POST['password'];
  $username = $_POST['username'];

  # validation simple du formulaire
  if (empty($username)) {
    # message d'erreur
    $em = "Le nom d'utilisateur est requis";

    # rediriger vers 'index.php' en passant le message d'erreur
    header("Location: ../../index.php?error=$em");
  } else if (empty($password)) {
    # message d'erreur
    $em = "Le mot de passe est requis";

    # rediriger vers 'index.php' en passant le message d'erreur
    header("Location: ../../index.php?error=$em");
  } else {
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    # si le nom d'utilisateur existe
    if ($stmt->rowCount() === 1) {
      # récupération des données de l'utilisateur
      $user = $stmt->fetch();

      # si les deux noms d'utilisateur sont strictement égaux
      if ($user['username'] === $username) {
        # vérification du mot de passe crypté
        if (password_verify($password, $user['password'])) {
          if ($user['reset'] == 1) {
            // L'utilisateur est à sa première connexion, rediriger vers une page de réinitialisation du mot de passe
            $_SESSION['rotabois'] = $user['user_id'];
            header("Location: ../../changepassword.php");
          } else {
            # authentification réussie
            # création de la SESSION
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];

            # redirection vers 'home.php'
            header("Location: ../../home.php");
          }
        } else {
          # message d'erreur
          $em = "Nom d'utilisateur ou mot de passe incorrect";

          # redirection vers 'index.php' en passant le message d'erreur
          header("Location: ../../index.php?error=$em");
        }
      } else {
        # message d'erreur
        $em = "Nom d'utilisateur ou mot de passe incorrect";

        # redirection vers 'index.php' en passant le message d'erreur
        header("Location: ../../index.php?error=$em");
      }
    }
    else {
      $em = "Nom d'utilisateur ou mot de passe incorrect";
      # redirection vers 'index.php' en passant le message d'erreur
      header("Location: ../../index.php?error=$em");
    }
  }
} else {
  header("Location: ../../index.php");
  exit;
}
