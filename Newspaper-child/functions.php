<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 1001);
function theme_enqueue_styles() {
  wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', '6.1c', 'all' );
  wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style.css', array('td-theme'), '6.1c', 'all' );
}

//Librerie VIMEO API
require("/home/sampnews24.com/htdocs/vimeophp/autoload.php");

/* Hide Visual Composer Activation Message */
setcookie('vchideactivationmsg', '1', strtotime('+3 years'), '/');
setcookie('vchideactivationmsg_vc11', (defined('WPB_VC_VERSION') ? WPB_VC_VERSION : '1'), strtotime('+3 years'), '/');

// Remove html tags from comments
remove_filter('comment_text', 'make_clickable', 9);

/* Hide WP Bar for Subscribers */
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
  if (!current_user_can('edit_posts') && !is_admin()) {
    show_admin_bar(false);
  }
}

// Remove subscribers profile url and social links
if( current_user_can( 'subscriber' ) ){
  add_action( 'personal_options', 'newtek_remove_user_profile_fields' );
}
function newtek_remove_user_profile_fields() { ?>
  <script type="text/javascript">
    jQuery(document).ready(function( $ ){
      jQuery('.user-url-wrap, .user-behance-wrap, .user-blogger-wrap, .user-delicious-wrap, .user-deviantart-wrap, .user-digg-wrap, .user-dribbble-wrap, .user-evernote-wrap, .user-facebook-wrap, .user-flickr-wrap, .user-forrst-wrap, .user-googleplus-wrap, .user-grooveshark-wrap, .user-instagram-wrap, .user-lastfm-wrap, .user-linkedin-wrap, .user-mail-1-wrap, .user-myspace-wrap, .user-path-wrap, .user-paypal-wrap, .user-pinterest-wrap, .user-reddit-wrap, .user-rss-wrap, .user-share-wrap, .user-skype-wrap, .user-soundcloud-wrap, .user-spotify-wrap, .user-stackoverflow-wrap, .user-steam-wrap, .user-stumbleupon-wrap, .user-tumblr-wrap, .user-twitter-wrap, .user-vimeo-wrap, .user-vk-wrap, .user-windows-wrap, .user-wordpress-wrap, .user-yahoo-wrap, .user-youtube-wrap ').remove();
    });
  </script>
<?php }

// Deregister CF7 scripts globally
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

// Register Contact Form 7 files only where there is one
add_action( 'wp_enqueue_scripts', 'newtek_register_cf7_files', 100 );
function newtek_register_cf7_files() {
  if ( is_page( 64980 ) ) {
    if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
        wpcf7_enqueue_styles();
    };
    if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
      wpcf7_enqueue_scripts();
    }
  }
}


// Deregister dashicons
function wpdocs_dequeue_dashicon() {
  if (current_user_can( 'update_core' )) {
      return;
  }
  wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );


// Remove comment-reply.min.js from footer
function newtek_remove_comment_reply() {
  wp_deregister_script( 'comment-reply' );
}
add_action('init','newtek_remove_comment_reply');


/* Customizzazione Login Page */
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Samp News 24';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

add_action('init', 'add_button');
function add_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin');
     add_filter('mce_buttons', 'register_button');
   }
}

function register_button($buttons) {
   array_push($buttons, "video_samp24");
   return $buttons;
}

function add_plugin($plugin_array) {
   $plugin_array['video_samp24'] = get_stylesheet_directory_uri().'/js/customcodes.js';
   return $plugin_array;
}

// Enable shortcodes in text widgets
add_filter('widget_text','do_shortcode');


/*  Thumbnail upscale
/* ------------------------------------ */
function alx_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){
    if ( !$crop ) return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    if( is_array( $crop ) ) {
      if( $crop[ 0 ] === 'left' ) {
        $s_x = 0;
      } else if( $crop[ 0 ] === 'right' ) {
        $s_x = $orig_w - $crop_w;
      }
      if( $crop[ 1 ] === 'top' ) {
        $s_y = 0;
      } else if( $crop[ 1 ] === 'bottom' ) {
        $s_y = $orig_h - $crop_h;
      }
    }

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'alx_thumbnail_upscale', 10, 6 );


//Custom rss feed url: feed/custom
add_action( 'after_setup_theme', 'my_rss_template' );
function my_rss_template() {
  add_feed( 'custom', 'my_custom_rss_render' );
}
function my_custom_rss_render() {
  get_template_part( 'feed', 'custom' );
}
//Custom rss feed url: feed/custom

/*
//Custom rss feed App url: feed/app
add_action( 'after_setup_theme', 'my_rss_apptemplate' );
function my_rss_apptemplate() {
  add_feed( 'app', 'my_custom_rss_apprender' );
}
function my_custom_rss_apprender() {
  get_template_part( 'feed', 'app' );
}
//Custom rss feed url: feed/app
*/

//Custom feed all da inserire nel tema parente - sovrascrive engine feed con questo template
remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', 'trg_product_feed_rss', 10, 1 );
function trg_product_feed_rss(  ) {
    $rss_template = get_template_directory() . '/feed-custom.php';
    load_template( $rss_template );
}
//Custom feed all da inserire nel tema parente - sovrascrive engine feed con questo template


//APP feed - sovrascrive engine feed ATOM con questo template
remove_all_actions( 'do_feed_atom' );
add_action( 'do_feed_atom', 'trg_product_feed_rss_s', 10, 1 );
function trg_product_feed_rss_s(  ) {
    $rss_template = get_template_directory() . '/feed-app.php';
    load_template( $rss_template );
}
//APP feed - sovrascrive engine feed ATOM con questo template


/* Aggiunge la paginazione alla meta description nelle Smart Lists */
add_filter('wpseo_metadesc','change_yoast_description',100,1);

function change_yoast_description($description) {

  $new_description=$description;

  $is_smart_list = false;

  if (is_singular('post')) {
    global $post;

    $td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);
    if (is_array($td_post_theme_settings) && array_key_exists('smart_list_template', $td_post_theme_settings)) {
      $is_smart_list = true;
    }
  }

  // outside the loop, it's reliable to check the page template
  if (!in_the_loop() && (is_page_template('page-pagebuilder-latest.php') || $is_smart_list)) {

    $td_page = (get_query_var('page')) ? get_query_var('page') : 1; //rewrite the global var
    $td_paged = (get_query_var('paged')) ? get_query_var('paged') : 1; //rewrite the global var

    if ($td_paged > $td_page) {
      $local_paged = $td_paged;
    } else {
      $local_paged = $td_page;
    }

    // the custom title is when the pagination is greater than 1
    if ($local_paged > 1) {
      $new_description.='' . ' - ' . __td('Page', TD_THEME_NAME) . ' ' . $local_paged;
    }
  }

  return $new_description;
}//change_yoast_description

/* Modifica il meta tag robots nelle Smart Lists */
add_filter('wpseo_robots', 'change_yoast_robots', 100,1);

function change_yoast_robots($robots) {

  $new_robots = $robots;

  $is_smart_list = false;

  if (is_singular('post')) {
    global $post;

    $td_post_theme_settings = get_post_meta($post->ID, 'td_post_theme_settings', true);
    if (is_array($td_post_theme_settings) && array_key_exists('smart_list_template', $td_post_theme_settings)) {
      $is_smart_list = true;
    }
  }

  // outside the loop, it's reliable to check the page template
  if (!in_the_loop() && (is_page_template('page-pagebuilder-latest.php') || $is_smart_list)) {

    $td_page = (get_query_var('page')) ? get_query_var('page') : 1; //rewrite the global var
    $td_paged = (get_query_var('paged')) ? get_query_var('paged') : 1; //rewrite the global var

    if ($td_paged > $td_page) {
      $local_paged = $td_paged;
    } else {
      $local_paged = $td_page;
    }

    // only when the pagination is greater than 1
    if ($local_paged > 1) {
      $new_robots='noindex';
    }
  }

  return $new_robots;
}//change_yoast_robots


//Funzione recupero immagine Video Vimeo by Riccardo Mel
function GetThumbCurl($vurl){
//Funzione di recupero diretto delle locandine recuperate da VIMEO
    $video_elab_cover = explode("/",$vurl);
    $video_id_cover = explode(".",$video_elab_cover[4]);
    $vid = $video_id_cover[0];
    $request = "https://vimeo.com/api/oembed.json?url=http%3A%2F%2Fvimeo.com%2F".$vid."";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $a = curl_exec($ch);
    $result = json_decode($a, true);
    return $result['thumbnail_url'];
}//Funzione recupero immagine Video Vimeo by Riccardo Mel


// Video JS Engine | ARTICOLO
wp_enqueue_script( 'video_samp24_js', get_stylesheet_directory_uri().'/js/video_samp24.js' );
function video_samp24($atts, $content = null) {
  extract(shortcode_atts(array(
    "url" => "",
    "autoplay" => "true",
    "width" => "100%",
    "height" => "300",
    "mute" => "false",
    "repeat" => "false"
  ), $atts));


  //Poster Video
  $cover_img = GetThumbCurl($url);

  preg_match('~external/(.*?).m3u8~', $url, $videoid); // Recupero ID Video
  $playerdiv = '<div id="Ajax_VideoHolder" class="playerHolder"><div id="rmpPlayer-'.$videoid[1].'"></div></div>';
  $playerdiv .= '<script>VideoSportReview("'.$url.'","'.$autoplay.'","'.$width.'","'.$height.'","'.$mute.'","'.$repeat.'","'.$videoid[1].'","'.$cover_img.'");</script>';
  return $playerdiv;


}
add_shortcode("video_samp24", "video_samp24");
// END Video JS Engine | ARTICOLO


// Sliding Player
function videoslide_samp24($atts, $content = null) {

  extract(shortcode_atts(array(
    "url" => "",
    "autoplay" => "true",
    "width" => "100%",
    "height" => "300",
    "mute" => "true",
    "repeat" => "false"
  ), $atts));


  //Poster Video
  //$cover_img = GetThumbCurl($url);

  ?>
<!--
  <div id="video-onslide">
    <p class="chiudi_player" onClick="ChiudiPlayer();"> <i class="fa fa-times" aria-hidden="true"></i> chiudi </p>
    <div id="SidebarAjax_VideoHolder">
      <div class="PlayerHolder">
        <div id="rmpPlayerSidebar">Caricamento Player...</div>
      </div>
    </div>
  </div> -->
  <script>
/*
  function ChiudiPlayer(){
    if(!closedPlayer){
      jQuery(".chiudi_player").hide();
      jQuery("#video-onslide").removeClass("follow-fixed-player").addClass("follow-holder-player");
      rmpSidebar.resize();
      jQuery(".sportreview-heading-video").removeClass("slideout");
      closedPlayer = true;
    }//closedPlayer
  }//ChiudiPlayer

  function RiposizionaPlayer(){
    jQuery(".chiudi_player").hide();
    jQuery("#video-onslide").removeClass("follow-fixed-player").addClass("follow-holder-player");
    rmpSidebar.resize();
    jQuery(".sportreview-heading-video").removeClass("slideout");
  }//RiposizionaPlayer

  function PosizionaPlayer(){
    if(!closedPlayer){
      setTimeout(function(){
       jQuery(".chiudi_player").css("display","inline-block");
      }, 5000);
      jQuery(".sportreview-heading-video").addClass("slideout");
      jQuery("#video-onslide").removeClass("follow-holder-player").addClass("follow-fixed-player");
      rmpSidebar.resize();
    }//closedPlayer
  }//PosizionaPlayer

  //Librerie JS is mobile
  !function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,h=/(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,i=/Windows Phone/i,j=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,k=/BlackBerry/i,l=/BB10/i,m=/Opera Mini/i,n=/(CriOS|Chrome)(?=.*\bMobile\b)/i,o=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,p=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),q=function(a,b){return a.test(b)},r=function(a){var r=a||navigator.userAgent,s=r.split("[FBAN");if("undefined"!=typeof s[1]&&(r=s[0]),s=r.split("Twitter"),"undefined"!=typeof s[1]&&(r=s[0]),this.apple={phone:q(b,r),ipod:q(c,r),tablet:!q(b,r)&&q(d,r),device:q(b,r)||q(c,r)||q(d,r)},this.amazon={phone:q(g,r),tablet:!q(g,r)&&q(h,r),device:q(g,r)||q(h,r)},this.android={phone:q(g,r)||q(e,r),tablet:!q(g,r)&&!q(e,r)&&(q(h,r)||q(f,r)),device:q(g,r)||q(h,r)||q(e,r)||q(f,r)},this.windows={phone:q(i,r),tablet:q(j,r),device:q(i,r)||q(j,r)},this.other={blackberry:q(k,r),blackberry10:q(l,r),opera:q(m,r),firefox:q(o,r),chrome:q(n,r),device:q(k,r)||q(l,r)||q(m,r)||q(o,r)||q(n,r)},this.seven_inch=q(p,r),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window)return this},s=function(){var a=new r;return a.Class=r,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=r:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=s():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=s()):a.isMobile=s()}(this);
  //Librerie JS is mobile


  //By Riccardo Mel
  //V1.7.5

  console.log("Engine by Riccardo Mel: Engine Sidebar - Versione 1.7.5 ");

  //Variabili utenti
  var DebugCustom = true;
  if (isMobile.any) {
    var attivaLoop = false;
    var attivaPostRoll = false;
  }else {
    var attivaLoop = true;
    var attivaPostRoll = true;
  }
  var permanentMuted = false;
  var mobileAudioChanger = false;
  var autoplayMobile = true;
  var mutedAudio = true;
  var hoverAudio = true;

  //Variabili contenuti
  var poster = '<?php //echo $cover_img; ?>';


  <?php
  //Identifico url singolo (Retrocompatibilità) oppure url multiplo (new engine)
  //$urlArray = explode("|",$url);
  //if(count($urlArray) == 1 ):
  //Url Singolo - Retrocompatibilità
  ?>

    //Array con video da processare nella playlist custom
    var video_playlists =[
       '<?php //echo $url; ?>'
    ];

  <?php //else:
  //Url Multiplo ?>

    //Array con video da processare nella playlist custom
    var video_playlists =[
      <?php //foreach ($urlArray as $keyUrlVideo => $valueUrlVideo) { ?>
      '<?php //echo $valueUrlVideo; ?>',
      <?php //} ?>
    ];

  <?php //endif
  //Url Check
  ?>


  if (!isMobileNewtek && homepageURL=="https://www.sampnews24.com/") {
    var prerollTagSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/hp/preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var postrollTagSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/hp/postroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var prerollTagSidebarRepeat = prerollTagSidebar;
    var dfpSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/165059490/Sampnews24_Preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var mediamaticSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/1028390/sampnews24.TM.preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var mediamaticFallbackSidebar = 'https://ad.360yield.com/advast?p=885167&w=16&h=9';
  } else if (!isMobileNewtek) {
    var prerollTagSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/altro/preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var postrollTagSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/altro/postroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var prerollTagSidebarRepeat = prerollTagSidebar;
    var dfpSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/165059490/Sampnews24_Preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var mediamaticSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/1028390/sampnews24.TM.preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var mediamaticFallbackSidebar = 'https://ad.360yield.com/advast?p=885167&w=16&h=9';
  } else {
    var prerollTagSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/mobile/preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var postrollTagSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/5196/sampnews24/mobile/postroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var prerollTagSidebarRepeat = prerollTagSidebar;
    var dfpSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/165059490/Sampnews24_Preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var mediamaticSidebar = 'https://pubads.g.doubleclick.net/gampad/ads?sz=640x480&iu=/1028390/sampnews24.TM.preroll&impl=s&gdfp_req=1&env=vp&output=vast&unviewed_position_start=1&url=sampnews24.com&description_url=sampnews24.com&correlator='+Math.round(Math.random()*10000000000)+'';
    var mediamaticFallbackSidebar = 'https://ad.360yield.com/advast?p=885167&w=16&h=9';
  }

  console.log("Tag prerollTagSidebar: "+prerollTagSidebar);
  console.log("Tag prerollTagSidebar REP: "+prerollTagSidebarRepeat);
  console.log("Tag postrollTagSidebar: "+postrollTagSidebar);
  console.log("Tag dfpSidebar: "+dfpSidebar);
  console.log("Tag mediamaticSidebar: "+mediamaticSidebar);
  console.log("Tag mediamaticFallbackSidebar: "+mediamaticFallbackSidebar);

  //Imposto array Waterfall - Metterne almeno due in quanto fallback parte da 1
  var waterfallArraySidebar = [
    mediamaticSidebar,
    mediamaticSidebar,
    mediamaticFallbackSidebar,
    dfpSidebar
  ];

  //Url video qui.
  //Nel caso usi adaptive usa questo codice:
  //var bitrates = { hls: 'video_playlists[0]' };
  var bitratesSidebar = {
    hls: ''+video_playlists[0]+'' // url video
  };

  var settings = {
    logo: '<?php //echo site_url(); ?>/wp-content/themes/Newspaper-child/images/logo-samp24-video.png',
    logoLoc: '<?php //echo site_url(); ?>/',
    licenseKey: 'dG54dHd4aXh6aEAxNTA5NDU3',
    pathToRmpFiles: '//cdn.sportreview.it/radiantmp/latest/',
    gaTrackingId: 'UA-11488352-4',
    gaCategory: 'Video Sidebar',
    bitrates: bitratesSidebar,
    width:307,
    height:220,
    permanentMuted: permanentMuted,
    muted: mutedAudio,
    delayToFade: 3000,
    autoplay: true,
    ads: true,
    adTagUrl: prerollTagSidebar,
    adCountDown: true,
    labels: {
      ads: {
        controlBarCustomMessage: 'Messaggio promozionale'
      },
      hint: {
        sharing: 'Condividi',
        quality: 'Qualità',
        speed: 'Velocità',
        captions: 'Sottotitoli',
        audio: 'Audio',
        cast: 'Cast',
        playlist: 'Playlist'
      },
      error: {
        customErrorMessage: 'Il contenuto video non è al momento disponibile.',
        noSupportMessage: 'Manca il supporto per la riproduzione dei video.',
        noSupportDownload: 'Puoi scaricare il video qui.',
        noSupportInstallChrome: 'E\' necessario aggiornare Google Chrome per visualizzare questo contenuto.'
      }
    },
    endOfVideoPoster: poster,
    poster: poster
  };
  var elementIDSidebar = 'rmpPlayerSidebar';
  var rmpSidebar = new RadiantMP(elementIDSidebar);
  var rmpContainerSidebar = document.getElementById(elementIDSidebar);


  //NON MODIFICARE DA QUI IN POI
  //Inizio Engine by Riccardo Mel
  //Set up Variabili di sistema
  var postRoll = 0;
  var videoEnded  = 0;
  var waterfallIndex  = 0;
  var adError = false;
  var playlistItem = 0;
  var lastItem = 0;
  var closedPlayer = false;

  //Debug opzionale
  for (var i = 0; i < video_playlists.length; i++) {
  if(DebugCustom) { console.log("Video playlist item: "+video_playlists[i]); }
  }

  //trigger Events
  rmpContainerSidebar.addEventListener('adcontentresumerequested', function () {
    if (adError) {
      return;
    }
   if(DebugCustom) { console.log("Engine by Riccardo Mel: ENGINE resume request"); }
  });

  rmpContainerSidebar.addEventListener('adcontentpauserequested', function () {
  adError = false;
  if(DebugCustom) { console.log("Engine by Riccardo Mel: pause request"); }
  });

  //AllAdsCompleted
  rmpContainerSidebar.addEventListener('adalladscompleted', function () {
    if(videoEnded == 1 && postRoll==1){
      videoEnded =0; postRoll=0;
      rmpSidebar.setLoop(false); //abilito postroll successivo intercettando workflow del player loop
      if(DebugCustom) { console.log("Engine by Riccardo Mel: RECALL PREROLL"); }
      rmpSidebar.loadAds(prerollTagSidebar);
    }
    if(DebugCustom) { console.log("Engine by Riccardo Mel: adalladscompleted"); }

    //Riposiziono player
    RiposizionaPlayer();

    //Metto in pausa se mobile
    if (isMobile.any) { rmpSidebar.stop(); }

  });
  //AllAdsCompleted

  //Ended events
  rmpContainerSidebar.addEventListener('ended', function () {
    //Setto video ended
    videoEnded=1;
      // Playlist Custom
      playlistItem++;
      if(DebugCustom) { console.log(playlistItem); }
      if (typeof video_playlists[playlistItem] !== 'undefined') {
        rmpSidebar.setSrc(video_playlists[playlistItem]);
        if(DebugCustom) { console.log("Play:"+video_playlists[playlistItem]); }
      } else {
        lastItem = 1;
        playlistItem = 0;
        rmpSidebar.setSrc(video_playlists[0]);
        if(DebugCustom) { console.log("playdefault video"); }
      }
      // Playlist Custom
  });
  //Ended

  //srcchanged
  rmpContainerSidebar.addEventListener('srcchanged', function () {
    //Se Loop non attivo
    if(!attivaLoop && lastItem == 1){ lastItem = 0; rmpSidebar.stop(); }else{

      if(attivaPostRoll){
        if(postRoll == 0){
          postRoll=1;
          if(DebugCustom) { console.log("Engine by Riccardo Mel: POSTROLL"); }
          rmpSidebar.loadAds(postrollTagSidebar);
        }//postRoll isset
      } else {
        rmpSidebar.loadAds(prerollTagSidebarRepeat);
      }//attivaPostRoll

    }//else
    //Se Loop non attivo
    if(DebugCustom) { console.log("Engine by Riccardo Mel: srcchanged"); }
  });
  //srcchanged

  //AdError
  rmpContainerSidebar.addEventListener('aderror', function () {
  if(DebugCustom) { console.log("Engine by Riccardo Mel: aderror: "); }
      adError = true;
      waterfallIndex++;
        if (typeof waterfallArraySidebar[waterfallIndex] !== 'undefined') {
          if(DebugCustom) {  console.log('new waterfall index is ' + waterfallIndex); }
          if(DebugCustom) {  console.log('loadAds waterfall ad at ' + waterfallArraySidebar[waterfallIndex]); }
          rmpSidebar.loadAds(waterfallArraySidebar[waterfallIndex]);
        } else {
          waterfallIndex = 0;//Fai ciclare di nuovo da 0 i fallback il prossimo adcall
          if(DebugCustom) { console.log("Fallback finiti"); }
        }

        //Riposiziono player
        RiposizionaPlayer();

        //Metto in pausa se mobile
        if (isMobile.any) { rmpSidebar.stop(); }

  });
  //AdError

  rmpContainerSidebar.addEventListener('adloaded', function () {
    //Posiziono player
    PosizionaPlayer();
    if(DebugCustom) { console.log("Engine by Riccardo Mel: adloaded"); }
  });


  rmpContainerSidebar.addEventListener('pause', function () {
    if(DebugCustom) { console.log("Engine by Riccardo Mel: pause"); }
    if(!attivaLoop) {  rmpSidebar.showPoster(); }
    if(isMobile.any) { rmpSidebar.stop(); rmpSidebar.showPoster(); }
  });

  if(mobileAudioChanger){
  rmpContainerSidebar.addEventListener('ready', function() {
    if(DebugCustom) { console.log('player ready'); }
      if (isMobile.any) {
        //Mobile
        if(DebugCustom) { console.log('Mobile'); }
        rmpSidebar.setVolume(1);//imposto volume
      } else {
        //Desktop
        if(DebugCustom) { console.log('Desktop'); }
        rmpSidebar.setVolume(0.5);//imposto volume
      }//if mobile
  });//playerReady
  }//mobileAudioChanger

  //Fix completion rate - Opzionale ma consigliato
  rmpContainerSidebar.addEventListener('adclick', function () {
    rmpSidebar.play();
    if(DebugCustom) { console.log('Engine by Riccardo Mel: adclick'); }
  });
  //Fix completion rate - Opzionale ma consigliato

    if(hoverAudio){
    jQuery(document).ready(function() {
              jQuery("#SidebarAjax_VideoHolder").mouseenter(
              function(){
              if(DebugCustom) { console.log('Hover: Audio ON'); }
              rmpSidebar.setMute(false);
              });

              jQuery("#SidebarAjax_VideoHolder").mouseleave(
              function(){
              if(DebugCustom) { console.log('Leave: Audio OFF'); }
              rmpSidebar.setMute(true);
              });
    });//FINE DOM
  }//hoverAudio

  //Start!!!!!
  rmpSidebar.init(settings);
  //Vietata la riproduzione
  //Info: info@riccardomel.com
  */
  </script>


  <!-- Mediamatic | Special - 307x220 | 396 & 392 -->
  <div id='sy_43332' align='center'></div>
  <script>
    function detectWidth() {return window.screen.width || window.innerWidth && document.documentElement.clientWidth ? Math.min(window.innerWidth, document.documentElement.clientWidth) : window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;}
      var mmTag = [];
      if(detectWidth() < 768) { 
    mmTag.push({mmSetPubId:396});
      mmTag.push({mmSetWeight:300});
      mmTag.push({mmSetHeight:169});
      } else {
    mmTag.push({mmSetPubId:392});
      mmTag.push({mmSetWeight:307});
      mmTag.push({mmSetHeight:220});
      }
    mmTag.push({mmSetDivId:'sy_43332'});
    mmTag.push({mmVideoDisplay:''});
  </script>
  <script type='text/javascript' src='https://videomatictv.com/dsp/show_w.js'></script>
  <!-- End of Mediamatic Tag -->


  <?php
  }
  add_shortcode("videoslide_samp24", "videoslide_samp24");
//END Sliding Player


// Video Playlist
function video_playlist_samp24($atts, $content = null) {

   extract(shortcode_atts(array(
      "autoplay" => "true",
      "mute" => "true"
   ), $atts));

?>

  <div class="td-container">
    <div class="td-pb-row" style="padding: 0px 22px;">
    <h2 class="video-playlist-title">Video</h2>

      <div class="rmp-playlist-container">
        <div class="rmp-playlist-player-wrapper">
          <div id="SportreviewPlaylist"></div>
        </div>
      </div>

      <script>
        var settings = {
          logo: '<?php echo site_url(); ?>/wp-content/themes/Newspaper-child/images/logo-samp24-video.png',
          logoLoc:'<?php echo site_url(); ?>/',
          pathToRmpFiles: '//cdn.sportreview.it/radiantmp/latest/',
          licenseKey: 'dG54dHd4aXh6aEAxNTA5NDU3',
          skinAccentColor: '092261',
          delayToFade: 3000,
          debug: false,
          autoHeightMode: true,
          autoplay: <?php echo $autoplay; ?>,
          muted: <?php echo $mute; ?>,
          ads: true,
          adTagUrl: tagpreroll,
          sharing: true,
          adCountDown: true,
          playlistUpNextAutoplay: true,
          playlistLoc: '<?php echo site_url(); ?>/playlist-json-hls-v2/',
          labels: {
            ads: {
              controlBarCustomMessage: 'Messaggio promozionale'
            },
            hint: {
              sharing: 'Condividi',
              quality: 'Qualità',
              speed: 'Velocità',
              captions: 'Sottotitoli',
              audio: 'Audio',
              cast: 'Cast',
              playlist: 'Playlist'
            },
            error: {
              customErrorMessage: 'Il contenuto video non è al momento disponibile.',
              noSupportMessage: 'Manca il supporto per la riproduzione dei video.',
              noSupportDownload: 'Puoi scaricare il video qui.',
              noSupportInstallChrome: 'E\' necessario aggiornare Google Chrome per visualizzare questo contenuto.'
            }
          }
        };

        var elementID = 'SportreviewPlaylist';
        var rmp = new RadiantMP(elementID);
        rmp.init(settings);

      </script>

    </div><!-- td-pb-row -->
  </div><!-- td-container -->

  <?php
}
add_shortcode("video_playlist_samp24", "video_playlist_samp24");

// Thumbnails quality
add_filter( 'jpeg_quality', create_function('', 'return 80;' ) );


function adv_libs() { ?>
  <script async='async' src='https://www.googletagservices.com/tag/js/gpt.js'></script>
  <script>
    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
  </script>

  <script>
  if (!isMobileNewtek) {
    googletag.cmd.push(function() {
      googletag.defineSlot('/21624773413/Sampnews24.com/Mpu_Middle', [300, 250], 'div-gpt-ad-Mpu_Middle').addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/ros/skin', [1, 1], 'div-gpt-ad-1521733626855-1').setTargeting('Display_Ad_Size', ['Skin']).setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/homepage/skin', [1, 1], 'div-gpt-ad-1521733530112-1').setTargeting('Display_Ad_Size', ['Skin']).setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/ros/top_banner', [[728, 90], [980, 250], [970, 250], [1056, 250]], 'div-gpt-ad-1521733626855-2').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_banner', [[1056, 250], [728, 90], [980, 250], [970, 250]], 'div-gpt-ad-1521733530112-2').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/ros/top_mpu', [[300, 600], [300, 250]], 'div-gpt-ad-1521733626855-3').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads()); 
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_mpu', [[300, 250], [300, 600]], 'div-gpt-ad-1521733530112-3').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.pubads().enableSingleRequest();
      googletag.pubads().collapseEmptyDivs();
      googletag.enableServices();
    });
     } else {
     googletag.cmd.push(function() {
      googletag.defineOutOfPageSlot('/67970281/display_thirdparty_it/sampnews24_responsive/ros/high_impact', 'div-gpt-ad-1521733626855-0').setTargeting('Display_Ad_Size', ['Out-of-page']).setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineOutOfPageSlot('/67970281/display_thirdparty_it/sampnews24_responsive/homepage/high_impact', 'div-gpt-ad-1521733530112-0').setTargeting('Display_Ad_Size', ['Out-of-page']).setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/ros/top_banner', [320, 50], 'div-gpt-ad-1521733626855-2').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_banner', [320, 50], 'div-gpt-ad-1521733530112-2').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/ros/top_mpu', [300, 250], 'div-gpt-ad-1521733626855-3').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads()); 
      googletag.defineSlot('/67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_mpu', [300, 250], 'div-gpt-ad-1521733530112-3').setTargeting('Display_Ad_Position', ['ATF']).addService(googletag.pubads());
      googletag.pubads().enableSingleRequest();
      googletag.pubads().collapseEmptyDivs();
      googletag.enableServices();
    });
   }
  </script>
<?php }//adv_libs


function adv_tag_manager() { ?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-NBLTHSW');</script>
  <!-- End Google Tag Manager -->
<?php }//adv_tag_manager


function adv_tag_manager_noscript() { ?>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NBLTHSW"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
<?php }//adv_tag_manager_noscript


function adv_skin() {
  if (is_front_page()) { ?>
   <!-- /67970281/display_thirdparty_it/sampnews24_responsive/homepage/skin -->
<div id='div-gpt-ad-1521733530112-1' style='height:1px; width:1px;'>
<script>
        if (!isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733530112-1'); });
        } else {
          jQuery("#div-gpt-ad-1521733530112-1").hide();
        }
      </script>
    </div>
  <?php } else { ?>
    <!-- /67970281/display_thirdparty_it/sampnews24_responsive/ros/skin -->
    <div id='div-gpt-ad-1521733626855-1' style='height:1px; width:1px;'>
      <script>
        if (!isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733626855-1'); });
        } else {
          jQuery("#div-gpt-ad-1521733626855-1").hide();
        }
      </script>
    </div>
  <?php }
}//adv_skin



function adv_high_impact() {
  if (is_front_page()) { ?>
   <!-- /67970281/display_thirdparty_it/sampnews24_responsive/homepage/high_impact -->
<div id='div-gpt-ad-1521733530112-0'>
<script>
        if (isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733530112-0'); });
        } else {
          jQuery("#div-gpt-ad-1521733530112-0").hide();
        }
      </script>
    </div>
  <?php } else { ?>
    <!-- /67970281/display_thirdparty_it/sampnews24_responsive/ros/high_impact -->
    <div id='div-gpt-ad-1521733626855-0'>
      <script>
        if (isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733626855-0'); });
        } else {
          jQuery("#div-gpt-ad-1521733626855-0").hide();
        }
      </script>
    </div>
  <?php }
}//adv_high_impact

function adv_top_desktop() { ?>
  <!-- /67970281/display_thirdparty_it/sampnews24_responsive/ros/top_banner -->
  <div id='div-gpt-ad-1521733626855-2'>
  <script>
    if (!isMobileNewtek) {
      googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733626855-2'); });
    } else {
      jQuery("#div-gpt-ad-1521733626855-2").hide();
    }
  </script>
  </div>
<?php }//adv_top_desktop



function adv_top_mobile() { ?>
  <!-- /67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_mpu -->
  <div id='div-gpt-ad-1521733530112-3'>
  <script>
    if (isMobileNewtek) {
      googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733530112-3'); });
    } else {
      jQuery("#div-gpt-ad-1521733530112-3").hide();
    }
  </script>
  </div>
<?php }//adv_top_mobile


function adv_top_mobile_single() {
  if (is_single()) { ?>
    <script type="text/javascript">
    if (isMobileNewtek) {
      top_mobile_content = '<!-- /67970281/display_thirdparty_it/sampnews24_responsive/ros/top_mpu -->\
        <div id="div-gpt-ad-1521733626855-3">\
        <script>\
          if (isMobileNewtek) {\
            googletag.cmd.push(function() { googletag.display("div-gpt-ad-1521733626855-3"); });\
          } else {\
            jQuery("#div-gpt-ad-1521733626855-3").hide();\
          }\
        <\/script>\
        <\/div>';
      jQuery(".td-post-content h2:nth-of-type(1)").after(top_mobile_content);
   } else {
      jQuery("#adv_top_mobile_single").hide();
    }
    </script>
  <?php }
}//adv_top_mobile_single

function adv_top_mobile_other() {
  if (is_front_page() || is_category() || is_single()) {
    // not show top_mobile on top if front page, category or single
  } else {
    if (function_exists('adv_top_mobile')) {
      adv_top_mobile();
    }
  }//else
}//adv_top_mobile_other

function adv_mpu_top() {
  if (is_front_page()) { ?>
   <!-- /67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_mpu -->
<div id='div-gpt-ad-1521733530112-3'>
<script>
if (isMobileNewtek) {
 googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733530112-3'); });
</script>
 } else {
        jQuery("#div-gpt-ad-1521733530112-3").hide();
        }
    </script>
    </div>
  <?php } else { ?>
    <!-- /67970281/display_thirdparty_it/sampnews24_responsive/ros/top_mpu -->
    <div id='div-gpt-ad-1521733626855-3'>
    <script>
        if (isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733626855-3'); });
        } else {
        jQuery("#div-gpt-ad-1521733626855-3").hide();
        }
      </script>
    </div>
  <?php }
}//adv_mpu_top



function adv_mpu_middle() { ?>
  <!-- /21624773413/Sampnews24.com/Mpu_Middle -->
  <div id='div-gpt-ad-Mpu_Middle' style='height:250px; width:300px;'>
  <script>
  googletag.cmd.push(function() { googletag.display('div-gpt-ad-Mpu_Middle'); });
  </script>
  </div>
<?php }//adv_mpu_middle


function adv_bottom_mobile() {
  if (is_front_page()) { ?>
   <!-- /67970281/display_thirdparty_it/sampnews24_responsive/homepage/top_banner -->
<div id='div-gpt-ad-1521733530112-2' style='height:50px; width:320px;'>
<script>
        if (isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733530112-2'); });
        } else {
          jQuery("#div-gpt-ad-1521733530112-2").hide();
        }
      </script>
    </div>
  <?php } else { ?>
    <!-- /67970281/display_thirdparty_it/sampnews24_responsive/ros/top_banner -->
    <div id='div-gpt-ad-1521733626855-2' style='height:50px; width:320px;'>
      <script>
        if (isMobileNewtek) {
          googletag.cmd.push(function() { googletag.display('div-gpt-ad-1521733626855-2'); });
        } else {
          jQuery("#div-gpt-ad-1521733626855-2").hide();
        }
      </script>
    </div>
  <?php }
}//adv_bottom_mobile



function adv_in_feed() {
  if (is_category()) { ?>
    <script type="text/javascript">
      in_feed_content = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script>\
        <ins class="adsbygoogle"\
          style="display:block"\
          data-ad-format="fluid"\
          data-ad-layout-key="-9l-44+2w-8r+b4"\
          data-ad-client="ca-pub-4951276053293022"\
          data-ad-slot="1046994921"></ins>\
        <script>\
          (adsbygoogle = window.adsbygoogle || []).push({});\
        <\/script>';
      jQuery(".td-ss-main-content > .td_module_wrap:nth-child(3)").after(in_feed_content);
    </script>
  <?php }
}//adv_in_feed


function adv_in_article() { ?>
  <script>
  if (!isMobileNewtek) {
    var code1 = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script>\
      <ins class="adsbygoogle adv_inarticle"\
      style="display:block; text-align:center;"\
      data-ad-format="fluid"\
      data-ad-layout="in-article"\
      data-ad-client="ca-pub-4951276053293022"\
      data-ad-slot="1713574294"></ins>\
      <script>\
      (adsbygoogle = window.adsbygoogle || []).push({});\
      <\/script>';
      jQuery( ".td-post-content h2:nth-of-type(1)" ).after( code1 );
   } else {
      jQuery("#adv_in_article").hide();
    }
  </script>
<?php }//adv_in_article

function adv_in_article_paragrafo() { ?>
  <script>
    var code1 = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script>\
      <ins class="adsbygoogle adv_inarticle"\
      style="display:block; text-align:center;"\
      data-ad-format="fluid"\
      data-ad-layout="in-article"\
      data-ad-client="ca-pub-4951276053293022"\
      data-ad-slot="1713574294"></ins>\
      <script>\
      (adsbygoogle = window.adsbygoogle || []).push({});\
      <\/script>';
      jQuery( ".td-post-content p:nth-of-type(1)" ).after( code1 );
  </script>
<?php }//adv_in_article_paragrafo


function adsense_vignetta() { ?>
  <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
    (adsbygoogle = window.adsbygoogle || []).push({
      google_ad_client: "ca-pub-4951276053293022",
      enable_page_level_ads: true
    });
  </script>
<?php }//adsense_vignetta

function correlati_adsense() { ?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-4951276053293022"
     data-ad-slot="5047567611"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php }//correlati_adsense


function correlati_4w() { ?>
  <!-- Correlati 4W -->
  <script type="text/javascript">
    (function($n,e,o,d,a,t,a$) {
        $n._4wRecom = $n._4wRecom || {};
        $n._4wRecom.Q = $n._4wRecom.Q || [];
        $n._4wRecom.Q.push(['setup', function () {
            $n._4wRecom.T.setTaxonomy("/sportreview/sampnews24/sampnews24.com/news");
            $n._4wRecom.B.addPosition("sportreview_sampnews24_news","NeoWidget");
        }]);
        var x = d.createElement(e), s = d.getElementsByTagName(e)[0];
        x.src = ('https:' ==  t.protocol ? 'https://js-ssl' : 'http://js')+o;
        x.async = a;
        s.parentNode.insertBefore(x, s);
    }) (window,'scr'+'ipt','.neodatagroup.com/4wr.js',document,1,location,1);
  </script>
  <div id="NeoWidget"></div>
<?php }//correlati_4w


function player_mediamatic() { ?>
  <script>
    var code2 = '<!-- Mediamatic | Masterhead Expand - 710x25 To 710x399 | 396 & 449 -->\
      <div id=\'sy_16679\' align=\'center\'></div>';
    jQuery( "#mm-player" ).append( code2 );
  </script>
  <script>
    function detectWidth() {return window.screen.width || window.innerWidth && document.documentElement.clientWidth ? Math.min(window.innerWidth, document.documentElement.clientWidth) : window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;}
    var mmTag = [];
    if(detectWidth() < 1141) { 
      mmTag.push({mmSetPubId:396});
      mmTag.push({mmSetWeight:300});
      mmTag.push({mmSetHeight:169});
    } else {
      mmTag.push({mmSetPubId:449});
      mmTag.push({mmSetWeight:710});
      mmTag.push({mmSetHeight:25});
      mmTag.push({mmSetExpandWeight:710});
      mmTag.push({mmSetExpandHeight:399});
    }
    mmTag.push({mmSetDivId:'sy_16679'});
    mmTag.push({mmVideoDisplay:''});
  </script>
  <script type='text/javascript' src='https://videomatictv.com/dsp/show_w.js'></script>
<?php }


function floor_ad() { ?>
<!-- FLOOR AD -->
  <script type="text/javascript">
  simply_publisher = 6778;
  simply_domain = 103993;
  simply_space = 214271;
  simply_ad_height = 1;
  simply_ad_width = 1;
  simply_callback = '';
  </script>
  <script type="text/javascript">
  var cb = Math.round(new Date().getTime());
  document.write('<scr'+'ipt type="text/javascript" src="'+ ('https:' == document.location.protocol ? 'https://' : 'http://') + 'optimized-by.4wnetwork.com/simply_loader.js?cb='+ cb +'"></scr' + 'ipt>');
  </script>
<?php }//floor_ad