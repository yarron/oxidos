<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-envelope"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-send"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?if($errors):?>
                <?foreach ($errors as $error):?>
                    <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                        <span class="sr-only">Error:</span>
                        <?=$error?>
                    </div>
                <?endforeach?>
            <?endif?>
            <?=Form::open('admin/subscribes', array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div class="form-group">
                <?=Form::label('from', $text['entry_from'], array("class" => "col-sm-2 control-label"))?>
                <div class="col-sm-10 input-group">
                    <span class="input-group-addon"><?=$from['name']?></span>
                    <fieldset disabled>
                    <?=Form::input('email', $from['email'], array('class'=>'form-control'))?>
                    </fieldset>
                    <?=Form::hidden('to_name', $from['name'])?>
                    <?=Form::hidden('to_email', $from['email'])?>
                </div>
            </div>
            <div class="form-group">
                <?=Form::label('whom', $text['entry_whom'], array("class" => "col-sm-2 control-label"))?>
                <div class="col-sm-10"><?=Form::select('whom', $whom, $post['whom'], array('class'=>'form-control'))?></div>
            </div>
            <div class="form-group <?=isset($errors['subject']) ? 'has-error' : ''?>">
                <?=Form::label('subject', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_subject'], array("class" => "col-sm-2 control-label"))?>
                <div class="col-sm-10"><?=Form::input('subject', $post['subject'], array('class'=>'form-control'))?></div>
            </div>
            <div class="form-group <?=isset($errors['message']) ? 'has-error' : ''?>">
                <?=Form::label('message', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_message'], array("class" => "col-sm-2 control-label"))?>
                <div class="col-sm-10"><?=Form::textarea('message', $post['message'], array('cols' => 40, 'rows' => 5, 'class'=>'form-control','id'=>'description'))?></div>
            </div>
            <?=Form::close()?>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $('#description').summernote({
            <?if($locale == 'ru'):?>
            lang: 'ru-RU',
            <?endif?>
            height: 300,
            focus: true
        });
    });
//--></script>
