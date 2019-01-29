<?php
session_start();
if(isset($_SESSION['userID'])){
  $accessRole = $_SESSION['accessRole'];
  $userID = $_GET['userID'];
  $btnID = $_GET['btnID'];

if($accessRole == "admin"){
  $sFile = file_get_contents("data.txt");
  $jData = json_decode($sFile);

  for ($i=0; $i < count($jData->users) ; $i++) {
      if($jData->users[$i]->userID == $userID){
        if($btnID == "btnDeactivateUserStatus"){
          $jData->users[$i]->status = "0";
          $sjResponse = '{"response":"ok", "status":"Deactivated"}';
      }else{
        $jData->users[$i]->status = "1";
       $sjResponse = '{"response":"ok", "status":"Activated"}';
      }
    }
  }
  $sUpdatedData = json_encode($jData);
  file_put_contents("data.txt", $sUpdatedData);
  echo $sjResponse;
 }
}

?>
