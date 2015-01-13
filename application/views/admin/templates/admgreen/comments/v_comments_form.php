<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-comment"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/comments" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/comments/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
                <div class="form-group <?=isset($errors['author']) ? 'has-error' : ''?>">
                    <?=Form::label('author', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_author'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('author', isset($data['author']) ? $data['author'] : "", array('class'=>'form-control'))?></div>
                </div>
                <div class="form-group <?=isset($errors['article_id']) ? 'has-error' : ''?>">
                    <?=Form::label('article', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_article'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('article', isset($data['article']) ? $data['article'] : "", array('class'=>'form-control'))?></div>
                </div>
                <div class="form-group <?=isset($errors['text']) ? 'has-error' : ''?>">
                    <?=Form::label('text', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['text_text'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::textarea('text', $value = isset($data['text']) ? $data['text'] : "", array('cols' => 40, 'rows' => 5, 'class'=>'form-control','id'=>'description'))?></div>
                </div>
                <div class="form-group">
                    <?=Form::label('date_modified', $text['text_date_modified'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10"><?=Form::input('date_modified', isset($data['date_modified']) ? $data['date_modified'] : "", array('class'=>'form-control date'))?></div>
                </div>
                <div class="form-group">
                    <?=Form::label('rating', $text['text_rating'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10 input-group">
                            <i class="glyphicon glyphicon-thumbs-down like" data-toggle="tooltip" title="<?=$text['text_bad']?>"></i>
                            <?=Form::radio('rating', 1, $data['rating'] == '1' ? true : false ,array("class"=>"form-control", 'style'=>'width:30px'))?>
                            <?=Form::radio('rating', 2, $data['rating'] == '2' ? true : false ,array("class"=>"form-control", 'style'=>'width:30px'))?>
                            <?=Form::radio('rating', 3, $data['rating'] == '3' ? true : false ,array("class"=>"form-control", 'style'=>'width:30px'))?>
                            <?=Form::radio('rating', 4, $data['rating'] == '4' ? true : false ,array("class"=>"form-control", 'style'=>'width:30px'))?>
                            <?=Form::radio('rating', 5, $data['rating'] == '5' ? true : false ,array("class"=>"form-control", 'style'=>'width:30px'))?>
                            <i class="glyphicon glyphicon-thumbs-up like" data-toggle="tooltip" title="<?=$text['text_excellent']?>"></i>
                    </div>
                </div>
                <div class="form-group">
                    <?=Form::label('status', $text['text_status'], array("class" => "col-sm-2 control-label"))?>
                    <div class="col-sm-10">
                        <?=Form::checkbox('status', 1, $data['status'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?>
                        <?=Form::hidden('action', $data['action'])?>
                        <?=Form::hidden('id', $data['id'])?>
                        <?=Form::hidden('article_id', $data['article_id'])?>
                    </div>
                </div>
            <?=Form::close()?>
        </div>
    </div>
</div>
<script><!--
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('.date').datepicker({dateFormat: 'yy-mm-dd'});

        $('input[name=\'article\']').autocomplete({
            delay: 0,
            source: function(request, response) {
                $.ajax({
                    url: '/admin/articles/autocomplete/filter_title/' +  encodeURIComponent(request.term),
                    dataType: 'json',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {
                                label: item.title,
                                value: item.article_id
                            }
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $('input[name=\'article\']').val(ui.item.label);
                $('input[name=\'article_id\']').val(ui.item.value);
                return false;
            }
        });
    });
//--></script>
<script><!--
    $(function() {
        $('#description').summernote({
            <?if($locale == 'ru'):?>
            lang: 'ru-RU',
            <?endif?>
            height: 300,
            focus: true
        });
    });
//--></script>
