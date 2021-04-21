document.querySelectorAll("a.js-like").forEach(function (link) {
  //On selectionne les liens a avec la classe js-likes
  link.addEventListener("click", onClickBtn); // On lance la fonction onClickBtnLike au click du lien
});

function onClickBtn(event) {
 
  event.preventDefault(); //stop l'execution que fait normalement PHP

  const url = this.href; // le this = au lien du a
console.log(url)
  const spanCount = this.querySelector("em"); 
  //on va chercher la span dans laquelle on affiche la quantité

  axios.get(url).then(function (response) {
    // axios se charge de renvoyer la reponse sur la page de la var url
    // on va chercher la repose que axios renvoi
    spanCount.textContent = response.data.Qt;
    //on remplace le contenu de la span
  });
}
