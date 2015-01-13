<div id="container">
    <?=$header?> 
    <div id="wrap">
        <div id="sub-wrap">
            <?=$slider?> 
            <?=$column_left?>
            <?=$column_right?> 
            <div id="content">
                <? if (isset($page_url)):?><div class="breadcrumb"><?=$page_url?></div><?endif?> 
                <?=$content_top?>
                <hr class="dots" /> 
                <h1><?=$text['password_title']?></h1>
                <?=Form::open('account/password')?>
                    <h2><?=$text['text_password_title']?></h2>
                    <div class="content">
                        <table class="form">
                            <tr>
                                <td><span class="required">* </span><?=Form::label('password_old', $text['text_password_old'])?> </td>
                                <td><?=Form::password('password_old', isset($data) ? $data['password_old'] : "", array('size' => 30))?>
                                    <?if (isset($errors['password_old'])):?>
                                    <span class="error"><?=$errors['password_old']?></span>
                                    <?endif?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="required">* </span><?=Form::label('password', $text['text_password_password'])?> </td>
                                <td><?=Form::password('password', isset($data) ? $data['password'] : "", array('size' => 30))?>
                                    <?if (isset($errors['password'])):?>
                                    <span class="error"><?=$errors['password']?></span>
                                    <?endif?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="required">* </span><?=Form::label('password_confirm', $text['text_password_confirm'])?> </td>
                                <td><?=Form::password('password_confirm', isset($data) ? $data['password_confirm'] : "", array('size' => 30))?>
                                    <?if (isset($errors['password_confirm'])):?>
                                        <span class="error"><?=$errors['password_confirm']?></span>
                                    <?endif?>
                                </td>
                            </tr>    
                        </table>  
                    </div>
                    <div class="buttons">
                        <div class="left"><?=Html::anchor('account/account', $text['button_abort'], array("class" => "button"))?></div>
                        <div class="right"> <?=Form::submit('save', $text['button_save'], array('class' => 'button'))?></div>
                    </div>
                    <?=Form::hidden('action', 'password')?>
                <?=Form::close()?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>
