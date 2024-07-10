var size;

var userId;

window.onload = function() {
    reset();
    updateScoreBoard()
    userId = prompt("Please enter your name:", "Your Name");
};

// button for new player
$('#newPlayer').click(function(e){
    location.reload();
})


document.addEventListener('keydown', control);


function reset(){
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"reset"},
        dataType: "json",
        success: function (response) {
           
        }
    });
}



// makeMap button function
$(document).ready(function(){
    $('#make-Map').click(function (e) { 
        $('#make-map').prop('disabled', true);
        e.preventDefault();
        size= $('#size').val();
        makeMap(size);
        
    });
})


function makeMap(size){
    $.ajax({
        type: "get",
        url: "api.php",
        data: { action: "makeMap", size: size },
        dataType: "json",
        success: function (response) {
            if(response.error){
                alert(response.error);
            }else{
                updateMap(response.map);
                $('#make-map').prop('disabled', true);
                console.log("yes");
            }
            
        }
    });
}


$('#start').click(function (e) {
    e.preventDefault;
    runGame();
    // $('#start').prop('disable',true);
    
  })


// ajax all for keep running game
function runGame(){
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"runGame"},
        dataType: "json",
        success: function (response) {
            if(response.error){
                alert(response.error);
            }else{
                
                updateScore(response.score);
                updateMap(response.map);
                
                switch(response.status){
                    case 0 :
                        console.log("Repeating runGame");
                        console.log(response.map);
                        setTimeout(runGame,100);
                        break;
                    case 1:
                        alert("You Win! next level");
                        size=size*2;
                        $.ajax({
                            type: "get",
                            url: "api.php",
                            data: {action: "nextLevel", size:size},
                            dataType: "json",
                            success: function (response) {
                                updateMap(response.map);
                            }
                        });
                        
                        break;
                    case 2:
                        updateMap(["You Lose!"]);
                        recorder();
                        updateScoreBoard();
                        reset();
                        break;
                }
            }
        }
    });
}

// button right make pacman go right

$('#right').click(function(e){
    e.preventDefault;
    goRight();  
})

function goRight(){
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"goRight"},
        dataType: "json",
        success: function (response) {
            
        }
    });
}


$('#left').click(function(e){
    e.preventDefault;
    goLeft();
})




function goLeft(){
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"goLeft"},
        dataType: "json",
        success: function (response) {
            
        }
    });
}

function recorder(){
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action: "record", id:userId},
        dataType: "json",
        success: function (response) {
            console.log("Record successed")
        }
    });
}







// function for displaying game
function updateMap(newMap){

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
            case "You Lose!":
                img.src='photos/lose.jpg';
                break;
            default:
                img.src = 'photos/blank.jpg'; // empty cell
        }

        cellDiv.appendChild(img);
        printedMap.appendChild(cellDiv);
    });
}

// update score
function updateScore(score) {
    var scoreDiv = document.getElementById("score");
    scoreDiv.textContent = "Score: " + score;
}

// update scoreboard
function updateScoreBoard(){
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"read"},
        dataType: "json",
        success: function (response) {
            console.log(response);
            var dataArray = Object.keys(response).map(function(key) {
                return { user: key, score: response[key] };
            });
            dataArray.sort(function(a, b) {
                return b.score - a.score;
            });
            // console.log(dataArray);
            $('#scoreboard').empty();
            if(dataArray.length>=10){
                for(var i=0;i<10;i++){
                    var newRow = $('<tr>');
                    var rank=$('<td>', {
                        text: i+1
                    });
                    var rowUser = $('<td>', {
                        text: dataArray[i].user
                    });
                    var rowScore = $('<td>', {
                        text: dataArray[i].score
                    });
                    newRow.append(rank,rowUser, rowScore);
                    $('#scoreboard').append(newRow);
                }
            }else{
                var counter=1;
                dataArray.forEach(function(item) {
                    
                    var newRow = $('<tr>');
                    var rank=$('<td>', {
                        text: counter
                    });
                    var rowUser = $('<td>', {
                        text: item.user
                    });
                    var rowScore = $('<td>', {
                        text: item.score
                    });
                    counter++;
                    newRow.append(rank,rowUser, rowScore);
                    $('#scoreboard').append(newRow);
                });
    
            }
            
        }
    });
}



function control(event) {
    switch (event.key) {
        case 'ArrowLeft':
            goLeft();
            break;
        case 'ArrowRight':
            goRight();
            break;
        case "enter":
            runGame();
            break;
        default:
            return;
    }
}



