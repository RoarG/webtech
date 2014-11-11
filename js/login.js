function statusChangeCallback(response) {
	if (response.status === 'connected') {
		FB.api('/me', function(response) {
			//console.log(JSON.stringify(response));
			login(response);
			document.getElementById('name').innerHTML = response.name;
		});
	} else if (response.status === 'not_authorized') {
		document.getElementById('name').innerHTML = 'Ikke logget inn.';
	} else {
		document.getElementById('name').innerHTML = 'Ikke logget inn.';
	}
}

function checkLoginState() {
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
		console.log(JSON.stringify(response));
	});
}

window.fbAsyncInit = function() {
	FB.init({
		appId      : '1537917766421568',
		cookie     : true,
		xfbml      : true,
		version    : 'v2.1'
	});
	
	FB.getLoginStatus(function(response) {
		statusChangeCallback(response);
	});
};

(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "http://connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function login(response) {
	var id = parseInt(response.id);
	var name = response.name;
	var email = response.email;
	var latitude = 63.00;
	var longitude = 63.00;
	var image = "https://graph.facebook.com/" + response.id + "/picture?type=large";
	
	//var message = "Jobbforespørsel sendt! <br> Dato: "+date+"<br> Tid:"+time+"<br> Arbeidstaker:"+worker;
	
	var params = "id="+id+"&name="+name+"&email="+email+"&latitude="+latitude+"&longitude="+longitude+"&image="+image;
			
	xmlhttp = new XMLHttpRequest();
	
	/*xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			openPopupWindow(message, 0);
		}
	}*/

	xmlhttp.open("POST", "./newUser.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);
}