<?php
$db = new PDO('mysql:host=localhost; dbname=pdornek', 'root', '');

$limit = 5;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
if($page <= 0){ $page = 1;}

$total_data = $db->query('SELECT count(id) as toplam FROM test')->fetch(PDO::FETCH_ASSOC)['toplam'];

//ceil yuvarlamak icin 50.1 = 51 
$total_page= ceil($total_data/$limit);

$start=($page * $limit)-$limit;

$sorgu =$db->query('SELECT * FROM test ORDER BY id DESC LIMIT ' . $start . ',' . $limit)->fetchAll(PDO::FETCH_ASSOC);

foreach ($sorgu as $veri){
    echo $veri['ad'] . ' ' . $veri['id'] . '<br>';
}
$left= $page - 3;
$right = $page + 3;

if($page <=3){
    $right= 7;
}
if($right >$total_page){
    $left = $total_page - 6;
}

echo '<div class="pages">';
echo '<a class="starts" href="sayfalama.php?page='.($page > 1 ? $page - 1 : 1).'">previous</a>';
 for ($i= $left; $i <= $right; $i++) { 
    if($i > 0 && $i<=$total_page ){
     echo '<a '.($i == $page ? 'class="active"':'').'href="sayfalama.php?page='. $i .'">'. $i .'</a>  ';
    }
 }
 echo '<a class="starts" href="sayfalama.php?page='.($page < $total_page ? $page + 1 : $total_page).'">next</a>';
echo '</div>';

?>
<style>
    .pages a{
        display: inline-block;
        padding: 10px;
        background:#eee;
        margin-right: 4px;
        color:#333;
        text-decoration:none;
    }
    .pages a.active{
        background : #333;
        color:#ffff;
    }
    .pages a.starts{
      
        color:blue;
    }
</style>