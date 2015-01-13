<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-registration-mark"></i>
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
            <?=Form::open('admin/feeds/frss/', array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
                <div class="form-group">
                    <?=Form::label("url", $text['entry_url'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><span class="form-control"><?=$text['url']?></span></div>
                </div>
                <div class="form-group">
                    <?=Form::label("frss[status]", $text['entry_status'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::checkbox("frss[status]", 1, isset($feed['status']) ? true : false, array('class'=>'form-control', 'style'=>'width:50px'))?></div>
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
