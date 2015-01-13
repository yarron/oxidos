<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-picture"></i>
            <span><?=$box_title?></span>
            <div class="btn-group btn-group-sm pull-right" role="group" >
                <a data-toggle="tooltip" title="<?=$text['button_save']?>" onclick="$('#form').submit();" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-open"></i></a>
                <a data-toggle="tooltip" title="<?=$text['button_abort']?>" href="/admin/adverts" class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i></a>
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
            <?=Form::open('admin/adverts/'.$data['action'].'/'.$data['id'], array('enctype' => 'multipart/form-data', "id" => "form", "role"=> "form", "class"=> "form-horizontal"))?>
            <div class="form-group <?=isset($errors['name']) ? 'has-error' : ''?>">
                <?=Form::label('name', '<i class="glyphicon glyphicon-asterisk"></i>&nbsp;'.$text['entry_name'], array("class" => "col-sm-2 control-label"))?>
                <div class="col-sm-10"><?=Form::input('name', isset($data['name']) ? $data['name'] : "", array('class'=>'form-control', 'style'=>'width:200px;'))?></div>
            </div>
            <div class="form-group">
                <?=Form::label('status', $text['entry_status'], array("class" => "col-sm-2 control-label"))?>
                <div class="col-sm-10">
                    <?=Form::checkbox('status', 1, $data['status'] == '1' ? true : false, array("class"=>"form-control", 'style'=>'width:30px'))?>
                    <?=Form::hidden('action', $data['action'])?><?=Form::hidden('id', $data['id'])?>
                </div>
            </div>
            <div id="images" class="container-fluid">
               <div class="row bg-success">
                   <div class="col-sm-4"><i class="glyphicon glyphicon-asterisk"></i>&nbsp;<span class="btn"><?=$text['entry_title']?></span></div>
                   <div class="col-sm-4"><span class="btn"><?=$text['entry_link']?></span></div>
                   <div class="col-sm-2"><span class="btn"><?=$text['entry_image']?></span></div>
                   <div class="col-sm-1"><span class="btn"><?=$text['entry_sort_order']?></span></div>
                   <div class="col-sm-1"></div>
               </div>
               <?php $image_row = 0; ?>
               <?foreach ($data['advert_images'] as $advert_image):?>
                   <div class="row" id="image-row<?=$image_row?>"><br/>
                       <div class="col-sm-4">
                           <?foreach ($languages as $language):?>
                           <div class="input-group">
                               <div class="input-group-addon"><?=HTML::image('styles/'.$template . 'image/flags/'.$language->image, array('title' => $language->name));?></div>
                               <input class="form-control" type="text" name="advert_images[<?=$image_row?>][descriptions][<?=$language->id?>][title]" value="<?=isset($advert_image['descriptions'][$language->id]) ? $advert_image['descriptions'][$language->id]['title'] : ''; ?>" />
                           </div>
                           <?endforeach?>
                       </div>
                       <div class="col-sm-4"><input class="form-control" type="text" name="advert_images[<?=$image_row?>][link]" value="<?=$advert_image['link']?>" /></div>
                       <div class="col-sm-2 image">
                           <?=HTML::image($advert_image['thumb'], array('alt' => '', 'id' => 'thumb'.$image_row, 'class'=>'img-thumbnail'));?>
                           <input type="hidden" name="advert_images[<?=$image_row?>][image]" value="<?=$advert_image['image']?>" id="image<?=$image_row?>"  /><br />
                           <a class="btn btn-default btn-editor" data-toggle="tooltip" data-image="image<?=$image_row?>" data-thumb="thumb<?=$image_row?>" data-loading-text="<?=$text['button_loading']?>" ><i class="glyphicon glyphicon-eye-open"></i></a>
                           <a class="btn btn-danger" data-toggle="tooltip"  onclick="$('#thumb<?=$image_row?>').attr('src', '<?=$data['no_image']?>'); $('#image<?=$image_row?>').attr('value', '');" ><i class="glyphicon glyphicon-trash"></i></a>
                       </div>
                       <div class="col-sm-1"><input style="width:50px" class="form-control" type="text" name="advert_images[<?=$image_row?>][sort_order]" value="<?=$advert_image['sort_order']?>" /></div>
                       <div class="col-sm-1"><a data-toggle="tooltip" onclick="$('#image-row<?=$image_row?>').remove();" title="<?=$text['button_remove']?>" class="btn btn-primary"><i class="glyphicon glyphicon-minus-sign"></i></a></div>
                   </div>
                   <?php $image_row++; ?>
               <?endforeach?>
               <div class="row" id="foot">
                   <div class="col-sm-4"></div>
                   <div class="col-sm-4"></div>
                   <div class="col-sm-2"></div>
                   <div class="col-sm-1"></div>
                   <div class="col-sm-1"><a id="addImage" data-toggle="tooltip" title="<?=$text['button_add']?>" class="btn btn-success"><i class="glyphicon glyphicon-plus-sign"></i></a></div>
               </div>
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
<script><!--
    var image_row = <?=$image_row?>;
    $('#images').on('click','#addImage', function () {
        html  = '<div class="row" id="image-row'+ image_row + '" ><br/>';
            html += '<div class="col-sm-4">';
            <?foreach ($languages as $language): ?>

                html += '<div class="input-group">';
                    html += '<div class="input-group-addon"><?=HTML::image('styles/'.$template . 'image/flags/'.$language->image, array('title' => $language->name))?></div>';
                    html += '<input class="form-control" type="text" name="advert_images[' + image_row + '][descriptions][<?=$language->id?>][title]" value="" />';
                html += '</div>';
            <?endforeach?>

            html += '</div>';
            html += '<div class="col-sm-4"><input class="form-control" type="text" name="advert_images[' + image_row + '][link]" value="" /></div>';
            html += '<div class="col-sm-2 image">';
                html += '<img class="img-thumbnail" src="<?=$data['no_image']?>" alt="" id="thumb' + image_row + '" />';
                html += '<input type="hidden" name="advert_images[' + image_row + '][image]" value="" id="image' + image_row + '" /><br />';
                html += '<a class="btn btn-default btn-editor" data-toggle="tooltip" data-image="image' + image_row + '" data-thumb="thumb' + image_row + '" data-loading-text="<?=$text['button_loading']?>" ><i class="glyphicon glyphicon-eye-open"></i></a> ';
                html += '<a class="btn btn-danger" data-toggle="tooltip" onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?=$data['no_image']?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');" ><i class="glyphicon glyphicon-trash"></i></a>';
            html += '</div>';
            html += '<div class="col-sm-1"><input style="width:50px" class="form-control" type="text" name="advert_images[' + image_row + '][sort_order]" value="0" /></div>';
            html += '<div class="col-sm-1"><a data-toggle="tooltip" title="<?=$text['button_remove']?>" onclick="$(\'#image-row' + image_row  + '\').remove();" class="btn btn-primary"><i class="glyphicon glyphicon-minus-sign"></i></a></div>';
        html += '</div>';
        $('#images #foot').before(html);
        image_row++;
    });

//--></script>
