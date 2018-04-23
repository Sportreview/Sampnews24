<?php

/*

Template Name: Counter

*/

?>

<?php

// Aggiorna contatore
$fr = fopen('/home/calcionews24/public_html/contatore3.txt', 'a+');
$count = file_get_contents('/home/calcionews24/public_html/contatore3.txt');
$count--;
$fr = fopen('/home/calcionews24/public_html/contatore3.txt', 'w+');
fwrite($fr, $count);
fclose($fr);
$count = file_get_contents('/home/calcionews24/public_html/contatore3.txt');
$id_progressivo = $count;

echo "<p>id progressivo: </p>" . $id_progressivo;

?>