window.addEventListener("scroll",function(){

let nav=document.querySelector(".top-header");

if(window.scrollY>50){

nav.style.boxShadow="0 4px 15px rgba(0,0,0,.2)";

}

else{

nav.style.boxShadow="none";

}

});