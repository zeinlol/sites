var ship;
var bullets = [];


function setup() {
    createCanvas(600, 400);
    ship = new Ship();
    bullet = new Bullet(ship.x);
}

function draw() {
    background(1);
    ship.show();
    for (var i = 0; i < bullets.length; i++) {
        //x = ship.x;
        bullets[i].show();
        bullets[i].move();
    }
}

function keyPressed() {
    if (keyCode === RIGHT_ARROW) {
        ship.x += 5;
    } else if (keyCode === LEFT_ARROW) {
        ship.x -= 5;
    } else {
        var bullet = new Bullet(ship.x);
        bullets.push(bullet);
    }
}