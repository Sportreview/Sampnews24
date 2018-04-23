<?php
/*
Template Name: Playlist JSON HLS v.2
*/
?>
<?php header('Content-Type: application/json');
echo '{
  "playlist": [
';

    // Include and instantiate the class.
    require_once 'includes/Mobile_Detect.php';
    $detect = new Mobile_Detect;

    // La Query
    $the_query = new WP_Query( array( 'cat' => 39, 'posts_per_page' => 10 ) );

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

        //Poster
        $poster_data = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'td_696x385' );
        $poster = $poster_data['0'];

        //Thumb
        $thumb_data = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'td_100x70' );
        $thumb = $thumb_data['0'];

        //Title
        setlocale(LC_ALL, 'it_IT.UTF8');
        $title_raw = iconv('UTF-8', 'ASCII//TRANSLIT', html_entity_decode(get_the_title()) );
        $title = str_replace("\"", "", "$title_raw"); // Rimuove eventuali virgolette


        if (strpos($url, '|') !== false) {//Se l'url contiene "|" vuol dire che ci sono video multipli

          //echo "<p><strong>Video multipli</strong></p>";

          $url_multipli = explode('|', $url);
          //print_r($url_multipli);

          $x = 1;

          foreach ($url_multipli as $url) {//Video multipli
            //echo "<p>$url</p>";

            $output .= <<<JSON
            {
              "bitrates": {
                "hls": "$url"
              },
              "poster": "$poster",
              "thumbnail": "$thumb",
              "adTagUrl": "$adtagurl",
              "contentTitle": "$title - Parte $x",
              "contentDescription": ""
            },
JSON;

            $x++;

          }//Video multipli

        } else {//Video singolo

          //echo "<p><strong>Video singolo</strong></p>";

            $output .= <<<JSON
            {
              "bitrates": {
                "hls": "$url"
              },
              "poster": "$poster",
              "thumbnail": "$thumb",
              "adTagUrl": "$adtagurl",
              "contentTitle": "$title",
              "contentDescription": ""
            },
JSON;

        }//Video singolo

    } else {//No video

      //url vimeo non presente

    }

  
    endwhile;
    wp_reset_query();
    wp_reset_postdata();


    $output .=<<<JSON
  ]
}
JSON;

    $new_output = substr_replace($output, '', -6, 1);

    echo $new_output;

?>