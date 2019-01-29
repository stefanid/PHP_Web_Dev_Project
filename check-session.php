<?php
session_start();
if(isset($_SESSION['userID'])){
$userID = $_SESSION['userID'];
$sUsername = $_SESSION['userName'];
$sFirstName = $_SESSION['firstName'];
$sLastName = $_SESSION['lastName'];
$sEmail = $_SESSION['email'];
$sPhone = $_SESSION['phone'];
$sAccessRole = $_SESSION['accessRole'];
$sImage = $_SESSION['userImage'];

$sjResponse = '{"response": "ok", "message": "Success", "userID": "'.$userID.'","userName": "'.$sUsername.'",
	"firstName": "'.$sFirstName.'", "lastName": "'.$sLastName.'","email": "'.$sEmail.'", "phone": "'.$sPhone.'",
	"accessRole":"'.$sAccessRole.'", "userImage":"'.$sImage.'"}';
echo $sjResponse;
exit;
}else{
  echo '{"response":"fail","message": "session not set"}';
	exit;
}
?>
