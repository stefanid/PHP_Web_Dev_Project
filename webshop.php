<?php
	session_start();
	$sShowMyAccount = "";
	$sShowLogin = "";
	if(isset( $_SESSION['userID'])){
		$sShowMyAccount  = "show";
	}else{
		$sShowLogin = "show";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>SIMPLE - LOGIN</title>
	<link rel="stylesheet" href="style-main.css">
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">
</head>
<body>
<!-- Navbar -->
<div class="" id="navbar">
	<button class="btnShowPage" data-showThisPage="pageProducts" id="btnNavProduct">Products</button>
	<button class="btnShowPage" data-showThisPage="pageUsers" id="btnUsers">Users</button>
	<button class="btnShowPage" id="btnNavCreateProducts" data-showThisPage="pageCreateProduct">Create Product</button>
	<button class="btnShowPage" data-showThisPage="pageSignup" id="btnNavSignUp">Sign Up</button>
	<button class="btnShowPage" data-showThisPage="pageLogin" id="btnNavLogIn">Login</button>
	<button class="btnShowPage"  data-showThisPage="pageMyAccount" id="btnNavMyAccount">My Account</button>
	<button class="btnShowPage" id="btnNavLogOut">Log Out</button>
</div>
<!-- Login -->
<div id="pageLogin" class="page cPage <?php echo $sShowLogin; ?> ">
	<div id="boxLogin">
    	<div id="divLogin">
      		<form id="frmLogin">
        		<input type="text" name="txtLoginUserName" placeholder="Username">
        		<input type="password" name="txtLoginPassword" placeholder="Password">
        		<button type="button" name="button" id="btnLogin">Login</button>
      		</form>
					<div id="divError"></div>
    		</div>
  	</div>
</div>
<!-- User Account Page -->
<div id="pageMyAccount" class="page cPage <?php echo $sShowMyAccount; ?>">
	<div id="accountPage">
    <div id="divMyAccountInfo">
      <center>
        <img id="userProfilePicture" class="img-circle"/>
      </center>
			<form id="frmAccount">
				<input type="text" class="enableMyTxt" name="txtMyFirstName" id="txtMyFirstName" placeholder="First Name">
				<input type="text" class="enableMyTxt" name="txtMyLastName" id="txtMyLastName" placeholder="Last Name">
				<input type="text" class="enableMyTxt" name="txtMyUserName" id="txtMyUserName" placeholder="Username">
				<input type="text" class="enableMyTxt" name="txtMyEmail" id="txtMyEmail" placeholder="Email">
				<input type="text" class="enableMyTxt" name="txtMyPhone" id="txtMyPhone" placeholder="Phone">
				<input type="password" class="enableMyTxt" name="txtMyPassword" id="txtMyPassword" placeholder="Current Password">
				<input type="password" class="enableMyTxt" name="txtMyNewPassword" id="txtMyNewPassword" placeholder="New Password">
				<input type="file" name="fMyNewPicture" id="fMyNewPicture">
				<button type="button" name="button" id="btnEditUser">Edit</button>
				<button type="button" name="button" id="btnDelete">Delete</button>
			</form>
			<div id="divErrorAccountPage"></div>
    </div>
  </div>
		<div id="map"></div>
</div>
<!--Sign up page -->
<div class="page" id="pageSignup">
	<div>
		<form id="frmSignUp">
      <input type="text" name="txtFirstName" placeholder="First Name">
      <input type="text" name="txtLastName" placeholder="Last Name">
      <input type="text" name="txtUserName" placeholder="Username">
      <input type="password" name="txtPassword" placeholder="Password">
      <input type="text" name="txtEmail" placeholder="Email">
      <input type="text" name="txtPhone" placeholder="Phone">
			<label for="checkBoxCreateUser">Subscribe for newsletters</label>
      <button id="btnSignUp" type="button">Sign up</button>
    </form>
		<div id="errorDiv">
		</div>
	</div>
</div>
<!-- Create Product -->
<div class="page" id="pageCreateProduct">
	<form id="frmPageAccount">
		<input type="text" name="txtProductName" placeholder="Product Name">
		<input type="text" name="txtProductBrand" placeholder="Brand Name">
		<input type="text" name="txtProductPrice" placeholder="Product Price">
		<input type="number" name="txtProductQuantity" placeholder="Product Quantity">
		<input type="text" name="txtProductModel" id="txtProductModel" placeholder="Product Model">
		<input type="text" name="txtProductColor" id="txtProductColor" placeholder="Product Color">
		<input type="text" name="txtProductProduction" id="txtProductProduction" placeholder="Product Production">
		<input type="file" name="fProductPicture" id="fProductPicture">
		<button type="button" id="btnCreateProduct">Create Product</button>
	</form>
	<div id="errorDivCreateProducts"></div>
</div>
<!-- Product page -->
<div class="page" id="pageProducts">
	<div id="boxProducts">
	</div>
</div>
<!-- Users page -->
<div class="page" id="pageUsers">
	<div id="boxUsers">
	</div>
</div>
<script>
loadUsers();
switchPages();
loadProducts();

//users page
function loadUsers(){
	ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200){
			boxUsers.innerHTML = "";
			var jDataFromServer = JSON.parse(this.responseText);
			var sDiv = "";
			var sImage = "";
			var sReadStatus = "";
			if(jDataFromServer.message != "Unauthorized"){
				for (var i = 0; i < jDataFromServer.length; i++) {
				if(jDataFromServer[i].accessRole != "admin"){
					var sUserID = jDataFromServer[i].userID;
					var sStatus = jDataFromServer[i].status;
					var sFirstName = jDataFromServer[i].firstName;
					var sLastName = jDataFromServer[i].lastName;
					var sUserName = jDataFromServer[i].userName;
					var sEmail = jDataFromServer[i].email;
					var sPhone = jDataFromServer[i].phone;
					var userImage = jDataFromServer[i].userImage;
					if(sStatus == "1"){
						 sReadStatus = "Active";
					}else{
						sReadStatus = "Deactivated";
					}
						if(userImage != ""){
							sImage = "<img id='usersImages' class='img-circle' src='" +userImage+"' />";
						}else{
							sImage = "<img id='usersImages' class='img-circle' src='https://techreport.com/forums/styles/canvas/theme/images/no_avatar.jpg'/>";
						}
						var sStatus = "<p data-userID='" + sUserID + "' class='cUserStatus'>"+ sReadStatus +"</p>"
						sDiv += "<div class='boxUser'>" +sImage + "<p> Name: " +sFirstName + " "+sLastName
						+ "<br /> Status:"+ sStatus + "</p><button id='btnDeactivateUserStatus' class='cChangeUserStatus' data-userID='" +sUserID+"'>Deactivate</button><button id='btnActivateUserStatus' class='cChangeUserStatus' data-userID='" +sUserID+"'>Activate</button></div>";
					}
				}
			}
			boxUsers.insertAdjacentHTML("beforeend", sDiv);
		}
	}
	ajax.open("GET", "api-getusers.php", true );
	ajax.send();
}

//product page
function loadProducts() {
	ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			var jDataFromServer = JSON.parse(this.responseText);
			var sInputName = "";
			var sEditButton = "";
			var sDeleteButton = "";
			var sBuyButton= "";
			var sInputBrand = "";
			var sInputModel = "";
			var sInputColor = "";
			var sInputQuantity = "";
			var sInputPrice = "";
			var sImageShow = "";
			var sDivProduct = "";
			for (var i = 0; i < jDataFromServer.length; i++) {
				var sProductID = jDataFromServer[i].productID;
				var sProductName = jDataFromServer[i].name;
				var sProductBrand = jDataFromServer[i].brand;
				var sProductPrice = jDataFromServer[i].price;
				var sProductQuantity = jDataFromServer[i].quantity;
				var sProductModel = jDataFromServer[i].model;
				var sProductColor = jDataFromServer[i].color;
				var sProductProduction = jDataFromServer[i].production;

				if(jDataFromServer[i].hasOwnProperty("productImage")){
					var sImage = jDataFromServer[i].productImage;
					sImageShow = "<img id='productImages' class='img-circle cImages' src='" +sImage+"' />";
				}

				sInputName = "<input id='txtEditProductName' class='cProductInputs' name='txtEditProductName' value='"+sProductName+"' disabled/>";
				sInputBrand = "<input id='txtEditProductBrand' class='cProductInputs' name='txtEditProductBrand' value='"+sProductBrand+"' disabled/>";
				sInputPrice = "<input id='txtEditProductPrice' class='cProductInputs' name='txtEditProductPrice' value='"+sProductPrice+"' disabled/>";
				sInputModel = "<input id='txtEditProductModel' class='cProductInputs' name='txtEditProductModel' value='"+sProductModel+"' disabled/>";
				sInputColor = "<input id='txtEditProductColor' class='cProductInputs' name='txtEditProductColor' value='"+sProductColor+"' disabled/>";
				sInputImage = "<input type='file' class='cProductImage' id='fEditProductImage' name='fEditProductImage' />";
				sInputQuantity = "<input class='cProductInputs cProductQuantity' name='txtEditProductQuantity' data-id='" + sProductID +"'value='"+sProductQuantity+"' disabled/>";
				sDeleteButton = "<button class='showBtnProducts'id='btnDeleteProduct' data-id='" + sProductID +"'>Delete</button>";
				sEditButton = "<button class='showBtnProducts'id='btnEditProduct' data-id='" + sProductID +"'>Edit</button>";
				sBuyButton = "<button class='showBtnProducts' id='btnBuyProduct' data-id='" + sProductID +"'>Buy</button>";
				sDivProduct += '<div class="boxProduct"><form class="cFrmEdits" data-id="' + sProductID +'" id="frmEdit">' + sImageShow + '<p>'
											  +sInputName + sInputBrand + sInputModel
												+ sInputColor + sInputPrice + sInputQuantity+ sInputImage+'</p></form>'
												+sEditButton+ sDeleteButton +sBuyButton +'</div>';
			}
			boxProducts.insertAdjacentHTML("beforeend", sDivProduct);
		}
	}
	ajax.open("GET", "api-getproducts.php", true);
	ajax.send();
}

//checkIfSessionIsSet
//soltuon needs refactor (Do it later)
function checkSession() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
				var jDataFromServer = JSON.parse(this.responseText);
				if( jDataFromServer.response == "ok" ){
					if(jDataFromServer.accessRole == "basicUser"){
						btnNavMyAccount.style.display = "block";
						btnNavLogOut.style.display = "block";
						btnNavSignUp.style.display = "none";
						btnUsers.style.display = "none";
						btnNavLogIn.style.display = "none";
						var aBtns = document.getElementsByClassName("showBtnProducts");
						for (var i = 0; i < aBtns.length; i++) {
							aBtns[i].style.display = "none";
							if(aBtns[i].id == "btnBuyProduct"){
								aBtns[i].style.display = "block";
							}
						}
						var aImages = document.getElementsByClassName("cProductImage");
						for (var i = 0; i < aImages.length; i++) {
							aImages[i].style.display = "none";
						}
					}else{
						btnNavMyAccount.style.display = "block";
						btnNavLogOut.style.display = "block";
						btnNavCreateProducts.style.display = "block";
						btnUsers.style.display = "block";
						var aBtns = document.getElementsByClassName("showBtnProducts");
						for (var i = 0; i < aBtns.length; i++) {
							aBtns[i].style.display = "block";
							if(aBtns[i].id == "btnBuyProduct"){
								aBtns[i].style.display = "none";
							}
						}
						var aInputs = document.getElementsByClassName("cProductInputs");
						for (var i = 0; i < aInputs.length; i++) {
								aInputs[i].style.border = "thin solid grey";
								aInputs[i].disabled = false;
								aInputs[i].style.backgroundColor = "white";
								aInputs[i].style.color = "black";
						}
						var aImages = document.getElementsByClassName("cProductImage");
						for (var i = 0; i < aImages.length; i++) {
							aImages[i].style.display = "block";
						}
						btnNavSignUp.style.display = "none";
						btnNavLogIn.style.display = "none";
					}
					pageMyAccount.style.display = "flex";
					pageLogin.style.display = "none";
					txtMyFirstName.value = jDataFromServer.firstName;
					txtMyLastName.value = jDataFromServer.lastName;
					txtMyUserName.value = jDataFromServer.userName;
					txtMyEmail.value = jDataFromServer.email;
					txtMyPhone.value = jDataFromServer.phone;
					if(jDataFromServer.userImage != ""){
						var sImage = jDataFromServer.userImage;
						userProfilePicture.src = sImage;
					}else{
						userProfilePicture.src = "https://techreport.com/forums/styles/canvas/theme/images/no_avatar.jpg";
					}
					}else{
						pageMyAccount.style.display = "none";
						btnNavMyAccount.style.display = "none";
						btnNavLogOut.style.display = "none";
						btnUsers.style.display = "none";
						pageLogin.style.display = "flex";
						btnNavSignUp.style.display = "block";
						btnNavLogIn.style.display = "block";
				}
		 }
	}
	ajax.open( "GET", "check-session.php" , true );
	ajax.send();
}
checkSession();
//login
btnLogin.addEventListener( "click" , function(){
	var ajax = new XMLHttpRequest();
	divError.innerHTML = "";
	ajax.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
		  var jDataFromServer = JSON.parse(this.responseText);
			if( jDataFromServer.response == "ok" ){
				if(jDataFromServer.accessRole == "basicUser"){
					btnNavMyAccount.style.display = "block";
					btnNavLogOut.style.display = "block";
					btnUsers.style.display = "none";
					btnNavSignUp.style.display = "none";
					btnNavLogIn.style.display = "none";
					var aBtns = document.getElementsByClassName("showBtnProducts");
					for (var i = 0; i < aBtns.length; i++) {
						aBtns[i].style.display = "none";
						if(aBtns[i].id == "btnBuyProduct"){
							aBtns[i].style.display = "block";
						}
					}
					var aImages = document.getElementsByClassName("cProductImage");
					for (var i = 0; i < aImages.length; i++) {
						aImages[i].style.display = "none";
					}

				}else{
					btnNavMyAccount.style.display = "block";
					btnNavLogOut.style.display = "block";
					btnUsers.style.display = "block";
					btnNavCreateProducts.style.display = "block";
					var aBtns = document.getElementsByClassName("showBtnProducts");
					for (var i = 0; i < aBtns.length; i++) {
						aBtns[i].style.display = "block";
						if(aBtns[i].id == "btnBuyProduct"){
							aBtns[i].style.display = "none";
						}
					}
					var aImages = document.getElementsByClassName("cProductImage");
					for (var i = 0; i < aImages.length; i++) {
						aImages[i].style.display = "block";
					}
					var aInputs = document.getElementsByClassName("cProductInputs");
					for (var i = 0; i < aInputs.length; i++) {
							aInputs[i].style.border = "thin solid grey";
							aInputs[i].disabled = false;
							aInputs[i].style.backgroundColor = "white";
							aInputs[i].style.color = "black";
					}
					btnNavSignUp.style.display = "none";
					btnNavLogIn.style.display = "none";
				}
				pageMyAccount.style.display = "flex";
				pageLogin.style.display = "none";
				txtMyFirstName.value = jDataFromServer.firstName;
				txtMyLastName.value = jDataFromServer.lastName;
				txtMyUserName.value = jDataFromServer.userName;
				txtMyEmail.value = jDataFromServer.email;
				txtMyPhone.value = jDataFromServer.phone;
				if(jDataFromServer.userImage != ""){
					var sImage = jDataFromServer.userImage;
					userProfilePicture.src = sImage;
				}else{
					userProfilePicture.src = "https://techreport.com/forums/styles/canvas/theme/images/no_avatar.jpg";
				}
				}else{
					pageMyAccount.style.display = "none";
					btnNavMyAccount.style.display = "none";
					btnUsers.style.display = "none";
					btnNavLogOut.style.display = "none";
					pageLogin.style.display = "flex";
					btnNavSignUp.style.display = "block";
					btnNavLogIn.style.display = "block";
					var sDiv = "<div><center>" + jDataFromServer.message + "</center></div>";
					divError.insertAdjacentHTML("beforeend", sDiv);
				}
	   	}
	   }
	  ajax.open( "POST", "api-login.php" , true );
		var jFrmLogin = new FormData( frmLogin );
		ajax.send( jFrmLogin );
});

//save the edited information
btnEditUser.addEventListener("click", function() {
	divErrorAccountPage.innerHTML = "";
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200){
			var jDataFromServer = JSON.parse(this.responseText);
			if(jDataFromServer.response == "success"){
				location.reload();
			}else{
				var sDiv = "<div><center><p>"+jDataFromServer.message+"</p></center></div>";
				divErrorAccountPage.insertAdjacentHTML("beforeend",sDiv);
			}
		}
	}
	ajax.open("POST", "api-editaccount.php", true);
	var jFrmEdit = new FormData( frmAccount );
	ajax.send(jFrmEdit);
});

//logOut
btnNavLogOut.addEventListener("click", function() {
	logOut();
});

//signup
btnSignUp.addEventListener("click", function() {
	var ajax = new XMLHttpRequest();
	errorDiv.innerHTML = "";
  ajax.onreadystatechange = function(){
    if (this.readyState == 4 && this.status == 200){
      var jDataFromServer = JSON.parse(this.responseText);
			console.log(this.responseText);
      if(jDataFromServer.response == "ok"){
    	alert(jDataFromServer.message);
      pageSignup.style.display = "none";
      pageLogin.style.display = "none";
     } else{
      var sDiv = "<div><center><p>" + jDataFromServer.message +"</p></center></div>"
      errorDiv.insertAdjacentHTML("beforeend", sDiv);
      }
    }
  }
  ajax.open( "POST", "api-signup.php" , true );
  var jSignUp = new FormData(frmSignUp);
  ajax.send(jSignUp);
});

//delete
btnDelete.addEventListener("click", function() {
	ajax = new XMLHttpRequest();
	divErrorAccountPage.innerHTML = "";
	ajax.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var jDataFromServer = JSON.parse(this.responseText);
		if(jDataFromServer.response == "ok"){
			alert(jDataFromServer.message);
			logOut();
		} else{
			var sDiv = "<div><center><p>" + jDataFromServer.message +"</p></center></div>";
			divErrorAccountPage.insertAdjacentHTML("beforeend",sDiv );
			}
		}
	}
	ajax.open("GET", "api-deleteaccount.php", true);
	ajax.send();
});

//createProduct
btnCreateProduct.addEventListener("click", function() {
	var ajax = new XMLHttpRequest();
	errorDivCreateProducts.innerHTML = "";
	ajax.onreadystatechange = function(){
	if(this.readyState == 4 && this.status == 200){
		var jDataFromServer = JSON.parse(this.responseText);
		if(jDataFromServer.response == "ok"){
			alert(jDataFromServer.message);
		}else{
			var sDiv = "<div><center><p>" + jDataFromServer.message +"</p></center></div>"
			errorDivCreateProducts.insertAdjacentHTML("beforeend", sDiv);
		}
		}
	}
	ajax.open("POST", "api-createproduct.php", true);
	var jFrmCreateProduct = new FormData(frmPageAccount);
	ajax.send(jFrmCreateProduct);
});

//navbar switch
function switchPages() {
	var aBtnShowPages = document.getElementsByClassName("btnShowPage");
	for(var i = 0; i < aBtnShowPages.length; i++)
	{
			aBtnShowPages[i].addEventListener("click",function(){
					var aPages = document.getElementsByClassName( "page" );
					for(var j = 0; j < aPages.length; j++)
					{
							aPages[j].style.display = "none";
					}
					var sDataAttibute = this.getAttribute("data-showThisPage");
					document.getElementById(sDataAttibute).style.display = "flex";
			});
	}
}

//change status
document.addEventListener("click", function(e){
 if( e.target.classList.contains("cChangeUserStatus")){
	var ajax = new XMLHttpRequest();
	var sUserID = e.target.getAttribute("data-userID");
	var sGetBtnIds = e.target.id;
	ajax.onreadystatechange = function() {
		if(this.readyState == 4 && this.status == 200){
				var jDataFromServer = JSON.parse(this.responseText);
				var aStatus = document.getElementsByClassName("cUserStatus");
				for (var i = 0; i < aStatus.length; i++) {
					var sStatUserID = aStatus[i].getAttribute("data-userID");
					if(sStatUserID == sUserID){
						aStatus[i].innerHTML = jDataFromServer.status;
					}
				}
			}
		}
	 ajax.open("GET", "api-changeuserstatus.php?userID=" + sUserID + "&btnID=" + sGetBtnIds, true);
	 ajax.send();
	}
});

//btnProduct CRUDS
document.addEventListener("click",function(e){
	var sProductID = e.target.getAttribute("data-id");
	var ajax = new XMLHttpRequest();
		if(e.target.id == "btnBuyProduct"){
			ajax.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200){
					var jDataFromServer = JSON.parse(this.responseText);
					if(jDataFromServer.response == "ok"){
						var aInputs = document.getElementsByClassName("cProductQuantity");
						for (var i = 0; i < aInputs.length; i++) {
							var iInputsID = aInputs[i].getAttribute("data-id");
							if(iInputsID == sProductID ){
								var oSound = new Audio('sounds/buysound.mp3');
								oSound.play();
								if (!("Notification" in window)) {
									alert("This browser does not support system notifications");
								}
								else if (Notification.permission === "granted") {
									var notification = new Notification(jDataFromServer.message,{
										icon: "https://cdn3.iconfinder.com/data/icons/rcons-finance/32/money_bag-512.png"
									});
								}
								else if (Notification.permission !== 'denied') {
									Notification.requestPermission(function (permission) {
									if (permission === "granted") {
										var notification = new Notification(jDataFromServer.message,{
											icon: "https://cdn3.iconfinder.com/data/icons/rcons-finance/32/money_bag-512.png"
										});
									}
								});
							}
								aInputs[i].value = jDataFromServer.quantity.toString();
							}
						}
					}
				}
			}
			ajax.open("GET", "api-buyproduct.php?productID=" + sProductID, true);
			ajax.send();
		}
		if(e.target.id == "btnEditProduct"){
			ajax.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200){
					var jDataFromServer = JSON.parse(this.responseText);
					if(jDataFromServer.response == "success"){
						var aFrms = document.getElementsByClassName("cFrmEdits");
						for (var i = 0; i < aFrms.length; i++) {
						var iFrmsID = aFrms[i].getAttribute("data-id");
						if(iFrmsID == sProductID ){
							// var sFrmProductName = aFrms[i].elements['imageProduct'];
							if(jDataFromServer.newProductImage != ""){
								aFrms[i].productImages.src = jDataFromServer.newProductImage;
								}
							}
						}
					}
				}
			}
			ajax.open("POST", "api-editproduct.php?productID=" +sProductID , true);
			var aFrms = document.getElementsByClassName('cFrmEdits');
			for (var i = 0; i < aFrms.length; i++) {
				var frmID = aFrms[i].getAttribute("data-id");
				if(sProductID == frmID){
				var jFrmData = new FormData(aFrms[i]);
				ajax.send(jFrmData);
				}
			}
		}
		if(e.target.id == "btnDeleteProduct"){
			ajax.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200){
					var jDataFromServer = JSON.parse(this.responseText);
					e.target.parentNode.remove();
				}
			}
			ajax.open("GET", "api-deleteproduct.php?productID=" + sProductID , true);
			ajax.send();
		}
});

//logOut
function logOut() {
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			pageMyAccount.style.display = "none";
			btnNavMyAccount.style.display = "none";
			btnNavLogOut.style.display = "none";
			btnUsers.style.display = "none";
			var aBtns = document.getElementsByClassName("showBtnProducts");
			for (var i = 0; i < aBtns.length; i++) {
				aBtns[i].style.display = "none";
			}
			var aImages = document.getElementsByClassName("cProductImage");
			for (var i = 0; i < aImages.length; i++) {
				aImages[i].style.display = "none";
			}
			var aInputs = document.getElementsByClassName("cProductInputs");
			for (var i = 0; i < aInputs.length; i++) {
					aInputs[i].style.border = "none";
					aInputs[i].disabled = true;
					aInputs[i].style.backgroundColor = "rgba(1,1,1,0)";
					aInputs[i].style.color = "white";
			}
			btnNavCreateProducts.style.display = "none";
			pageLogin.style.display = "flex";
			btnNavSignUp.style.display = "block";
			btnNavLogIn.style.display = "block";
		}
	}
	ajax.open( "GET", "api-logout.php" , true );
	ajax.send();
}

function initMap() {
	var uluru = {lat: -25.363, lng: 131.044};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 4,
		center: uluru
	});
	var marker = new google.maps.Marker({
		position: uluru,
		map: map
	});
}
</script>
<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIv1OlB_-SncdGfzhXYWlgvomYyx4JNjk&callback=initMap">
	</script>
</body>
</html>
''
