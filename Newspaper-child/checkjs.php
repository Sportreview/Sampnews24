<?php

/*

Template Name: CheckJS

*/

?>

<?php 

$tag =  $_GET['tag'];
    $mobile =  $_GET['mobile'];

    if($mobile == 1 && $tag == "textlink"):
    //Textlink Bottom Mobile
    ?>

    <!-- Sampnews 300x250 - 2 adv -->
    <div class="4wNET">
        <script type="text/javascript">
            m3ads_system = "4WM";
            m3ads_partnernumber = 100987;
            m3ads_containerclass = "m3_container sampnews_300x250_2";
            m3ads_numberadverts = 2;
            m3ads_logoimagewidth = 120;
            m3ads_logoimageheight = 120;
            m3ads_cssurl = "http://static.4wmarketplace.com/publisher/css/ppnm/sportreview/sampnews_300x250_2.css";
            m3ads_subpartner = "sampnews24_art_bot_2_mobile";
            m3ads_customheader = 5;
        </script>
        <script type="text/javascript" src="//feed.4wnet.com/resources/scripts/jsAds-1.4.min.js"></script>
    </div>


    <?php

    endif;

    if($mobile == 0 && $tag == "textlink"):
    //Textlink Desktop
    ?>

    <!-- Sampnews 725x275 -->
    <div class="4wNET">
        <script type="text/javascript">
            m3ads_system = "4WM";
            m3ads_partnernumber = 100987;
            m3ads_containerclass = "m3_container sampnews_750x275";
            m3ads_numberadverts = 4;
            m3ads_logoimagewidth = 250;
            m3ads_logoimageheight = 188;
            m3ads_cssurl = "http://static.4wmarketplace.com/publisher/css/ppnm/sportreview/sampnews_725x275.css";
            m3ads_subpartner = "sampnews24_art_bot_4_desk";
            m3ads_customheader = 5;
        </script>
        <script type="text/javascript" src="//feed.4wnet.com/resources/scripts/jsAds-1.4.min.js"></script>
    </div>


    <?php
    endif;

    if($mobile == 1 && $tag == "mobiletopads"):
    //Textlink Top Mobile
    ?>

    <!-- Sampnews 320x100 -->
    <div class="4wNET">
        <script type="text/javascript">
            m3ads_system = "4WM";
            m3ads_partnernumber = 100987;
            m3ads_containerclass = "m3_container sampnews_320x100";
            m3ads_numberadverts = 1;
            m3ads_logoimagewidth = 120;
            m3ads_logoimageheight = 120;
            m3ads_cssurl = "http://static.4wmarketplace.com/publisher/css/ppnm/sportreview/sampnews_320x100.css";
            m3ads_subpartner = "sampnews24_art_top_1_mobile";
            m3ads_customheader = 5;
        </script>
        <script type="text/javascript" src="//feed.4wnet.com/resources/scripts/jsAds-1.4.min.js"></script>
    </div>


  <?php
    endif; ?>
