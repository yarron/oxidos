<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-globe"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/feeds" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?if($time):?>
                <div id="mapinfo" class="alert alert-success">
                    <?=$text['entry_info']?><br /><br />
                    <?=Form::button('admin/feeds/fsitemap/robot', __('button_robot'), array("id" => "sendrobot",'data-loading-text'=>$text['button_connect'], 'class'=>"btn btn-success"))?><br />
                    <div id="mapresult"></div>
                </div>

            <?endif?>
            <?=Form::open('admin/feeds/fsitemap/', array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
                <div class="form-group <?=isset($errors['priority_page']) ? 'has-error' : ''?>">
                    <?=Form::label("fsitemap[priority_page]", '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_priority_page'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input("fsitemap[priority_page]", isset($feed['priority_page']) ? $feed['priority_page'] : "", array('maxlength' => 3,'id' => 'priority_page','class'=>'form-control', 'style'=>'width:50px'))?></div>
                </div>
                <div class="form-group <?=isset($errors['priority_article']) ? 'has-error' : ''?>">
                    <?=Form::label("fsitemap[priority_article]", '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_priority_article'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input("fsitemap[priority_article]", isset($feed['priority_article']) ? $feed['priority_article'] : "", array('maxlength' => 3,'id' => 'priority_article','class'=>'form-control', 'style'=>'width:50px'))?></div>
                </div>
                <div class="form-group <?=isset($errors['priority_category']) ? 'has-error' : ''?>">
                    <?=Form::label("fsitemap[priority_category]", '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_priority_category'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input("fsitemap[priority_category]", isset($feed['priority_category']) ? $feed['priority_category'] : "", array('maxlength' => 3,'id' => 'priority_category','class'=>'form-control', 'style'=>'width:50px'))?></div>
                </div>
                <div class="form-group <?=isset($errors['priority_news']) ? 'has-error' : ''?>">
                    <?=Form::label("fsitemap[priority_news]", '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_priority_news'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input("fsitemap[priority_news]", isset($feed['priority_news']) ? $feed['priority_news'] : "", array('maxlength' => 3,'id' => 'priority_news','class'=>'form-control', 'style'=>'width:50px'))?></div>
                </div>
                <div class="form-group">
                    <?=Form::label("fsitemap[status]", $text['entry_status'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::checkbox("fsitemap[status]", 1, isset($feed['status']) ? true : false, array('class'=>'form-control', 'style'=>'width:30px'))?></div>
                </div>
            <?=Form::close()?>
            <?=Form::button('admin/feeds/fsitemap/map', __('button_map'), array("id" => "buildmap", 'data-loading-text'=>$text['button_loading'], 'class'=>"btn btn-default"))?>
        </div>
    </div>
</div>
<script><!--
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
//--></script>
<script>
$(function(){
	$('#sendrobot').click(function() {
        var btn = $(this).button('loading');

        $.ajax({
            url: '/admin/feeds/fsitemap/robot',
            type: 'post',
            data: {url: "<?=$url?>"},
            dataType: 'html',
            success: function(data) {
                $('#mapresult').html('<br />' + data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },
            complete: function(){
                btn.button('reset');
            }
        });
	});

    $('#buildmap').click(function() {
		var page = $('#priority_page').val();
        var btn = $(this).button('loading');

        $.ajax({
            url: '/admin/feeds/fsitemap/map',
            type: 'post',
            data: {page: $('#priority_page').val(), news: $('#priority_news').val(), article: $('#priority_article').val(), category : $('#priority_category').val() },
            dataType: 'html',
            success: function(data) {
                location.href = "/admin/feeds/fsitemap/";
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },
            complete: function(){
                btn.button('reset');
            }
        });
	});
});
</script>

