<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des Articles</title>
</head>
<body>
    <h1>Liste des Articles</h1>
    <ul id="articleList"></ul>

    <script>
        // Fonction pour récupérer et afficher la liste des articles
        function fetchArticles() {
            // Créez une demande JSON pour récupérer tous les articles
            const requestData = {
                endpoint: 'post',
                method: 'GET',
                data: {}
            };

            fetch('app/http/proxy.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                // Traitez les données et affichez-les dans la liste
                const articleList = document.getElementById('articleList');
                articleList.innerHTML = ''; // Effacez le contenu précédent

                if (data && data.length > 0) {
                    data.forEach(article => {
                        const listItem = document.createElement('li');
                        listItem.textContent = `ID: ${article.id}, Titre: ${article.title}, Contenu: ${article.content}`;
                        articleList.appendChild(listItem);
                    });
                } else {
                    const listItem = document.createElement('li');
                    listItem.textContent = 'Aucun article trouvé.';
                    articleList.appendChild(listItem);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des articles:', error);
            });
        }

        // Appelez la fonction pour afficher la liste des articles lors du chargement de la page
        fetchArticles();
    </script>
</body>
</html>
