var map = [];
var Cdir = 0;
var Gdir = 0;
var Clocation = 0;
var Glocation = 0;
var size = 0;
var finish = 99;
var power = 0;
var score = 0;

document.addEventListener('keydown', control);

function makeMap() {
    score = 0;
    size = document.getElementById("randomN").value;
    randomN(size);   
}

function randomN(size) {
    map = [];
    if (size == '') {
        alert("Please enter a map size");
        return false;
    }
    if (size < 3) {
        alert("please enter a number larger than 3");
        return false;
    }

    for (i = 0; i < size; i++) {
        if (i == Math.floor(size / 3)) {
            map.push("C");
            Clocation = i;
        } else if (i == Math.floor(size / 2)) {
            map.push("@");
        } else if (i == size - 1) {
            map.push("^.");
            Glocation = i;
        } else {
            map.push(".");
        }
    }

    updateMap(map);
}

function init() {
    Cdir = 0;
    Gdir = 0;
    Clocation = 0;
    Glocation = 0;
    finish = 0;
    power = 0;
    randomN(size);
}

function start() {
    init();
    run();
}

function run() {
    updateScore();
    if (finish == 1) {
        updateMap(["You Lose!"]);
    } else if (finish == 2) {
        alert("You Win! Next Level");
        setTimeout(1000);
        size = size * 2;
        randomN(size);
    } else if (remainPellets() == false) {
        alert("You Win! Next Level");
        size = size * 2;
        randomN(size);
    } else {
        Cmove();
        if (finish == 0) {
            moveGhost();
        }
        setTimeout(run, 500);
    }
}

function moveGhost() {
    for (i = 0; i < map.length; i++) {
        var elem = map[i];
        if (elem == "^." || elem == "^") {
            Gdir = 1;
            break;
        } else if (elem == "." || elem == "@" || elem == " ") {
            // Do nothing
        } else {
            Gdir = 0;
            break;
        }
    }
    if (Gdir == 1) {
        gohostRight();
    } else {
        gohostleft();
    }
}

function gohostleft() {
    if (map[Glocation] == "^.") {
        map[Glocation] = ".";
    } else if (map[Glocation] == "^") {
        map[Glocation] = " ";
    } else {
        map[Glocation] = "@";
    }
    var nextLocation = Glocation - 1;
    if (nextLocation <= 0) {
        nextLocation = size - 1;
    }
    switch (map[nextLocation]) {
        case ".":
            map[nextLocation] = "^.";
            break;
        case " ":
            map[nextLocation] = "^";
            break;
        case "@":
            map[nextLocation] = "^@";
            break;
        default:
            map[nextLocation] = "^";
            finish = 1; 
    }
    Glocation = nextLocation;

    updateMap(map);
}

function gohostRight() {
    if (map[Glocation] == "^.") {
        map[Glocation] = ".";
    } else if (map[Glocation] == "^") {
        map[Glocation] = " ";
    } else {
        map[Glocation] = "@";
    }
    var nextLocation = Glocation + 1;
    if (nextLocation >= size) {
        nextLocation = 0;
    }
    switch (map[nextLocation]) {
        case ".":
            map[nextLocation] = "^.";
            break;
        case " ":
            map[nextLocation] = "^";
            break;
        case "@":
            map[nextLocation] = "^@";
            break;
        default:
            map[nextLocation] = "^";
            finish = 1;
    }
    Glocation = nextLocation;

    updateMap(map);
}

function Cmove() {
    if (Cdir == 1) {
        cRight();
    } else {
        cLeft();
    }
}

function cRight() {
    map[Clocation] = " ";
    var nextLocation = Clocation + 1;
    if (nextLocation >= size) {
        nextLocation = 0;
    }
    switch (map[nextLocation]) {
        case ".":
            score++;
            map[nextLocation] = "C.";
            break;
        case " ":
            map[nextLocation] = "C";
            break;
        case "@":
            score += 10;
            map[nextLocation] = "C@";
            power = 1;
            break;
        default:
            if (power == 0) {
                map[nextLocation] = "^";
                finish = 1;
            }
            if (power == 1) {
                score += 20;
                map[nextLocation] = "C";
                finish = 2;
            }
    }
    Clocation = nextLocation;
    updateMap(map);
}

function cLeft() {
    map[Clocation] = " ";
    var nextLocation = Clocation - 1;
    if (nextLocation < 0) {
        nextLocation = size - 1;
    }
    switch (map[nextLocation]) {
        case ".":
            score++;
            map[nextLocation] = "C.";
            break;
        case " ":
            map[nextLocation] = "C";
            break;
        case "@":
            score += 10;
            map[nextLocation] = "C@";
            power = 1;
        default:
            if (power == 0) {
                map[nextLocation] = "^";
                finish = 1;
            }
            if (power == 1) {
                score += 20;
                map[nextLocation] = "C";
                finish = 2;
            }
    }
    Clocation = nextLocation;
    updateMap(map);
}

function right() {
    Cdir = 1;
}

function left() {
    Cdir = 0;
}

function updateMap(newMap) {
    var printedMap = document.getElementById("map");
    printedMap.innerHTML = ''; // Clear the previous map

    newMap.forEach(function(cell) {
        var cellDiv = document.createElement('div');
        cellDiv.className = 'game-cell';

        var img = document.createElement('img');

        switch(cell) {
            case 'C':
                img.src = 'photos/pacman.jpg';
                break;
            case 'C.':
                img.src = 'photos/pacman.jpg';
                break;
            case '^.':
                img.src = 'photos/ghost.jpg';
                break;
            case '^@':
                img.src = 'photos/ghost.jpg';
                break;  
            case '^':
                img.src = 'photos/ghost.jpg';
                break;
            case '@':
                img.src = 'photos/fruit.jpg';
                break;  
            case '.':
                img.src = 'photos/pellet.jpg';
                break;
            default:
                img.src = 'photos/blank.jpg'; // empty cell
        }

        cellDiv.appendChild(img);
        printedMap.appendChild(cellDiv);
    });
}

function updateScore() {
    var scoreDiv = document.getElementById("score");
    scoreDiv.textContent = "Score: " + score;
}

function remainPellets() {
    var result = false;
    for (i = 0; i < map.length; i++) {
        if (map[i] == ".") {
            result = true;
            break;
        }
    }
    return result;
}

function control(event) {
    switch (event.key) {
        case 'ArrowLeft':
            left();
            break;
        case 'ArrowRight':
            right();
            break;
        default:
            return;
    }
}
