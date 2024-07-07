var size;

window.onload = function() {
    reset();
};


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
                        setTimeout(runGame,500);
                        break;
                    case 1:
                        alert("You Win! next level");
                        size=size*2;
                        makeMap(size);
                        $.ajax({
                            type: "get",
                            url: "api.php",
                            data: {action: "nextLevel"},
                            dataType: "json",
                            success: function (response) {
                                
                            }
                        });
                        break;
                    case 2:
                        updateMap(["You Lose!"]);
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
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"goRight"},
        dataType: "json",
        success: function (response) {
            
        }
    });
})


$('#left').click(function(e){
    e.preventDefault;
    $.ajax({
        type: "get",
        url: "api.php",
        data: {action:"goLeft"},
        dataType: "json",
        success: function (response) {
            
        }
    });
})









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