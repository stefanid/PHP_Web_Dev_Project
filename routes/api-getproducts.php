<?php
$sFile = file_get_contents("data.txt");
$jData = json_decode($sFile);

$saProducts = json_encode($jData->products);
echo $saProducts;
?>
