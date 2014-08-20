var state;
var box;

window.onload=function(){
    setInterval(load, 500);
};

function load(){
    xmlhttp=new XMLHttpRequest();
    xmlhttp.open("GET","send.php", true);
    
    xmlhttp.send();
	
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState===4 && xmlhttp.status===200){
            state=JSON.parse(xmlhttp.responseText);
            console.log(state);
            echostuff(state);
        }
    };
}

function echostuff(state){
    box = document.getElementById("messagebox");
    var b = "";
    for(i = 0; i< state.length; i++){
       b = b+ "<a href = 'chat.php?target="+state[i].username+"'>"+state[i].username+"</a><br>";
    box.innerHTML = b;
    box.height = "100px";
    box.width = "100px";
}

}
