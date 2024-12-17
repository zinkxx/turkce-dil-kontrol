jQuery(document).ready(function ($) {
    $('#dilkontrol-btn').on('click', function () {
        var content = $('#content').val(); // WordPress editöründeki içeriği al

        if (content) {
            alert('Dil kontrolü başlatılıyor...');
            $.post(ajaxurl, {
                action: 'turkce_dilkontrol',
                content: content
            }, function (response) {
                if (response.success) {
                    var results = response.data.split("\n");
                    var updatedContent = content;

                    // Hataları içeriğin altına ekle
                    results.forEach(function (error, index) {
                        var match = error.match(/\(Konum: (\d+)\)/);
                        if (match) {
                            var position = parseInt(match[1]);
                            var before = updatedContent.substring(0, position);
                            var after = updatedContent.substring(position);
                            updatedContent = before + '<span class="dilkontrol-error" title="' + error + '">' + after[0] + '</span>' + after.slice(1);
                        }
                    });

                    $('#content').val(updatedContent);
                    alert("Dil kontrolü tamamlandı. Hatalar işaretlendi.");
                } else {
                    alert("Hata: " + response.data);
                }
            });
        } else {
            alert('Lütfen içeriği doldurun.');
        }
    });
});
