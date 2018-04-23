<?php

/*

Template Name: Inserisci

*/

?>

<?php

// Aggiorna contatore
$fr = fopen('/home/sampnews24/public_html/contatore.txt', 'a+');
$count = file_get_contents('/home/sampnews24/public_html/contatore.txt');
++$count;
$fr = fopen('/home/sampnews24/public_html/contatore.txt', 'w+');
fwrite($fr, $count);
fclose($fr);
$count = file_get_contents('/home/sampnews24/public_html/contatore.txt');
$id_progressivo = $count;

	//connessione DB
	$host = "185.81.1.79";
	$db_user = "sampnews_user";
	$db_psw = "NEkyJuxvI672";
	$db_name = "sampnews_site";

	$connessione = mysql_connect("$host","$db_user","$db_psw");
	if(!$connessione) { die("Errore critico di Connessione al Database" . mysql_error()); }

	//connessione
	mysql_select_db("$db_name",$connessione);
	$ris_news= mysql_query("SELECT * FROM news WHERE id = $id_progressivo ORDER BY id ASC");
	if (!$ris_news) {
	 	exit ('<p> Errore mentre recuperavo i dati' . mysql_error() . '</p>');
	}

	if (mysql_num_rows($ris_news)== 0) {

		// Log ID non presenti
		$sep = ",";
		$fp = fopen('/home/sampnews24/public_html/log-id.txt', 'a');
		fwrite($fp, $id_progressivo);
		fwrite($fp, $sep);
		fclose($fp);

	} else {
   // loop per stampare i risultati
   while ($news= mysql_fetch_array($ris_news))
   {

	   	echo $news['id'];
	   	echo "<br />";
	   	echo $news['titolo'];
	   	echo "<br />";
	 	echo $news['slug'];
	 	echo "<br />";
	 	echo $news['publicated_at'];
	 	echo "<br />";
	  	echo "<hr />";


	    // Normal filtering
	    remove_filter('title_save_pre', 'wp_filter_kses');
	    remove_filter( 'pre_comment_content', 'wp_filter_post_kses' );
	    remove_filter( 'pre_comment_content', 'wp_filter_kses' );
	    remove_filter('content_save_pre', 'wp_filter_post_kses');
	    remove_filter('excerpt_save_pre', 'wp_filter_post_kses');


	     //struttura del loop visualizzazione si ripeterà n volte
	 	 $titolo = $news['titolo'];
	 	 if(!empty($news['subtitolo'])):
	     $contenuto = "<h2>".$news['subtitolo']."</h2>".$news['testo'];
	 	 else:	    
	 	 $contenuto = $news['testo'];
	 	 endif;
	     //DEBUG echo utf8_encode($contenuto); 

	    //Insert WP
		$my_post = array(
		  'post_title'    => utf8_encode($titolo),
		  'post_content'  =>  utf8_encode($contenuto),
		  'post_name'=> $news['slug'],
		  'guid' => $news['slug'],
		  'post_status'   => 'publish',
		  'post_category' => array(2), //Id categoria
		  'post_author'   => 2,
		  'post_date' => $news['publicated_at']
		);


		// Insert the post into the database
		$post_id = wp_insert_post( $my_post );
		//echo $post_id;


		//Insert image evidenza
		$media_featured =  substr(str_replace("uploads/","", $news['url_immagine']), 1);

		$filename = $media_featured;
		$wp_filetype = wp_check_filetype(basename($filename), null );
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
		set_post_thumbnail( $post_id, $attach_id );
		//Insert image evidenza




 	}//While insert POST

 	};
?>