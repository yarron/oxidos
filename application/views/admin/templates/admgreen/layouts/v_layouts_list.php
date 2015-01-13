<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/layouts/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
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
                <?=Form::open('admin/layouts/delete/', array('enctype' => 'multipart/form-data', "id" => "form", 'role' => 'form'))?>
                <table class="table table-hover">
                    <thead>
                        <tr >
                            <td width="1" ><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                            <td>
                                <?if($type == "" || $type=="desc"): ?>
                                    <?=HTML::anchor('admin/layouts/name/asc', $text['column_name'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='name' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <? else: ?>
                                    <?=HTML::anchor('admin/layouts/name/desc', $text['column_name'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='name' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                        <td class="left">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/layouts/route/asc', $text['column_route'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='route' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/layouts/route/desc', $text['column_route'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='route' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td><p class="btn"><?=$text['column_action']?></p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?if(count($layouts) > 0):?>
                            <? foreach ($layouts as $layout):?>
                            <tr>
                                <td><?=Form::checkbox("selected[]", $layout->id)?></td>
                                <td><?=$layout->name?></td>
                                <td><?=$layout->route?></td>
                                <td><?=HTML::anchor('admin/layouts/edit/'.$layout->id, '<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?> </td>
                            </tr>
                            <? endforeach?>
                        <?else:?>
                            <tr>
                                <td colspan="4" ><p align="center"><?=$text['message_no']?></p></td>
                            </tr>

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

