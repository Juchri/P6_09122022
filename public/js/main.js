console.log('js chargé');

const images = document.querySelectorAll(".lazy")
let options = {
// root: null,
rootMargin: "-10% 0px",
threshold: 0.4
}

function handleIntersect(entries){
    console.log(entries);
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.style.opacity = 1;
        }
    })
}

const observer = new IntersectionObserver (handleIntersect, options)
images.forEach(image => {
    observer.observe(image)
})


function afficher(){
    let selecteur = document.querySelector('.visible-off');
    let info = selecteur.style.display;
    if(info == 'none'){
        selecteur.style.display = 'block';
    }else{
        selecteur.style.display = 'none';
    }
}