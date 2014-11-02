function statusChangeCallback(response) {
	if (response.status === 'connected') {
		FB.api('/me', function(response) {
			console.log(JSON.stringify(response));
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