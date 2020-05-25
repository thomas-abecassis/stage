function requeteAJAX(url,callback) {
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		callback(requete);
	});
	requete.send(null);
}

function inArray(arr){
	let tmp=[];
	for(let i=0;i<arr.length;i++){
		tmp.push(arr[i]);
	}
	return tmp;
}