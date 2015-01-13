<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-user"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/users" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/users/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?=Form::label('group', $text['text_group'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::select('group', $roles, $data['group'], array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['username']) ? 'has-error' : ''?>">
                            <?=Form::label('username', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_username'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('username', isset($data) ? $data['username'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['name']) ? 'has-error' : ''?>">
                            <?=Form::label('name', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_name'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('name', isset($data) ? $data['name'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group <?=isset($errors['email']) ? 'has-error' : ''?>">
                            <?=Form::label('email', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_email'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('email', isset($data) ? $data['email'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('phone', $text['text_phone'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('phone', isset($data) ? $data['phone'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('skype', $text['text_skype'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('skype', isset($data) ? $data['skype'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('icq', $text['text_icq'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('icq', isset($data) ? $data['icq'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('info', $text['text_info'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::textarea('info', isset($data) ? $data['info'] : "",array('cols' => 40, 'rows' => 5,"class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?=Form::label('ava', $text['text_ava'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <?if ($data['ava']):?>
                                    <?=HTML::image(HTTP_IMAGE.$data['ava'], array("height" => 75, 'class'=>'img-thumbnail'))?>
                                <?endif?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?=Form::label('password', $text['text_password'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('password', isset($data) ? $data['password'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('confirm', $text['text_confirm'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('confirm', isset($data) ? $data['confirm'] : "", array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('ip', $text['text_ip'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><span class="label label-default"><?=isset($data) ? $data['ip']:""?></span></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('last_login', $text['text_date'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><span class="label label-default"><?=isset($data['last_login']) ? $data['last_login']:""?></span></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('newsletter', $text['text_newsletter'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::checkbox('newsletter', 1, $data['newsletter'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?></div>
                        </div>
                        <div class="form-group">
                            <?=Form::label('status', $text['text_status'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <?=Form::checkbox('status', 1, $data['status'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?>
                                <?=Form::hidden('action', $data['action'])?><?=Form::hidden('id', $data['id'])?>
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
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>