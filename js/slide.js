toggle = document.getElementById('toggle'),
nav = document.getElementById('nav');

toggle.onclick = function () {
	if (toggle.checked == true) {
		nav.style.height 	= '200px';
		nav.style.maxHeight = '200px';
		//nav.style.opacity   = '1';
	} else {
		nav.style.height 	= '35px';
		setTimeout(function() {
			nav.style.maxHeight = '35px';
			//nav.style.opacity   = '0';
		}, 800);
	}
};

function openCategoryPage(category){
	sessionStorage.category = category;
	window.location.href = "./job.html#nav";
}