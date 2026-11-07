(function(){
  var html=document.documentElement;
  var titles={lt:"VIKOPS – Kalkakmenio grindų plytelės su fosilijomis | Vilnius",en:"VIKOPS – Limestone floor tiles with fossils | Vilnius"};
  function setLang(l){html.setAttribute("lang",l);document.title=titles[l];try{localStorage.setItem("vikops-lang",l);}catch(e){}}
  var p=new URLSearchParams(location.search).get("lang");
  var saved=null;try{saved=localStorage.getItem("vikops-lang");}catch(e){}
  var l=p||saved||"lt";
  setLang(l==="en"?"en":"lt");
  document.getElementById("langBtn").addEventListener("click",function(){setLang(html.getAttribute("lang")==="lt"?"en":"lt");});

  /* pets */
  var btns=document.querySelectorAll(".pet-btn"),pets=document.querySelectorAll(".pet");
  btns.forEach(function(b){b.addEventListener("click",function(){
    btns.forEach(function(x){x.classList.remove("active");x.setAttribute("aria-selected","false");});
    pets.forEach(function(x){x.classList.remove("active");});
    b.classList.add("active");b.setAttribute("aria-selected","true");
    document.querySelector(".pet."+b.dataset.pet).classList.add("active");
  });});

  document.getElementById("year").textContent=new Date().getFullYear();

  var reduce=window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  /* reveal on scroll */
  var items=document.querySelectorAll(".reveal");
  if(reduce||!("IntersectionObserver" in window)){items.forEach(function(e){e.classList.add("in");});}
  else{
    var io=new IntersectionObserver(function(entries){entries.forEach(function(en){if(en.isIntersecting){en.target.classList.add("in");io.unobserve(en.target);}});},{rootMargin:"0px 0px -8% 0px",threshold:.08});
    items.forEach(function(e){io.observe(e);});
  }

  /* subtle hero parallax (decorative layer only) */
  var hm=document.getElementById("heroMedia");
  if(hm&&!reduce){
    var ticking=false;
    window.addEventListener("scroll",function(){
      if(ticking)return;ticking=true;
      requestAnimationFrame(function(){
        var y=window.scrollY;
        if(y<window.innerHeight*1.2){hm.style.transform="translateY("+(y*0.12)+"px)";}
        ticking=false;
      });
    },{passive:true});
  }
})();
