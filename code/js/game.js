/**
 * Description : Script du jeu
 */

import { sendDataToPhp } from "./sendDataToPhp.js";
import { addBadFood } from "./addBadFood.js";
import { UpdateUsers } from "./updateUsers.js";

//Déclarations de varaiables
let nbFood = 1;
let Speed = 2;
let Score = 0;
let time = 0;
let foods = [];
let Slice_count = 0;

// Récuperation des aliments
let FoodList = JSON.parse(localStorage.getItem("Foods"));
// Ajout des mauvais aliments dans la liste
addBadFood(FoodList);


let TimerElement = document.getElementById("time");
let SpeedElement = document.getElementById("speed");
let GameOverMenu = document.getElementById("game-over-menu");
let GameOverMenuButton = document.getElementById("game-over-menu-button");
let Informations = document.getElementById("informations");
let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');

canvas.width = window.innerWidth * 0.95;
canvas.height = window.innerHeight * 0.75;
let FoodWidth = canvas.width / 25;
let FoodHeight = canvas.width / 20;
let url = new URL(window.location.href);
let categorie = url.searchParams.get("category");
let idUser = url.searchParams.get("idUser");
SpeedElement.innerText = "Vitesse: *" + Math.round(Speed * 10) / 10;
TimerElement.innerText = "Temps: 0h 0m 0s";

canvas.addEventListener('click', handleClickEvent, false);
window.addEventListener('resize', resizeCanvas, false);

let drawInterval = setInterval(draw, 10); // Boucle principal
let TimerInterval = setInterval(Timer, 1000);
let UpdateInformaions = setInterval(UpdateUsers, 100);
UpdateUsers();

/**
 * function qui permet de récuperer un aliment aléatoire de la liste
 * @param {Array} list 
 * @returns 
 */
function RandomFoodFromList(list) {
  //On filtre les aliments de la categorie
  let foodCategorieList = list.filter(item => item.category === categorie);
  if (foodCategorieList.length > 0 && Math.random() < 0.75) { // 75% de chance de tomber sur les aliments de la catégorie choisie 
    return foodCategorieList[Math.floor(Math.random() * foodCategorieList.length)];
  } else {
    return list[Math.floor(Math.random() * list.length)];
  }
}
/** 
 * function qui permet de crée un nouveau aliment
 * @returns food
 */
function createFood() {
  let randomFood = RandomFoodFromList(FoodList);
  let food = {
    x: Math.random() * Math.floor(Math.random() * (canvas.width - (FoodHeight) - FoodWidth)) + FoodWidth, // position x aléatoire
    y: -FoodHeight,
    width: FoodWidth,
    height: FoodHeight,
    src: "../sprites/" + randomFood.picture_path,
    speed: Speed,
    name: randomFood.name,
    category: randomFood.category,
  };
  return food;
}

/**
 * function qui permet de dessiner les aliments
 */
function draw() {
  // Effacer le canvas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Dessine chaque aliment
  for (let i = 0; i < foods.length; i++) {
    let food = foods[i];
    let img = new Image();
    img.src = food.src;
    ctx.drawImage(img, food.x, food.y, food.width, food.height);

    // Fait tomber l'aliment avec la vitesse 
    food.y += food.speed;

    // Si l'aliment atteint le bas de l'écran,on le supprime de la liste
    if (food.y > canvas.height - food.height) {
      if (food.category == categorie) {
        Score -= 2;
        if (Score < 0) {
          Score = 0;
          GameOver();
        }
      }
      sendDataToPhp(categorie, Score, Slice_count, time, 1);
      foods.splice(i, 1);
      break;
    }
  }
  //On vérifie si le nombre des aliments est plus petit que le nombre max des aliments
  if (foods.length < nbFood) {
    foods.push(createFood());
  }
}

/**
 * function qui permet d'augmenter la vitesse du défilement du joueur qui a le score le plus petit
 */
function ShowUserInformations() {
  UpdateUsers();
  let userScore = JSON.parse(sessionStorage.getItem("ListUsers"));
  if (userScore.length > 1) {
    //Si le jouer a le score le plus petit alors la vitesse augmente plus vite
    if (userScore[1]["idUser"] == idUser) {
      Speed += 0.1;
      SpeedElement.innerText = "Vitesse: *" + Math.round(Speed * 10) / 10;
    }
  }
}

/**
 * function qui permet de vérifier si le cursor est à l'interieur de l'image
 * @param {int} x position x du cursor
 * @param {int} y position y du cursor
 * @param {array} rect aliment
 * @returns 
 */
function isPointerInsideFood(x, y, rect) {
  return x >= rect.x && x <= rect.x + rect.width &&
    y >= rect.y && y <= rect.y + rect.height;
}


/**
 * function qui permet de gérer l'évenement click
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
      // Supprimer l'aliment et on met à jour les informations
      if (food.category == categorie) {
        Speed += 0.1;
        Score++;
        nbFood = Math.floor(1 + (0.2 * (Speed - 2) / 0.1));
        SpeedElement.innerText = "Vitesse: *" + Math.round(Speed * 10) / 10;
        Slice_count++;
        ShowUserInformations();
        sendDataToPhp(categorie, Score, Slice_count, time, 1);
        
      } else {
        if (food.category == "malbouffe") {
          Score = 0;
          GameOver();
        }
        Score -= 2;
        Slice_count++;
        ShowUserInformations();
        if (Score < 0) {
          Score = 0;
          GameOver();
        }
        
      }
      sendDataToPhp(categorie, Score, Slice_count, time, 1);
      //Supprimer l'aliment du tableau
      foods.splice(i, 1);
      break;
    }
  }
}

/**
 * function qui permet de rzise le canvas en fonction de la taille de la fênetre
 */
function resizeCanvas() {
  canvas.width = window.innerWidth * 0.8;
  canvas.height = window.innerHeight * 0.8;
}


/**
 * function qui permet d'affiche le timer 
 */
function Timer() {
  time++;
  let hours = Math.floor(time / 3600);
  let minutes = Math.floor((time - hours * 3600) / 60);
  let seconds = time - hours * 3600 - minutes * 60;
  TimerElement.innerText = "Temps: " + hours + "h " + minutes + "m " + seconds + "s";
}

/**
 * Évenement qui permet de vérifier si le joueur a quitté la page
 */
window.addEventListener('beforeunload', function (event) {
  sendDataToPhp(categorie,Score, Slice_count, time, 0);
});


/**
 * function qui permet d'afficher le menu de la fin du jeu
 */
function GameOver() {
  sendDataToPhp(categorie, Score, Slice_count, time, 0);
  clearInterval(UpdateInformaions);
  clearInterval(TimerInterval);
  clearInterval(drawInterval);
  canvas.remove();
  GameOverMenu.style.visibility = "visible";
  Informations.style.visibility = "hidden";
  GameOverMenuButton.addEventListener('click', function (event) {
  location.href = "./categories.php";
  });
}





