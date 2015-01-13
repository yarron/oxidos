<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-folder-open"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/categories/path/<?=$path?>" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/categories/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div role="tabpanel">
                <ul id="tabs-main" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general"  aria-controls="general" role="tab" data-toggle="tab"><?=$text['tab-general']?></a></li>
                    <li role="presentation"><a href="#data"  aria-controls="data" role="tab" data-toggle="tab"><?=$text['tab-data']?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active"  id="general">
                        <br/>
                        <div role="tabpanel">
                            <ul id="tabs-language" class="nav nav-tabs" role="tablist">
                                <? foreach ($languages as $language) : ?>
                                    <li role="presentation">
                                        <a href="#language<?=$language->id?>" aria-controls="language<?=$language->id?>" role="tab" data-toggle="tab">
                                            <?=HTML::image('styles/'.$template . 'image/flags/'.$language->image, array('title' => $language->name))?> <?=$language->name ?>
                                        </a>
                                    </li>
                                <?endforeach?>
                            </ul>
                            <div class="tab-content">
                                <? foreach ($languages as $language) : ?>
                                <div role="tabpanel" class="tab-pane" id="language<?=$language->id ?>">
                                    <br/>
                                    <div class="form-group <?=isset($errors['title']) ? 'has-error' : ''?>">
                                        <?=Form::label('category_description['.$language->id.'][title]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_title'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::input('category_description['.$language->id.'][title]', isset($data['category_description']) ? $data['category_description'][$language->id]['title'] : "", array('size' => 100, 'class'=>'form-control'))?></div>
                                    </div>
                                    <div class="form-group">
                                        <?=Form::label('category_description['.$language->id.'][seo_title]', $text['text_seo_title'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::input('category_description['.$language->id.'][seo_title]', isset($data['category_description']) ? $data['category_description'][$language->id]['seo_title'] : "", array('size' => 100, 'class'=>'form-control'))?></div>
                                    </div>
                                    <div class="form-group">
                                        <?=Form::label('category_description['.$language->id.'][meta_description]', $text['text_meta_description'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::input('category_description['.$language->id.'][meta_description]', isset($data['category_description']) ? $data['category_description'][$language->id]['meta_description'] : "", array('size' => 100, 'class'=>'form-control'))?></div>
                                    </div>
                                    <div class="form-group">
                                        <?=Form::label('category_description['.$language->id.'][meta_keywords]', $text['text_meta_keywords'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::input('category_description['.$language->id.'][meta_keywords]', isset($data['category_description']) ? $data['category_description'][$language->id]['meta_keywords'] : "", array('size' => 100, 'class'=>'form-control'))?></div>
                                    </div>
                                    <div class="form-group <?=isset($errors['description']) ? 'has-error' : ''?>">
                                        <?=Form::label('category_description['.$language->id.'][description]', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_description'], array("class" => "col-sm-2 control-label"))?>
                                        <div class="col-sm-10"><?=Form::textarea('category_description['.$language->id.'][description]',$value = isset($data['category_description']) ? $data['category_description'][$language->id]['description'] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control','id'=>'description-'.$language->id))?></div>
                                    </div>
                                </div>
                                <?endforeach?>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade"  id="data" ><br/>
                        <div class="form-group">
                            <?=Form::label('categories', $text['text_parent'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::select('category', $data['categories'], $data['parent_id'], array("class"=>"form-control"))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('alias', $text['text_alias'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>', array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_alias_tooltip']))?>
                            <div class="col-sm-10"><?=Form::input('alias', isset($data) ? $data['alias'] : "", array('size' => 100, "class"=>"form-control"))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('top', $text['text_top'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>', array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_top_tooltip']))?>
                            <div class="col-sm-10"><?=Form::checkbox('top', 1, $data['top'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('column', $text['text_column'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>', array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_column_tooltip']))?>
                            <div class="col-sm-10"><?=Form::input('column', isset($data) ? $data['column'] : "", array('size' => 2,"class"=>"form-control",'style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('sort_order', $text['text_sort_order'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('sort_order', isset($data) ? $data['sort_order'] : "", array('size' => 2,"class"=>"form-control",'style'=>'width:50px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('status', $text['text_status'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <?=Form::checkbox('status', 1, $data['status'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?>
                                <?=Form::hidden('action', $data['action'])?>
                                <?=Form::hidden('id', $data['id'])?>
                                <?=Form::hidden('parent_id', $data['parent_id'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?=Form::close()?>
        </div>
    </div>
</div>
 
<script><!--
    $(function() {
        $('#tabs-main a:first').tab('show');
        $('#tabs-language a:first').tab('show');
        $('[data-toggle="tooltip"]').tooltip();

        <? foreach ($languages as $language) : ?>
        $('#description-<?=$language->id?>').summernote({
            <?if($locale == 'ru'):?>
            lang: 'ru-RU',
            <?endif?>
            height: 300,
            focus: true
        });
        <?endforeach?>
    });
//--></script>



   