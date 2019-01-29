<?php
$sFile = file_get_contents('data.txt');
$jData = json_decode($sFile);

$bCheckProduct = False;

$productID = $_GET['productID'];
$sNewProductName = $_POST['txtEditProductName'];
$sNewProductBrand = $_POST['txtEditProductBrand'];
$sNewProductPrice = $_POST['txtEditProductPrice'];
$sNewProductModel = $_POST['txtEditProductModel'];
$sNewProductColor = $_POST['txtEditProductColor'];
$sNewProductQuantity = $_POST['txtEditProductQuantity'];
$snewProductImage = $_FILES['fEditProductImage']['name'];



for ($i=0; $i <count($jData->products) ; $i++) {
  if($jData->products[$i]->productID == $productID){
    $bCheckProduct = True;
    $jData->products[$i]->name = $sNewProductName;
    $jData->products[$i]->brand = $sNewProductBrand;
    $jData->products[$i]->price = $sNewProductPrice;
    $jData->products[$i]->quantity = $sNewProductQuantity;
    $jData->products[$i]->model = $sNewProductModel;
    $jData->products[$i]->color = $sNewProductColor;
    if($snewProductImage != ""){
      $sFolder = 'pictures/';
      $sSaveImgTo = $sFolder.$snewProductImage;
      move_uploaded_file($_FILES['fEditProductImage']['tmp_name'],$sSaveImgTo);
      $jData->products[$i]->productImage = $sSaveImgTo;
    }
  }else{
    $bCheckProduct;
  }
}
if($bCheckProduct = True){
  $updatedProduct = json_encode($jData);
  file_put_contents("data.txt", $updatedProduct);
  echo '{"response":"success", "message":"Product has been successfully edited!",
        "newProductName": "'.$sNewProductName.'",
        "newProductBrand": "'.$sNewProductBrand.'",
        "newProductPrice": "'.$sNewProductPrice.'",
        "newProductQuantity": "'.$sNewProductQuantity.'",
        "newProductModel": "'.$sNewProductModel.'",
        "newProductColor": "'.$sNewProductColor.'",
        "newProductImage": "'.$sSaveImgTo.'"}';
}else{
  echo '{"response":"fail", "message":"Something went wrong!"}';
}

 ?>
