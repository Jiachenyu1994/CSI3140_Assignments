
// getter

// makeMap button function
$(document).ready(function(){
    $('#make-Map').click(function (e) { 
        e.preventDefault();
        var size= $('#size').val();
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
                }
                
            }
        });
        
    });
})

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