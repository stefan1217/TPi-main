// Créer un canevas
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const NbFood = 2;
const FoodList = JSON.parse(localStorage.getItem("Foods"));
const ScoreElement = document.getElementById("score");
var Score = 0;
ScoreElement.innerText = "Score : " + Score;
var GameOver = document.getElementById("Game-Over");
// Définir la largeur et la hauteur du canevas
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
// Fonction pour créer une image
const FoodWidth = canvas.width/30;
const FoodHeight = canvas.width/25;
var url = new URL(window.location.href);
var categorie = url.searchParams.get("categorie");
var informationsElement = document.getElementById("informations");


function RandomFoodFromList(list){
  return list[Math.floor(Math.random() * (list.length - 0)) + 0];
}


function createImage() {
  var randomFood = RandomFoodFromList(FoodList);
  const food = {
    x: Math.random() * Math.floor(Math.random() * (canvas.width-(FoodHeight) - FoodWidth)) + FoodWidth, // position x aléatoire
    y: -FoodHeight, // position y en haut de l'écran
    width: FoodWidth, // largeur aléatoire
    height: FoodHeight, // hauteur aléatoire
    src: "../sprites/" + randomFood.picture_path, // source de l'image
    speed: 2, // vitesse aléatoire
    name: randomFood.name,
    category: randomFood.category,   
  };
  return food;
}

// Tableau pour stocker tous les aliments
const foods = [];
// Fonction pour dessiner les aliments
function draw() {
  // Effacer le canevas
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Dessiner chaque aliment
  foods.forEach(image => {
    const img = new Image();
    img.src = image.src;
    ctx.drawImage(img, image.x, image.y, image.width, image.height);

    // Faire tomber l'aliment avec la vitesse 
    image.y += image.speed;

    // Si l'aliment atteint le bas de l'écran, la supprimer
if (image.y > canvas.height-image.height) {
  const index = foods.indexOf(image);
  foods.splice(index, 1);
}
  });
 

  // Vérifie si le nombre d'aliment qui tombent en même temps ne depasse pas la valeur de la variable
  if (foods.length < NbFood) {
    const image = createImage();
    foods.push(image);
  }
}

function endGame() {
  // Supprimer le canevas et afficher un message de fin de jeu
  canvas.remove();
  informationsElement.style.visibility = "hidden";
  const endMessage = document.createElement("h1");
  endMessage.innerText = "Vous avez perdu!";
  endMessage.style.fontSize = "300%";
  GameOver.style.backgroundColor="lightblue";
  GameOver.style.textAlign="center";
  GameOver.style.top = "6%";
  GameOver.appendChild(endMessage);
  }

canvas.addEventListener('mousedown', checkCollision);

function checkCollision(event) {
  // Vérifier si le clic ou le déplacement de la souris est sur un fruit en cours de dessin
  foods.forEach((image, index) => {
    const xInBounds = event.clientX >= image.x && event.clientX <= image.x + image.width;
    const yInBounds = event.clientY >= image.y && event.clientY <= image.y + image.height;
  
    if (xInBounds && yInBounds) {
      // Supprimer le fruit du tableau "foods" et mettre à jour le score en fonction de sa catégorie
      if (image.category == categorie) {
        foods.splice(index, 1);
        Score++;
        ScoreElement.innerText = "Score : " + Score;
      } else {
        foods.splice(index, 1);
        Score--;
        ScoreElement.innerText = "Score : " + Score;
      }
    }
    if(Score == -1){
      endGame();
    }
  });
}

function animate() {
  requestAnimationFrame(animate);
  draw();
}
animate();