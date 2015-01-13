<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-file"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/pages/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
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
            <?=Form::open('admin/pages/delete/', array('enctype' => 'multipart/form-data', "id" => "form", 'role' => 'form'))?>
                <table class="table table-hover">
                    <thead>
                    <tr >
                        <td width="1"><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                        <td>
                            <?if($type == "" || $type=="desc"):?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/title/asc', $text['column_title'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='title' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                            <?else:?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/title/desc', $text['column_title'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='title' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                            <?endif?>
                        </td>
                        <td>
                            <?if($type == "" || $type=="desc"):?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/alias/asc', $text['column_alias'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='alias' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                            <?else:?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/alias/desc', $text['column_alias'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='alias' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                            <?endif?>
                        </td>
                        <td>
                            <?if($type == "" || $type=="desc"):?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/date_modified/asc', $text['column_date_modified'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='date_modified' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                            <?else:?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/date_modified/desc', $text['column_date_modified'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='date_modified' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                            <?endif?>
                        </td>
                        <td>
                            <?if($type == "" || $type=="desc"):?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/sort_order/asc', $text['column_sort_order'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='sort_order' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                            <?else:?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/sort_order/desc', $text['column_sort_order'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='sort_order' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                            <?endif?>
                        </td>
                        <td class="right">
                            <?if($type == "" || $type=="desc"):?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/viewed/asc', $text['column_showed'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='viewed' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                            <?else:?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/viewed/desc', $text['column_showed'], Array("class" =>"btn btn-link"))?>
                                <?=$sort=='viewed' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                            <?endif?>
                        </td>
                        <td align="center">
                            <?if($type == "" || $type=="desc"):?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/status/asc', $text['column_status']." (1/0)", Array("class" =>"btn btn-link"))?>
                                <?=$sort=='status' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                            <?else:?>
                                <?=HTML::anchor('admin/pages/page/'.$page.'/status/desc', $text['column_status']." (0/1)", Array("class" =>"btn btn-link"))?>
                                <?=$sort=='status' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                            <?endif?>
                        </td>
                        <td><p class="btn"><?=$text['column_action']?></p></td>
                    </tr>
                </thead>
                    <tbody>
                    <?if(count($pages) > 0):?>
                        <? foreach ($pages as $page):?>
                        <tr>
                            <td><?=Form::checkbox("selected[]", $page['page_id'])?></td>
                            <td><?=$page['title']?></td>
                            <td><?=HTML::anchor($page['alias'].'.html', $page['alias'], array('target' => '_blank'))?></td>
                            <td><?=date("Y-m-d H:i",$page['date_modified'])?></td>
                            <td><?=$page['sort_order']?></td>
                            <td><?=$page['viewed']?></td>
                            <td align="center">
                                <?if($page['status'] == 0):?>
                                    <?=HTML::anchor('admin/pages/statusupdate/'. $page['page_id'].'/status_1', '<i class="glyphicon glyphicon-remove"></i>', array('class'=>'btn btn-danger btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                <?else:?>
                                    <?=HTML::anchor('admin/pages/statusupdate/'. $page['page_id'].'/status_0', '<i class="glyphicon glyphicon-ok"></i>', array('class'=>'btn btn-success btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                <?endif?>
                            </td>
                            <td><?=HTML::anchor('admin/pages/edit/'.$page['page_id'],'<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?> </td>
                        </tr>
                        <? endforeach?>
                    <?else:?>
                        <tr><td colspan="8" ><p align="center"><?=$text['message_no']?></p></td></tr>
                    <?endif?>
                </tbody>
                </table>
            <?=Form::close()?>
            </div>
            <br/>
            <?=$pagination?>
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

