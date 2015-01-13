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
                <h1><?=$text['edit_title']?></h1>
                <?=Form::open('account/edit', array('enctype' => 'multipart/form-data'))?>
                <h2><?=$text['text_edit_account']?></h2>
                <div class="content">
                    <table class="form">
                        <tr>
                            <td ><span class="required">* </span><?=Form::label('username', $text['text_edit_username'])?> </td>
                            <td ><?=Form::input('username', $data['username'], array('size' => 30))?>
                                <?if (isset($errors['username'])):?>
                                    <span class="error"><?=$errors['username']?></span>
                                <?endif?>
                            </td>
                        </tr>
                        <tr>
                            <td ><span class="required">* </span><?=Form::label('name', $text['text_edit_name'])?> </td>
                            <td ><?=Form::input('name', $data['name'], array('size' => 30))?>
                                <?if (isset($errors['name'])):?>
                                    <span class="error"><?=$errors['name']?></span>
                                <?endif?>
                            </td>
                        </tr> 
                        <tr>
                            <td ><span class="required">* </span><?=Form::label('email', $text['text_edit_email'])?> </td>
                            <td><?=Form::input('email', $data['email'], array('size' => 30))?>
                                <?if (isset($errors['email'])):?>
                                    <span class="error"><?=$errors['email']?></span>
                                <?endif?>
                            </td>
                        </tr>
                        <tr>
                            <td ><?=Form::label('phone', $text['text_edit_phone'])?> </td>
                            <td><?=Form::input('phone', $data['phone'], array('size' => 30))?></td>
                        </tr>
                        <tr>
                            <td ><?=Form::label('skype', $text['text_edit_skype'])?> </td>
                            <td><?=Form::input('skype', $data['skype'], array('size' => 30))?></td>
                        </tr>
                        <tr>
                            <td ><?=Form::label('icq', $text['text_edit_icq'])?> </td>
                            <td><?=Form::input('icq', $data['icq'], array('size' => 10))?></td>
                        </tr>
                        <tr>
                            <td><?=Form::label('info', $text['text_edit_info'])?> </td>
                            <td><?=Form::textarea('info', $data['info'], array('style' => 'width: 98%; height: 70px;')) ?></td>
                        </tr>
                        <tr>
                            <td><?=Form::label('ava', $text['text_edit_ava'])?><br /> <br />
                                <?if ($data['ava']):?>
                                <?=HTML::image(HTTP_IMAGE.$data['ava'])?>
                                <?endif?>    
                            </td>
                            <td>
                                <?=Form::file('ava')?><br /><?=Form::checkbox('noava', 1, false);?><?=Form::label('noava', $text['text_edit_noava'])?>
                                <?if (isset($errors['ava'])):?>
                                    <span class="error"><?=$errors['ava']?></span>
                                <?endif?>
                            </td>
                        </tr>
                        </table>  
                    </div>
                    <div class="buttons">
                        <div class="left"><?=Html::anchor('account/account', $text['button_abort'], array("class" => "button"))?></div>
                        <div class="right"> <?=Form::submit('save', $text['button_save'], array('class' => 'button'))?></div>
                    </div>
                    <?=Form::hidden('id', $data['id'])?><?=Form::hidden('action', 'edit')?>
                <?=Form::close()?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>
