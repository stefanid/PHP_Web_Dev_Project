<?php
$sjNewUser = '{}';
$jNewUser = json_decode($sjNewUser);

$sFirstName = $_POST['txtFirstName'];
$sLastName = $_POST['txtLastName'];
$sUserName = $_POST['txtUserName'];
$sEmail = $_POST['txtEmail'];
$sPhone = $_POST['txtPhone'];
$sPassword = $_POST['txtPassword'];
$sImage = $_FILES['fProfilePicture']['name'];

$sFolder = 'picturesUser/';
$sSaveImgTo = $sFolder.$sImage;
move_uploaded_file($_FILES['fProfilePicture']['tmp_name'],$sSaveImgTo);

$jNewUser->userID = uniqid();
$jNewUser->firstName = $sFirstName;
$jNewUser->lastName = $sLastName;
$jNewUser->userName = $sUserName;
$jNewUser->password = $sPassword;
$jNewUser->email = $sEmail;
$jNewUser->phone = $sPhone;
$jNewUser->accessRole = 'basicUser';
$jNewUser->userImage = $sSaveImgTo;

$sFile = file_get_contents("data.txt");
$jExistingUsers = json_decode($sFile);

$bCheckExist = False;

for ($i=0; $i < count($jExistingUsers->users) ; $i++) {
  if($jExistingUsers->users[$i]->userName == $jNewUser->userName || $jExistingUsers->users[$i]->email == $jNewUser->email = $sEmail){
    $bCheckExist = True;
  } else {
    $bCheckExist;
  }
}

if($bCheckExist == False){
  array_push($jExistingUsers->users,$jNewUser);
  $sNewUsers =  json_encode($jExistingUsers);
  file_put_contents("data.txt", $sNewUsers);
  echo '{"response": "ok","message": "User successfully created!"}';
  exit;
}else{
  echo '{"response": "fail","message": "User with that username or email already exists!"}';
  exit;
}
?>
