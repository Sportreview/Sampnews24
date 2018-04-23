<?php
/*
Template Name: Radiant Test
*/
get_header(); ?>

<div class="td-container">
    <h1>Test Radiant</h1>
    
  <div class="playerHolder"><div id="SportreviewPlayer"></div></div>
  <script>
    var bitrates = {
      mp4: ["https://player.vimeo.com/external/184516630.sd.mp4?s=e765f4b44a8bca57012361e5fea27d5f8c305c3b&profile_id=165"] // url video
    };

    var Fourw = 'http://optimized-by.4wnetwork.com/impression.php?code=154741;76845;6778;0&from=';
  
    var fallbacks = [
      Fourw
    ];

    var settings = {
      logo: 'http://www.sampnews24.com/wp-content/themes/Newspaper-child/images/logo-samp24-video.png', // logo
      logoLoc: 'http://www.sampnews24.com/', // logo url
      licenseKey: 'dG54dHd4aXh6aEAxNTA5NDU3', // chiave presa dal sito (cambia da sito a sito)
      bitrates: bitrates,
      skin: 's5', // da s1 a s5
      delayToFade: 3000,
      debug: false,
      autoplay: true,
      autoHeightMode: true,
      muted: true,
      loop: true,
      mutedAutoplayOnMobile: true,
      sharing: true,
      ads: true,
      adMaxNumRedirects:6,
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
      adTagUrl: Fourw, // tag firstcall
      adTagWaterfall: fallbacks, // array fallbacks
      poster: '' // eventuale immagine poster
    };
           
    var elementID = 'SportreviewPlayer';
    var rmpContainer = document.getElementById(elementID);
    var rmp = new RadiantMP(elementID);
    rmp.init(settings);

    //esempio di api al click
    rmpContainer.addEventListener('adclick', function () {
      rmp.play();
      console.log('Sportreview VIDEO ENGINE by Riccardo Mel: adclick e play');
    });
    
    //fix fullscreen bug
    function FullScreenOnFix() {
      document.getElementById("at4-share").style.display = "none !important";
    }
    rmpContainer.addEventListener('enterfullscreen', FullScreenOnFix);

    function FullScreenOffFix() {
      document.getElementById("at4-share").style.display = "inherit";
    }
    rmpContainer.addEventListener('exitfullscreen', FullScreenOffFix);

  </script>

</div>

<?php
get_footer();