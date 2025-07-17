// Game variables
const canvas = document.getElementById('gameCanvas');
const ctx = canvas.getContext('2d');
const overlay = document.getElementById('gameOverlay');
const startButton = document.getElementById('startButton');
const restartButton = document.getElementById('restartButton');
const overlayTitle = document.getElementById('overlayTitle');
const overlayMessage = document.getElementById('overlayMessage');

// Game state
let gameState = 'menu'; // 'menu', 'playing', 'paused', 'gameOver'
let score = 0;
let lives = 3;
let gameSpeed = 2;
let lastTime = 0;

// Player car
const playerCar = {
    x: canvas.width / 2 - 25,
    y: canvas.height - 100,
    width: 50,
    height: 80,
    speed: 5,
    color: '#ff6b6b'
};

// Enemy cars array
let enemyCars = [];

// Road lines for visual effect
let roadLines = [];

// Input handling
const keys = {
    left: false,
    right: false,
    up: false,
    down: false,
    space: false
};

// Initialize road lines
function initRoadLines() {
    roadLines = [];
    for (let i = 0; i < 10; i++) {
        roadLines.push({
            x: canvas.width / 2,
            y: i * 80,
            width: 4,
            height: 40
        });
    }
}

// Create enemy car
function createEnemyCar() {
    const lanes = [150, 250, 350, 450, 550];
    const colors = ['#3498db', '#e74c3c', '#f39c12', '#9b59b6', '#2ecc71'];
    
    return {
        x: lanes[Math.floor(Math.random() * lanes.length)],
        y: -100,
        width: 50,
        height: 80,
        speed: Math.random() * 2 + 1,
        color: colors[Math.floor(Math.random() * colors.length)]
    };
}

// Draw car
function drawCar(car) {
    ctx.fillStyle = car.color;
    ctx.fillRect(car.x, car.y, car.width, car.height);
    
    // Car details
    ctx.fillStyle = '#2c3e50';
    // Windows
    ctx.fillRect(car.x + 5, car.y + 10, car.width - 10, 15);
    ctx.fillRect(car.x + 5, car.y + 30, car.width - 10, 15);
    
    // Wheels
    ctx.fillStyle = '#34495e';
    ctx.fillRect(car.x - 3, car.y + 15, 8, 15);
    ctx.fillRect(car.x + car.width - 5, car.y + 15, 8, 15);
    ctx.fillRect(car.x - 3, car.y + 50, 8, 15);
    ctx.fillRect(car.x + car.width - 5, car.y + 50, 8, 15);
}

// Draw road
function drawRoad() {
    // Road background
    ctx.fillStyle = '#34495e';
    ctx.fillRect(100, 0, 600, canvas.height);
    
    // Road edges
    ctx.fillStyle = '#ecf0f1';
    ctx.fillRect(100, 0, 10, canvas.height);
    ctx.fillRect(690, 0, 10, canvas.height);
    
    // Road lines
    ctx.fillStyle = '#ecf0f1';
    roadLines.forEach(line => {
        ctx.fillRect(line.x, line.y, line.width, line.height);
    });
}

// Update road lines
function updateRoadLines() {
    roadLines.forEach(line => {
        line.y += gameSpeed * 2;
        if (line.y > canvas.height) {
            line.y = -40;
        }
    });
}

// Update player car
function updatePlayerCar() {
    if (keys.left && playerCar.x > 110) {
        playerCar.x -= playerCar.speed;
    }
    if (keys.right && playerCar.x < 640) {
        playerCar.x += playerCar.speed;
    }
    if (keys.up && playerCar.y > 0) {
        playerCar.y -= playerCar.speed * 0.5;
    }
    if (keys.down && playerCar.y < canvas.height - playerCar.height) {
        playerCar.y += playerCar.speed * 0.5;
    }
}

// Update enemy cars
function updateEnemyCars() {
    // Move existing cars
    enemyCars.forEach(car => {
        car.y += car.speed + gameSpeed;
    });
    
    // Remove cars that are off screen
    enemyCars = enemyCars.filter(car => car.y < canvas.height + 100);
    
    // Add new cars randomly
    if (Math.random() < 0.02) {
        enemyCars.push(createEnemyCar());
    }
}

// Check collisions
function checkCollisions() {
    enemyCars.forEach((car, index) => {
        if (playerCar.x < car.x + car.width &&
            playerCar.x + playerCar.width > car.x &&
            playerCar.y < car.y + car.height &&
            playerCar.y + playerCar.height > car.y) {
            
            // Collision detected
            enemyCars.splice(index, 1);
            lives--;
            
            // Flash effect
            canvas.style.filter = 'brightness(1.5)';
            setTimeout(() => {
                canvas.style.filter = 'brightness(1)';
            }, 100);
            
            if (lives <= 0) {
                gameOver();
            }
        }
    });
}

// Update score
function updateScore() {
    score += Math.floor(gameSpeed);
    
    // Increase game speed gradually
    if (score % 500 === 0) {
        gameSpeed += 0.2;
    }
    
    // Update UI
    document.getElementById('score').textContent = score;
    document.getElementById('speed').textContent = Math.floor(gameSpeed * 20);
    document.getElementById('lives').textContent = lives;
}

// Game over
function gameOver() {
    gameState = 'gameOver';
    overlayTitle.textContent = 'Game Over!';
    overlayMessage.textContent = `Final Score: ${score}`;
    startButton.style.display = 'none';
    restartButton.style.display = 'inline-block';
    overlay.style.display = 'flex';
}

// Reset game
function resetGame() {
    score = 0;
    lives = 3;
    gameSpeed = 2;
    enemyCars = [];
    playerCar.x = canvas.width / 2 - 25;
    playerCar.y = canvas.height - 100;
    initRoadLines();
    updateScore();
}

// Start game
function startGame() {
    gameState = 'playing';
    overlay.style.display = 'none';
    resetGame();
    gameLoop();
}

// Pause game
function pauseGame() {
    if (gameState === 'playing') {
        gameState = 'paused';
        overlayTitle.textContent = 'Paused';
        overlayMessage.textContent = 'Press SPACE to resume';
        startButton.style.display = 'none';
        restartButton.style.display = 'none';
        overlay.style.display = 'flex';
    } else if (gameState === 'paused') {
        gameState = 'playing';
        overlay.style.display = 'none';
        gameLoop();
    }
}

// Game loop
function gameLoop(currentTime) {
    if (gameState !== 'playing') return;
    
    const deltaTime = currentTime - lastTime;
    lastTime = currentTime;
    
    // Clear canvas
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    // Draw background
    ctx.fillStyle = '#2c3e50';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    
    // Update and draw game elements
    updateRoadLines();
    drawRoad();
    
    updatePlayerCar();
    updateEnemyCars();
    checkCollisions();
    updateScore();
    
    // Draw cars
    drawCar(playerCar);
    enemyCars.forEach(car => drawCar(car));
    
    // Continue game loop
    requestAnimationFrame(gameLoop);
}

// Event listeners
document.addEventListener('keydown', (e) => {
    switch(e.code) {
        case 'ArrowLeft':
            keys.left = true;
            break;
        case 'ArrowRight':
            keys.right = true;
            break;
        case 'ArrowUp':
            keys.up = true;
            break;
        case 'ArrowDown':
            keys.down = true;
            break;
        case 'Space':
            e.preventDefault();
            keys.space = true;
            pauseGame();
            break;
    }
});

document.addEventListener('keyup', (e) => {
    switch(e.code) {
        case 'ArrowLeft':
            keys.left = false;
            break;
        case 'ArrowRight':
            keys.right = false;
            break;
        case 'ArrowUp':
            keys.up = false;
            break;
        case 'ArrowDown':
            keys.down = false;
            break;
        case 'Space':
            keys.space = false;
            break;
    }
});

startButton.addEventListener('click', startGame);
restartButton.addEventListener('click', () => {
    startButton.style.display = 'inline-block';
    restartButton.style.display = 'none';
    overlayTitle.textContent = 'Get Ready!';
    overlayMessage.textContent = 'Use arrow keys to control your car';
    gameState = 'menu';
});

// Initialize game
initRoadLines();
updateScore();

// Add touch controls for mobile
let touchStartX = 0;
let touchStartY = 0;

canvas.addEventListener('touchstart', (e) => {
    e.preventDefault();
    touchStartX = e.touches[0].clientX;
    touchStartY = e.touches[0].clientY;
});

canvas.addEventListener('touchmove', (e) => {
    e.preventDefault();
    if (gameState !== 'playing') return;
    
    const touchX = e.touches[0].clientX;
    const touchY = e.touches[0].clientY;
    
    const deltaX = touchX - touchStartX;
    const deltaY = touchY - touchStartY;
    
    if (Math.abs(deltaX) > Math.abs(deltaY)) {
        // Horizontal movement
        if (deltaX > 10) {
            keys.right = true;
            keys.left = false;
        } else if (deltaX < -10) {
            keys.left = true;
            keys.right = false;
        }
    } else {
        // Vertical movement
        if (deltaY > 10) {
            keys.down = true;
            keys.up = false;
        } else if (deltaY < -10) {
            keys.up = true;
            keys.down = false;
        }
    }
});

canvas.addEventListener('touchend', (e) => {
    e.preventDefault();
    keys.left = false;
    keys.right = false;
    keys.up = false;
    keys.down = false;
});