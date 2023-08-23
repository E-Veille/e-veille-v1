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
        
        // Remplacez 'VOTRE_CLE_API' par votre propre clé d'API
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
                            $this->getAllpost();
                        } else {
                            $this->getpost($url[1]);
                        }
                        break;
                    default:
                        throw new Exception("Invalid request, check the URL.");
                }
            } else {
                throw new Exception("Data retrieval problem.");
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

    public function getAllpost()
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
}

$api = new API();
$api->handleRequest();
