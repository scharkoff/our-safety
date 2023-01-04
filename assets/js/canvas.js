(function () {

    let canvas = document.createElement("canvas"),
        ctx = canvas.getContext("2d"),
        w = canvas.width = innerWidth,
        h = canvas.height = innerHeight,
        particles = [],
        properties = {
            bgColor: "rgb(241, 241, 241)", // -- цвет заднего фона
            particleColor: "rgb(0, 140, 255)", // -- цвет вершины
            particleRadius: 5, // -- радиус вершины
            particleCount: 70, // -- число вершин
            particleMaxVelocity: 0.2, // -- скорость перемещения вершин
            lineLength: 200, // -- макс длина линии
            particleLife: 6 // -- жизненный цикл частички
        }

    // -- Оптимизация для других устройств
    if (w <= 768 && h <= 1045) { // -- планшет
        properties.particleCount = 50;
    }

    if ((w <= 420 && h < 900) || (w <= 900 && h < 420)) { // -- телефон
        properties.particleCount = 20;
    }


    document.querySelector("body").prepend(canvas);
    canvas.classList.add("canvas");

    window.onresize = function () {
        w = canvas.width = innerWidth;
        h = canvas.height = innerHeight;
    }

    class Particles {
        constructor() {
            this.x = Math.random() * w;
            this.y = Math.random() * h;
            this.velocityX = Math.random() * (properties.particleMaxVelocity * 2) - properties.particleMaxVelocity;
            this.velocityY = Math.random() * (properties.particleMaxVelocity * 2) - properties.particleMaxVelocity;
            this.life = Math.random() * properties.particleLife * 60;
        }

        position() {
            this.x + this.velocityX > w && this.velocityX > 0 || this.x + this.velocityX < 0 && this.velocityX < 0 ? this.velocityX *= -1 : this.velocityX; // меняем направление скорости
            this.y + this.velocityY > h && this.velocityY > 0 || this.y + this.velocityY < 0 && this.velocityY < 0 ? this.velocityY *= -1 : this.velocityY;
            this.x += this.velocityX;
            this.y += this.velocityY;
        }

        reDraw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, properties.particleRadius, 0, Math.PI * 2);
            ctx.closePath();
            ctx.fillStyle = properties.particleColor;
            ctx.fill();
        }

        reCalculateLife() {
            if (this.life < 1) {
                this.x = Math.random() * w;
                this.y = Math.random() * h;
                this.velocityX = Math.random() * (properties.particleMaxVelocity * 2) - properties.particleMaxVelocity;
                this.velocityY = Math.random() * (properties.particleMaxVelocity * 2) - properties.particleMaxVelocity;
                this.life = Math.random() * properties.particleLife * 60;
            }

            this.life--;
        }
    }

    function reDrawBackground() {
        ctx.fillStyle = properties.bgColor;
        ctx.fillRect(0, 0, w, h);
    }

    function drawLines() {
        let x1, y1, x2, y2, length, opacity;
        for (let i in particles) {
            for (let j in particles) {
                x1 = particles[i].x; // -- коорды первой частицы
                y1 = particles[i].y;
                x2 = particles[j].x; // -- коорды второй частицы
                y2 = particles[j].y;
                length = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
                if (length < properties.lineLength) {
                    opacity = 1 - length / properties.lineLength;
                    ctx.lineWidth = "1";
                    ctx.strokeStyle = "rgb(0, 140, 255, " + opacity + ")";
                    ctx.beginPath();
                    ctx.moveTo(x1, y1);
                    ctx.lineTo(x2, y2);
                    ctx.closePath();
                    ctx.stroke();

                }
            }

        }
    }

    function reDrawParticles() {
        for (let i in particles) {
            // particles[i].reCalculateLife();
            particles[i].position();
            particles[i].reDraw();
        }
    }

    function loop() {
        reDrawBackground();
        reDrawParticles();
        drawLines();
        requestAnimationFrame(loop);
    }

    function init() {
        for (let i = 0; i < properties.particleCount; i++) {
            particles.push(new Particles);
        }
        loop();
    }

    init();
}());