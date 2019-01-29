<?php
session_start();
if(isset($_SESSION['userID'])){
  //ensure authorization level
  $userRole = $_SESSION['accessRole'];
  if($userRole == "admin"){
    $sFile = file_get_contents("data.txt");
    $jData = json_decode($sFile);

    $asUsers = json_encode($jData->users);
    echo $asUsers;
  } else{
    echo '{"response":"fail", "message":"Unauthorized!"}';
  }
} else{
    echo '{"response":"fail", "message":"Unauthorized!"}';
}


 ?>
