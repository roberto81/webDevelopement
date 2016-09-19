<?php
/*
 * viene incluso una sola volta il file con la prima parte della pagina html che si deve
 * produrre in output
 */
require_once "header.php";
/*
 * include lo script per la generazione del menu in questo caso è solo puro html
 */
include "lib/menu.php";
?>
    <div class="container">
            <?php
            /*
            * qui si recuperano tutti i file json contenuti nella cartella data
            */
            $arrRest = glob("data/*.json");

            foreach ($arrRest as $curr) {
                // recupera il contenuto del file json
                $cFile = file_get_contents($curr);

                // il contenuto del file json viene decodificato e assggnato a una
                // struttura dati di tipo array
                $val = json_decode($cFile, true);

                // stampa il nome del ristorante e torna a capo
                //echo $val['nome'] . "<br>";
            ?>
                <div class="row margin-row">
                    <div class="col-xs-4">
                        <img <?php echo 'src="'.$val['thumb'].'"'; ?> class="img-responsive" alt="thumb"/>
                    </div>
                    <div class="col-xs-8">
                        <div class="row">
                            <div class="col-xs-12">
                                <a <?php echo 'href="index.php?id='.$val['id'].'"'; ?> class="a-rest-title"> <?php echo $val['nome']; ?></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <img <?php echo 'src="'.getRateImg($val['voto']).'"'; ?> class="media-object" alt="voto"/>
                            </div>
                            <div class="col-xs-6">
                                <p class="p-margin p-color"><?php echo count($val['rev']); ?> review</p>
                            </div>
                        </div>
                        <?php printRandomRec($val['rev'],$val['cucina'],$val['id']); ?>
                    </div>
                </div>
            <?php
            }
            ?>
    </div>

<?php
/*
 * viene incluso una sola volta il file con l'ultima parte della pagina html che si deve
 * produrre in output
 */
require_once "footer.php";
?>