(function() {
    tinymce.create('tinymce.plugins.video_samp24', {
        init : function(ed, url) {
            ed.addButton('video_samp24', {
                title : 'Aggiungi video',
                image : url+"/video_samp24.png",
                onclick : function() {
                     ed.selection.setContent('[video_samp24 url="" autoplay="false" width="100%" height="300" mute="false" repeat="false"]' + ed.selection.getContent());
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('video_samp24', tinymce.plugins.video_samp24);
})();