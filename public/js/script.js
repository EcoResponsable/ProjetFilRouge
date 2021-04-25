
const span = document.querySelectorAll("span.panierUpdate") //on prend la span qui regroupe le tout
const pTotal = document.querySelectorAll("strong.prixTotal") 

const moins = [] //pour chaque bouton, on vient enregistrer le contenu du a et du p dans un tableau
 span.forEach(element=>moins.push(element.children.item(0).outerHTML + element.children.item(1).outerHTML))

const plus = []
 span.forEach(element=>plus.push(element.children.item(2).outerHTML + element.children.item(1).outerHTML))


document.querySelectorAll("a.js-like").forEach(function (link) {//On selectionne les liens a avec la classe js-likes
  
  link.addEventListener("click", onClickBtn); // On lance la fonction onClickBtnLike au click du lien
});

function onClickBtn(event) {
  event.preventDefault(); //stop l'execution que fait normalement PHP

 
const url = this.href; // le this = au lien du a

const aLink = this.outerHTML
 
const tabMoins = [].concat(moins.filter(el => el.includes(aLink)))

const tabPlus = [].concat(plus.filter(el => el.includes(aLink)))
const prixTotal = (pTotal.item(0))



if (tabMoins.length != 0){

  const spanCount = this.nextElementSibling;  
  const prix = this.previousSibling.parentElement.children.item(3); 
  

 


axios.get(url).then(function (response) { // axios se charge de renvoyer la reponse sur la page de la var url
 
  
  spanCount.textContent = response.data.Qt;
  //on remplace le contenu de la span 
  prixTotal.textContent = response.data.prixTotal;
  prix.textContent = response.data.prix;

  
});


}else if(tabPlus.length != 0){

 
    const spanCount = this.previousElementSibling;
    const prix = this.nextElementSibling

     axios.get(url).then(function (response) { // axios se charge de renvoyer la reponse sur la page de la var url
    
    spanCount.textContent = response.data.Qt;
    prix.textContent = response.data.prix;
    prixTotal.textContent = response.data.prixTotal
   
    // on remplace le contenu de la span
  });


}

}





















document.querySelectorAll("span.add").forEach(function (link) {
  //On selectionne les liens a avec la classe js-likes
  link.addEventListener("click", onClickBtnAdd); // On lance la fonction onClickBtnLike au click du lien
});

function onClickBtnAdd(event) {
 
  event.preventDefault(); //stop l'execution que fait normalement PHP
  console.log(this.firstElementChild)
  const url2 = this.firstElementChild.href; // le this = au lien du a

  
  const spanCount = this.querySelector("div.validate"); 

  
  //on va chercher la span dans laquelle on affiche la quantité

  axios.get(url2).then(function (response) {
    // axios se charge de renvoyer la reponse sur la page de la var url
    // on va chercher la repose que axios renvoi
    spanCount.textContent = response.data.Qt+" "+response.data.message;
    //on remplace le contenu de la span
  });
}
