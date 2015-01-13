<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-comment"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/comments/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
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
                <?=Form::open('admin/comments/delete/', array('enctype' => 'multipart/form-data', "id" => "form", 'role' => 'form'))?>
                <table class="table table-hover">
                    <thead>
                        <tr >
                            <td width="1" ><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/article_id/asc', $text['column_article'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='article_id' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/article_id/desc', $text['column_article'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='article_id' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/author/asc', $text['column_author'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='author' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/author/desc', $text['column_author'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='author' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/email/asc', $text['column_email'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='email' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/email/desc', $text['column_email'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='email' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/rating/asc',$text['column_rating'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='rating' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/rating/desc', $text['column_rating'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='rating' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/date_modified/asc', $text['column_date_modified'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='date_modified' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/date_modified/desc', $text['column_date_modified'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='date_modified' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td align="center">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/status/asc', $text['column_status']." (1/0)", Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='status' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/status/desc', $text['column_status']." (0/1)", Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='status' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td align="center">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/is_reg/asc', $text['column_is_reg'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='is_reg' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/is_reg/desc', $text['column_is_reg'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='is_reg' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td align="center">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/ip/asc', $text['column_ip'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='ip' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/comments/page/'.$page.'/ip/desc', $text['column_ip'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='ip' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td><p class="btn"><?=$text['column_action']?></p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?if(count($comments) > 0):?>
                            <? foreach ($comments as $comment):?>
                            <tr>
                                <td><?=Form::checkbox("selected[]", $comment->id)?></td>
                                <td><?=$comment->title?></td>
                                <td><?=$comment->author?></td>
                                <td><?=$comment->email?></td>
                                <td><?=$comment->rating?></td>
                                <td><?= $comment->date_modified?></td>
                                <td align="center">
                                    <?if($comment->status == 0):?>
                                        <?=HTML::anchor('admin/comments/statusupdate/'. $comment->id.'/status_1', '<i class="glyphicon glyphicon-remove"></i>', array('class'=>'btn btn-danger btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?else:?>
                                        <?=HTML::anchor('admin/comments/statusupdate/'. $comment->id.'/status_0', '<i class="glyphicon glyphicon-ok"></i>', array('class'=>'btn btn-success btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?endif?>
                                </td>
                                <td align="center">
                                    <?if($comment->is_reg):?>
                                        <?=$text['text_no']?>
                                    <?else:?>
                                        <?=$text['text_yes']?>
                                    <?endif?>
                                </td>
                                <td align="center"><?=$comment->ip?></td>
                                <td class="right"><?=HTML::anchor('admin/comments/edit/'.$comment->id, '<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?> </td>
                            </tr>
                            <? endforeach?>
                        <?else:?>
                            <tr>
                                <td colspan="10" ><p align="center"><?=$text['message_no']?></p></td>
                            </tr>

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

