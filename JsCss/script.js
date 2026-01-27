////[SLIDER]
//KRIJIMI I ARRAY (ELEMENTET)
const slides = 
[
  { video: "../images/spring.mp4"  , season: "SPRING"},
  { video: "../images/summer.mp4" , season: "SUMMER"},
  { video: "../images/autumn.mp4" , season: "AUTUMN"},
  { video: "../images/winter.mp4", season: "WINTER"},
];

//KRIJIMI I VARIABLAVE PER QASJE TE ELEMENTEVE
const video = document.getElementById("video");
const video2 = document.getElementById("video2");
const season = document.getElementById("season");

//INDEX PER PERDITESIM, ACTIVE PER VIDEON MOMENTALE
let index = 0;
let active = 1; 

//DEKLARIMI I FUNKSIONIT
function changeSlide() {

//MERR VLERAT SIPAS INDEX TE ARRAY
  const nextSlide = slides[index];

//ZGJEDH VIDEON MOMENTALE DHE TE ARDHSHME PER TE SHMANGUR VONESAT
  const currentVideo = active === 1 ? video : video2;
  const nextVideo = active === 1 ? video2 : video;

//LARGIMI I VIDEOS PARAPRAKE DHE TEKSTIT
  currentVideo.style.opacity = 0;
  season.style.opacity = 0;
  

  //TIMEOUT I VENDOSUR PER SHFAQJE TE ELEMENTEVE TE RRADHES
  setTimeout(() => {
    
    //NGARKIMI I VIDEOS SE RRADHES
    nextVideo.src = nextSlide.video;
    nextVideo.load();

    //FUNKSION QE TREGON SE VIDEO E RRADHES ESHTE E GATSHME
    nextVideo.oncanplaythrough = () => {


    //SHFAQJA E VIDEOS SE RRADHES
      nextVideo.play();
      nextVideo.style.opacity = 1;

    //SHFAQJA E TEKSTIT TE RRADHES
      season.innerText = nextSlide.season;
      requestAnimationFrame(() => {
        season.style.opacity = 1;
      });

      //PERDITESIMI I "ACTIVE" DHE "INDEX" DUKE KONTROLLUAR KUSHTET
      active = active === 1 ? 2 : 1;
      index = (index + 1) % slides.length;

      nextVideo.oncanplaythrough = null;
    };
  }, 300); //300 MS KOHA E SHFAQJES SE ELEMENTEVE
}

//THIRRJA E PARE E SLIDER
changeSlide();

//AUTOMATIZIMI, CDO 6000MS THIRR FUNKSIONIN
setInterval(changeSlide, 6000);
//[END OF SLIDER]




//BURGER MENU FOR PHONE 
const hamburger = document.getElementById("hamburger");
  const nav = document.getElementById("nav");

  hamburger.addEventListener("click", () => {
    nav.classList.toggle("open");
  });
//[END OF BURGER MENU]