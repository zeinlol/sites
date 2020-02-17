function Bullet(x) {
    this.x = x;
    this.y = height-24;

    this.show = function() {
        noStroke();
        fill(250, 50, 100);
        ellipse(this.x, this.y, 15, 15);
    }
    
    function move() {
        this.y = this.y - 3;
    }
}