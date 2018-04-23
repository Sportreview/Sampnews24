<!-- Instagram -->

<?php if (td_util::get_option('tds_footer_instagram') == 'show') { ?>

<div class="td-main-content-wrap td-footer-instagram-container">
    <?php
    //get the instagram id from the panel
    $tds_footer_instagram_id = td_util::get_option('tds_footer_instagram_id');
    ?>

    <div class="td-instagram-user">
        <h4 class="td-footer-instagram-title">
            <?php echo  __td('Follow us on Instagram', TD_THEME_NAME); ?>
            <a class="td-footer-instagram-user-link" href="https://www.instagram.com/<?php echo $tds_footer_instagram_id ?>" target="_blank">@<?php echo $tds_footer_instagram_id ?></a>
        </h4>
    </div>

    <?php
    //get the other panel seetings
    $tds_footer_instagram_nr_of_row_images = intval(td_util::get_option('tds_footer_instagram_on_row_images_number'));
    $tds_footer_instagram_nr_of_rows = intval(td_util::get_option('tds_footer_instagram_rows_number'));
    $tds_footer_instagram_img_gap = td_util::get_option('tds_footer_instagram_image_gap');
    $tds_footer_instagram_header = td_util::get_option('tds_footer_instagram_header_section');

    //show the insta block
    echo td_global_blocks::get_instance('td_block_instagram')->render(
        array(
            'instagram_id' => $tds_footer_instagram_id,
            'instagram_header' => /*td_util::get_option('tds_footer_instagram_header_section')*/ 1,
            'instagram_images_per_row' => $tds_footer_instagram_nr_of_row_images,
            'instagram_number_of_rows' => $tds_footer_instagram_nr_of_rows,
            'instagram_margin' => $tds_footer_instagram_img_gap
        )
    );

    ?>
</div>

<?php } ?>


<!-- Footer -->
<?php
if (td_util::get_option('tds_footer') != 'no') {
    td_api_footer_template::_helper_show_footer();
}
?>


<!-- Sub Footer -->
<?php if (td_util::get_option('tds_sub_footer') != 'no') { ?>
    <div class="td-sub-footer-container">
        <div class="td-container">
            <div class="td-pb-row">
                <div class="td-pb-span7 td-sub-footer-menu">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-menu',
                            'menu_class'=> 'td-subfooter-menu',
                            'fallback_cb' => 'td_wp_footer_menu'
                        ));

                        //if no menu
                        function td_wp_footer_menu() {
                            //do nothing?
                        }
                        ?>
                </div>

                <div class="td-pb-span5 td-sub-footer-copy">
                    <?php
                    $tds_footer_copyright = stripslashes(td_util::get_option('tds_footer_copyright'));
                    $tds_footer_copy_symbol = td_util::get_option('tds_footer_copy_symbol');

                    //show copyright symbol
                    if ($tds_footer_copy_symbol == '') {
                        echo '&copy; ';
                    }

                    echo $tds_footer_copyright;
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div><!--close td-outer-wrap-->


<div class="newtekadv-mobile-bottom">
  <?php if (function_exists('adv_bottom_mobile')) {
    adv_bottom_mobile();
  } ?>
</div>


<div class="newtekadv-mobile-top">
  <?php if(function_exists('adv_top_mobile_single')) {
    adv_top_mobile_single();
  } ?>
</div>


</div><!-- chiude contenitore -->


<?php wp_footer(); ?>

<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Open Sans:300,400,700', 'Oswald:300,400,700', 'Roboto:300,400,700' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })();
</script>


<?php if (function_exists('floor_ad')) {
  floor_ad();
} ?>


<!-- Tabs Classifiche -->
<script type="text/javascript"> 
jQuery(document).ready(function(){
    jQuery("ul#tabs li").click(function(e){
        if (!jQuery(this).hasClass("active")) {
            var tabNum = jQuery(this).index();
            var nthChild = tabNum+1;
            jQuery("ul#tabs li.active").removeClass("active");
            jQuery(this).addClass("active");
            jQuery("ul#tab li.active").removeClass("active");
            jQuery("ul#tab li:nth-child("+nthChild+")").addClass("active");
        }
    });
}); </script>


<!-- Facebook SDK -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v2.11&appId=1246170328768937';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>


<?php if(is_single()): ?>
    <!-- Facebook share -->
    <script>

        function GetShareTargetCMS(){
            var token = '1246170328768937|88ebaf4c312e68000ed6e0a20e79912d';
                jQuery.ajax({
                    url: 'https://graph.facebook.com/?id='+'<?php the_permalink(); ?>',
                    dataType: 'jsonp',
                    type: 'POST',
                    success: function(data){
                        console.log(data.share);
                            if(typeof data.share != 'undefined'){
                                jQuery('.results_share').empty().html('<span>'+data.share.share_count+'</span>');
                            }else{
                                jQuery('.results_share').empty().html('<span>0</span>');
                            }//else
                    }//success
             });
        }//GetShareTargetCMS
        jQuery(document).ready(function() {
            GetShareTargetCMS();
        });

    </script>

    <script>
        document.getElementById('shareBtn').onclick = function() {
            FB.ui({
                method: 'share',
                mobile_iframe: true,
                href: "<?php the_permalink(); ?>",
            }, function(response){ setTimeout(function(){GetShareTargetCMS()},1000); });
        }
    </script>

<?php endif; ?>

<!-- JavaScript Cookie v2.2.0 -->
<script>
  ;(function(factory){var registeredInModuleLoader=false;if(typeof define==='function'&&define.amd){define(factory);registeredInModuleLoader=true;}
if(typeof exports==='object'){module.exports=factory();registeredInModuleLoader=true;}
if(!registeredInModuleLoader){var OldCookies=window.Cookies;var api=window.Cookies=factory();api.noConflict=function(){window.Cookies=OldCookies;return api;};}}(function(){function extend(){var i=0;var result={};for(;i<arguments.length;i++){var attributes=arguments[i];for(var key in attributes){result[key]=attributes[key];}}
return result;}
function init(converter){function api(key,value,attributes){var result;if(typeof document==='undefined'){return;}
if(arguments.length>1){attributes=extend({path:'/'},api.defaults,attributes);if(typeof attributes.expires==='number'){var expires=new Date();expires.setMilliseconds(expires.getMilliseconds()+attributes.expires*864e+5);attributes.expires=expires;}
attributes.expires=attributes.expires?attributes.expires.toUTCString():'';try{result=JSON.stringify(value);if(/^[\{\[]/.test(result)){value=result;}}catch(e){}
if(!converter.write){value=encodeURIComponent(String(value)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent);}else{value=converter.write(value,key);}
key=encodeURIComponent(String(key));key=key.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent);key=key.replace(/[\(\)]/g,escape);var stringifiedAttributes='';for(var attributeName in attributes){if(!attributes[attributeName]){continue;}
stringifiedAttributes+='; '+attributeName;if(attributes[attributeName]===true){continue;}
stringifiedAttributes+='='+attributes[attributeName];}
return(document.cookie=key+'='+value+stringifiedAttributes);}
if(!key){result={};}
var cookies=document.cookie?document.cookie.split('; '):[];var rdecode=/(%[0-9A-Z]{2})+/g;var i=0;for(;i<cookies.length;i++){var parts=cookies[i].split('=');var cookie=parts.slice(1).join('=');if(!this.json&&cookie.charAt(0)==='"'){cookie=cookie.slice(1,-1);}
try{var name=parts[0].replace(rdecode,decodeURIComponent);cookie=converter.read?converter.read(cookie,name):converter(cookie,name)||cookie.replace(rdecode,decodeURIComponent);if(this.json){try{cookie=JSON.parse(cookie);}catch(e){}}
if(key===name){result=cookie;break;}
if(!key){result[name]=cookie;}}catch(e){}}
return result;}
api.set=api;api.get=function(key){return api.call(api,key);};api.getJSON=function(){return api.apply({json:true},[].slice.call(arguments));};api.defaults={};api.remove=function(key,attributes){api(key,'',extend(attributes,{expires:-1}));};api.withConverter=init;return api;}
return init(function(){});}));
</script>


<?php if ( is_single() && in_category('video') ) :
  //
  else:
?>
  <script type="text/javascript">
    // get cookie value
    var ck = Cookies.get('rb');
    if (ck) {
      console.log("RB cookie set");
    } else {
      console.log("RB cookie not set");  
        function RedirectBoost() {
        // set cookie timeout
        var threehours = new Date(new Date().getTime() + 180 * 60 * 1000);
        // set cookie
        Cookies.set('rb', 'refresh', { expires: threehours });
        // change url
        location.href = window.location.href;
      }
      setTimeout('RedirectBoost()', 120000);
    }
  </script>
<?php endif; ?>


<script>
	//GBS

    jQuery(document).ready(function () {
		
        if (navigator.userAgent.search("iPhone") >= 0) {
            content = `
                        <span class="close">&times;</span>
                        <a href="https://itunes.apple.com/my/app/sampnews24/id1130387688?mt=8">
                            <div class="app-banner__content">
                                <div class="app-banner__text">
                                    Scarica ora la nostra app e naviga più velocemente!
                                </div>
                                <div class="app-banner__logo">
                                    <i class="app-banner__logo app-banner__logo--app-store"></i>
                                </div>
                            </div>
                        </a>`;
        }
        else if (navigator.userAgent.search("Android") >= 0) {
            content = `
                        <span class="close">&times;</span>
                        <a href="https://play.google.com/store/apps/details?id=com.appsbuilder1008218">
                            <div class="app-banner__content">
                                <div class="app-banner__text">
                                    Scarica ora la nostra app e naviga più velocemente!
                                </div>
                                <div class="app-banner__logo">
                                    <i class="app-banner__logo app-banner__logo--google-play"></i>
                                </div>
                            </div>
                        </a>`;
        }else content = '';
		
        jQuery("#android-banner.app-banner").html(content);
		
		
		if (typeof jQuery.cookie('noShowBannerApp') !== 'undefined'){
        	jQuery('#android-banner').hide();
        	jQuery(".contenitore").css('top','55px');
    	}else {
			console.log("else");
        	jQuery("#android-banner.app-banner .close").on('click', function() {
				jQuery("#android-banner").hide();
				jQuery(".contenitore").css('top','55px');
				jQuery.cookie('noShowBannerApp', true);
        	});
    	}
    })
	
	//jquery.cookie.js
	!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?e(require("jquery")):e(jQuery)}(function(e){var o=/\+/g;function n(e){return r.raw?e:encodeURIComponent(e)}function i(n,i){var t=r.raw?n:function(e){0===e.indexOf('"')&&(e=e.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return e=decodeURIComponent(e.replace(o," ")),r.json?JSON.parse(e):e}catch(e){}}(n);return e.isFunction(i)?i(t):t}var r=e.cookie=function(o,t,c){if(void 0!==t&&!e.isFunction(t)){if("number"==typeof(c=e.extend({},r.defaults,c)).expires){var u=c.expires,a=c.expires=new Date;a.setTime(+a+864e5*u)}return document.cookie=[n(o),"=",(d=t,n(r.json?JSON.stringify(d):String(d))),c.expires?"; expires="+c.expires.toUTCString():"",c.path?"; path="+c.path:"",c.domain?"; domain="+c.domain:"",c.secure?"; secure":""].join("")}for(var d,f,p=o?void 0:{},s=document.cookie?document.cookie.split("; "):[],m=0,v=s.length;m<v;m++){var x=s[m].split("="),k=(f=x.shift(),r.raw?f:decodeURIComponent(f)),l=x.join("=");if(o&&o===k){p=i(l,t);break}o||void 0===(l=i(l))||(p[k]=l)}return p};r.defaults={},e.removeCookie=function(o,n){return void 0!==e.cookie(o)&&(e.cookie(o,"",e.extend({},n,{expires:-1})),!e.cookie(o))}});
</script>




<script type="text/javascript" async> 
//Sviluppata da Riccardo Mel
//targetweb.it - riccardomel.com
 
//Trigger - Dove far generare la cookiebar - default:body
//Dominio - no http 
//Link privacy estesa - no http
//Framework - Scegli tra: bootstrap, custom - default:bootstrap
//Position - Scegli tra: fixed, absolute, relative - default:fixed 
//Custom CSS - Passa una variabile contenente i tuoi fix css  es. var customcss_fix = "#cookiebox{ background:blue;}";

function CookieBar(o,e,i,t,n,a){""==o&&(o="body"),""==t&&(t="bootstrap"),""==n&&(n="fixed");var r=Cookies.get("CookieBar");"bootstrap"==t?cookiebox="<style>#cookiebox a{color:#fff; } #cookiebox{ position:"+n+"; top:0px; left:0px; width:100%; padding:10px; margin:0; background:rgba(0,0,0,0.7); border-bottom:2px solid #333; color:#fff;  } .close-cookiebar{cursor:pointer; font-weight:bold; } #cookiebox p{ font-size:12px; margin:0; }  #cookiebox span{ font-size:12px; text-transform:uppercase; float:right; margin:5px 5px; padding:5px;  }  "+a+"      @media screen and (max-width: 320px) { #cookie-controlbar{margin-top:10px; text-align:center;  } #cookie-controlbar span{ float:none; } } @media screen and (min-width: 321px) and (max-width: 480px) { #cookie-controlbar{margin-top:10px; text-align:center;} #cookie-controlbar span{ float:none; }  }</style> <div id='cookiebox'><div class='container'><div class='row'> <div id='cookie-text' class='col-xs-12 col-sm-12 col-md-8'> <p>Questo sito utilizza i cookie per diversi scopi, tra cui la personalizzazione dell'esperienza dell'utente e della pubblicitÃ  online. Continuando a utilizzare il nostro sito acconsenti all'utilizzo dei cookie. </p></div><div id='cookie-controlbar' class='col-xs-12 col-sm-12 col-md-4'><span class='close-cookiebar'>Accetto</span> <a href='https://"+i+"' target='_blank'><span>Informativa Estesa</span></a></div></div></div></div>":cookiebox="<style>#cookiebox a{color:#fff; } #cookiebox{ position:"+n+"; top:0px; left:0px; width:100%; padding:10px; margin:0; background:rgba(0,0,0,0.7); border-bottom:2px solid #333; color:#fff;  } .close-cookiebar{cursor:pointer; font-weight:bold; } #cookiebox p{ font-size:12px; margin:0; }  #cookiebox span{ font-size:12px; text-transform:uppercase; float:right; margin:5px 5px; padding:5px;  }  "+a+"      @media screen and (max-width: 320px) { #cookie-controlbar{margin-top:10px; text-align:center;  } #cookie-controlbar span{ float:none; } } @media screen and (min-width: 321px) and (max-width: 480px) { #cookie-controlbar{margin-top:10px; text-align:center;} #cookie-controlbar span{ float:none; }  }</style> <div id='cookiebox'><div class='cookie-container'><div class='cookie-row'> <div id='cookie-text'> <p>Questo sito utilizza i cookie per diversi scopi, tra cui la personalizzazione dell'esperienza dell'utente e della pubblicitÃ  online. Continuando a utilizzare il nostro sito acconsenti all'utilizzo dei cookie. </p></div><div id='cookie-controlbar'><span class='close-cookiebar'>Accetto</span> <a href='https://"+i+"' target='_blank'><span>Informativa Estesa</span></a></div></div></div></div>",1==r?console.log("CookieBar Targetweb: Cookie policy accettata!"):jQuery(cookiebox).appendTo(o),window.onscroll=function(o){jQuery("#cookiebox").fadeOut(),Cookies.set("CookieBar","1",{expires:730,domain:e})},jQuery(".close-cookiebar").click(function(){jQuery("#cookiebox").fadeOut(),Cookies.set("CookieBar","1",{expires:730,domain:e})})}!function(o){if("function"==typeof define&&define.amd)define(o);else if("object"==typeof exports)module.exports=o();else{var e=window.Cookies,i=window.Cookies=o();i.noConflict=function(){return window.Cookies=e,i}}}(function(){function o(){for(var o=0,e={};o<arguments.length;o++){var i=arguments[o];for(var t in i)e[t]=i[t]}return e}function e(i){function t(e,n,a){var r;if("undefined"!=typeof document){if(arguments.length>1){if(a=o({path:"/"},t.defaults,a),"number"==typeof a.expires){var c=new Date;c.setMilliseconds(c.getMilliseconds()+864e5*a.expires),a.expires=c}try{r=JSON.stringify(n),/^[\{\[]/.test(r)&&(n=r)}catch(s){}return n=i.write?i.write(n,e):encodeURIComponent(String(n)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),e=encodeURIComponent(String(e)),e=e.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),e=e.replace(/[\(\)]/g,escape),document.cookie=[e,"=",n,a.expires?"; expires="+a.expires.toUTCString():"",a.path?"; path="+a.path:"",a.domain?"; domain="+a.domain:"",a.secure?"; secure":""].join("")}e||(r={});for(var l=document.cookie?document.cookie.split("; "):[],p=/(%[0-9A-Z]{2})+/g,d=0;d<l.length;d++){var f=l[d].split("="),x=f.slice(1).join("=");'"'===x.charAt(0)&&(x=x.slice(1,-1));try{var u=f[0].replace(p,decodeURIComponent);if(x=i.read?i.read(x,u):i(x,u)||x.replace(p,decodeURIComponent),this.json)try{x=JSON.parse(x)}catch(s){}if(e===u){r=x;break}e||(r[u]=x)}catch(s){}}return r}}return t.set=t,t.get=function(o){return t(o)},t.getJSON=function(){return t.apply({json:!0},[].slice.call(arguments))},t.defaults={},t.remove=function(e,i){t(e,"",o(i,{expires:-1}))},t.withConverter=e,t}return e(function(){})});

var customcss_fix = "#cookiebox{ z-index: 99999; background:#2041a0!important; border-bottom:2px solid #132E7F!important; } .cookie-container{ width:1068px; margin:0 auto; padding:0;} .cookie-row{width:1068px; overflow:hidden;} #cookie-text{ width:65%; font-size:12px; float:left; } #cookie-controlbar{ width:30%; float:right; margin-right:10px; } @media screen and (max-width: 320px) { .cookie-container{ width:100%;} .cookie-row{width:100%;} #cookie-text{ width:100%;} #cookie-controlbar{ width:100%;} } @media screen and (min-width: 321px) and (max-width: 480px) { .cookie-container{width:100%;} .cookie-row{width:100%;} #cookie-text{ width:100%;} #cookie-controlbar{ width:100%;} }";
CookieBar("#cookiebar-holder","www.sampnews24.com","www.sampnews24.com/privacy-policy","custom","relative", customcss_fix); 
</script>

</body>

</html>