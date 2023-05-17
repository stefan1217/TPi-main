/**
 * Description : Script principale du jeu
 */
import { sendDataToPhp } from "./sendDataToPhp.js";
import { addBadFood } from "./addBadFood.js";
import { updateUsers } from "./updateUsers.js";

// Déclarations des variables
let nbFood = 1;
let speed = 1;
let score = 0;
let foods = [];
let slice_count = 0;
let isMultiplayer = false;
// Récuperation d'aliments
let foodList = JSON.parse(localStorage.getItem("Foods"));
// Ajout des aliments malsains dans la liste
addBadFood(foodList);
// Récupération des éléments HTML
let speedElement = document.getElementById("speed");
let gameOverMenu = document.getElementById("game-over-menu");
let gameOverMenuButton = document.getElementById("game-over-menu-button");
let informations = document.getElementById("informations");
let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');
// Définition de la taille du canvas
canvas.width = window.innerWidth * 0.95;
canvas.height = window.innerHeight * 0.75;
let FoodWidth = canvas.width / 25;
let FoodHeight = canvas.width / 20;
let url = new URL(window.location.href);
// Récupérations des variables de l'URL
let URLcategory = url.searchParams.get("category");
let idUser = url.searchParams.get("idUser");
speedElement.innerText = "Vitesse: *" + Math.round(speed * 10) / 10;

canvas.addEventListener('click', handleClickEvent, false);
window.addEventListener('resize', resizeCanvas, false);

let drawInterval = setInterval(draw, 10); // Boucle principale
let UpdateInformaions = setInterval(updateUsers, 100);
updateUsers();

/**
 * fonction qui permet de récuperer un aliment aléatoire de la liste
 * @param {Array} list  la liste des aliments
 * @returns 
 */
function randomFoodFromList(list) {
  // On filtre les aliments de la catégorie
  let foodCategorieList = list.filter(item => item.category === URLcategory);
  if (foodCategorieList.length > 0 && Math.random() < 0.75) {
    // 75% de chance de tomber sur les aliments de la catégorie choisie 
    return foodCategorieList[Math.floor(Math.random() * foodCategorieList.length)];
  } else {
    return list[Math.floor(Math.random() * list.length)];
  }
}
/** 
 * fonction qui permet de crée un nouveau aliment
 * @returns food
 */
function createFood() {
  let randomFood = randomFoodFromList(foodList);
  let food = {
    x: Math.random() * Math.floor(Math.random() * (canvas.width - (FoodHeight) - FoodWidth)) + FoodWidth, // position x aléatoire
    y: -FoodHeight,
    width: FoodWidth,
    height: FoodHeight,
    src: "../sprites/" + randomFood.picture_path, // chemin de l'image récuperer de la fonction randomFood()
    speed: speed,
    name: randomFood.name, // le nom de l'aliment récuperer de random de la fonction randomFood()
    category: randomFood.category, // la catégorie récuperer de randomFood de la fonction randomFood()
  };
  return food;
}


/**
 * fonction qui permet de dessiner les aliments sur le canvas
 */
function draw() {
  // Effacer le canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Dessine chaque aliment
  for (let i = 0; i < foods.length; i++) {
    let food = foods[i];
    let img = new Image();
    img.src = food.src;
    // Ajout de l'aliment sur le canvas
    ctx.drawImage(img, food.x, food.y, food.width, food.height);

    // Dessine le nom en dessus de l'aliment
    ctx.font = "bold 13px Comic Sans MS";
    ctx.fillText(food.name, food.x + food.width / 3, food.y + food.height * 1.2);

    // Fait tomber l'aliment avec la vitesse 
    food.y += food.speed;

    // Si l'aliment atteint le bas de l'écran
    if (food.y > canvas.height - food.height) {
      // On vérifie si l'aliment fais partie de la catégorie
      if (food.category == URLcategory) {
        // Si oui on lui enlève les points
        score -= 2;
        // Si le score est négatif on le met à zèro
        if (score < 0) {
          score = 0;
          gameOver();
        }
      }
      // On envoie les donnés au php
      sendDataToPhp(URLcategory, score, slice_count, 1);
      // On supprime l'aliment
      foods.splice(i, 1);
      break;
    }
  }
  // On vérifie si le nombre d'aliments est plus petit que le nombre max des aliments
  if (foods.length < nbFood) {
    foods.push(createFood());
  }
}
/**
 * fonction qui permet d'augmenter la vitesse du défilement du joueur qui a le score le plus petit de la partie
 */
function addAndShowUsersSpeed() {
  updateUsers();
  let userScore = JSON.parse(sessionStorage.getItem("ListUsers"));
  if (userScore.length > 1) {
    isMultiplayer = true;
    // Si le jouer a le score le plus petit alors la vitesse augmente plus vite
    if (userScore[0]["idUser"] == idUser) {
      speed += 0.1;
      speedElement.innerText = "Vitesse: *" + Math.round(speed * 10) / 10;
    }
  }
}

/**
 * fonction qui permet de vérifier si le cursor est à l'interieur de l'image
 * @param {int} x position x du cursor
 * @param {int} y position y du cursor
 * @param {array} rect l'aliment
 * @returns 
 */
function isPointerInsideFood(x, y, rect) {
  return x >= rect.x && x <= rect.x + rect.width &&
    y >= rect.y && y <= rect.y + rect.height;
}


/**
 * fonction qui permet de gérer de vérifier si un aliment a été clicker
 * @param {} event 
 */
function handleClickEvent(event) {

  // Les coordonnés exacts du curseur
  let clicX = event.offsetX;
  let clicY = event.offsetY;

  // Vérifier si le cursor est à l'intéreur d'un aliment
  for (let i = 0; i < foods.length; i++) {
    let food = foods[i];
    if (isPointerInsideFood(clicX, clicY, food)) {
      // Si l'aliment fait partie de la catégorie on augmente la vitesse,le score du joueur
      if (food.category == URLcategory) {
        speed += 0.1;
        score++;
        nbFood = Math.floor(1 + (0.2 * (speed - 1) / 0.1));
        speedElement.innerText = "Vitesse: *" + Math.round(speed * 10) / 10;
        slice_count++;
        addAndShowUsersSpeed();
        sendDataToPhp(URLcategory, score, slice_count, 1);
      } else {
        // Si l'aliment fait partie de la catégorie malbouffe on arrête le jeu
        if (food.category == "malbouffe") {
          score = 0;
          gameOver();
        }
        score -= 2;
        slice_count++;
        addAndShowUsersSpeed();
        if (score < 0) {
          score = 0;
          gameOver();
        }
      }
      sendDataToPhp(URLcategory, score, slice_count, 1);
      // Supprimer l'aliment du tableau
      foods.splice(i, 1);
      break;
    }
  }
}

/**
 * fonction qui permet de rezise le canvas en fonction de la taille de la fênetre
 */
function resizeCanvas() {
  canvas.width = window.innerWidth * 0.9;
  canvas.height = window.innerHeight * 0.9;
}

/**
 * événement qui permet de vérifier si le joueur a quitté ou rechargé la page
 */
window.addEventListener('beforeunload', function (event) {

  sendDataToPhp(URLcategory, score, slice_count, 0);
});

/**
 * fonction qui permet d'afficher le menu de la fin du jeu
 */
function gameOver() {
  let userScore = JSON.parse(sessionStorage.getItem("ListUsers"));
  // Supprime la variable de l'url
  url.searchParams.delete("category");
  history.replaceState(null, "", url);
  sendDataToPhp(URLcategory, score, slice_count, 0);
  clearInterval(UpdateInformaions);
  clearInterval(drawInterval);
  canvas.remove();
  // On vérifie si le nombres de joueurs de la partie
  if (userScore.length < 2) {
    // On vérifie si le jeu est en multijouer
    if (isMultiplayer) {
      // Affichage du gagnant de la partie
      document.getElementById("winner").innerText = "Vous avez gagné la partie!";
    }
  }
  // Affichage de la durée de la partie
  document.getElementById("duration").innerText = document.getElementById("time").textContent;
  gameOverMenu.style.visibility = "visible";
  informations.style.visibility = "hidden";
  gameOverMenuButton.addEventListener('click', function (event) {
    location.href = "./categories.php";
  });
}





