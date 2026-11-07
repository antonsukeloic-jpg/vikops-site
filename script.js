(function(){
  var html=document.documentElement;
  var titles={lt:"VIKOPS – Kalkakmenio grindų plytelės su fosilijomis | Vilnius",en:"VIKOPS – Limestone floor tiles with fossils | Vilnius"};
  function setLang(l){
    html.setAttribute("lang",l);
    document.title=titles[l];
    try{localStorage.setItem("vikops-lang",l);}catch(e){}
  }
  var p=new URLSearchParams(location.search).get("lang");
  var saved=null;try{saved=localStorage.getItem("vikops-lang");}catch(e){}
  var l=p||saved||((navigator.language||"").toLowerCase().indexOf("lt")===0?"lt":null)||"lt";
  setLang(l==="en"?"en":"lt");
  document.getElementById("langBtn").addEventListener("click",function(){
    setLang(html.getAttribute("lang")==="lt"?"en":"lt");
  });
  document.querySelectorAll(".pet-btn").forEach(function(b){
    b.addEventListener("click",function(){
      document.querySelectorAll(".pet-btn").forEach(function(x){x.classList.remove("active");});
      document.querySelectorAll(".pet").forEach(function(x){x.classList.remove("active");});
      b.classList.add("active");
      document.querySelector(".pet."+b.dataset.pet).classList.add("active");
    });
  });
  document.getElementById("year").textContent=new Date().getFullYear();
})();
