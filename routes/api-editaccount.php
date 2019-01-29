<?php
session_start();
if(isset($_SESSION['userID'])){
$userID = $_SESSION['userID'];
$sFile = file_get_contents('data.txt');
$jConfirmUser = json_decode($sFile);
$bCorrectUser = False;

$sNewFirstName = $_POST['txtMyFirstName'];
$sNewLastName = $_POST['txtMyLastName'];
$sNewUserName = $_POST['txtMyUserName'];
$sNewEmail = $_POST['txtMyEmail'];
$sNewPhone = $_POST['txtMyPhone'];
$sPassword = $_POST['txtMyPassword'];
$sNewPassword = $_POST['txtMyNewPassword'];
$sNewUserImage = $_FILES['fMyNewPicture']['name'];


for ($i=0; $i < count($jConfirmUser->users) ; $i++) {
      if($jConfirmUser->users[$i]->userID ==$userID
      && $jConfirmUser->users[$i]->password == $sPassword){
        $jConfirmUser->users[$i]->firstName = $sNewFirstName;
        $jConfirmUser->users[$i]->lastName = $sNewLastName;
        $jConfirmUser->users[$i]->userName = $sNewUserName;
        $jConfirmUser->users[$i]->email = $sNewEmail;
        $jConfirmUser->users[$i]->phone = $sNewPhone;
        $jConfirmUser->users[$i]->password = $sNewPassword;
          if($sNewUserImage != ""){
            $sFolder = 'picturesUser/';
            $sSaveImgTo = $sFolder.$sNewUserImage;
            move_uploaded_file($_FILES['fMyNewPicture']['tmp_name'],$sSaveImgTo);
            $jConfirmUser->users[$i]->userImage = $sSaveImgTo;
          }
        $bCorrectUser = True;
      } else{
        $bCorrectUser;
      }
  }
  if($bCorrectUser == True){
    $sUpdatedUser = json_encode($jConfirmUser);
    file_put_contents("data.txt",$sUpdatedUser);
    $_SESSION['userName'] = $sNewUserName;
    $_SESSION['firstName'] = $sNewFirstName;
    $_SESSION['lastName'] = $sNewLastName;
    $_SESSION['email'] = $sNewEmail;
    $_SESSION['phone'] = $sNewPhone;
    $_SESSION['userImage' ] = $sSaveImgTo;
    echo '{"response":"success","message": "User successfully edited!"}';

  }else{
     echo '{"response":"fail","message": "Password is incorrect!"}';
  }
}
?>
