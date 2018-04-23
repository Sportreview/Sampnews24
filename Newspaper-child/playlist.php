<?php

/*

Template Name: Playlist

*/

?>

<?php get_header(); ?>

<div class="td-container">


        <div class="td-pb-row" style="padding: 0px 22px;">



        <div class="playlist_holder">
            <div class="jwplay_holdervideo">
                <div id="SrwPlaylist">Caricamento Player...</div> 
            </div>
            <div id="list" class="playlist_sidebar mCustomScrollbar data-mcs-theme='dark'"></div>
        </div><!--playlist_holder -->


        <script>

        var playerInstance = jwplayer("SrwPlaylist");
            function playThis(index) {
            playerInstance.playlistItem(index);
            }

            playerInstance.setup({
                skin: {
                  name: "seven",
                  active: "#000",
                  inactive: "#fff",
                  background: "#092261"
                },
                logo: {
                  file:'http://www.sampnews24.com/wp-content/uploads/2016/10/logo-samp24-video.png',
                  link:'http://www.sampnews24.com/'
                },
                autostart: false,
                repeat: false,
                mute: false,
                playlist: '<?php echo site_url() ?>/playlist_feed.rss',
                displaytitle: true,
                width:"100%",
                aspectratio:"16:9",
                //height:450
                });


                var list = document.getElementById("list");
                var html = list.innerHTML;

                playerInstance.on('ready',function(){
                var playlist = playerInstance.getPlaylist();
                    for (var index=0;index<playlist.length;index++){
                    var playindex = index +1;

                    html += "<li class='playlist_jw7_item'><span class='dropt' id='"+index+"'> <a href='javascript:playThis("+index+")'> <img height='80' width='80' src='" + playlist[index].image + "' class='jwplaylist_image' /><div class='jwplaylist_holder_text'><h4>"+playlist[index].title+"</h4> </div></a> </span> </li>"
                    list.innerHTML = html;
                    }
                });

        </script>

   


    </div>

</div><!--td-container-->





<?php get_footer(); ?>