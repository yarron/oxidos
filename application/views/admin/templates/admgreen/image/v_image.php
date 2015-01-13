<div class="modal fade" id="modal">
<link href='/styles/admin/bower_components/jstree/dist/themes/default/style.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/styles/admin/bower_components/blueimp-file-upload/css/jquery.fileupload.css">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?=$text['heading_title']?></h4>
            </div>
            <div class="modal-body">
                <?if($permission):?>
                <div class="container-fluid" id="editor-img">
                    <div class="row" id="menu">
                        <div class="col-sm-8" id="message"></div>
                        <div class="col-sm-4">
                            <div class="btn-group btn-group-sm" role="group" >
                                <button data-toggle="tooltip" title="<?=$text['button_upload']?>" id="upload" class="btn btn-primary fileinput-button" >
                                    <i class="glyphicon glyphicon-open"></i>
                                    <input id="fileupload" type="file" name="image[]" multiple>
                                </button>
                                <button data-toggle="tooltip" title="<?=$text['button_rename_file']?>" id="rename" class="btn btn-primary" ><i class="glyphicon glyphicon-pencil"></i></button>
                                <button data-toggle="tooltip" title="<?=$text['button_copy_file']?>" id="copy" class="btn btn-primary" ><i class="glyphicon glyphicon-floppy-save"></i></button>
                                <button data-toggle="tooltip" title="<?=$text['button_delete_file']?>" id="delete" class="btn btn-primary" ><i class="glyphicon glyphicon-trash"></i></button>
                                <button data-toggle="tooltip" title="<?=$text['button_refresh']?>" id="refresh" class="btn btn-primary" ><i class="glyphicon glyphicon-refresh"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3" id="column-left"><ul></ul></div>
                        <div class="col-sm-9 jstree-default" id="column-right"></div>
                    </div>
                </div>
                <?else:?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <?=$text['error_permission']?>
                    </div>
                <?endif?>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-10">
                            <div id="progress" class="progress" style="height: 30px;margin-bottom: 0px;display: none">
                                <div role="progressbar" class="progress-bar progress-bar-success progress-bar-striped active" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-sm-2"><button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?=$text['button_close']?></button></div>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
<?if($permission):?>
<script src="/styles/admin/bower_components/jstree/dist/jstree.min.js"></script>
<script src="/styles/admin/bower_components/jquery.lazyload/jquery.lazyload.min.js"></script>
<script src="/styles/admin/bower_components/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/styles/admin/bower_components/blueimp-file-upload/js/jquery.iframe-transport.js"></script>
<script src="/styles/admin/bower_components/blueimp-file-upload/js/jquery.fileupload.js"></script>

<script><!--
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();

    function displayMsg(msg) {
        $("#message").html('<div class="alert alert-success" style="padding: 4px;margin-bottom: 10px;" role="alert"><i class="glyphicon glyphicon-ok"></i> ' + msg + '</div>');
    }

    function displayErr(err) {
        $("#message").html('<div class="alert alert-warning" style="padding: 4px;margin-bottom: 10px;" role="alert"><i class="glyphicon glyphicon-warning-sign"></i> ' + err + '</div>');
    }

    //события дерева
    $("#column-left")
        .jstree({
            "plugins": ["contextmenu", "dnd", "search", "state", "types", "wholerow"],
            "core" : {
                themes: {"stripes": true},
                check_callback : true,
                animation : 400,
                multiple:false,
                data : function (node, cb) {
                    var nodeId = node.id == "#" ? "" : node.id; //id дерева
                    var nodeText = node.id!="#" ? node.text : ''; //название папки
                    var nodeParent = node.id!="#" ? node.li_attr['data-parent'] : ''; //путь до родителя
                    $.ajax({
                        url: '/admin/image/directory',
                        type: 'post',
                        data: {id : nodeId, dir: nodeText, parent:nodeParent},
                        dataType: 'json',
                        success: function(nodes) {
                            cb.call(this, nodes);
                        }
                    });
                }
            },
            "contextmenu" : {
                "items" : function (node) {
                    return {
                        "rename" : {
                            label: "<?=$text['button_rename']?>",
                            icon:'glyphicon glyphicon-edit',
                            action: function(obj) {
                                var ref = $("#column-left").jstree(true);
                                var sel = ref.get_selected(true);

                                if(sel.length) {
                                    sel = sel[0];
                                    ref.edit(sel);
                                } else {
                                    displayErr('<?=$text['error_directory']?>');
                                }
                            }
                        },
                        "create" : {
                            label: "<?=$text['button_create']?>",
                            icon:'glyphicon glyphicon-folder-close',
                            action: function() {
                                var ref = $("#column-left").jstree(true);
                                var sel = ref.get_selected(true);

                                if(sel.length){
                                    sel = sel[0];
                                    var text = "<?=$text['button_folder']?>";

                                    if(sel.text == 'image') var dir = sel.li_attr['data-parent'];
                                    else var dir = sel.li_attr['data-parent']+sel.text+'/';

                                    $.ajax({
                                        url: '/admin/image/create',
                                        type: 'post',
                                        data: {directory: dir, name: text},
                                        dataType: 'json',
                                        success: function(json) {
                                            if (json.success) {
                                                var cre = ref.create_node(sel, {"type":"folder","li_attr":{"data-parent":dir},"text":text},"first");
                                                ref.edit(cre);
                                                displayMsg(json.success);
                                            }else{
                                                displayErr(json.error);
                                            }
                                        },
                                        error: function(xhr, ajaxOptions, thrownError) {
                                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                        }
                                    });

                                }else{
                                    displayErr('<?=$text['error_directory']?>');
                                }
                            }
                        },
                        "delete" : {
                            label: "<?=$text['button_delete']?>",
                            icon:'glyphicon glyphicon-trash',
                            action: function() {
                                    var ref = $("#column-left").jstree(true);
                                    var sel = ref.get_selected(true);

                                    if(sel.length){
                                        sel = sel[0];
                                        if(sel.text == 'image')
                                            var path = sel.li_attr['data-parent'];
                                        else
                                            var path = sel.li_attr['data-parent']+sel.text;

                                        $.ajax({
                                            url: '/admin/image/delete',
                                            type: 'post',
                                            data: {path:path},
                                            dataType: 'json',
                                            success: function(json) {
                                                if (json.success) {
                                                    ref.delete_node(ref.get_selected());
                                                    displayMsg(json.success);
                                                }

                                                if (json.error) {
                                                    displayErr(json.error);
                                                }
                                            },
                                            error: function(xhr, ajaxOptions, thrownError) {
                                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                            }
                                        });
                                    } else {
                                        displayErr('<?=$text['error_directory']?>');
                                    }
                            },
                            separator_before: true
                        }
                    }
                }
            }
    }) //инициализация дерева
        .on("copy_node.jstree", function(event, data) {
            $("#message").html('');
            var text = data.node.text;
            var old_parent_obj = data['new_instance']._model.data[data.old_parent];
            var parent_obj = data['new_instance']._model.data[data.parent];

            if(old_parent_obj.parent == '#')
                var dir_old = old_parent_obj.li_attr['data-parent'] + text;
            else
                var dir_old = old_parent_obj.li_attr['data-parent'] + old_parent_obj.text+'/'+text;

            if(parent_obj.parent =='#')
                var dir_new = parent_obj.li_attr['data-parent'] + text+'_';
            else
                var dir_new = parent_obj.li_attr['data-parent'] + parent_obj.text+'/'+text+'_';

            $.ajax({
                url: '/admin/image/copy',
                type: 'post',
                data: {from: dir_old, to: dir_new},
                dataType: 'json',
                success: function(json) {
                    if (json.success) {
                        displayMsg(json.success);
                    }

                    if (json.error) {
                        displayErr(json.error);
                    }
                    $("#column-left").jstree(true).refresh_node(data.parent);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

        })//событие, наступающее после того, как папку скопировали
        .on('select_node.jstree', function (node, selected, event) {

            if(selected.node.parent == '#')
                var dir = selected.node.li_attr['data-parent'];
            else
                var dir = selected.node.li_attr['data-parent'] + selected.node.text;

            $.ajax({
                url: '/admin/image/files',
                type: 'post',
                data: {directory: dir},
                dataType: 'json',
                success: function(json) {
                    var html = '<div>';
                    if (json) {
                        for (i = 0; i < json.length; i++) {
                            var name = '';
                            filename = json[i]['filename'];
                            for (j = 0; j < filename.length; j = j + 15) {
                                name += filename.substr(j, 15);
                            }
                            size = json[i]['size'];
                            html += '<a file="' + json[i]['file'] + '" data-toggle="tooltip" title="'+size+'"><img class="lazy" src="<?php echo $data['no_image']; ?>" data-original="' + json[i]['thumb'] + '"  width="160" height="70" /><br />';
                            html += '<div class="input-group input-group-sm" style="width:170px">';
                            html += '<input type="text" style="font-size: 10px" class="form-control"  disabled="disabled" value="'+name+'" /><span class="input-group-addon" id="button-rename"><i class="glyphicon glyphicon-picture"></i></span>';
                            html += '</div>';
                            html += '</a>'
                        }
                    }
                    html += '</div>';

                    $('#column-right').html(html);
                    $('img.lazy').lazyload({
                        container: $('#column-right'),
                        effect : "fadeIn"
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }) //событие выбора ветки дерева
        .on("rename_node.jstree", function(node, tree) {
            $("#message").html('');
            if(tree.node.parent == '#')
                var path = tree.node.li_attr['data-parent'];
            else
                var path = tree.node.li_attr['data-parent']+tree.old;

            var name = tree.text;

            $.ajax({
                url: '/admin/image/rename',
                type: 'post',
                data: {path:path, name:name},
                dataType: 'json',
                success: function(json) {
                    if (json.success) {
                        displayMsg(json.success);
                    }
                    if (json.error) {
                        displayErr(json.error);
                    }
                    $("#column-left").jstree(true).refresh();

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

        }) //событие, наступающее после того, как папку переименовали
        .on("move_node.jstree", function(event, data) {
            $("#message").html('');
            var text = data.node.text;
            var old_parent_obj = data['new_instance']._model.data[data.old_parent];
            var parent_obj = data['new_instance']._model.data[data.parent];

            if(old_parent_obj.parent == '#')
                var dir_old = old_parent_obj.li_attr['data-parent'] + text;
            else
                var dir_old = old_parent_obj.li_attr['data-parent'] + old_parent_obj.text+'/'+text;

            if(parent_obj.parent =='#')
                var dir_new = parent_obj.li_attr['data-parent'];
            else
                var dir_new = parent_obj.li_attr['data-parent'] + parent_obj.text;

            $.ajax({
                url: '/admin/image/move',
                type: 'post',
                data: {from: dir_old, to: dir_new},
                dataType: 'json',
                success: function(json) {
                    if (json.success) {
                        displayMsg(json.success);
                    }
                    if (json.error) {
                        displayErr(json.error);
                    }
                    $("#column-left").jstree(true).refresh_node(data.parent);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

        });//событие, наступающее после того, как папку переместили

    //события у изображений
	$('#column-right')
        .on('click','a', function() {
            if ($(this).attr('class') == 'jstree-clicked') {
                $(this).removeAttr('class');
            } else {
                $('#column-right a').removeAttr('class');
                $(this).attr('class', 'jstree-clicked');
            }
        }) //выделение изображение по клику
        .on('dblclick','a', function() {
            <?php if ($data['fckeditor']) { ?>
                var src = "<?=$data['directory']?>" + $(this).attr('file');

                if(src) {
                    $('#modal').modal('hide');
                    $('#modal-sm').find('.note-image-url').val(src);
                    $('#modal-sm').find('.note-image-btn').toggleClass('disabled', false).attr('disabled', false);
                    $('#modal-sm').css("display", 'block').removeAttr("id");
                }
                else{
                    displayErr('<?=$text['error_editor']?>');
                }

            <?php } else { ?>
            var path = $(this).attr('file');

            $.ajax({
                url: '/admin/image/image/',
                type: 'post',
                data: {image: path},
                dataType: 'text',
                success: function(data) {
                    $('#<?=$data['field']?>').attr('value', path);
                    $('#<?=$data['thumb']?>').replaceWith('<img src="' + data + '" alt="" id="<?=$data['thumb']?>" class="img-thumbnail" />');
                    $('#modal').modal('hide');
                }
            });
            <?php } ?>
        }) //загрузка изображения по 2-му клику
        .on('click','#button-rename', function() {
            var name = $(this).parent().children('.form-control').val();
            var path = $(this).attr('data-path');
            $.ajax({
                 url: '/admin/image/rename',
                 type: 'post',
                 data: 'path=' + encodeURIComponent(path) + '&name=' + encodeURIComponent(name),
                 dataType: 'json',
                 success: function(json) {
                     if (json.success) {
                         var tree = $("#column-left").jstree(true);
                         var sel = tree.get_selected();
                         tree.deselect_all();
                         tree.select_node(sel);
                         displayMsg(json.success);
                     }

                     if (json.error) {
                         var tree = $("#column-left").jstree(true);
                         var sel = tree.get_selected();
                         tree.deselect_all();
                         tree.select_node(sel);
                         displayErr(json.error);
                     }
                 },
                 error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                 }
            });
        });

    //события у меню
    $('#menu')
        .on('click','#refresh', function() {
            $("#message").html('');
            $("#column-left").jstree(true).refresh();
        }) //событие обновления всех папок
        .on('click','#rename', function() {
            $("#message").html('');
            path = $('#column-right a.jstree-clicked').attr('file');

            if (path) {
                $('#column-right a.jstree-clicked  .form-control').attr('disabled', false).trigger('select');
                $('#column-right a.jstree-clicked  .input-group-addon').html('<i class="glyphicon glyphicon-floppy-save"></i>').attr({"id":"button-rename","data-path": path});
            } else
                displayErr('<?=$text['error_file']?>');

        }) //событие переименования файла
        .on('click','#delete', function() {
            $("#message").html('');
            path = $('#column-right a.jstree-clicked').attr('file');
            if (path) {
                $.ajax({
                    url: '/admin/image/delete',
                    type: 'post',
                    data: 'path=' + encodeURIComponent(path),
                    dataType: 'json',
                    success: function(json) {
                        if (json.success) {
                            var tree = $("#column-left").jstree(true);
                            var sel = tree.get_selected();
                            tree.deselect_all();
                            tree.select_node(sel);
                            displayMsg(json.success);
                        }

                        if (json.error) {
                            displayErr(json.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }else
                displayErr('<?=$text['error_file']?>');
        }) //событие удаления файла
        .on('click','#copy', function(){
            $("#message").html('');
            path = $('#column-right a.jstree-clicked').attr('file');
            if (path) {
                $.ajax({
                    url: '/admin/image/copy',
                    type: 'post',
                    data: 'from=' + encodeURIComponent(path)+'&to=' + encodeURIComponent(path),
                    dataType: 'json',
                    success: function(json) {
                        if (json.success) {
                            var tree = $("#column-left").jstree(true);
                            var sel = tree.get_selected();
                            tree.deselect_all();
                            tree.select_node(sel);
                            displayMsg(json.success);
                        }

                        if (json.error) {
                            displayErr(json.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }else
                displayErr('<?=$text['error_file']?>');
        }) //событие копирования файла
        .on('click','#upload', function(){
            $("#message").html('');
            $(this)
                .fileupload({
                    url: '/admin/image/upload',
                    dataType: 'json',
                    done: function (e, data) {

                        json = data.result;
                        if (json.success) {
                            var tree = $("#column-left").jstree(true);
                            var sel = tree.get_selected();

                            setTimeout(function(){
                                tree.deselect_all();
                                tree.select_node(sel);
                                $('#progress .progress-bar').removeClass('active');
                                $('#progress').css('display','none');
                                displayMsg(json.success);
                            }, 500)
                        }
                        if (json.error) {
                            setTimeout(function(){
                                $('#progress .progress-bar').removeClass('active');
                                $('#progress').css('display','none');
                                displayErr(json.error);
                            }, 500)
                        }
                    },
                    progressall: function (e, data) {
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $('#progress .progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
                    }
                })
                .prop('disabled', !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : 'disabled')
                .on('fileuploadsubmit', function (e, data) {

                    var tree = $("#column-left").jstree(true);
                    var sel = tree.get_selected();
                    if(sel.length) {
                        $('#progress').css('display','block');
                        $('#progress .progress-bar').css('width', 0 + '%').attr('aria-valuenow', 0).addClass('active');
                        if(tree._model.data[sel].parent == '#')
                            var dir = tree._model.data[sel].li_attr['data-parent'];
                        else
                            var dir = tree._model.data[sel].li_attr['data-parent']+tree._model.data[sel].text;

                        data.formData = {'directory': dir};
                    }else{
                        displayErr('<?=$text['error_directory']?>');
                        return false;
                    }


                });
        }); //событие загрузки файла
});

//--></script>
<?endif?>
</div>