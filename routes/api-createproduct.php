<?php
session_start();
//ensure authorization
if(isset($_SESSION['userID'])){
  $accessRole = $_SESSION['accessRole'];
  $sFile = file_get_contents("data.txt");
  $jData = json_decode($sFile);
  $bCheckAuthorization = False;

  if($accessRole == "admin"){
    $bCheckAuthorization = True;
  } else{
    $bCheckAuthorization;
  }

  if($bCheckAuthorization == True){
    $sjNewProduct = '{}';
    $jNewProduct = json_decode($sjNewProduct);
    $sName = $_POST['txtProductName'];
    $sBrand = $_POST['txtProductBrand'];
    $sPrice = $_POST['txtProductPrice'];
    $sQuantity = $_POST['txtProductQuantity'];
    $sModel = $_POST['txtProductModel'];
    $sColor = $_POST['txtProductColor'];
    $sProduction = $_POST['txtProductProduction'];
    $sProductImage = $_FILES['fProductPicture']['name'];

    $sFolder = 'pictures/';
    $sSaveImgTo = $sFolder.$sProductImage;
    move_uploaded_file($_FILES['fProductPicture']['tmp_name'],$sSaveImgTo);

    $jNewProduct->productID = uniqid();
    $jNewProduct->name = $sName;
    $jNewProduct->brand = $sBrand;
    $jNewProduct->price = $sPrice;
    $jNewProduct->quantity = $sQuantity;
    $jNewProduct->model = $sModel;
    $jNewProduct->color = $sColor;
    $jNewProduct->production = $sProduction;
    $jNewProduct->productImage = $sSaveImgTo;

      array_push($jData->products,$jNewProduct);
      $sNewProduct =  json_encode($jData);
      file_put_contents("data.txt", $sNewProduct);
      echo '{"response": "ok","message": "Product successfully created!"}';
      exit;
    }else{
      echo '{"response": "fail","message": "Unable to create product!"}';
      exit;
    }
}
else{
  echo '{"response": "401 Unauthorized", "message": "Insufficient permissions!"}';
}




 ?>
