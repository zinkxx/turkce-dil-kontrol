(function (wp) {
    var el = wp.element.createElement;
    var registerPlugin = wp.plugins.registerPlugin;

    var DilKontrolButton = function () {
        return el(wp.editPost.PluginSidebar, {
            name: 'dilkontrol-sidebar',
            icon: 'editor-spellcheck',
            title: 'Dil Kontrolü',
            children: el('button', {
                className: 'button button-primary',
                onClick: function () {
                    alert('Gutenberg Dil Kontrolü çalıştırılıyor...');
                }
            }, 'Dil Kontrolü Yap')
        });
    };

    registerPlugin('dilkontrol-plugin', {
        render: DilKontrolButton
    });
})(window.wp);
