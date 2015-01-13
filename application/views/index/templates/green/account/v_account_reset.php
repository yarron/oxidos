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
                <h1><?=$text['reset_title']?></h1>
                <?=Form::open('account/reset', array('enctype' => 'multipart/form-data', "id" => "form"))?>
                <p><?=$text['text_reset_description']?></p>
                    <div class="content">
                      <table class="form">
                        <tr>
                            <td><?=$text['text_reset_password']?></td>
                            <td><input type="text" name="password" value="<?=isset($data["password"]) ? $data["password"] : ""?>" /></td>
                        </tr>
                        <tr>
                            <td><?=$text['text_reset_confirm']?></td>
                            <td><input type="text" name="password_confirm" value="<?=isset($data["password_confirm"]) ? $data["password_confirm"] : ""?>" />
                        </tr>
                      </table>
                    </div>
                    <div class="buttons">
                      <div class="left"><?=Html::anchor('account/login', $text['button_abort'], array("class" => "button"))?><?=Form::hidden('action', 'reset')?><?=Form::hidden('key', $data['key'])?></div>
                      <div class="right"><input type="submit" name="save" class="button" value="<?=$text['button_save']?>" /></div>
                    </div>
                <?=Form::close()?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>