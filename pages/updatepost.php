<?php
if ($_SESSION['role'] != 'intervenant') {
?>

<?php

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Récupérer les valeurs du formulaire
        $title = htmlspecialchars(trim($_POST['title']));
        $content = nl2br(htmlspecialchars(trim($_POST['content'])));

        if (!empty($title) && !empty($content)) {

            $query = "UPDATE posts SET title = :title, content = :content WHERE post_id = :post_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $content, PDO::PARAM_STR);
            $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: backoffice.php?page=post');
            exit();
        }
    }




    $query = "SELECT * FROM posts WHERE post_id = :post_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="flex justify-center items-center h-screen w-3/4">
    <div class="w-96 bg-white shadow-md rounded-md p-6 w-full border-2 border-blue-100">
        <h1 class="text-xl font-bold mb-4 text-center">Modifier le post</h1>
        <form method="post" action="" class="text-center">
            <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
            <div class="mb-4">
                <label for="title" class="block font-bold">Titre :</label>
                <input type="text" name="title" id="title" value="<?= $post['title'] ?>" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="mb-4">
                <label for="content" class="block font-bold">Contenu :</label>
                <textarea name="content" id="content" class="w-full border border-gray-300 rounded-md px-3 py-2 h-60"><?= str_replace('<br />', ' ',  $post['content']) ?></textarea>
            </div>
            <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Enregistrer
            </button>
        </form>
    </div>
</div>

<?php
    } else {
        echo "<p class='text-center'>Le post demandé n'existe pas.</p>";
    }

    $conn = null;
} else {
    echo "<p class='text-center'>L'ID du post n'est pas spécifié.</p>";
}
?>

<?php
} else {
    header("Location: backoffice.php");
    exit;
}
?>
