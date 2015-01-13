<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-pushpin"></i>
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
            <?=Form::open('admin/widgets/whtml/', array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div role="tabpanel">
                <?php $widget_row = 1; ?>
                <ul id="tabs-main" class="nav nav-tabs" role="tablist">
                    <? foreach ($widgets as $widget): ?>
                        <li role="presentation" id="widget-<?=$widget_row?>"  >
                            <a href="#tab-widget-<?=$widget_row?>" aria-controls="tab-widget-<?=$widget_row?>" role="tab" data-toggle="tab">
                                <?=$text['tab_widget'] . ' ' . $widget_row?>&nbsp;<i onclick="$('#tabs-main a:first').tab('show'); $('#widget-<?=$widget_row?>').remove(); $('#tab-widget-<?=$widget_row?>').remove(); return false;" class="glyphicon glyphicon-minus-sign" style="cursor:pointer"></i>
                            </a>
                        </li>
                        <?php $widget_row++; ?>
                    <?endforeach?>
                    <li role="presentation">
                        <a  style="cursor:pointer"  id="widget-add" role="tab" ><?=$text['button_add_widget']; ?>&nbsp;<i class="glyphicon glyphicon-plus-sign"></i></a>
                    </li>
                </ul>
                <div class="tab-content" id="tab-content">
                    <?php $widget_row = 1; ?>
                    <?foreach ($widgets as $widget):?>
                        <div role="tabpanel" class="tab-pane fade"  id="tab-widget-<?=$widget_row; ?>">
                        <br/>
                            <ul id="tabs-language-<?=$widget_row; ?>" class="nav nav-tabs" role="tablist">
                                <? foreach ($languages as $language) : ?>
                                    <li role="presentation">
                                        <a href="#language-<?=$widget_row; ?>-<?=$language->id?>" aria-controls="language<?=$language->id?>" role="tab" data-toggle="tab">
                                            <?=HTML::image('styles/'.$template . 'image/flags/'.$language->image, array('title' => $language->name))?> <?=$language->name ?>
                                        </a>
                                    </li>
                                <?endforeach?>
                            </ul>
                            <div class="tab-content">
                                <? foreach ($languages as $language) : ?>
                                <div role="tabpanel" class="tab-pane fade" id="language-<?=$widget_row; ?>-<?=$language->id ?>">
                                    <br/>
                                    <div class="form-group">
                                        <?=Form::label("whtml[".$widget_row."][title]", '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_title'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::input("whtml[".$widget_row."][title][".$language->id."]", isset($widget['title'][$language->id]) ? $widget['title'][$language->id] : "", array('class'=>'form-control'))?></div>
                                    </div>
                                    <div class="form-group">
                                        <?=Form::label('whtml['.$widget_row.'][description]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_description'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::textarea('whtml['.$widget_row.'][description]['.$language->id.']', $value = isset($widget['description'][$language->id]) ? $widget['description'][$language->id] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control','id'=>'description-'.$widget_row.'-'.$language->id))?></div>
                                    </div>
                                </div>
                                <?endforeach?>
                                <div class="form-group">
                                    <?=Form::label("whtml[".$widget_row."][layout_id]", $text['entry_layout'], array("class" => "col-sm-2 control-label"))?>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="whtml[<?=$widget_row?>][layout_id]">
                                            <?foreach ($layouts as $layout):?>
                                                <?if ($layout->id == $widget['layout_id']): ?>
                                                    <option value="<?=$layout->id?>" selected="selected"><?=$layout->name?></option>
                                                <?else: ?>
                                                    <option value="<?=$layout->id?>"><?=$layout->name?></option>
                                                <?endif?>
                                            <?endforeach?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?=Form::label("whtml[".$widget_row."][position]", $text['entry_position'], array("class" => "col-sm-2 control-label"))?>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="whtml[<?=$widget_row?>][position]">
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
                                </div>
                                <div class="form-group">
                                    <?=Form::label("whtml[".$widget_row."][sort_order]", $text['entry_sort_order'], array("class" => "col-sm-2 control-label"))?>
                                    <div class="col-sm-10">
                                        <?=Form::input("whtml[".$widget_row."][sort_order]", isset($widget) ? $widget['sort_order'] : "", array('class' => 'form-control', 'style'=> 'width:50px;'))?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?=Form::label("whtml[".$widget_row."][status]", $text['entry_status'], array("class" => "col-sm-2 control-label"))?>
                                    <div class="col-sm-10">
                                        <?=Form::checkbox("whtml[".$widget_row."][status]", 1, isset($widget['status']) ? true : false, array('class' => 'form-control', 'style'=> 'width:30px;'))?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $widget_row++; ?>
                    <?endforeach ?>
                </div>
            </div>
            <?=Form::close()?>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('#tabs-main a:first').tab('show');
        $('#tabs-language-1 a:first').tab('show');

        <? for ($i=1; $i < $widget_row; $i++) : ?>
        <? foreach ($languages as $language) : ?>
        $('#description-<?=$i?>-<?=$language->id?>').summernote({
            <?if($locale == 'ru'):?>
            lang: 'ru-RU',
            <?endif?>
            height: 300,
            focus: true
        });
        <?endforeach?>
        <?endfor?>
    });
//--></script>
<script><!--
$(function() {
    var widget_row = <?=$widget_row?>;

    $('#widget-add').on('click', function () {
        html = '<div id="tab-widget-' + widget_row + '" role="tabpanel" class="tab-pane fade"><br />';
            html += '  <ul id="tabs-language-' + widget_row + '" class="nav nav-tabs" role="tablist">';
            <?foreach ($languages as $language):?>
                html += '<li role="presentation"><a href="#language-'+ widget_row + '-<?=$language->id?>" aria-controls="language<?=$language->id?>" role="tab" data-toggle="tab"><?=HTML::image('styles/'.$template .'image/flags/'.$language->image, array('title' => $language->name))?> <?=$language->name ?></a></li>';
            <?endforeach?>
            html += '</ul>';
            html +='<div class="tab-content">';
                <?foreach ($languages as $language):?>
                    html += '<div role="tabpanel" class="tab-pane fade" id="language-'+widget_row+'-<?=$language->id ?>"><br/>';
                        html += '<div class="form-group">';
                            html += '<label class="col-sm-2 control-label" for="whtml['+widget_row+'][title]"><i class="glyphicon glyphicon-asterisk"></i>&nbsp;<?=$text['entry_title']?></label>';
                            html += '<div class="col-sm-10"><input type="text" name="whtml[' + widget_row + '][title][<?=$language->id?>]" value="" class="form-control" /></div>';
                        html += '</div>';
                        html += '<div class="form-group">';
                            html += '<label class="col-sm-2 control-label" for="whtml['+widget_row+'][description]"><i class="glyphicon glyphicon-asterisk"></i>&nbsp;<?=$text['entry_description']?></label>';
                            html += '<div class="col-sm-10"><textarea name="whtml[' + widget_row + '][description][<?=$language->id?>]" id="description-' + widget_row + '-<?=$language->id?>" сlass="form-control" ></textarea></div>';
                        html += '</div>';
                    html += '</div>';
                <?endforeach?>

                html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="whtml['+widget_row+'][layout_id]"><?=$text['entry_layout']?></label>';
                    html += '<div class="col-sm-10"><select class="form-control" name="whtml[' + widget_row + '][layout_id]">';
                    <?foreach ($layouts as $layout):?>
                        html += '<option value="<?=$layout->id?>"><?=addslashes($layout->name)?></option>';
                    <?endforeach?>
                    html += '</select></div>';
                html += '</div>';
                html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="whtml['+widget_row+'][position]"><?=$text['entry_position']?></label>';
                    html += '<div class="col-sm-10"><select class="form-control" name="whtml[' + widget_row + '][position]">';
                        html += '<option value="content_top"><?=$text["text_content_top"]?></option>';
                        html += '<option value="content_bottom"><?=$text["text_content_bottom"]?></option>';
                        html += '<option value="column_left"><?=$text["text_column_left"]?></option>';
                        html += '<option value="column_right"><?=$text["text_column_right"]?></option>';
                        html += '<option value="block_slider"><?=$text["text_slider"]?></option>';
                    html += '</select></div>';
                html += '</div>';
                html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="whtml['+widget_row+'][sort_order]"><?=$text['entry_layout']?></label>';
                    html += '<div class="col-sm-10"><input type="text" name="whtml[' + widget_row + '][sort_order]" value="0" class="form-control" style="width:50px" /></div>';
                html += '</div>';
                html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="whtml['+widget_row+'][status]"><?=$text['entry_status']?></label>';
                    html += '<div class="col-sm-10"><input type="checkbox" name="whtml[' + widget_row + '][status]" value="1" checked="checked" class="form-control" style="width:30px" /></div>';
                html += '</div>';
            html += '</div>';
        html += '</div>';

        $('#tab-content').append(html);

        <?foreach ($languages as $language):?>
            $('#description-'+widget_row+'-<?=$language->id?>').summernote({
                <?if($locale == 'ru'):?>
                lang: 'ru-RU',
                <?endif?>
                height: 300,
                focus: true
            });
        <?endforeach?>
        $('#tabs-language-'+widget_row+' a:first').tab('show');
        $('#widget-add').parent().before('<li role="presentation" id="widget-' + widget_row + '"><a href="#tab-widget-' + widget_row + '" aria-controls="tab-widget-' + widget_row + '" role="tab" data-toggle="tab"><?=$text['tab_widget']?> ' + widget_row + '&nbsp;<i onclick="$(\'#tabs-main a:first\').tab(\'show\'); $(\'#widget-' + widget_row + '\').remove(); $(\'#tab-widget-' + widget_row + '\').remove(); return false;" class="glyphicon glyphicon-minus-sign" style="cursor:pointer"></i></a></li>');
        $('#widget-' + widget_row+' > a').tab('show');

        widget_row++;
    });
});
//--></script>

