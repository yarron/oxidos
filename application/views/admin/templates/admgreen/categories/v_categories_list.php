<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-folder-close"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/categories/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
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
                <?=Form::open('admin/categories/delete/', array('enctype' => 'multipart/form-data', "id" => "form",'role' => 'form'))?>
                    <table class="table table-hover">
                        <thead>
                            <tr >
                                <td width="1" ><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                                <td><p class="btn"><?=$text['column_title']?></p></td>
                                <td><p class="btn"><?=$text['column_alias']?></p></td>
                                <td><p class="btn"><?=$text['column_children']?></p></td>
                                <td><p class="btn"><?=$text['column_date_modified']?></p></td>
                                <td><p class="btn"><?=$text['column_sort_order']?></p></td>
                                <td align="center"><p class="btn"><?=$text['column_status']." (0/1)"?></p></td>
                                <td><p class="btn"><?=$text['column_action']?></p></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?if(count($categories) > 0):?>
                                <? foreach ($categories as $category):?>
                                <tr>
                                    <td><?=Form::checkbox("selected[]", $category['category_id'])?></td>
                                    <?if ($category['href']):?>
                                        <td><?=$category['indent']?><?=HTML::anchor($category['href'], $category['name'])?></td>
                                    <?else:?>
                                        <td><?=$category['indent']?><?=$category['name']?></td>
                                    <?endif?>
                                    <td><?=$category['indent']?><?=$category['alias']?></td>
                                    <td><?=$category['indent']?><?=$category['children']?></td>
                                    <td><?=$category['indent']?><?=date("Y-m-d H:i", $category['date_modified'])?></td>
                                    <td><?=$category['indent']?><?=$category['sort_order']?></td>
                                    <td align="center">
                                        <?if($category['status'] == 0):?>
                                            <?=HTML::anchor('admin/categories/statusupdate/'. $category['category_id'].'/status_1', '<i class="glyphicon glyphicon-remove"></i>', array('class'=>'btn btn-danger btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                        <?else:?>
                                            <?=HTML::anchor('admin/categories/statusupdate/'. $category['category_id'].'/status_0', '<i class="glyphicon glyphicon-ok"></i>', array('class'=>'btn btn-success btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                        <?endif?>
                                    </td>
                                    <td><?=HTML::anchor($category['action']['href'], '<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?></td>
                                </tr>
                                <? endforeach?>
                            <?else:?>
                                <tr>
                                    <td colspan="8" ><p align="center"><?=$text['message_no']?></p></td>
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

