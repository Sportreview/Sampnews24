<?php

/*

Template Name: Video test

*/

?>
<html>
	<head>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php wp_head(); ?>
		<script type="text/javascript" src="http://www.sampnews24.com/wp-content/themes/Newspaper-child/jwplayer/7.4.4/jwplayer.js"></script>
    	<script type="text/javascript">jwplayer.key="agAFPszGafpq2bXqn10ceqpuNAdZ4/xQnyiagg==";</script>
	</head>

	<body>

		<div class="td-container">

			<div class="td-pb-row" style="padding: 0px 22px;">

			<div class="video_samp24">
            <div id="player"></div><br />
              <script>

            var Fourw = "http://optimized-by.4wnetwork.com/impression.php?code=154641;76809;6778;0&from=";
            var Mediamatic = "http://ad.360yield.com/advast?p=885170&w=16&h=9";
                          
            jwplayer('player').setup({
               aspectratio:"16:9",
               width:"100%",
               height:"300",
               skin: {
                   name: "seven",
                   active: "#000",
                   inactive: "#fff",
                   background: "#092261"
                },
                logo: {
                  file:'http://www.sampnews24.com/wp-content/themes/Newspaper-child/images/logo-samp24-video.png',
                  link:'http://www.sampnews24.com/'
                },
               autostart:"false",
               repeat:"false",
               mute:"true",
               advertising:{
               client:"vast",
               admessage: 'Messaggio promozionale: xx secondi.',
                   schedule:{
                       adbreak1: {
                         offset: "pre",
                         tag: Mediamatic
                       }
                   }//Schedule
               },//Adv
               ga: {
                 idstring: "mediaid",
                 trackingobject: "pageTracker"
               },
               file:"https://player.vimeo.com/external/184516630.sd.mp4?s=e765f4b44a8bca57012361e5fea27d5f8c305c3b&profile_id=165",
               image:"",
               type:"video/mp4"
             });//jwplayer

                //Fallbacks
               var index = 0;
               var fallbacks = [
                Mediamatic
               ];

               //AdErrorEngine V2.0
                  var hysteresisTime = 500, // millisecondi
                      timer;

                jwplayer('player').on('adError', function(e) {
                      console.log("Error Fallback Engine - V2.1");
                      jwplayer('player').pause(true);
                      if(timer) return;  
                      timer = setTimeout(function(){
                          if(index < fallbacks.length) {
                              console.log("Tag "+index+" vuoto - Fallback Mode "+(index+1)+"");
                              console.log("Nuovo fallback:"+fallbacks[index]);
                              jwplayer('player').pause(true);
                              jwplayer('player').playAd(fallbacks[index]);
                              index++;
                                            
                          } else { 
                            console.log("Fallbacks Vuoti");   
                                            
                            }//fallbacks vuoti
                               clearTimeout(timer);
                               timer = null;
                              jwplayer('player').play(true);
                        }, hysteresisTime );
                });//adError

                //Fix Completion Rate by Riccardo Mel
                jwplayer('player').onAdClick(function(event){
                   jwplayer('player').play(true);
                });


                jwplayer('player').on('mute', function(e) { 
				 console.log("Mute Toggle"+e);
				 var mute_toggle = jwplayer('player').getMute();
				 if(!mute_toggle){ jwplayer('player').setVolume(60); }
				});
                                        
        </script>
        </div>

				<?php //the_content(); ?>

		    </div><!--td-pb-row-->

		</div><!--td-container-->

		<?php wp_footer(); ?>

	</body>
</html>