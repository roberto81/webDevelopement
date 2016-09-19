<?php
/*
 * FILE index.php
 * Location: /
 * Description: Questo script permette la creazione delle pagine
 *             richieste analizzando la query string presente nella
 *             url.
 */

// questo script ci permette di abilitare gli errori
// commentare quando viene terminata la fase di sviluppo
require_once "lib/error_enable.php";
// include lo script con le funzioni di utilità generale
require_once "lib/utility.php";



/*
 * Se nella url non è definito alcun parametro viene incluso il file main.php
 */
if (!isset($_GET['id'])){
    require_once "main.php";
}


/*
 * se nella url è stato definito il parametro id e non il parametro rec allora viene incluso il file
 * single.php che si deve occupare di mostrare le informazioni di un certo ristorante
 */


if(!empty($_GET['id'])){
    $paths = "data/*.json";
    $content_path = glob($paths);
    
    for($i=0;$i<count($content_path);$i++) {
        $esito = preg_match("/".$_GET['id']."/", $content_path[$i], $out);
        if($esito == 1){
            break;
        }
    }
    
    if($esito == 0){
        require_once "lib/error.php";
    }else {
        require_once "single.php";
    }
}
?>