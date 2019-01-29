<?php
$productid = $_GET['productID'];

$sFile = file_get_contents('data.txt');
$jFindProduct = json_decode($sFile);
$bCheckProduct = False;
for ($i=0; $i < count($jFindProduct->products) ; $i++) {
   if($jFindProduct->products[$i]->productID == $productid){
     $bCheckProduct = True;
     unset($jFindProduct->products[$i]);
   }else{
     $bCheckProduct;
   }
}
if($bCheckProduct == True){
  //rebasing array values
  $jFindProduct->products = array_values($jFindProduct->products);
  $sUpdatedData = json_encode($jFindProduct);
  file_put_contents("data.txt",$sUpdatedData);
  echo '{"response": "ok", "message":"Product has been successfully deleted!"}';
}else{
  echo '{"response": "fail", "message":"Something went wrong!"}';
}
?>
