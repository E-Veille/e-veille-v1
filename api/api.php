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

    public function __construct()
    {
        $this->db = getConnexion();
    }

    public function handleRequest()
    {
        try {
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

function customErrorHandler($errno, $errstr, $errfile, $errline)
{
    // Enregistrez l'erreur dans un fichier journal
    error_log("Erreur [$errno] : $errstr dans $errfile à la ligne $errline", 3, "error.log");

    // Définissez un message d'erreur générique
    $error = [
        "message" => "Une erreur s'est produite. Veuillez réessayer ultérieurement.",
        "code" => 500 // Code d'erreur interne du serveur
    ];

    // Renvoyez le message d'erreur sous forme de réponse JSON
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    echo json_encode($error, JSON_UNESCAPED_UNICODE);
}


set_error_handler("customErrorHandler");

$api = new API();
$api->handleRequest();
