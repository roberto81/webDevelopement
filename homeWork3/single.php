<?php
/*
 * viene incluso una sola volta il file con la prima parte della pagina html che si deve
 * produrre in output
 */
require_once "header.php";
// recupero tutti i dati del ristorante
$dataRest = getAllDataRestourantById();

if (!isset($_GET['rec'])) {
    $rec = 0;
}else{
    $rec = $_GET['rec'];
}
/*
 * include lo script per la generazione del menu in questo caso è solo puro html
 */
include "lib/menu.php";
?>
    <div class="container">
        <div class="row">
            <div class="col-xs-12"><a href="index.php">back</a></div>
        </div>
        <div class="row">
            <h1><?php echo $dataRest['nome']; ?></h1>
        </div>
        <div class="row">
            <div class="col-xs-4 img-padding">
                <img <?php echo 'src="'.getRateImg($dataRest['voto']).'"'; ?> alt="voto"/>
            </div>
            <div class="col-xs-8">
                <p class="p-margin p-color"><?php echo count($dataRest['rev']); ?> review</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3"><p>Cucina</p></div>
            <div class="col-xs-9"><p class="p-margin p-cu-type"> <?php foreach ($dataRest['cucina'] as $cu){echo $cu." ";} ?> </p></div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <img <?php echo 'src="'.getRandomImmage($dataRest['foto']).'"'; ?> class="img-responsive" alt="immagine"/>
            </div>
        </div>
        <?php printRec($dataRest['rev'],$rec); ?>
        <div class="row">
            <div class="col-xs-12"><hr></div>
        </div>
    </div>
<?php
/*
 * viene incluso una sola volta il file con l'ultima parte della pagina html che si deve
 * produrre in output
 */
require_once "footer.php";
?>