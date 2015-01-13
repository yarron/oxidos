<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-file"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_delete']?>" id="delete" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <?if($message):?>
                <div class="alert alert-success" role="alert">
                    <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                    <span class="sr-only">Success:</span>
                    <?=$message?>
                </div>
            <?endif?>
            <div class="container-fluid" id="logs">
                <div class="row">
                  <div id="column-left"  class="col-sm-2 col-md-2"></div>
                  <div id="column-right" class="col-sm-3 col-sm-offset-1 col-md-3 col-md-offset-1 jstree-default"></div>
                  <div id="column-logs"  class="col-sm-5 col-sm-offset-1 col-md-5 col-md-offset-1"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>
<script><!--
$(document).ready(function() {
    function loadNodes(tree, node, cb) {
        var nodeId = node.id == "#" ? "" : node.id; //id дерева
        var nodeText = node.id!="#" ? node.text : ''; //название папки
        var nodeParent = node.id!="#" ? node.li_attr['data-parent'] : ''; //путь до родителя

        $.ajax({
            url: '/admin/logs/directory',
            type: 'post',
            data: {id : nodeId, dir: nodeText, parent:nodeParent},
            dataType: 'json',
            success: function(nodes) {
                cb.call(tree, nodes);
            }
        });
    }

    function selectNode(node, selected, event){
        var nodeText = selected.node.parent != '#' ? selected.node.text : ''; //название папки
        var nodeParent = selected.node.parent != '#' ? selected.node.li_attr['data-parent'] : ''; //путь до родителя

        $.ajax({
            url: '/admin/logs/files',
            type: 'post',
            data: {directory: nodeText, parent: nodeParent},
            dataType: 'json',
            success: function(json) {
                html = '<div>';
                if (json) {
                    for (i = 0; i < json.length; i++) {
                        name = '';
                        filename = json[i]['filename'];
                        for (j = 0; j < filename.length; j = j + 15) {
                            name += filename.substr(j, 15) + '<br />';
                        }
                        name += json[i]['size'];
                        html += '<a file="' + json[i]['file'] + '"><i class="glyphicon glyphicon-file lazy btn-lg" ></i><br />' + name + '</a>';
                    }

                }

                html += '</div>';

                $('#column-right').html(html);
                $('i.lazy').lazyload({
                    container: $('#column-right'),
                    effect : "fadeIn"
                });
                $('#column-logs').html("");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }

    $("#column-left").jstree({
        "plugins": ["themes"],
        "core" : {
            themes: {"stripes": true},
            check_callback : true,
            animation : 400,
            data : function (node, cb) {
                loadNodes(this, node, cb);
            }
        }
    });
    $("#column-left").on('select_node.jstree', function (node, selected, event) {
        selectNode(node, selected, event);
    });

    //выделение изображение по клику
    $('#column-right').on('click','a', function() {

        if ($(this).attr('class') == 'jstree-clicked') {
            $(this).removeAttr('class');
            $('#column-logs').html("");
        } else {
            $('#column-right a').removeAttr('class');
            $(this).attr('class', 'jstree-clicked');
            $.ajax({
                url: '/admin/logs/log',
                type: 'post',
                data: 'file='+$(this).attr('file'),
                dataType: 'json',
                success: function(json) {
                    html = '<div>';
                    if (json) {
                        for (i = 2; i < json.length; i++) {
                            html += json[i];
                            html += '<br />';
                        }
                    }
                    html += '</div>';
                    $('#column-logs').html(html);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });
    $('#delete').on('click', function() {
		path = $('#column-right a.jstree-clicked').attr('file');

		if (path) {
			$.ajax({
				url: '/admin/logs/delete',
				type: 'post',
				data: 'path=logs/' + encodeURIComponent(path),
				dataType: 'json',
				success: function(json) {
					if (json.success) {
                        $('#column-right a.jstree-clicked').remove();
                        $('#column-logs').html("");
						alert(json.success);
					}
					
					if (json.error) {
						alert(json.error);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});				
		} else {
            var tree = $('#column-left').jstree(true), sel = tree.get_selected();
            if(!sel.length) {
                alert('<?=$text['error_select']?>');
                return false;
            }
            else{
                var dir = tree._data.core.last_clicked.li_attr['data-parent']+tree._data.core.last_clicked.text;
                if(dir){
                    $.ajax({
                        url: '/admin/logs/delete',
                        type: 'post',
                        data: {path:dir},
                        dataType: 'json',
                        success: function(json) {
                            if (json.success) {
                                $('#column-right').html("");
                                tree.delete_node(sel);
                                tree.refresh();
                                alert(json.success);
                            }

                            if (json.error) {
                                alert(json.error);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            }
		}
	});
});
//--></script>
	