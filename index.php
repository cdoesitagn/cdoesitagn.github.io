<?php
require_once 'app/init.php';
?>
<script>
        console.log("<?php echo ""?>");
</script>

<?php
$portal['content'] = LoadFile('home/content');

if ($zon['page'][0] === '') {
    $portal['content'] = LoadFile('home/content');
} else if ($zon['page'][0] === 'play') {
    $portal['content'] = LoadFile('play/content');
} else if ($zon['page'][0] === 'c') {
    if ($zon['page'][1] != ""){
        $portal['content'] = LoadFile('c/' . $zon['page'][1]);
    } else {
        $portal['content'] = LoadFile('404/content');
    }
} else if ($zon['page'][0] === 'description') {
    $portal['content'] = LoadFile('description/content');
} else if ($zon['page'][0] === '404') {
    $portal['content'] = LoadFile('404/content');
} else {
    $portal['content'] = LoadFile('404/content');
    // echo "<script>window.location.href = '/404'</script>";
    // header("Location: " . url() . "/404");
}

echo LoadFile('container');

