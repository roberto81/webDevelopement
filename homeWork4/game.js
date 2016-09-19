"use strict";

/*
    nome: removeAllPuzzle
    input: none
    output: none
 */
function removeAllPuzzle() {

    var gameBox = document.getElementById('game');
    while(gameBox.hasChildNodes()){
        gameBox.removeChild(gameBox.firstChild);
    }

}

/*
    nome: getBlankPuzzle
    input: lo schema corrente
    output: un array dove il primo elemento identifica l'indice di riga
            e il secondo l'indice di colonna
 */
function getBlankPuzzle(schema) {
    var row;
    var col;
    for(var i = 0; i < 4; i++){
        col = schema[i].indexOf(16);
        row = i;
        if(col != -1){
            break;
        }
    }
    return [row,col];
}
/*
    nome: showBanner
    input: una variabile booleana che identifica lo stato dello schema risolto/non risolto
    output: la funzione non restituisce alcun valore
 */
function showBanner(stato) {
    if(stato){
        var t = document.getElementById('game');
        var o = document.createElement('div');
        o.className='banner';
        o.innerHTML = "BRAVO HAI VINTO..!!!";
        t.appendChild(o);
    }else{
        var child = document.getElementsByClassName('banner');
        child.remove;
    }
}

/*
    nome: checkResult
    input: schema
    output: true o false;
 */
function checkResult(schema) {
    var winschema = [[1,2,3,4],[5,6,7,8],[9,10,11,12],[13,14,15,16]];
    for(var i = 0; i < 4; i++){
        for(var j = 0; j < 4; j++){
            if(schema[i][j] != winschema[i][j]){
                return false;
            }
        }
    }
    return true;
}

/*
    nome: randBackGround
    input: none
    output: una stringa che identifica il nome del file di background selezionato in modo random
 */
function randBackGround() {
    var bg =["bg1.jpg","bg2.png","bg4.jpg"];
    var randbg = Math.floor(Math.random()*3);
    return "url('" + bg[randbg] + "')";
}

/*
    nome: shuffle
    input: none
    output: un array per codificare lo schema iniziale
 */
function shuffle() {
    
    var position = [[1,2,3,4],[5,6,7,8],[9,10,11,12],[13,14,15,16]];
    var blankPos = {row:3,col:3};
    var tmp;
    var step = 0;
    var randstep;
    
    while (step <= 1000){
        
        // genera un numero da 1 a 4 per simulare la mossa scelta
        randstep = Math.floor((Math.random()*4) + 1);
        
        // mossa a sinistra
        if(randstep == 1 && blankPos.col > 0){

            tmp = position[blankPos.row][blankPos.col-1];
            position[blankPos.row][blankPos.col] = tmp;
            position[blankPos.row][blankPos.col-1] = 16;
            blankPos.col = blankPos.col-1;
            
        }
        // mossa in alto
        if(randstep == 2 && blankPos.row > 0){

            tmp = position[blankPos.row-1][blankPos.col];
            position[blankPos.row][blankPos.col] = tmp;
            position[blankPos.row-1][blankPos.col] = 16;
            blankPos.row = blankPos.row-1;

        }
        
        // mossa a destra
        if(randstep == 3 && blankPos.col < 3){
            tmp = position[blankPos.row][blankPos.col+1];
            position[blankPos.row][blankPos.col] = tmp;
            position[blankPos.row][blankPos.col+1] = 16;
            blankPos.col = blankPos.col+1;
            
        }
        
        // mossa in basso
        if(randstep == 4 && blankPos.row < 3){
            tmp = position[blankPos.row+1][blankPos.col];
            position[blankPos.row][blankPos.col] = tmp;
            position[blankPos.row+1][blankPos.col] = 16;
            blankPos.row = blankPos.row+1;
        }
        
        step += 1;
        
    }
    
    return position;
    
}

/*
    name: drawSchema
    input: uno schema da disegnare
    output: none
 */
function drawSchema(schemas,bg,score) {
    var background;
    document.getElementsByTagName('span')[0].innerHTML=score;
    // recupero il div che fa da container al gioco
    var gameContainer = document.getElementById('game');
    var cella;
    if(bg == null) {
        background = randBackGround();
    }else{
        background = bg;
    }
    
    for(var i = 0; i < 4; i++){
        for(var j = 0; j < 4; j++){
            
            cella = document.createElement('div');
            cella.classList.add('tstyle',"tnum"+schemas[i][j]);
            if(schemas[i][j] != 16){
                cella.style.backgroundImage = background;
                cella.innerHTML= "" + schemas[i][j];
            }

            cella.setAttribute('id',schemas[i][j]);
            gameContainer.appendChild(cella);
            
        }
    }
    //return background;
}

/*
    nome: playGame
    input: none
    output: none
*/
function playGame() {
    var randSchema = shuffle();
    removeAllPuzzle();
    document.getElementsByTagName('span')[0].innerHTML=0;
    var score = document.getElementsByTagName('span')[0].innerHTML;
    score = parseInt(score);
    drawSchema(randSchema,null,score);
    var blankPuzzle = getBlankPuzzle(randSchema);
    setPuzzleListner(blankPuzzle,randSchema);
}

function move(pressPuzzle,blankPuzzle,schema) {
    var press = schema[pressPuzzle[0]][pressPuzzle[1]];
    schema[pressPuzzle[0]][pressPuzzle[1]] = schema[blankPuzzle[0]][blankPuzzle[1]];
    schema[blankPuzzle[0]][blankPuzzle[1]] = press;
    return schema;
}

/*
 nome: setPuzzleListner
 input: la posizione blank dello schema e lo schema
 output: none
 Description: aggiunge i vari listener agli elementi adiacenti alla cella blank
 */
function setPuzzleListner(blankposition,schema) {

    if(blankposition[1] > 0){
        var puzzle1;
        console.log("sinistro:" + schema[blankposition[0]][blankposition[1]-1]);
        puzzle1 = document.getElementById(''+schema[blankposition[0]][blankposition[1]-1]);

        puzzle1.addEventListener("mouseover",function () {
            puzzle1.className += " overtstyle";
        });

        puzzle1.addEventListener("mouseout",function () {
            puzzle1.classList.remove("overtstyle");
        });

        puzzle1.addEventListener("click",function () {
            var newSchema;
            var bg = document.getElementById('1').style.backgroundImage;
            newSchema = move([blankposition[0],blankposition[1]],[blankposition[0],blankposition[1]-1],schema);
            removeAllPuzzle();
            var score =document.getElementsByTagName('span')[0].innerHTML;
            score = 1+parseInt(score);
            drawSchema(newSchema,bg,score);
            setPuzzleListner(getBlankPuzzle(newSchema),newSchema);
            showBanner(checkResult(newSchema));
            console.log("sinistro premuto");
        })
    }

    if(blankposition[0] > 0){
        var puzzle2;
        console.log("sopra:" + schema[blankposition[0]-1][blankposition[1]]);
        puzzle2 = document.getElementById(''+schema[blankposition[0]-1][blankposition[1]]);

        puzzle2.addEventListener("mouseover",function () {
            puzzle2.className += " overtstyle";
        });
        puzzle2.addEventListener("mouseout",function () {
            puzzle2.classList.remove("overtstyle");
        });

        puzzle2.addEventListener("click",function () {
            var newSchema;
            var bg = document.getElementById('1').style.backgroundImage;
            newSchema = move([blankposition[0],blankposition[1]],[blankposition[0]-1,blankposition[1]],schema);
            removeAllPuzzle();
            var score =document.getElementsByTagName('span')[0].innerHTML;
            score = 1+parseInt(score);
            drawSchema(newSchema,bg,score);
            setPuzzleListner(getBlankPuzzle(newSchema),newSchema);
            showBanner(checkResult(newSchema));
            console.log("sopra premuto");
        })
    }

    if(blankposition[1] < 3){
        var puzzle3;
        console.log("destra:" + schema[blankposition[0]][blankposition[1]+1]);
        puzzle3 = document.getElementById(''+schema[blankposition[0]][blankposition[1]+1]);

        puzzle3.addEventListener("mouseover",function () {
            puzzle3.className += " overtstyle";
        });
        puzzle3.addEventListener("mouseout",function () {
            puzzle3.classList.remove("overtstyle");
        });

        puzzle3.addEventListener("click",function () {
            var newSchema;
            var bg = document.getElementById('1').style.backgroundImage;
            newSchema = move([blankposition[0],blankposition[1]],[blankposition[0],blankposition[1]+1],schema);
            removeAllPuzzle();
            var score =document.getElementsByTagName('span')[0].innerHTML;
            score = 1+parseInt(score);
            drawSchema(newSchema,bg,score);
            setPuzzleListner(getBlankPuzzle(newSchema),newSchema);
            showBanner(checkResult(newSchema));
            console.log("destra premuto");
        })
    }

    if(blankposition[0] < 3){
        var puzzle4;
        console.log("sotto:" + schema[blankposition[0]+1][blankposition[1]]);
        puzzle4 = document.getElementById(''+schema[blankposition[0]+1][blankposition[1]]);

        puzzle4.addEventListener("mouseover",function () {
            puzzle4.className += " overtstyle";
        });
        puzzle4.addEventListener("mouseout",function () {
            puzzle4.classList.remove("overtstyle");
        });

        puzzle4.addEventListener("click",function () {
            var newSchema;
            var bg = document.getElementById('1').style.backgroundImage;
            newSchema = move([blankposition[0],blankposition[1]],[blankposition[0]+1,blankposition[1]],schema);
            removeAllPuzzle();
            var score =document.getElementsByTagName('span')[0].innerHTML;
            score = 1+parseInt(score);
            drawSchema(newSchema,bg,score);
            setPuzzleListner(getBlankPuzzle(newSchema),newSchema);
            showBanner(checkResult(newSchema));
            
            console.log("sotto premuto");
        })
    }
}

/*
  codice eseguito una volta che la pagina viene caricata
*/
window.onload = function startGame() {
    var schema =[[1,2,3,4],[5,6,7,8],[9,10,11,12],[13,14,15,16]];
    document.getElementsByTagName('span')[0].innerHTML=0;
    var score = document.getElementsByTagName('span')[0].innerHTML;
    score = parseInt(score);
    // disegna lo schema
    drawSchema(schema,null,score);
    document.getElementsByTagName('span')[0].innerHTML=0;
    // verifica se lo schema è risolto
    showBanner(checkResult(schema));
    //aggiunge i listner per l'elemento controls
    var btnNew = document.getElementsByTagName('button')[0];
    btnNew.addEventListener('click',playGame);
};

