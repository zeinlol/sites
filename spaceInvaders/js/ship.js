function Ship() {
    this.x = width / 2;

    this.show = function() {
        fill(250);
        rect(this.x, height-24, 20, 20);
    }
}