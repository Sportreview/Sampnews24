<?php

/*

Template Name: Playlist Feed

*/

?>

<?php //wp_head(); ?>
<?php
header('Content-Type: text/xml');
?>

<?php
$myfile = fopen("playlist_feed.rss", "w") or die("Unable to open file!");
?> 


<?php $txt = '<rss version="2.0" xmlns:jwplayer="http://rss.jwpcdn.com/">'; ?>
<?php $txt .= '<channel>'; ?>

<?php

// The Query
$the_query = new WP_Query(  array( 'cat' => 36 )  );

// The Loop
	
	while ( $the_query->have_posts() ) {
		$the_query->the_post();


		//Titolo
		$title =  get_the_title();
		
		//Url
		$vimeoArr = explode('[video_samp24 url="', get_the_content());
		$vimeoArr_temp = explode('"]', $vimeoArr[1]);
		$url = $vimeoArr_temp[0];

		//Image
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'tds_thumb_td_696x385' );
		$image = $thumb['0']; 
		
		//print_r($image);
		//wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		//$image = get_the_post_thumbnail_url( 'thumbnail' );

?>

  	<?php $txt .= '<item>'; ?>
    <?php $txt .= '<title> '. $title.'</title>'; ?>
    <?php $txt .= '<jwplayer:image>'. $image.'</jwplayer:image>'; ?>
    <?php $txt .= '<jwplayer:source file="'. $url.'" />'; ?>
    <?php $txt .= '</item>'; ?>

  <?php

	}
	
	/* Restore original Post Data */
	wp_reset_postdata();

	?>

<?php 
 $txt .= '</channel>';
 $txt .= '</rss>';
?>

<?php 
echo "<h1>Feed Generato nella root del sito</h1>";
fwrite($myfile, $txt);
fclose($myfile);
?>




<?php //wp_footer(); ?>

