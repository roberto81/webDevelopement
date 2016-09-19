<?php
/**
 * Created by PhpStorm.
 * User: roberto
 * Date: 03/05/16
 * Time: 10:24
 */

function getAllDataRestourantById(){

    $id = $_GET['id'];
    $path = "data/r".$id.".json";

    $cFile = file_get_contents($path);

    if ($cFile == false){
        return false;
    }

    // il contenuto del file json viene decodificato e assggnato a una
    // struttura dati di tipo array
    $val = json_decode($cFile,true);

    return $val;
}

function getRestourantById(){
    
    $id = $_GET['id'];
    $path = "data/r".$id.".json";
    
    $cFile = file_get_contents($path);
    
    if ($cFile == false){
        return false;
    }
    
    // il contenuto del file json viene decodificato e vine restituito
    // il nome del ristorante
    $val = json_decode($cFile,true);
    
    return $val['nome'];
}

function getTitlePage(){
    
    // se il parametro id non è definito allora la pagina sarà la main e quindi
    // avrà un title specifico
    if (empty($_GET['id'])){
        return "Ristorati ­ Main Page";
    }
    
    // se il parametro id è definito allora dobbiamo recuperare il nome del ristorante
    // identificato con quello specifico id
    return getRestourantById();
    
}

/*
 * questa funzione ci permette di recuperare la giusta immagine per il voto assegnato al ristorante
 */
function getRateImg($rate){
    
    $data = "";
    
    switch ($rate){
        case 0:
            $data = "img/rate-00.png";
            break;
        case 0.5:
            $data = "img/rate-05.png";
            break;
        case 1:
            $data = "img/rate-10.png";
            break;
        case 1.5:
            $data = "img/rate-15.png";
            break;
        case 2:
            $data = "img/rate-20.png";
            break;
        case 2.5:
            $data = "img/rate-25.png";
            break;
        case 3:
            $data = "img/rate-30.png";
            break;
        case 3.5:
            $data = "img/rate-35.png";
            break;
        case 4:
            $data = "img/rate-40.png";
            break;
        case 4.5:
            $data = "img/rate-45.png";
            break;
        case 5:
            $data = "img/rate-50.png";
            break;
    }
    
    return $data;
    
}
/*
 * questa funzione ci permette di selezionare due recenzioni tra quelle esistenti in modo random
 */
function printRandomRec($arrRec,$arrCucina,$id){

    $nrec = count($arrRec);

    if ($nrec == 1){
    ?>
        <div class="row">
            <div class="col-xs-8"><a <?php echo 'href="index.php?id='.$id.'"';?>> <?php echo  key($arrRec[0]); ?></a></div>
            <div class="col-xs-4"><p class="p-margin"> <?php echo $arrRec[0]; ?></p></div>
        </div>
    <?php
    }
    if ($nrec == 2) {
        ?>
        <div class="row">
            <div class="col-xs-8"><a <?php echo 'href="index.php?id='.$id.'"';?>> <?php echo  key($arrRec[0]); ?></a></div>
            <div class="col-xs-4"><p class="p-margin"> <?php echo $arrRec[0]; ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-8"><a <?php echo 'href="index.php?id='.$id.'"';?>> <?php echo  key($arrRec[1]); ?></a></div>
            <div class="col-xs-4"><p class="p-margin"> <?php echo $arrRec[1]; ?></p></div>
        </div>
        <?php
    }
    if ($nrec > 2){
        $rec_one=null;
        $rec_two=null;
        
        srand(time());
        
        while ((!isset($rec_one) && !isset($rec_two)) || !($rec_one != $rec_two)) {
            $rec_one = rand(0, ($nrec - 1));
            $rec_two = rand(0, ($nrec - 1));
        }
        
        $key_one = key($arrRec[$rec_one]);
        $key_two = key($arrRec[$rec_two]);
    ?>
        <div class="row">
            <div class="col-xs-8"><a <?php echo 'href="index.php?id='.$id.'&rec='.$rec_one.'"';?>> <?php echo  $arrRec[$rec_one]['titolo']; ?></a></div>
            <div class="col-xs-4"><p class="p-margin"> <?php echo $arrRec[$rec_one]['data']; ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-8"><a <?php echo 'href="index.php?id='.$id.'&rec='.$rec_two.'"';?>> <?php echo  $arrRec[$rec_two]['titolo']; ?></a></div>
            <div class="col-xs-4"><p class="p-margin"> <?php echo $arrRec[$rec_two]['data']; ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-3">Cucina:</div>
            <div class="col-xs-9"><p class="p-margin p-cu-type"> <?php foreach ($arrCucina as $cu){echo $cu." ";} ?> </p> </div>
        </div>
    <?php
    }
}

function getRandomImmage($imgArr){
    $ind = array_rand($imgArr,1);
    return $imgArr[$ind];
}

function printRec($arrRec,$getrec){
    
    $recdim = count($arrRec)-1;
    if ($getrec + 5 <= $recdim){
        $end = $getrec+4;
    }else{
        $end = $recdim;
    }
    
    for ($i = $getrec; $i <= $end; $i++){
?>
        <div class="row"><div class="col-xs-12"><hr></div></div>
        <div class="row">
            <div class="col-xs-12">
                <h5> "<?php echo  $arrRec[$i]['titolo']; ?>" </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <img <?php echo 'src="'.getRateImg($arrRec[$i]['voto']).'"'; ?> class="img-responsive" alt="thumb"/>
            </div>
            <div class="col-xs-8"> <p> <?php echo  $arrRec[$i]['data']; ?> </p> </div>
        </div>
        <div class="row">
            <div class="col-xs-12"> <p><?php echo  $arrRec[$i]['user']; ?></p></div>
        </div>
        <div class="row">
            <div class="col-xs-12"> <p class="note"><?php echo  $arrRec[$i]['note']; ?></p></div>
        </div>

<?php
    }
}
?>