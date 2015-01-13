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
                <h1><?=$text['reg_title']?></h1>
                <br/>
                <?if(isset($errors['newsletter'])):?>
                <div class="warning"><?=$errors['newsletter']?></div>
                <?endif?>
                <?=Form::open('account/register/', array('enctype' => 'multipart/form-data', "id" => "form"))?>
                    <h2><?=$text['text_your_details']?></h2>
                    <div class="content">
                        <table class="form">
                        <tr>
                            <td ><span class="required">* </span><?=Form::label('username', $text['text_username'])?> </td>
                            <td ><?=Form::input('username', isset($data) ? $data['username'] : "", array('size' => 30))?>
                                <?if (isset($errors['username'])):?>
                                    <span class="error"><?=$errors['username']?></span>
                                <?endif?>
                            </td>

                        </tr> 
                        <tr>
                            <td ><span class="required">* </span><?=Form::label('name', $text['text_name'])?> </td>
                            <td ><?=Form::input('name', isset($data) ? $data['name'] : "", array('size' => 30))?>
                                <?if (isset($errors['name'])):?>
                                    <span class="error"><?=$errors['name']?></span>
                                <?endif?>
                            </td>

                        </tr> 
                        <tr>
                            <td ><span class="required">* </span><?=Form::label('email', $text['text_email'])?> </td>
                            <td><?=Form::input('email', isset($data) ? $data['email'] : "", array('size' => 30))?>
                                <?if (isset($errors['email'])):?>
                                    <span class="error"><?=$errors['email']?></span>
                                <?endif?>
                            </td>

                        </tr>
                        <tr>
                            <td ><?=Form::label('phone', $text['text_phone'])?> </td>
                            <td><?=Form::input('phone', isset($data) ? $data['phone'] : "", array('size' => 30))?></td>

                        </tr>
                        </table>  
                    </div>
                    <h2><?=$text['text_your_password']?></h2>
                    <div class="content">
                        <table class="form">
                            <tr>
                                <td><span class="required">* </span><?=Form::label('password', $text['text_password'])?> </td>
                                <td><?=Form::password('password', isset($data) ? $data['password'] : "", array('size' => 30))?>
                                    <?if (isset($errors['password'])):?>
                                    <span class="error"><?=$errors['password']?></span>
                                    <?endif?>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="required">* </span><?=Form::label('password_confirm', $text['text_confirm'])?> </td>
                                <td><?=Form::password('password_confirm', isset($data) ? $data['password_confirm'] : "", array('size' => 30))?>
                                    <?if (isset($errors['password_confirm'])):?>
                                        <span class="error"><?=$errors['password_confirm']?></span>
                                    <?endif?>
                                </td>
                            </tr>    
                        </table>
                    </div>
                    <h2><?=$text['text_code']?></h2>
                    <div class="content">
                        <table class="form">
                            <tr>
                                <td><?=Form::label('captcha', $text['text_captcha'])?></td>
                                <td><?=$captcha?>&nbsp;<?=HTML::image('styles/'.$template . 'image/update.png', Array('onclick' =>'reload()'))?><br /></td>
                            </tr>
                            <tr>
                                <td><span class="required">* </span><?=Form::label('captcha_enter', $text['text_captcha_enter'])?></td>
                                <td><?=Form::input('captcha', "", array('size' => 13))?>
                                    <?if (isset($errors['captcha'])):?>
                                        <span class="error"><?=$errors['captcha']?></span>
                                    <?endif?>
                                </td>
                            </tr>   
                        </table>
                    </div>       
                    <?if (isset($text['text_newsletter'])):?>
                        <div class="buttons"><div class="right">
                            <?=$text['text_newsletter']?>
                            <?if ( isset($data['newsletter'])):?>
                                <?=Form::checkbox('newsletter', 1, true)?>
                            <?else:?>
                                <?=Form::checkbox('newsletter', 1, false)?>
                            <?endif?>
                            <?=Form::submit('save', $text['button_save'], array('class' => 'button'))?>
                        </div></div>
                    <?else:?>
                        <div class="buttons"><div class="right">
                        <?=Form::submit('save', $text['button_save'], array('class' => 'button'))?>
                        </div></div>
                    <?endif?>    
                    <?=Form::close()?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#form').submit();
	}
});

function reload(){
    id=Math.floor(Math.random()*1000000);
    $("img.captcha").attr("src","/captcha/default?id="+id);
}

$(document).ready(function() {
	$('.colorbox').colorbox({
		width: 640,
		height: 480
	});
});

//--></script>