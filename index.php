<?php
require_once 'app/init.php';

$portal['content'] = LoadFile('home/content');

// if ($zon['page'][0] === '') {
//     $portal['content'] = LoadFile('home/content');
//     // if (isset($zon['page'][1])) {
//     // $game_name = str_replace("-", " ", $zon['page'][1]);
//     // $poki['game_data'] = dataBy("SELECT * FROM zon_games WHERE game_name='$game_name'")[0];
//     // }
// } else if ($zon['page'][0] === 'play') {
//     $portal['content'] = LoadFile('play/content');
// } else if ($zon['page'][0] === 'description') {
//     $portal['content'] = LoadFile('description/content');
// } else if ($zon['page'][0] === '404') {
//     $portal['content'] = LoadFile('404/content');
// } else {
//     $portal['content'] = LoadFile('404/content');
//     echo "<script>window.location.href = '/404'</script>";
//     // header("Location: " . url() . "/404");
// }

echo LoadFile('container');