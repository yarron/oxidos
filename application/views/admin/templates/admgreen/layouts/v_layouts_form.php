<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/layouts" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/layouts/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
                <div class="form-group <?=isset($errors['name']) ? 'has-error' : ''?>">
                    <?=Form::label('name', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_name'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('name', isset($data['name']) ? $data['name'] : "", array('class'=>'form-control'))?></div>
                </div>
                <div class="form-group <?=isset($errors['name']) ? 'has-error' : ''?>">
                    <?=Form::label('route', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_route'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10">
                        <?=Form::input('route', isset($data['route']) ? $data['route'] : "", array('class'=>'form-control'))?>
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