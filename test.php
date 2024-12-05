<?php
define('SEC', 'section');
define('CONFIG', 'config');
define('GAMES', 'games');
define('CATEGORY', 'category');
define('F_GAMES', 'featured_games');
define('BLOGS', 'blog');
define('ADS', 'ads');
define('PAGES', 'pages');
define('COMMENTS', 'comments');
define('USERS', 'users');
define('LIKES', 'likes');
define('REPORTS', 'report');
define("DISLIKES", "unlikes");
// MySQL Database User
define("DB_USERNAME", "user");
// MySQL Database Password
define("DB_PASSWORD", "user");
// MySQL Hostname
define("DB_HOST", "ACENSOR");
// MySQL Database Name
define("DB_NAME", "game_portal");

// Site URL
$site_url = "http://localhost/html5-portal-main/"; // e.g (http://example.com)
try {
    $socket = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($socket) {
        # empty code;
    } else {
        # error if connection is not established 
    }
} catch (Exeception $error) {
    if ($error) {
        echo 'Connection is not establish';
    }
}
function getGame($limit)
{
    global $socket;
    if ($limit !== '') {
        $sql = $socket->query("SELECT * FROM " . GAMES . "  ORDER BY id DESC LIMIT $limit ");
        $data = [];
        while ($row = $sql->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
$data = [];
$data = GameByCategoryName(10,40);
echo "<pre>"; // Optional: for better formatting
print_r($data);
echo "</pre>";
ini_set('display_errors', 0);
error_reporting(E_ALL);


function GameByCategoryName($id, $limit)
{
    global $socket;
    $name = getCategoryNameById($id);
    if ($limit !== '') {
        $sql = $socket->query("SELECT * FROM " . GAMES . " WHERE game_category='$name' LIMIT $limit ");
        $data = [];
        while ($row = $sql->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}

function getCategoryNameById($id)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . CATEGORY . " WHERE id=$id ");
    $data = $row = $sql->fetch_assoc();

    return $data['name'];
}
?>