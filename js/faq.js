window.onload = function (){
	xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange=function() {
		if (xhttp.readyState==4 && xhttp.status==200) {
			xmlDOC=xhttp.responseXML;
			placeFAQ(xmlDOC);
		}
	}
	xhttp.open('GET', './faq.xml',false);
	xhttp.send();
	
}

function placeFAQ(xmlDOC){
	parentDiv = document.getElementById('faqs');
	faqs = xmlDOC.getElementsByTagName('QA');
	
	for(var i=0; i<faqs.length; i++){
		var question = faqs[i].childNodes[1].childNodes[0].nodeValue;
		var answer = faqs[i].childNodes[3].childNodes[0].nodeValue;
		
		var questionDiv = document.createElement('div');
		questionDiv.className = "question";
		questionDiv.innerHTML = question;
		
		var answerDiv = document.createElement('div');
		answerDiv.className = "answer";
		answerDiv.innerHTML = answer;
		
		parentDiv.appendChild(questionDiv);
		parentDiv.appendChild(answerDiv);
	}
}