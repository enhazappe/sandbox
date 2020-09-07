<?php

header('HTTP/1.1 503 Service Unavailable');
header('Retry-After: 300');

?>
    <!DOCTYPE html>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <style>
        body
        {
            color: #333;
            background: white;
            width: 800px;
            margin: 100px auto;
        }

        h1
        {
            font-family: sans-serif;
            text-shadow: 2px 2px 2px #CCCCCC;
            color: #2d93ba;
            text-transform: uppercase;
            font-size: 4em;
        }

        p
        {
            font: 21px/1.5 Georgia,serif;
            margin: 1.5em 0;
        }

        .blue
        {
            color: #2d93ba;
        }

        #trigger
        {
            cursor: pointer;
        }

        .modal
        {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content
        {
            background-color: #fefefe;
            margin: auto;
            padding: 15px 5px;
            border: 1px solid #888;
            width: 820px;
            text-align: center;
        }

        .close
        {
            color: #999;
            font-size: 14px;
            font-family: Arial;
            padding-top: 4px;
        }

        .close:hover,
        .close:focus
        {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <title>Plánovaná údržba</title>

    <h1>
        <table>
            <tr>
                <td>
                    <img src="data:image/png;base64,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" alt="Deploy">
                </td>
                <td>
                    Probíhá údržba
                </td>
        </table>
    </h1>

    <p>
        Právě provádíme plánovou údržbu nebo pro Vás nasazujeme <span class="blue">něco úžasného</span>
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC1ElEQVQ4T4WTX0hTURzHv2e7825NZaKIy+Uf0ppFUaiRPRhmFtSLphQFUT5IEZXvhaZBPfQQSAj1ElEUSpFmSeksQSMtFSRT/JMzZVPT6Wbzzrvtnnvi3qlMe+j39Duc3/fz+/4Ov0OwKc6+6du7hddV6wjJ4gCLJFN4/ZJDCEi9Xgm3Pp47+D1cQsIPZR8GGjhCCntnlzDlXUGAMvVapyGIN3BINeqwItHGtvO5RWs6FTAxwfT3x4fGxt0+S9e0Z7OpDedUIwcTB0cuQ3pVaZ6oApTOTq9Y+D/xGsmiJ+DBGnsvFRSR8rYf2QGKb3XDM0iKNuBu7g4cT4lDs30eFZ2jUIaoPJSGI8mxaP3lwp0v43Aui9jOU0iUHSAX3vW3Di0IBT89PjSdykROoglUZpAZ0GmfBtNFINscA8oYlCfpts/gYssgonkORlmykfK2QUfd8Eyi8mCua/lqkQJQBLIqYqAyVgFKzrC7+jF0SelIYCtOcrVlgD0fnlXHGys7jMgI7TpAgamQVaAC8wh+5FQ/BGfNRHzQC3L5fT+rH51XATX5GSjZmfCvCxUQcvG6ZwgVDZ/Ape9DjOgBKW3qczRPuhODMoMlSo+WkkwYed1GF6sOPD4RxTUv8JtFQGtOhlFwO8nJ+q7WSa+/wCkEVRfHtplwL88KI89vmHvJJ+LGSxvaRybBpeyCjjAQ/4qNFL/6mhUISj2f53zrC2M1MNSe2A+zKUqFTC38wfWnbzEy54bWnAISaQK/vAiJydnqIh191tGw6KeFE4K0DolkQVzJiAWlFLW2bggU0FjSQHgDOHEZTAo0um6eKVIBVe3t+o5JjM37qcUhhvZfDZlCdk2rqSZuK6DRhsR+0eGyj6TjSVVoldci65GtAYwWzgUJBJlARuiagIGTAtCIAiRA7bzhM4VDrA+a92gYbsuylMUkaglSioAMR5Cx3oCESnfl6YHw+r+2vZqktPKQUAAAAABJRU5ErkJggg==">
        .
    </p>

    <p>
        Zkuste to za pár minut znovu. Stránka se automaticky po pěti minutách resetuje.
    </p>

    <p>
        Pokud se nudíte, můžete si zahrát třeba <a id="trigger" class="blue">Pong</a>.
    </p>

    <p>
        <small style="color: #aaa;">
            Kontaktujte nás, pokud se Vám obrazovka s údržbou objevuje delší čas. <br/>
            <?php

            $filename = __DIR__ . '/../.deployment.running';

            if(file_exists($filename))
            {
                echo "Pracujeme na tom od" . date("j.n.Y H:i:s", filectime($filename));
            }

            ?>
        </small>
    </p>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <canvas id="game" width="800" height="600"></canvas>
            <span class="close">zavřít</span>
        </div>
    </div>

    <script>
        var modal = document.getElementById('myModal');

        var trigger = document.getElementById("trigger");

        var span = document.getElementsByClassName("close")[0];

        trigger.onclick = function () {
            modal.style.display = "block";
        };

        span.onclick = function () {
            modal.style.display = "none";
        };

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        var canvas;
        var canvasContext;

        var ballX = 400;
        var ballY = 300;
        var ballSpeedX = 8;
        var ballSpeedY = 0;

        const paddleWidth = 10;
        const paddleHeight = 100;
        var paddle1Y = 250;
        var paddle2Y = 250;

        var score1 = 0;
        var score2 = 0;
        const win = 5;
        var winScreen = false;
        var loseScreen = false;

        window.onload = function () {
            canvas = document.getElementById('game');
            canvasContext = canvas.getContext('2d');

            var FPS = 60;
            setInterval(function () {
                move();
                draw();
            }, 1000/FPS);

            canvas.addEventListener('mousemove',function (evt) {
                var mouse = mousePosition(evt);
                paddle1Y = mouse.y-(paddleHeight/2)
            });

            canvas.addEventListener('mousedown',function (evt) {
                if (winScreen || loseScreen) {
                    score1 = 0;
                    score2 = 0;
                    winScreen = false;
                    loseScreen = false;
                }
            })
        };

        function rectangle(X,Y,width,height,color) {
            canvasContext.fillStyle = color;
            canvasContext.fillRect(X,Y,width,height);
        }

        function circle(X,Y,radius,color) {
            canvasContext.fillStyle = color;
            canvasContext.beginPath();
            canvasContext.arc(X,Y,radius,0,2*Math.PI,true);
            canvasContext.fill();
        }

        function mousePosition(evt) {
            var rect = canvas.getBoundingClientRect();
            var root = document.documentElement;
            var mouseX = evt.clientX - rect.left - root.scrollLeft;
            var mouseY = evt.clientY - rect.top - root.scrollTop;
            return {
                x:mouseX,
                y:mouseY
            }
        }

        function AI() {
            if (paddle2Y+(paddleHeight/2) < ballY-25) {
                paddle2Y = paddle2Y+5;
            }
            else if (paddle2Y+(paddleHeight/2) > ballY+25) {
                paddle2Y = paddle2Y-5;
            }
        }

        function ballReset() {
            if (score1 == win) {
                winScreen = true;
            }
            if (score2 == win) {
                loseScreen = true;
            }


            ballSpeedX = -ballSpeedX;
            ballX = canvas.width/2;
            ballY = canvas.height/2;
        }

        function draw() {
            //canvas
            rectangle(0,0,canvas.width,canvas.height,'black');

            //net
            for (var i = 0;i < canvas.height;i = i+44){
                rectangle(399,i,2,28,'white');
            }

            //ball
            circle(ballX,ballY,10,'white');

            //left paddle (player)
            rectangle(20,paddle1Y,paddleWidth,paddleHeight,'white');

            //right paddle (AI)
            rectangle(770,paddle2Y,paddleWidth,paddleHeight,'white');

            //score
            canvasContext.fillStyle='white';
            canvasContext.font = '15px Arial';
            canvasContext.fillText(score1,50,50);
            canvasContext.fillText(score2,750,50);

            //you win
            if (winScreen) {
                canvasContext.fillStyle='green';
                canvasContext.font = '30px Arial';
                canvasContext.fillText("Vítězství",340,285);
                canvasContext.font = '20px Arial';
                canvasContext.fillText("Klikněte pro pokračování",290,325);
                return;
            }

            //you lose
            if (loseScreen) {
                canvasContext.fillStyle='red';
                canvasContext.font = '30px Arial';
                canvasContext.fillText("Prohra",355,285);
                canvasContext.font = '20px Arial';
                canvasContext.fillText("Klikněte pro pokračování",290,325);
                return;
            }
        }

        function move() {
            if (winScreen) {
                return;
            }
            if (loseScreen) {
                return;
            }

            AI();

            ballX = ballX+ballSpeedX;
            ballY = ballY+ballSpeedY;


            if (ballX < 10) {
                score2++;
                ballReset();
            }
            if (ballX > canvas.width-10){
                score1++;
                ballReset();
            }

            if (ballX < 45) {
                if (ballY > paddle1Y && ballY < paddle1Y+paddleHeight) {
                    ballSpeedX = -ballSpeedX;

                    var deltaY = ballY-(paddle1Y+paddleHeight/2);
                    ballSpeedY = deltaY*0.3;
                }
            }
            if (ballX > 755) {
                if (ballY > paddle2Y && ballY < paddle2Y+paddleHeight) {
                    ballSpeedX = -ballSpeedX;

                    var deltaY = ballY-(paddle2Y+paddleHeight/2);
                    ballSpeedY = deltaY*0.3;
                }
            }

            if (ballY < 15 || ballY > canvas.height-15){
                ballSpeedY = -ballSpeedY;
            }
        }
    </script>
<?php
exit;
