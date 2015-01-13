<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-folder-open"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/menu" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/menu/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
                <div class="form-group <?=isset($errors['title']) ? 'has-error' : ''?>">
                    <?=Form::label('title', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_title'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10">
                        <?foreach ($languages as $language):?>
                        <div class="input-group">
                            <div class="input-group-addon"><?=HTML::image('styles/'.$template . 'image/flags/'.$language->image, array('title' => $language->name));?></div>
                            <?=Form::input('menu_description['.$language->id.'][title]', isset($data['menu_description'][$language->id]) ? $data['menu_description'][$language->id]['title'] : '', array('class' => 'form-control', 'style'=>'width:250px'))?>
                        </div>
                        <?endforeach?>
                    </div>
                </div>
                <div class="form-group <?=isset($errors['url']) ? 'has-error' : ''?>">
                    <?=Form::label('url', $text['text_url'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10">
                        <div class="radio">
                            <label>
                                <?=Form::radio('page_mode', 1, $data['page_id']? true : false, array('id'=>'page_static'))?><?=Form::label('page_static', $text['text_page_static'])?><br />
                                <?=Form::radio('page_mode', 2, $data['page_id']? false : true, array('id'=>'page_other'))?><?=Form::label('page_other', $text['text_page_other'])?><br /><br />
                            </label>
                        </div>
                        <div id="page" style="display:none;"><?=Form::select('page_id', $pages, $data['page_id'], array('style' => 'width:400px','class'=> 'form-control')) ?></div>
                        <div id="other" style="display:none;" class="input-group">
                            <div class="input-group-addon"><?=URL::base(true)?></div><?=Form::input('url', isset($data) ? $data['url'] : "", array('style' => 'width:250px','class'=> 'form-control'))?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?=Form::label('sort_order', $text['text_sort_order'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('sort_order', isset($data) ? $data['sort_order'] : "", array('size' => 2,"class"=>"form-control",'style'=>'width:50px'))?></div>
                </div>
                <div class="form-group">
                    <?=Form::label('status', $text['text_status'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10">
                        <?=Form::checkbox('status', 1, $data['status'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?>
                        <?=Form::hidden('action', $data['action'])?><?=Form::hidden('id', $data['id'])?>
                    </div>
                </div>
            <?=Form::close()?>
        </div>
    </div>
</div>

<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        function checked (){

            if($("#page_static:checked").val()){
                $("#page select").attr("disabled",false);
                $("#other input").attr("disabled","disabled");
                $('#page').slideDown(500);
                $('#other').slideUp(500);
            }
            if($("#page_other:checked").val()){
                $("#page select").attr("disabled",'disabled');
                $("#other input").attr("disabled",false);
                $('#page').slideUp(500);
                $('#other').slideDown(500);
            }
        }
        $('#page_static,#page_other').on('change',function(){
            checked();
        });

        checked();
    });
//--></script> 