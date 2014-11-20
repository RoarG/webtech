window.onload = function () {
	getTopUsers();
}

function getTopUsers(){
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var x = xmlhttp.responseText;
			/*Parser string til DOM-objekt*/
			var parser = new DOMParser();
			var xmlDoc = parser.parseFromString(x,"text/xml");
			setTopList(xmlDoc);
		}
	}
	xmlhttp.open("GET", "./getTopList.php", true);
	xmlhttp.send();
}

function openProfile(id){
	window.location.href = "./info.php?id="+id;
	
	/*var params = "id="+id;
	console.log(params);
	xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			window.location.href = "./info.php?id="+id;
		}
	}
	
	xmlhttp.open("POST", "./info.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(params);*/
}

function setTopList(xmlDoc){
	var parentNode = document.getElementById('topliste');
	var persons = xmlDoc.getElementsByTagName('person');
	if(persons.length < 1){
		return;
	}
	
	for (var i=0; i<persons.length; i++){
		var personDiv = document.createElement('div');
		personDiv.className = 'topUser';
		personDiv.id = persons[i].childNodes[1].childNodes[0].nodeValue;
	
		var imageDiv = document.createElement('div');
		
		var image = document.createElement('img');
		image.className = "topUserImage";
		//Sjekker om personen har bilde. Mest for testing.
		if(persons[i].childNodes[3].childNodes[0]){
			image.setAttribute('src', persons[i].childNodes[3].childNodes[0].nodeValue);
		}
		else{
			image.setAttribute('src', './images/defaultUser.png');
		}
		imageDiv.appendChild(image);
		
		var nameDiv = document.createElement('div');
		nameDiv.className = "topUserName";
		nameDiv.innerHTML = persons[i].childNodes[5].childNodes[0].nodeValue;
		
		var ratingDiv = document.createElement('div');
		ratingDiv.className = "topUserRating";
		
		var r5 = document.createElement('div');r5.className = "starRating";
		var r4 = document.createElement('div');r4.className = "starRating";
		var r3 = document.createElement('div');r3.className = "starRating";
		var r2 = document.createElement('div');r2.className = "starRating";
		var r1 = document.createElement('div');r1.className = "starRating";
		
		var i1 = document.createElement('input');
		i1.setAttribute('type', 'radio');i1.setAttribute('value', '1');
		i1.setAttribute('width', '24px');
		var i2 = document.createElement('input');
		i2.setAttribute('type', 'radio');i2.setAttribute('value', '2');
		i2.setAttribute('width', '24px');
		var i3 = document.createElement('input');
		i3.setAttribute('type', 'radio');i3.setAttribute('value', '3');
		i3.setAttribute('width', '24px');
		var i4 = document.createElement('input');
		i4.setAttribute('type', 'radio');i4.setAttribute('value', '4');
		i4.setAttribute('width', '24px');
		var i5 = document.createElement('input');
		i5.setAttribute('type', 'radio');i5.setAttribute('value', '5');
		i5.setAttribute('width', '24px');
		
		var l1 = document.createElement('label');;
		var l2 = document.createElement('label');		
		var l3 = document.createElement('label');
		var l4 = document.createElement('label');		
		var l5 = document.createElement('label');
		var labels = [l1,l2,l3,l4,l5];
		
		r1.appendChild(i1);r1.appendChild(l1);
		r2.appendChild(r1);r2.appendChild(i2);r2.appendChild(l2);
		r3.appendChild(r2);r3.appendChild(i3);r3.appendChild(l3);
		r4.appendChild(r3);r4.appendChild(i4);r4.appendChild(l4);
		r5.appendChild(r4);r5.appendChild(i5);r5.appendChild(l5);
		
		var rating = parseFloat(persons[i].childNodes[7].childNodes[0].nodeValue);
		//Første ikke-hele stjerne
		var labelNum = Math.floor(parseFloat(persons[i].childNodes[7].childNodes[0].nodeValue));
		var rest = rating-labelNum;
		var nextStar = labelNum*24;
		var sliceOfLastStar = nextStar+Math.ceil((rest*24));
		
		//Fyller ut stjernene.
		if(labelNum > 4){
			labels[4].style.background = "url('stars.png') -"+nextStar+"px -24px";
			labels[4].position = "absolute";
		}
		else{
			labels[labelNum].style.background = "url('stars.png') -"+nextStar+"px -24px";
			labels[labelNum].position = "absolute";
			//Clip tar et utklipp i form av et rektangel(top, right, bottom, left) av den siste stjernen
			//tilsvarende hvor mye den skal utfylles. SliceOfLastStar forteller hvor langt til høyre utklippet skal gå, dvs hvor mye stjernen skal fylles opp.
			labels[labelNum].style.clip = "rect(0, "+sliceOfLastStar+"px, 24px, 0)";
		}

		ratingDiv.appendChild(r5);
		
		var numJobsDiv = document.createElement('div');
		numJobsDiv.className = "topUserJobs";
		numJobsDiv.innerHTML = "Antall jobber:"+persons[i].childNodes[9].childNodes[0].nodeValue;
	
		personDiv.appendChild(imageDiv);
		personDiv.appendChild(nameDiv);
		personDiv.appendChild(ratingDiv);
		personDiv.appendChild(numJobsDiv);
		
		personDiv.onclick = function(){
			openProfile(this.id);
		}
		
		parentNode.appendChild(personDiv);
	}

}