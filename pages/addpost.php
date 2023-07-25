<?php 
if($_SESSION['role'] != 'intervenant'){ 
?>

<?php
if (isset($_POST['submit'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $content = nl2br(htmlspecialchars(trim($_POST['content'])));


    if (empty($title) || empty($content)) {
        $error = 'Veuillez remplir tout les champs';
    } else {
        require_once('app/db.conn.php');
        global $conn;

        $timestamp = date("Y-m-d H:i:s");
        $postType = 'texte';

        $posts = [
            'title' => $title,
            'content' => $content,
            'timestamp' => $timestamp,
            'user_id' => $_SESSION['user_id'],
            'postType' => $postType,
        ];

        $sql = "
    INSERT INTO posts(title, content, user_id, timestamp, post_type)
    VALUES (:title, :content, :user_id, :timestamp, :postType)
";
        $request = $conn->prepare($sql);
        $request->execute($posts);
        header('Location: backoffice.php?page=post');
    }
}
?>

<div class="flex justify-center items-center h-screen w-3/4">
    <div name="container" class="border-2 border-blue-100 text-black bg-white p-8 rounded-lg w-full shadow-lg">
        <h1 class="text-xl font-bold mb-4 text-center">Créer un post</h1>
        <form method="post" action="" class="text-center">
            <input type="hidden" name="post_id" value="">
            <div class="mb-4">
                <label for="title" class="block font-medium mb-1">Titre :</label>
                <input type="text" name="title" id="title" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label for="content" class="block font-medium mb-1">Contenu :</label>
                <textarea name="content" id="content" class="w-full border border-gray-300 rounded-md px-3 py-2 h-40 resize-none focus:outline-none focus:ring focus:border-blue-300"></textarea>
            </div>
            <div name="interaction">
                <input type="submit" name="submit" value="Enregistrer" class="w-full admin_btn">
            </div>
        </form>
    </div>
</div>

<?php
}
else{
	header("Location: backoffice.php");
   	exit;
}
?>