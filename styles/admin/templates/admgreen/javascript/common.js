$(document).ready(function() {
    $('main')
        .on('click', '.btn-image' ,function () {

            var btn = $(this).button('loading');
            var self = this;

            $.ajax({
                url: '/admin/image',
                type: 'post',
                data: {editor: true},
                beforeSend: function(){
                    $('#modal').remove();
                },
                dataType: 'html',
                success: function(data) {
                    $('main').prepend(data);
                    $(self).parentsUntil(".note-editor").find('.note-image-dialog').css("display", 'none').attr('id', 'modal-sm');
                    $('#modal').modal();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },
                complete: function(){
                    btn.button('reset');
                }
            });
        })      //кнопка для вызова менеджера изображений из редактора
        .on('click', '.btn-editor',function () {
            var field = $(this).attr('data-image');
            var thumb = $(this).attr('data-thumb');
            var btn = $(this).button('loading');

            $.ajax({
                url: '/admin/image',
                type: 'post',
                data: {field: field, thumb: thumb},
                beforeSend: function(){ $('#modal').remove(); },
                dataType: 'html',
                success: function(data) {
                    $('main').prepend(data);
                    $('#modal').modal();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },
                complete: function(){
                    btn.button('reset');
                }
            });
        })      //кнопка для вызова менеджера изображений
        .on('click', '.btn-preview',function () {
            var lang = $(this).attr('data-lang');
            var title = $('#title-'+lang).val();
            var seo_title = $('#seo_title-'+lang).val();
            var description = $('#description-'+lang).code();
            var btn = $(this).button('loading');

            $.ajax({
                url: '/admin/image/preview',
                type: 'post',
                data: {title : title, seo_title : seo_title, description : description},
                dataType: 'html',
                beforeSend: function(){ $('#modal').remove(); },
                success: function(data) {
                    $('main').prepend(data);
                    $('#modal').modal();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },
                complete: function(){
                    btn.button('reset');
                }
            });
        })     //кнопка для вызова предпросмотра
        .on('hidden.bs.modal','#modal', function () {
            $('#modal-sm').css("display", 'block').removeAttr("id");

        });
});
