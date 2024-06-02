
var map=[];
var Cdir=0;
var Gdir=0;
var Clocation=0;
var Glocation=0;
var size=0;
var finish=99;
var power=0;
var score=0;

document.addEventListener('keydown', control);

function makeMap(){
    score=0;
    size = document.getElementById("randomN").value;
    randomN(size);   
}

function randomN(size){
    map=[];
    if (size==''){
        alert("Please enter a map size");
        return false;
    };
    if(size<3){
        alert("please enter a number larger than 3");
        return false;
    };

    for(i=0;i<size;i++){
        if(i==Math.floor(size/3)){
            map.push("C");
            Clocation=i;
        }else if(i==Math.floor(size/2)){
            map.push("@");
        }else if(i==size-1){
            map.push("^.");
            Glocation=i;
        }else{
            map.push(".");
        }
    }
    
    updateMap(map);
    
}

function init(){
    Cdir=0;
    Gdir=0;
    Clocation=0;
    Glocation=0;
    finish=0;
    power=0;
    randomN(size);
}

function start(){
    init();
    run();
}

function run(){
    
    updateScore();
    if(finish==1){
        updateMap("You Lose!");
        
    }else if(finish==2){
        alert("You Win! Next Level");
        setTimeout(1000);
        size=size*2;
        randomN(size);
    }else if(remainPellets()==false){
        alert("You Win! Next Level");
        size=size*2;
        randomN(size);
    }else{
        Cmove();
        if(finish==0){
            moveGhost();
        }
        setTimeout(run,500);
    }
}

function moveGhost(){
    // decide Ghost dir
    for (i=0;i<map.length;i++){
        elem=map[i];
        if(elem=="^."||elem=="^"){
            Gdir=1;
            break;
        }else if(elem=="."||elem=="@"||elem==" "){
            
        }else{
            Gdir=0;
            break;
        }
    }
    if(Gdir==1){
        gohostRight();
    }else{
        gohostleft();
    }
}

function gohostleft(){
    if(map[Glocation]=="^."){
        map[Glocation]=".";
    }else if(map[Glocation]=="^"){
        map[Glocation]=" ";
    }else{
        map[Glocation]="@";
    }
    nextLocation=Glocation-1;
    if(nextLocation<=0){
        nextLocation=size-1;
    }
    switch (map[nextLocation]){
        case ".":
            map[nextLocation]="^.";
            break;
        case " ":
            map[nextLocation]="^";
            break;
        case "@":
            map[nextLocation]="^@";
            break;
        default:
            map[nextLocation]="^";
            finish=1; 
               
    }
    Glocation=nextLocation;
    
    updateMap(map);
}

function gohostRight(){
    if(map[Glocation]=="^."){
        map[Glocation]=".";
    }else if(map[Glocation]=="^"){
        map[Glocation]=" ";
    }else{
        map[Glocation]="@";
    }
    nextLocation=Glocation+1;
    if(nextLocation>=size){
        nextLocation=0;
    }
    switch (map[nextLocation]){
        case ".":
            map[nextLocation]="^.";
            break;
        case " ":
            map[nextLocation]="^";
            break;
        case "@":
            map[nextLocation]="^@";
            break;
        default:
            map[nextLocation]="^";
            finish=1;
               
    }
    Glocation=nextLocation;
    
    updateMap(map);
}

function Cmove(){
    if(Cdir==1){
        cRight();
    }else{
        cLeft();
    }
}

function cRight(){
    map[Clocation]=" ";
    nextLocation=Clocation+1
    if(nextLocation>=size){
        nextLocation=0;
    }
    switch (map[nextLocation]){
        case ".":
            score++;
            map[nextLocation]="C.";
            break;
        case " ":
            map[nextLocation]="C";
            break;
        case "@":
            score=score+10;
            map[nextLocation]="C@";
            power=1;
            break;
        default:
            if(power==0){
                map[nextLocation]="^";
                finish=1;
                
            }
            if(power==1){
                score=score+20;
                map[nextLocation]="C";
                finish=2;
                
            }          
    }
    Clocation=nextLocation;
    updateMap(map);
    
}

function cLeft(){
    map[Clocation]=" ";
    nextLocation=Clocation-1
    if(nextLocation<0){
        nextLocation=size-1;
    }
   
    switch (map[nextLocation]){
        case ".":
            score++;
            map[nextLocation]="C.";
            break;
        case " ":
            map[nextLocation]="C";
            break;
        case "@":
            score=score+10;
            map[nextLocation]="C@";
            power=1;
        default:
            if(power==0){
                map[nextLocation]="^";
                finish=1;
                
            }
            if(power==1){
                score=score+20;
                map[nextLocation]="C";
                finish=2;
                
            }          
    }
    Clocation=nextLocation;
    updateMap(map);
}

function right(){
    Cdir=1;
}
function left(){
    Cdir=0;
}

function updateMap(newMap){
    printedMap=document.getElementById("map");
    printedMap.textContent=newMap;
}

function updateScore(){
    printedMap=document.getElementById("score");
    printedMap.textContent=score;
}

function remainPellets(){
    result=false;
    
    for(i=0;i<map.length;i++){
        if (map[i]=="."){
            result=true;
            break;
        }
    }
    return result;
}

function control(event) {
    switch(event.key) {
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