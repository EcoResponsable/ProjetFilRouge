
const span = document.querySelectorAll("span.panierUpdate")
console.log(span)
const moins = []
 span.forEach(element=>moins.push(element.children.item(0).outerHTML + element.children.item(1).outerHTML))

const plus = []
 span.forEach(element=>plus.push(element.children.item(2).outerHTML + element.children.item(1).outerHTML))


document.querySelectorAll("a.js-like").forEach(function (link) {
  //On selectionne les liens a avec la classe js-likes
  link.addEventListener("click", onClickBtn); // On lance la fonction onClickBtnLike au click du lien
});

function onClickBtn(event) {
  event.preventDefault(); //stop l'execution que fait normalement PHP

 
  const url = this.href; // le this = au lien du a

 

const aLink = this.outerHTML
 
const tabMoins = [].concat(moins.filter(el => el.includes(aLink)))

const tabPlus = [].concat(plus.filter(el => el.includes(aLink)))


if (tabMoins.length != 0){


console.log(this.nextElementSibling)
  const spanCount = this.nextElementSibling;  


axios.get(url).then(function (response) {
  // axios se charge de renvoyer la reponse sur la page de la var url
  // on va chercher la repose que axios renvoi
  spanCount.textContent = response.data.Qt;
  //on remplace le contenu de la span

  
});


}else if(tabPlus.length != 0){

  console.log(this)
    const spanCount = this.previousElementSibling;  

  
  axios.get(url).then(function (response) {
    // axios se charge de renvoyer la reponse sur la page de la var url
    // on va chercher la repose que axios renvoi
    spanCount.textContent = response.data.Qt;
    //on remplace le contenu de la span
  });


}




  // La on va devoir regarder si le aLink est present dans le tableau Moins ou +, et si oui extraire le p dans une variable pour en faire un text content 

 

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
