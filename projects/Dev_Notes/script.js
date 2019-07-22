console.log("I'm here...");
document.querySelector('body > header > div > a.logIn').onclick = function(){
	this.className += " dn";
	document.querySelector('body > header > div > div').className = "signed";
	return false
}
document.querySelector("body > div > main > div.Note > div.noteContent > a.addToFavorite").onclick = function(){
	if(this.style.backgroundPositionY == '0%' || this.style.backgroundPositionY == ''){
		this.style.backgroundPositionY="bottom";
	}else{
		this.style.backgroundPositionY="top";
	}
	return false
}