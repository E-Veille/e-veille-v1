<?php 
if($_SESSION['role'] == 'admin'){ 
?>

<div class="flex justify-center items-center h-screen ">
    <div class="text-black bg-white p-4 rounded-lg w-5/4">
    <h2 class="text-lg font-bold mb-4">Créer un nouvel utilisateur</h2>

    <form method="post" action="backoffice.php?page=signup">

        <label for="firstname">Le Prénom :</label>
        <input type="text" name="firstname" id="" class="border rounded-lg px-3 py-2 mb-2">
        <br>

        <label for="lastname">Le Nom :</label>
        <input type="text" name="lastname" id="" class="border rounded-lg px-3 py-2 mb-2">
        <br>

        <label for="role">Le role</label>
        <select name="role" id="">
            <option value="user">Utilisateur</option>
            <option value="admin">Administrateur</option>
            <option value="influenceur">Influenceur</option>            
            <option value="intervenant">Intervenant</option>
        </select>
        <button type="submit" name="submit" class='login_btn mt-2'>Créer un compte</button>

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