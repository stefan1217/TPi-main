let NbFood = 1;
let Speed = 1;
let Score = 0;
let Slice_count = 0;
let time = 0;
let foods = [];

const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');
const FoodList = JSON.parse(localStorage.getItem("Foods"));
const ScoreElement = document.getElementById("score");

FoodList.push({category:"malbouffe", name:"fausse-tomate", picture_path:"t.png"});
FoodList.push({category:"malbouffe", name:"fausse-aubergine", picture_path:"l.png"});

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;
const FoodWidth = canvas.width/30;
const FoodHeight = canvas.width/25;
let url = new URL(window.location.href);
let categorie = url.searchParams.get("categorie");
ScoreElement.innerText = "Score : " + Score;
let collisionDetected = false;

function RandomFoodFromList(list){
  return list[Math.floor(Math.random() * (list.length - 0)) + 0];
}

function createImage() {
  let randomFood = RandomFoodFromList(FoodList);
  const food = {
    x: Math.random() * Math.floor(Math.random() * (canvas.width-(FoodHeight) - FoodWidth)) + FoodWidth, // position x aléatoire
    y: -FoodHeight, 
    width: FoodWidth, 
    height: FoodHeight, 
    src: "../sprites/" + randomFood.picture_path, 
    speed: Speed, 
    name: randomFood.name,
    category: randomFood.category,   
  };
  
  // Vérifier s'il y a une collision avec un autre fruit
  for (let i = 0; i < foods.length; i++) {
    const otherFood = foods[i];
    const xInBounds = food.x + food.width > otherFood.x && food.x < otherFood.x + otherFood.width;
    const yInBounds = food.y + food.height > otherFood.y && food.y < otherFood.y + otherFood.height;
    if (xInBounds && yInBounds) {
      collisionDetected = true;
      break;
    }
  }
  
  // Si une collision est détectée, modifier la position du nouveau fruit
  if (collisionDetected) {
    return createImage();
  } else {
    return food;
  }
}

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
  if(image.category == categorie){
    Score--;
    sendDataToPhp();
  }
    if(Score < 0){
      Score = 0;
      alert("Vous avez perdu votre socre est de: " + Score);
      location.href ="./categories.php";
    }
  
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

canvas.addEventListener('mousedown', checkCollision);

function checkCollision(event) {
  
  // Vérifier si le clic ou le déplacement de la souris est sur un fruit en cours de dessin
  let collisionDetected = false;
  for (let i = 0; i < foods.length; i++) {
    const image = foods[i];
    const xInBounds = event.clientX >= image.x && event.clientX <= image.x + image.width;
    const yInBounds = event.clientY >= image.y && event.clientY <= image.y + image.height;
    
    if (xInBounds && yInBounds) {
      collisionDetected = true;
      // Supprimer l'aliment du tableau "foods" et mettre à jour le score en fonction de sa catégorie
      if (image.category == categorie) {
        Score++;
        Slice_count++;
        sendDataToPhp();
        ScoreElement.innerText = "Score : " + Score;
      } else {
        Score--;
        sendDataToPhp();
        ScoreElement.innerText = "Score : " + Score;
        
        if(Score < 0){
          Score = 0;
          alert("Vous avez perdu votre socre est de: " + Score);
          location.href ="./categories.php";
        }
      }
      if(image.category == "malbouffe"){
        sendDataToPhp();
        alert("Vous avez perdu votre socre est de: " + Score);
          location.href ="./categories.php";
      }
      foods.splice(i, 1);
      break;
    }
  }
}

function sendDataToPhp() {
  let dataToSend = JSON.stringify([Score, Slice_count, time]);
  fetch('../pages/game.php?categorie='+categorie, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-Requested-With': 'XMLHttpRequest'
      },
      body: 'data=' + encodeURIComponent(dataToSend)
  })
      .then(response => response.text())
      .then(result => {
          document.getElementById("result").innerHTML = result;
      })
      .catch(error => {
          console.error('Erreur:', error);
      });
}

function animate() {
  requestAnimationFrame(animate);
  draw();
}
animate();


window.addEventListener('resize', resizeCanvas);


function resizeCanvas() {
  canvas.width = window.innerWidth * 0.9;
  canvas.height = window.innerHeight * 0.9;
}
