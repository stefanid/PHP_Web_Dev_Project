<?php
$productID = $_GET['productID'];

$sFile = file_get_contents("data.txt");
$jData = json_decode($sFile);
$bCheckResult = False;
$jResponse = "";
$iQuantity = "";
for ($i=0; $i < count($jData->products) ; $i++) {
  if($jData->products[$i]->productID == $productID ){
      $iQuantity = $jData->products[$i]->quantity;
      $iQuantity -= 1;
      $jData->products[$i]->quantity = $iQuantity;
      $bCheckResult = True;
  }else{
    $bCheckResult;
  }
}

if($bCheckResult == True){
  $sjData = json_encode($jData);
  file_put_contents("data.txt",$sjData);
  $jResponse = '{"response":"ok","message":"Product successfully bought!", "quantity":"'.$iQuantity.'"}';
} else{
  $jResponse = '{"response":"fail","message":"Something went wrong!"}';
}
echo $jResponse;
?>
