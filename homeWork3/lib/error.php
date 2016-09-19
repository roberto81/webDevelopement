<html>
<head>
    <title>NOT FOUND.</title>
</head>
<h1>Errore.</h1>
<h3>Il ristorante con id <?php echo $_GET['id']; ?> non esiste</h3>
<h4>Tra 4 secondi sarete rediretti ad un ristorante scelto da noi.</h4>
</html>

<?php
/*
 * con questo codice andiamo a recuperare un file json in modo random e presentiamo
 * all'utente questo ristorante con un refresh di pagina.
 */
$paths = "data/*.json";
$content_path = glob($paths);
$rand_ind = array_rand($content_path,1);
preg_match("/[0-9]+/",$content_path[$rand_ind],$out);
$url = "Refresh: 4; URL=index.php?id=".$out[0];
header($url);
?>
