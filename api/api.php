<?php
function getConnexion()
{
    return new PDO("mysql:host=localhost;dbname=krpi8598_testprojet;charset=utf8", "krpi8598_admin", "Afrique2015!");
}

function sendJSON($infos)
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    echo json_encode($infos, JSON_UNESCAPED_UNICODE);
}

class API
{
    private $db;
    private $apiKey; // Ajout de la clé d'API

    public function __construct()
    {
        $this->db = getConnexion();

        $this->apiKey = 'feur';
    }

    public function handleRequest()
    {
        try {
            // Vérification de la clé d'API
            $this->checkApiKey();

            if (!empty($_GET['request'])) {
                $url = explode("/", filter_var($_GET['request'], FILTER_SANITIZE_URL));
                switch ($url[0]) {
                    case "post":
                        if (empty($url[1])) {
                            $this->getAllPosts();
                        } else if ($url[1] === "delete" && !empty($url[2])) {
                            $this->deletePost($url[2]);
                        } else {
                            $this->getPost($url[1]);
                        }
                        break;
                    case "users":
                        $this->getAllUsers();
                        break;

                    default:
                        throw new Exception("Requête invalide");
                }
            } else {
                throw new Exception("Problème de réception de donnée.");
            }
        } catch (Exception $e) {
            $error = [
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            print_r($error);
        }
    }

    private function checkApiKey()
    {
        // Récupérer la clé d'API de l'en-tête de la demande
        $clientApiKey = $_SERVER['HTTP_X_API_KEY'];

        // Vérifier la clé d'API
        if ($clientApiKey !== $this->apiKey) {
            http_response_code(401); // Code d'erreur non autorisé
            throw new Exception("Clé d'API non valide.");
        }
    }

    public function getAllPosts()
    {
        $query = "SELECT * FROM posts";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $posts = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post = array(
                "post_id" => $row['post_id'],
                "title" => $row['title'],
                "content" => $row['content'],
                "user_id" => $row['user_id'],
                "reactions" => $row['reactions'],
                "timestamp" => $row['timestamp'],
                "post_type" => $row['post_type']
            );

            $posts[] = $post;
        }

        sendJSON($posts);
    }

    public function getpost($id)
    {
        $query = "SELECT * FROM posts WHERE post_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($post) {
            sendJSON($post);
        } else {
            throw new Exception("Le message avec l'ID $id n'a pas été trouvé.");
        }
    }

    public function deletePost($id)
    {
        try {
            // Vérifiez d'abord si le post existe
            $query = "SELECT * FROM posts WHERE post_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $post = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$post) {
                throw new Exception("Le post avec l'ID $id n'a pas été trouvé.");
            }

            // Si le post existe, supprimez-le de la base de données
            $query = "DELETE FROM posts WHERE post_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            sendJSON(["message" => "Le post avec l'ID $id a été supprimé avec succès."]);
        } catch (Exception $e) {
            $error = [
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            print_r($error);
        }
    }


    public function getAllUsers()
    {
        try {
            $query = "SELECT * FROM users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $users = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = array(
                    "user_id" => $row['user_id'],
                    "name" => $row['name'],
                    "username" => $row['username'],
                    "p_p" => $row['p_p'],
                    "last_seen" => $row['last_seen'],
                    "role" => $row['role'],
                    "reset" => $row['reset']
                );

                $users[] = $user;
            }

            sendJSON($users);
        } catch (Exception $e) {
            $error = [
                "message" => $e->getMessage(),
                "code" => $e->getCode()
            ];
            print_r($error);
        }
    }
}

$api = new API();
$api->handleRequest();
