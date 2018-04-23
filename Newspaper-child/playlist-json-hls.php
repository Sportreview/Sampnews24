<?php
/*
Template Name: Playlist JSON HLS
*/
?>
<?php header('Content-Type: application/json'); ?>
{
  "playlist": [
    <?php

    // Include and instantiate the class.
    require_once 'includes/Mobile_Detect.php';
    $detect = new Mobile_Detect;

    // La Query
    $the_query = new WP_Query( array( 'cat' => 39, 'posts_per_page' => 10 ) );

    // Conteggio post per eliminare la virgola all'ultimo elemento
    $last = $the_query->post_count;
    $i = 1;

    // Il Loop
    while ( $the_query->have_posts() ) :
    $the_query->the_post();

    if ($detect->isMobile()) {
      $adtagurl = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/mobile/preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='.mt_rand(10000000000,99999999999).'';
    } else {
      $adtagurl = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/hp/preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='.mt_rand(10000000000,99999999999).'';
    }
    

    $vimeoArr = get_the_content();
      if (strpos($vimeoArr, '[video_samp24 url="') !== false ) {

        //Url
        $vimeoArr = explode('[video_samp24 url="', get_the_content());
        //echo "<p>vimeoArr: ".$vimeoArr[1]."</p>";
        $vimeoArrUrl = explode('"', $vimeoArr[1]);
        //echo "<p>url: ".$vimeoArrUrl[0]."</p>";
        $url = $vimeoArrUrl[0];

        //Image
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'td_696x385' );
        $image = $thumb['0'];

        //Title
        setlocale(LC_ALL, 'it_IT.UTF8');
        $title_raw = iconv('UTF-8', 'ASCII//TRANSLIT', html_entity_decode(get_the_title()) );
        $title = str_replace("\"", "", "$title_raw"); // Rimuove eventuali virgolette

        if ($i !== $last ) {
          $i++;
          ?>
          {
            "bitrates": {
              "hls": "<?php echo $url; ?>"
            },
            "poster": "<?php echo $image; ?>",
            "adTagUrl": "<?php echo $adtagurl; ?>",
            "contentTitle": "<?php echo $title; ?>",
            "contentDescription": ""
          },
          <?php
        } else {
          $i++;
          ?>
          {
            "bitrates": {
              "hls": "<?php echo $url; ?>"
            },
            "poster": "<?php echo $image; ?>",
            "adTagUrl": "<?php echo $adtagurl; ?>",
            "contentTitle": "<?php echo $title; ?>",
            "contentDescription": ""
          }
          <?php
        }

      } else {
        $i++;
        //url vimeo non presente
      }
  
    endwhile;
    wp_reset_query();
    wp_reset_postdata();
    ?>
  ]
}
