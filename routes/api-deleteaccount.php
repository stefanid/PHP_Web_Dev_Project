<?php
session_start();
if(isset($_SESSION['userID'])){
  $userID = $_SESSION['userID'];
  $sFile = file_get_contents('data.txt');
  $jFindUser = json_decode($sFile);
  $bCorrectUser = False;

  for ($i=0; $i <count($jFindUser->users); $i++) {
    if($jFindUser->users[$i]->userID ==$userID ){
      unset($jFindUser->users[$i]);
      $bCorrectUser = True;
    } else{
      $bCorrectUser;
    }
  }
  if($bCorrectUser == True){
    $jFindUser->users = array_values($jFindUser->users);
    $sUpdatedArray = json_encode($jFindUser);
    file_put_contents("data.txt",$sUpdatedArray);
    echo '{"response": "ok", "message":"Account successfully removed"}';
  }else{
    echo '{"response": "fail", "message":"Unable to remove account"}';
  }
}



 ?>
