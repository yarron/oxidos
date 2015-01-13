<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-user"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/users/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
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
                <?=Form::open('admin/users/delete/', array('enctype' => 'multipart/form-data', "id" => "form", 'role' => 'form'))?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td width="1" ><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/username/asc', $text['column_username'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='username' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/username/desc', $text['column_username'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='username' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/name/asc', $text['column_name'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='name' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/name/desc', $text['column_name'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='name' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/last_login/asc',$text['column_last_login'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='last_login' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/last_login/desc', $text['column_last_login'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='last_login' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/logins/asc', $text['column_logins'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='logins' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/logins/desc', $text['column_logins'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='logins' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td class="right">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/ip/asc', $text['column_ip'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='ip' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/ip/desc', $text['column_ip'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='ip' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td align="center">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/status/asc', $text['column_status']." (1/0)", Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='status' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/users/page/'.$page.'/status/desc', $text['column_status']." (0/1)", Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='status' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>

                            <td><p class="btn"><?=$text['column_action']?></p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="filter warning">
                            <td></td>
                            <td><?=Form::input('filter_username', '', array('size' => 20, 'class'=> 'form-control'))?></td>
                            <td><?=Form::input('filter_name', '', array('size' => 20, 'class'=> 'form-control'))?></td>
                            <td><?=Form::input('filter_date', '', array('size' => 20, 'id'=> 'datepicker', 'class'=> 'form-control'))?></td>
                            <td></td>
                            <td><?=Form::input('filter_ip', '', array('size' => 20, 'class'=> 'form-control'))?></td>
                            <td align="center"><?=Form::input('filter_status', '', array('size' => 1, 'class'=> 'form-control'))?></td>
                            <td><a onclick="filter();" data-toggle="tooltip" title="<?=$text['button_filter']?>" class="btn btn-default" id="filter"><i class="glyphicon glyphicon-filter"></i></a></td>
                        </tr>
                        <?if(count($users) > 0):?>
                            <? foreach ($users as $user):?>
                            <tr>
                                <td><?=Form::checkbox("selected[]", $user->id)?></td>
                                <td><?=$user->username?></td>
                                <td><?=$user->name?></td>
                                <td><?=$user->last_login?></td>
                                <td><?=$user->logins?></td>
                                <td><?=$user->ip?></td>
                                <td align="center">
                                    <?if($user->status == 0):?>
                                        <?=HTML::anchor('admin/users/statusupdate/'. $user->id.'/status_1', '<i class="glyphicon glyphicon-remove"></i>', array('class'=>'btn btn-danger btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?else:?>
                                        <?=HTML::anchor('admin/users/statusupdate/'. $user->id.'/status_0','<i class="glyphicon glyphicon-ok"></i>', array('class'=>'btn btn-success btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?endif?>
                                </td>
                                <td class="right"><?=HTML::anchor('admin/users/edit/'.$user->id,'<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?> </td>
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
<script><!--
    $(function() {
        $( "#datepicker" ).datepicker( {dateFormat: 'yy-mm-dd'} );
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>
<script><!--
    function filter() {
        url = '/admin/users';

        var filter_username = $('input[name=\'filter_username\']').val();
        if (filter_username) {
            url += '/filter_username/' + encodeURIComponent(filter_username);
        }

        var filter_name = $('input[name=\'filter_name\']').val();
        if (filter_name) {
            url += '/filter_name/' + encodeURIComponent(filter_name);
        }

        var filter_date = $('input[name=\'filter_date\']').val();
        if (filter_date) {
            url += '/filter_date/' + encodeURIComponent(filter_date);
        }

        var filter_ip = $('input[name=\'filter_ip\']').val();
        if (filter_ip) {
            url += '/filter_ip/' + encodeURIComponent(filter_ip);
        }

        var filter_status = $('input[name=\'filter_status\']').val();
        if (filter_status) {
            url += '/filter_status/' + encodeURIComponent(filter_status);
        }

        location = url;
    }
//--></script>

