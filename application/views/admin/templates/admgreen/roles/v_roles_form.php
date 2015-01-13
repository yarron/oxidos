<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-lock"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/roles" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/roles/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group <?=isset($errors['name']) ? 'has-error' : ''?>">
                            <?=Form::label('name', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_name'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10"><?=Form::input('name', $data['name'], array("class"=>"form-control", 'style'=>'width:250px'))?></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <?=Form::label('group', $text['entry_access'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <div class="scrollbox2">
                                    <?php $count = 0;?>
                                    <?foreach ($permissions['all'] as $permission):?>
                                        <div class="checkbox">
                                            <label>
                                            <?if (in_array($permission, $permissions['access'])):?>
                                                <input type="checkbox" name="permission[access][]" value="<?=$permission?>" checked="checked"  /><?=$permissions['title'][$count]?>
                                            <?else:?>
                                                <input type="checkbox" name="permission[access][]" value="<?=$permission?>"  /><?=$permissions['title'][$count]?>
                                            <?endif?>
                                            </label>
                                        </div>
                                        <?php $count++; ?>
                                    <?endforeach ?>
                                </div>
                                <a class="btn btn-default" data-toggle="tooltip" title="<?=$text['text_select_all']?>"  onclick="$(this).parent().find(':checkbox').attr('checked', true).prop('checked', true).is(':checked', true);"><i class="glyphicon glyphicon-ok-circle"></i></a>
                                <a class="btn btn-default" data-toggle="tooltip" title="<?=$text['text_select_remove']?>" onclick="$(this).parent().find(':checkbox').attr('checked', false).prop('checked', false).is(':checked', false);"><i class="glyphicon glyphicon-remove-circle"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?=Form::label('group', $text['entry_modify'], array("class" => "col-sm-2 control-label"))?>
                            <div class="col-sm-10">
                                <div class="scrollbox2">
                                    <?php $count = 0;?>
                                    <?foreach ($permissions['all'] as $permission):?>
                                        <div class="checkbox">
                                            <label>
                                                <?if (in_array($permission, $permissions['modify'])):?>
                                                    <input type="checkbox" name="permission[modify][]" value="<?=$permission?>" checked="checked"  /><?=$permissions['title'][$count]?>
                                                <?else:?>
                                                    <input type="checkbox" name="permission[modify][]" value="<?=$permission?>"  /><?=$permissions['title'][$count]?>
                                                <?endif?>
                                            </label>
                                        </div>
                                        <?php $count++; ?>
                                    <?endforeach ?>
                                </div>
                                <a class="btn btn-default" data-toggle="tooltip" title="<?=$text['text_select_all']?>" onclick="$(this).parent().find(':checkbox').attr('checked', true).prop('checked', true).is(':checked', true);"><i class="glyphicon glyphicon-ok-circle"></i></a>
                                <a class="btn btn-default" data-toggle="tooltip" title="<?=$text['text_select_remove']?>" onclick="$(this).parent().find(':checkbox').attr('checked', false).prop('checked', false).is(':checked', false);"><i class="glyphicon glyphicon-remove-circle"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?=Form::hidden('action', $data['action'])?><?=Form::hidden('id', $data['id'])?>
            <?=Form::close()?>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>