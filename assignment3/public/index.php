<?php
    require_once('../config/_config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment3</title>
    <link rel = "stylesheet" href = "assignment3.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <header class ="header">
    

        <nav class="navigationbar">
            <img class = "logo" src = "photos/pacmanlogo2.jpg" alt = "logo">
            <a href="index.php" >1D Paku Paku</a>
        </nav>

    </header>

    <h1>Initialize your 1D Paku Paku Game</h1>
    <br>
    <input type="number" id="size" placeholder="Enter the map size">
    <br>
    <button id="make-Map">Make Game Map</button>
    <br>
    <br>
    <h2>Scoreboard:</h2>
  
    <p id="score" class = "scoreboard">0</p>
    <br>
    <h2>Map</h2>
    <br>
    <P id="map" class = "board"></P>
    <br>
    <button id="start">Start the game</button>
    <button id="left">Go left</button>
    <button id="right">Go right</button>

    <div>
        <table>
            <thead>
                <tr>
                    <th>User:</th>
                    <th>score:</th>
                </tr>
            </thead>
            <tbody id="scoreboard">

            </tbody>
            
        </table>
    </div>

    
    <script src="assignemnt3.js"></script>
</body>

</html>