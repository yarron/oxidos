<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-th-list"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="/admin/articles/add" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i></a>
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
                <?=Form::open('admin/articles/delete/', array('enctype' => 'multipart/form-data', "id" => "form", 'role' => 'form'))?>
                <table class="table table-hover">
                    <thead>
                        <tr >
                            <td width="1" ><?=Form::checkbox("selected[]", 0, false, Array("onclick" => "$('input[name*=\'selected\']').attr('checked', this.checked).prop('checked', this.checked).is(':checked', this.checked);",'class'=> 'form-control'))?></td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/title/asc', $text['column_title'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='title' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/title/desc', $text['column_title'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='title' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/alias/asc', $text['column_alias'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='alias' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/alias/desc', $text['column_alias'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='alias' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/date_modified/asc', $text['column_date_modified'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='date_modified' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/date_modified/desc', $text['column_date_modified'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='date_modified' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/sort_order/asc', $text['column_sort_order'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='sort_order' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/sort_order/desc', $text['column_sort_order'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='sort_order' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td>
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/viewed/asc', $text['column_showed'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='viewed' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/viewed/desc', $text['column_showed'], Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='viewed' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>
                            <td align="center">
                                <?if($type == "" || $type=="desc"):?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/status/asc', $text['column_status']." (1/0)", Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='status' ? '<div class="btn-group"><span class="caret"></span></div>' : ''?>
                                <?else:?>
                                    <?=HTML::anchor('admin/articles/page/'.$page.'/status/desc', $text['column_status']." (0/1)", Array("class" =>"btn btn-link"))?>
                                    <?=$sort=='status' ? '<div class="btn-group dropup"><span class="caret"></span></div>' : ''?>
                                <?endif?>
                            </td>

                            <td><p class="btn"><?=$text['column_action']?></p></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="filter warning">
                            <td></td>
                            <td><?=Form::input('filter_title', '', array('size' => 20, 'class'=> 'form-control'))?></td>
                            <td><?=Form::input('filter_alias', '', array('size' => 20, 'class'=> 'form-control'))?></td>
                            <td><?=Form::input('filter_date', '', array('size' => 20, 'id'=> 'datepicker', 'class'=> 'form-control'))?></td>
                            <td><?=Form::input('filter_sort_order', '', array('size' => 1, 'class'=> 'form-control'))?></td>
                            <td></td>
                            <td align="center"><?=Form::input('filter_status', '', array('size' => 1, 'class'=> 'form-control'))?></td>
                            <td><a onclick="filter();" data-toggle="tooltip" title="<?=$text['button_filter']?>" class="btn btn-default" id="filter"><i class="glyphicon glyphicon-filter"></i></a></td>
                        </tr>
                        <?if(count($articles) > 0):?>
                            <? foreach ($articles as $article):?>
                            <tr>
                                <td><?=Form::checkbox("selected[]", $article['article_id'])?></td>
                                <td><?=$article['title']?></td>
                                <td><?=$article['alias']?></td>
                                <td><?=$article['date_modified']?></td>
                                <td><?=$article['sort_order']?></td>
                                <td><?=$article['viewed']?></td>
                                <td align="center">
                                    <?if($article['status'] == 0):?>
                                        <?=HTML::anchor('admin/articles/statusupdate/'. $article['article_id'].'/status_1', '<i class="glyphicon glyphicon-remove"></i>', array('class'=>'btn btn-danger btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?else:?>
                                        <?=HTML::anchor('admin/articles/statusupdate/'. $article['article_id'].'/status_0', '<i class="glyphicon glyphicon-ok"></i>', array('class'=>'btn btn-success btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_status']))?>
                                    <?endif?>
                                </td>
                                <td><?=HTML::anchor('admin/articles/edit/'.$article['article_id'], '<i class="glyphicon glyphicon-edit"></i>', array('class'=>'btn btn-primary btn-xs','data-toggle'=>"tooltip", 'title'=>$text['button_change']))?> </td>
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
	url = '/admin/articles';
        
    var filter_title = $('input[name=\'filter_title\']').val();
	if (filter_title) {
		url += '/filter_title/' + encodeURIComponent(filter_title);
	}
        
    var filter_alias = $('input[name=\'filter_alias\']').val();
	if (filter_alias) {
		url += '/filter_alias/' + encodeURIComponent(filter_alias);
	}
        
	var filter_date_modified = $('input[name=\'filter_date\']').val();
	if (filter_date_modified) {
		url += '/filter_date/' + encodeURIComponent(filter_date_modified);
	}
        
    var filter_sort_order = $('input[name=\'filter_sort_order\']').val();
	if (filter_sort_order) {
		url += '/filter_sort_order/' + encodeURIComponent(filter_sort_order);
	}
        
    var filter_status = $('input[name=\'filter_status\']').val();
	if (filter_status) {
		url += '/filter_status/' + encodeURIComponent(filter_status);
	}		

    location = url;
}
//--></script>  
