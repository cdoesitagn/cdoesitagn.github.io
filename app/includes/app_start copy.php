<?php
session_start();

function LoadFile($name)
{
    global $zon;
    $theme = $zon['config']['theme'];
    $path = "themes/$theme/layout/" . $name . ".phtml";
    if (file_exists($path)) {
        ob_start();
        require ($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    } else {
        echo 'file not exists.' . $path . '\n';
    }
}

function LoadFile2($name)
{
    global $zon;
    $theme = $zon['config']['theme'];
    $path = $name;
    if (file_exists($path)) {
        ob_start();
        require ($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    } else {
        echo 'file not exists.' . $path . '\n';
    }
}


function ZonConfig()
{
    global $socket;
    $sql = $socket->query('SELECT * FROM ' . T_ZON_CONFIG);
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data = $row;
    }
    return $data;
}

function HomeFeedGames()
{
    global $socket;
    $data = [];
    $s = "SELECT * FROM zon_games ORDER BY id DESC";
    $q = $socket->query($s);

    while ($game = $q->fetch_assoc()) {
        if (count($data) != 201) {
            if ($game['is_featured'] == 1) {
                $data[] = $game;
            }

            if ($game['is_featured'] == 0) {
                $data[] = $game;
            }
        }






        // if (count($data) != 130) {
        //     $data[] = $game;
        // } else {
        //     if ($game['is_featured'] == 1) {
        //         $data[] = $game;
        //         die();
        //     }
        // }

        // if (count($data) != 170) {
        //     $data[] = $game;
        // } else {
        //     if ($game['is_featured'] == 1) {
        //         $data[] = $game;
        //         die();
        //     }
        // }

        // if (count($data) != 200) {
        //     $data[] = $game;
        // }
    }

    return $data;

}

$zon = [];
$zon['url'] = $_GET['url'] ?? '';
$zon['page'] = explode("/", $_GET['url'] ?? '');
$zon['config'] = ZonConfig();
$zon['user'] = getLoggedinUser();


// if (isset($_GET) && isset($_GET['theme'])) {
//     if ($_GET['theme'] === 'garud' || $_GET['theme'] === 'zontal') {
//         $_SESSION['theme'] = $_GET['theme'];
//         if (isset($_SESSION) && isset($_SESSION['theme'])) {
//             $zon['config']['theme'] = $_SESSION['theme'];
//             header("Location: ?");
//         }
//     }
// }

// $zon['config']['theme'] = $_SESSION['theme'] ?? 'garud';



if (isset($_SESSION['Loggedin'])) {
    define("IsLoggedin", true);
} else {
    define("IsLoggedin", false);
}


if (isset($_SESSION['is_admin_Loggedin'])) {
    define("IsAdmin", true);
} else {
    define("IsAdmin", false);
}

function getLoggedinUser()
{
    global $socket;

    if (isset($_SESSION['Loggedin']) && isset($_SESSION['Loggedin_user'])) {
        $user_i = $_SESSION['Loggedin_user'];
        $sql = "SELECT * FROM " . T_ZON_USERS . " WHERE username='$user_i' OR email='$user_i' ";
        $runned = mysqli_query($socket, $sql);
        $data = [];
        while ($row = $runned->fetch_assoc()) {
            $data = $row;
        }
        return $data;
    }
}

function DynamicSection()
{
    global $socket;
    $sql = $socket->query('SELECT * FROM ' . T_ZON_SEC);
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function GameByCategoryName($id, $limit)
{
    global $socket;
    $name = getCategoryNameById($id);
    if ($limit !== '') {
        $sql = $socket->query("SELECT * FROM " . T_ZON_GAMES . " WHERE game_category='$name' LIMIT $limit ");
        $data = [];
        while ($row = $sql->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}

function GameByCategoryWise($name, $limit = 0)
{
    global $socket;
    if ($limit !== 0) {
        $sql = $socket->query("SELECT * FROM " . T_ZON_GAMES . " WHERE game_category='$name' LIMIT $limit ");
    } else {
        $sql = $socket->query("SELECT * FROM " . T_ZON_GAMES . " WHERE game_category='$name'");
    }
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function getGame($limit)
{
    global $socket;
    if ($limit !== '') {
        $sql = $socket->query("SELECT * FROM " . T_ZON_GAMES . "  ORDER BY id DESC LIMIT $limit ");
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
    $sql = $socket->query("SELECT * FROM " . T_ZON_CATEGORY . " WHERE id=$id ");
    $data = $row = $sql->fetch_assoc();

    return $data['name'];
}

function getFeaturedGames()
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_F_GAMES);
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function getGamesById($game_id)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_GAMES . " WHERE id=$game_id ");
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data = $row;
    }
    return $data;
}

function getCategory($limit = 0)
{
    global $socket;
    if ($limit !== 0) {
        $sql = $socket->query("SELECT * FROM " . T_ZON_CATEGORY . " LIMIT $limit ");
    } else {
        $sql = $socket->query("SELECT * FROM " . T_ZON_CATEGORY);
    }
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function num_rows($table, $con)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM $table WHERE $con ORDER BY id DESC ");
    $count = 0;
    while ($row = $sql->fetch_assoc()) {
        $count++;
    }

    return $count;
}

function getGamesByPopular($limit)
{
    global $socket;
    $sql = $socket->query("SELECT MAX( game_played ) FROM " . T_ZON_GAMES . " $limit ");
    $s = $socket->query("SELECT * FROM " . T_ZON_GAMES . " $limit ");
    $data = [];
    $count = 0;
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
        $count++;
    }
    $data2 = [];
    if ($count <= 4) {
        while ($r = $s->fetch_assoc()) {
            $data2[] = $r;
        }
    }

    return $data2;
}

function getBlogs()
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_BLOGS . " ORDER BY id DESC ");
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
    }

    return $data;
}

function tabActivation($page, $class)
{
    global $zon;

    if (isset($zon['page'][0]) && $zon['page'][0] == $page) {
        echo $class;
    }

}


function getAd($offset, $d)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_ADS . " LIMIT $offset ");
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data = $row;
    }
    return $data[$d];
}

function getAdById($id, $d)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_ADS . " WHERE id=$id ORDER BY id DESC");
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data = $row;
    }
    return $data[$d];
}

function makeSlug($v)
{
    $e = strtolower($v);
    $e = str_replace(" ", "-", $e);
    $e = urlencode($e);
    return $e;
}

function blogById($id)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_BLOGS . " WHERE id=$id ORDER BY id DESC ");
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data = $row;
    }

    return $data;
}



function getUserDataById($id)
{
    global $socket;
    $sql = $socket->query("SELECT * FROM " . T_ZON_USERS . " WHERE id=$id");
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data = $row;
    }
    return $data;
}

function redirect($path, $full = 0)
{
    global $site_url;
    $p = $path;
    if ($full == 1) {
        $p = $site_url . $path;
    } else {
        $p = $path;
        return $p;
    }

    echo "<script>window.location.href = '$p'</script>";

}


function add_views($game_id)
{
    global $socket;
    mysqli_query($socket, "UPDATE " . T_ZON_GAMES . " SET game_played=game_played+1 WHERE id=$game_id");
}

function dataBy($query)
{
    global $socket;
    $sql = $socket->query($query);
    $data = [];
    while ($row = $sql->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


function formatNumber($num)
{
    if ($num >= 1000000) {
        return number_format($num / 1000000, 1) . 'm';
    } elseif ($num >= 1000) {
        return number_format($num / 1000, 1) . 'k';
    } else {
        return $num;
    }
}

function isCategory($name)
{
    $n = str_replace("-", " ", urldecode($name));
    if (num_rows(T_ZON_CATEGORY, "name='$n'")) {
        return true;
    } else {
        return false;
    }
}

function clearText($value)
{
    $v = str_replace(":", "", $value);
    $v = str_replace("'", "", $v);
    $v = str_replace(",", "", $v);
    $v = str_replace('"', "", $v);
    $v = str_replace(';', "", $v);
    $v = str_replace('-', "", $v);
    $v = str_replace('_', "", $v);
    return $v;
}