console.log('js chargé');

const images = document.querySelectorAll(".images-container img")

let options = {
  // root: null,
  rootMargin: "-10% 0px",
  threshold: 0
}

function handleIntersect(entries){
    console.log(entries);

    entries.forEach(entry => {
        if(entry.isIntersecting){
          entry.target.style.opacity = 1;
        }
      })
}

const observer = new IntersectionObserver(handleIntersect, options)

images.forEach(image => {
  observer.observe(image)
})


$(document).ready(function(){

  // clic sur les boutons
  $('.btn').on('click',function(event){
    event.stopPropagation(); // important
    var id = $(this).data('id');  // on récupère le data-id
    $(".box:not(#box-"+id+")").show(); // on ferme les box, sauf celle concernée
    $("#box-"+id).slideToggle(); // on ouvre ou ferme celle concernée
  });
  // clic en dehors des div
  $(window).on('click', function(){
    $(".box").slideUp(); // on ferme
  });

 });



