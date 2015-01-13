<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-flag"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/languages/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
                <a onclick="$('#form').submit();" data-toggle="tooltip" title="<?=$text['button_remove']?>" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
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
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon glyphicon-ban-circle" aria-hidden="true"></span>
                    <span class="sr-only">Error:</span>
                    <?=$errors?>
                </div>
            <?endif?>
            <div class="table-responsive">
                <?=Form::open('admin/languages/delete/', array('enctype' => 'multipart/form-data', "id" => "form", 'role' => 'form'))?>
                <table class="table table-hover">
                    <thead>
                        <tr >
                            <td width="1" ><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                            <td><span class="btn"><?=$text['column_title']?></span></td>
                            <td><span class="btn"><?=$text['column_code']?></span></td>
                            <td><span class="btn"><?=$text['column_sort_order']?></span></td>
                            <td align="center"><span class="btn"><?=$text['column_status']?></span></td>
                            <td><span class="btn"><?=$text['column_action']?></span></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?if(count($languages) > 0):?>
                            <? foreach ($languages as $language):?>
                            <tr>
                                <td><?=Form::checkbox("selected[]", $language['id'])?></td>
                                <td class="left">
                                    <?if($default == $language['id']):?>
                                        <?=$language['name'].$text['text_default']?>
                                    <?else:?>
                                        <?=$language['name']?>
                                    <?endif?>
                                </td>

                                <td class="left"><?=$language['code']?></td>
                                <td class="right"><?=$language['sort_order']?></td>
                                <td align="center">
                                    <?if($language['status'] == 0):?>
                                        <?=HTML::anchor('admin/languages/statusupdate/'. $language['id'].'/status_1', '<i class="glyphicon glyphicon-remove"></i>', array('class'=>'btn btn-danger btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?else:?>
                                        <?=HTML::anchor('admin/languages/statusupdate/'. $language['id'].'/status_0', '<i class="glyphicon glyphicon-ok"></i>', array('class'=>'btn btn-success btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?endif?>
                                </td>
                                <td class="right"><?=HTML::anchor('admin/languages/edit/'.$language['id'], '<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?> </td>
                            </tr>
                            <? endforeach?>
                        <?else:?>
                            <tr><td colspan="6" ><p align="center"><?=$text['message_no_languages']?></p></td></tr>
                        <?endif?>
                    </tbody>
                </table>
                <?=Form::close()?>
            </div>
        </div>
    </div>
</div>
<script><!--
//-----------------------------------------
// Confirm Actions (delete, uninstall)
//-----------------------------------------
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    // Confirm Delete
    $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm('<?=$text['confim_delete']?>')) {
                return false;
            }
        }
    });
});
//--></script>
