<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-flag"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/languages" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/languages/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
                <div class="form-group <?=isset($errors['name']) ? 'has-error' : ''?>">
                    <?=Form::label('name', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_title'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('name', isset($data['name']) ? $data['name'] : "", array('class'=>'form-control', 'style'=>'width:200px'))?></div>
                </div>
                <div class="form-group <?=isset($errors['code']) ? 'has-error' : ''?>">
                    <?=Form::label('code', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_code'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>', array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_code_tooltip']))?>
                    <div class="col-sm-10"><?=Form::input('code', isset($data['code']) ? $data['code'] : "", array('class'=>'form-control', 'style'=>'width:50px'))?></div>
                </div>
                <div class="form-group <?=isset($errors['locale']) ? 'has-error' : ''?>">
                    <?=Form::label('locale', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_locale'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>', array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_locale_tooltip']))?>
                    <div class="col-sm-10"><?=Form::input('locale', isset($data['locale']) ? $data['locale'] : "", array('class'=>'form-control', 'style'=>'width:200px'))?></div>
                </div>
                <div class="form-group <?=isset($errors['image']) ? 'has-error' : ''?>">
                    <?=Form::label('image', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_image'].'&nbsp;<i class="glyphicon glyphicon-info-sign"></i>', array("class" => "col-sm-2 control-label", 'data-toggle' => 'tooltip', 'data-placement' => 'right', 'title'=>$text['text_image_tooltip']))?>
                    <div class="col-sm-10"><?=Form::input('image', isset($data['image']) ? $data['image'] : "", array('class'=>'form-control', 'style'=>'width:200px'))?></div>
                </div>
                <div class="form-group">
                    <?=Form::label('sort_order', $text['text_sort_order'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('sort_order', isset($data['sort_order']) ? $data['sort_order'] : "", array('class'=>'form-control', 'style'=>'width:50px'))?></div>
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
    });
//--></script>


   