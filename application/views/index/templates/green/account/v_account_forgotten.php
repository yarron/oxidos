<div id="container">
    <?=$header?> 
    <div id="wrap">
        <div id="sub-wrap">
            <?=$slider?> 
            <?=$column_left?>
            <?=$column_right?> 
            <div id="content">
                <?if($errors):?>
                <?foreach ($errors as $error):?>
                <div class="warning"><?=$error?></div>
                <?endforeach?>
                <?endif?>
                <? if (isset($page_url)):?><div class="breadcrumb"><?=$page_url?></div><?endif?> 
                <?=$content_top?>
                <hr class="dots" />
                <h1><?=$text['text_forgotten']?></h1>
                <?=Form::open('account/forgotten', array('enctype' => 'multipart/form-data', "id" => "form"))?>
                    <p><?=$text['text_description']?></p>
                    <div class="content">
                      <table class="form">
                        <tr>
                          <td><?=$text['text_email']?></td>
                          <td><input type="text" name="email" value="" /></td>
                        </tr>
                      </table>
                    </div>
                    <div class="buttons">
                      <div class="left"><?=Html::anchor('account/login', $text['button_abort'], array("class" => "button", "onclick" => "location =''"))?></div>
                      <div class="right"><input type="submit" name="submit" class="button" value="<?=$text['button_reset']?>" /><?=Form::hidden('action', 'forgotten')?></div>
                    </div>
                <?=Form::close()?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>
