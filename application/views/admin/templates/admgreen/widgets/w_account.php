<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-user"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/widgets" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <?if($errors):?>
                <?foreach ($errors as $error):?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <?=$error?>
                    </div>
                <?endforeach?>
            <?endif?>
            <?=Form::open('admin/widgets/waccount/', array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div class="container-fluid" id="widget">
                <div class="row bg-success">
                    <div class="col-sm-4"><span class="btn"><?=$text['entry_layout']?></span></div>
                    <div class="col-sm-4"><span class="btn"><?=$text['entry_position']?></span></div>
                    <div class="col-sm-2"><span class="btn"><?=$text['entry_status']?></span></div>
                    <div class="col-sm-1"><span class="btn"><?=$text['entry_sort_order']?></span></div>
                    <div class="col-sm-1"></div>
                </div>
                <?php $widget_row = 0; ?>
                <?foreach ($widgets as $widget) :?>
                    <div class="row" id="widget-row<?=$widget_row?>"><br/>
                        <div class="col-sm-4">
                            <select class="form-control" name="waccount[<?=$widget_row?>][layout_id]">
                                <?php foreach ($layouts as $layout) { ?>
                                    <?if ($layout->id == $widget['layout_id']):?>
                                        <option value="<?=$layout->id?>" selected="selected"><?=$layout->name?></option>
                                    <?else:?>
                                        <option value="<?=$layout->id?>"><?=$layout->name?></option>
                                    <?endif?>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control" name="waccount[<?=$widget_row?>][position]">
                                <?if ($widget['position'] == 'content_top'):?>
                                    <option value="content_top" selected="selected"><?=$text['text_content_top']?></option>
                                <?else:?>
                                    <option value="content_top"><?=$text['text_content_top']?></option>
                                <?endif?>
                                <?if ($widget['position'] == 'content_bottom'):?>
                                    <option value="content_bottom" selected="selected"><?=$text['text_content_bottom']?></option>
                                <?else:?>
                                    <option value="content_bottom"><?=$text['text_content_bottom']?></option>
                                <?endif?>
                                <?if ($widget['position'] == 'column_left'):?>
                                    <option value="column_left" selected="selected"><?=$text['text_column_left']?></option>
                                <?else:?>
                                    <option value="column_left"><?=$text['text_column_left']?></option>
                                <?endif?>
                                <?if ($widget['position'] == 'column_right'):?>
                                    <option value="column_right" selected="selected"><?=$text['text_column_right']?></option>
                                <?else:?>
                                    <option value="column_right"><?=$text['text_column_right']?></option>
                                <?endif?>
                                <?if ($widget['position'] == 'block_slider'):?>
                                    <option value="block_slider" selected="selected"><?=$text['text_slider']?></option>
                                <?else:?>
                                    <option value="block_slider"><?=$text['text_slider']?></option>
                                <?endif?>
                            </select>
                        </div>
                        <div class="col-sm-2"><?=Form::checkbox("waccount[".$widget_row."][status]", 1, isset($widget['status']) ? true : false, array('class'=> 'form-control', 'style'=>'width:30px'))?></div>
                        <div class="col-sm-1"><?=Form::input("waccount[".$widget_row."][sort_order]", isset($widget) ? $widget['sort_order'] : "", array('class'=> 'form-control', 'style'=>'width:50px'))?></div>
                        <div class="col-sm-1"><a class="btn btn-primary" data-toggle="tooltip" title="<?=$text['button_remove']?>" onclick="$('#widget-row<?=$widget_row?>').remove();" ><i class="glyphicon glyphicon-minus-sign"></i></a></div>
                    </div>
                    <?php $widget_row++; ?>
                <?endforeach?>
                <div class="row" id="foot"><br/>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-1"><a id="addWidget" data-toggle="tooltip" title="<?=$text['button_add_widget']?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i></a></div>
                </div>
            </div>
            <?=Form::close()?>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>
<script><!--
var widget_row = <?=$widget_row?>;

$('#widget').on('click', '#addWidget',function () {
    html  = '<div class="row" id="widget-row' + widget_row + '" ><br/>';
        html += '<div class="col-sm-4"><select class="form-control" name="waccount[' + widget_row + '][layout_id]">';
            <?foreach ($layouts as $layout):?>
            html += '<option value="<?=$layout->id?>"><?=addslashes($layout->name)?></option>';
            <?endforeach?>
	    html += '</select></div>';
        html += '<div class="col-sm-4"><select class="form-control" name="waccount['+ widget_row +'][position]">';
            html += '<option value="content_top"><?=$text["text_content_top"]?></option>';
            html += '<option value="content_bottom"><?=$text["text_content_bottom"]?></option>';
            html += '<option value="column_left"><?=$text["text_column_left"]?></option>';
            html += '<option value="column_right"><?=$text["text_column_right"]?></option>';
            html += '<option value="block_slider"><?=$text["text_slider"]?></option>';
        html += '</select></div>';
        html += '<div class="col-sm-2"><input class="form-control" style="width:30px" type="checkbox" name="waccount[' + widget_row + '][status]" value="1" checked="checked"></div>';
        html += '<div class="col-sm-1"><input class="form-control" type="text"    name="waccount[' + widget_row + '][sort_order]" value="0" style="width:50px" ></div>';
        html += '<div class="col-sm-1"><a data-toggle="tooltip" title="<?=$text["button_remove"]?>" class="btn btn-primary" onclick="$(\'#widget-row' + widget_row + '\').remove();" ><i class="glyphicon glyphicon-minus-sign"></i></a></div>';
    html += '</div>';
	$('#widget #foot').before(html);
	widget_row++;
});
//--></script>
