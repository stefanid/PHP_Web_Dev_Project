<?php
session_start();
$sFile = file_get_contents("data.txt");
$jExistingUsers = json_decode($sFile);

$sInputUserName = $_POST['txtLoginUserName'];
$sInputPassword = $_POST['txtLoginPassword'];

$bCheckLogin = False;
$sUserId = "";
$sUsername = "";
$sFirstName = "";
$sLastName = "";
$sEmail = "";
$sPhone = "";
$sImage = "";
$sAccessRole = "";

for ($i=0; $i <count($jExistingUsers->users) ; $i++) {
	if(($jExistingUsers->users[$i]->userName == $sInputUserName
		&& $jExistingUsers->users[$i]->password == $sInputPassword) && $jExistingUsers->users[$i]->status == "1"){
			$bCheckLogin = True;
			$sUserId = $jExistingUsers->users[$i]->userID;
			$sUsername = $jExistingUsers->users[$i]->userName;
			$sFirstName = $jExistingUsers->users[$i]->firstName;
			$sLastName = $jExistingUsers->users[$i]->lastName;
			$sEmail = $jExistingUsers->users[$i]->email;
			$sPhone = $jExistingUsers->users[$i]->phone;
			$sAccessRole = $jExistingUsers->users[$i]->accessRole;
			$sImage = $jExistingUsers->users[$i]->userImage;
		}else{
			$bCheckLogin;
		}
}

if($bCheckLogin == True){
	$_SESSION['userID'] = $sUserId;
	$_SESSION['userName'] = $sUsername;
	$_SESSION['firstName'] = $sFirstName;
	$_SESSION['lastName'] = $sLastName;
	$_SESSION['email'] = $sEmail;
	$_SESSION['phone'] = $sPhone;
	$_SESSION['accessRole'] = $sAccessRole;
	$_SESSION['userImage'] = $sImage;

	$sjResponse = '{"response": "ok", "message": "Success", "userID": "'.$sUserId.'","userName": "'.$sUsername.'",
		"firstName": "'.$sFirstName.'", "lastName": "'.$sLastName.'","email": "'.$sEmail.'", "phone": "'.$sPhone.'",
		"accessRole":"'.$sAccessRole.'", "userImage":"'.$sImage.'"}';
	echo $sjResponse;
	exit;
} else{
	$sjResponse = '{"response": "fail", "message": "Incorrect Username or Password"}';
	echo $sjResponse;
	exit;
}

?>
