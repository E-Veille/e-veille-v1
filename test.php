<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts de Réseau Social</title>
</head>

<body>
    <h1>Posts de Réseau Social</h1>
    <div id="post-container"></div>

    <script>
        // Fonction pour charger les posts depuis l'API
        function loadPosts() {
            fetch('app/http/proxy.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        endpoint: 'post',
                        method: 'GET',
                        data: {}
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur de réponse du serveur');
                    }
                    return response.json();
                })
                .then(posts => {
                    // Afficher la réponse dans la console
                    console.log('Réponse de l\'API:', posts);

                    // Afficher les posts dans la page
                    const postContainer = document.getElementById('post-container');
                    postContainer.innerHTML = '';

                    posts.forEach(post => {
                        const postElement = document.createElement('div');
                        postElement.innerHTML = `
                <h2>${post.title}</h2>
                <p>${post.content}</p>
                <p>Auteur: ${post.user_id}</p>
                <p>Date: ${post.timestamp}</p>
                <hr>
            `;
                        postContainer.appendChild(postElement);
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des posts:', error);
                });
        }



        // Appeler la fonction pour charger les posts au chargement de la page
        window.onload = loadPosts;
    </script>
</body>

</html>