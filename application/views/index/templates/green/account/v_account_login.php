<div id="container">
    <?=$header?> 
    <div id="wrap">
        <div id="sub-wrap">
            <?=$slider?> 
            <?=$column_left?>
            <?=$column_right?> 
            <div id="content">
                <?if($message):?>
                <div class="success"><?=$message?></div>
                <?endif?>
                <?if($errors):?>
                <?foreach ($errors as $error):?>
                <div class="warning"><?=$error?></div>
                <?endforeach?>
                <?endif?>
                <? if (isset($page_url)):?><div class="breadcrumb"><?=$page_url?></div><?endif?> 
                <?=$content_top?>
                <hr class="dots" />
                <h1><?=$text['auth_title']?></h1>
                <div class="login-content">
                    <div class="left">
                        <h2><?=$text['auth_reg_heading']?></h2>
                        <?=Form::open('account/login', array('enctype' => 'multipart/form-data', "id" => "form"))?>
                        <div class="content">
                            <table>
                                <tr>
                                    <td class="line1"><?=Form::label('username', $text['text_username'])?></td>
                                    <td class="line2"><?=Form::input('username', isset($data) ? $data['username'] : "", array('size' => 30, 'id'=>'username'))?></td>
                                </tr> 
                                <tr>
                                    <td class="line1"><?=Form::label('password', $text['text_password'])?></td>
                                    <td class="line2"><?=Form::password('password', isset($data) ? $data['password'] : "", array('size' => 30, 'id' => 'password'))?></td>
                                </tr>
                                <?if($enters):?>
                                <tr >
                                    <td class="line1"><?=Form::label('captcha', $text['text_captcha'])?></td>
                                    <td class="line2"><?=$captcha?>&nbsp;<?=HTML::image('styles/'.$template . 'image/update.png', Array('onclick' =>'reload()'))?><br /><?=Form::input('captcha', "", array('size' => 13, 'id'=>'captcha'))?></td>
                                </tr>
                                <?endif?>
                                <tr>
                                    <td class="line1">&nbsp;</td>
                                    <td class="line2"><br /><?=Form::checkbox('remember',1,false, array('id'   => 'remember'))?> <?=$text['text_remember']?></td>
                                </tr>
                                <tr>
                                    <td class="line1">&nbsp;</td>
                                    <td class="line2">
                                        <br />
                                        <?=Form::submit('submit', $text['text_enter'], array('class' => 'button'))?>&nbsp;&nbsp;
                                        <?=HTML::anchor('account/forgotten', $text['text_forgotten'])?>
                                        <?=Form::hidden('enters', ++$enters)?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?=Form::close()?>
                    </div>
                    <div class="right">
                        <h2><?=$text['auth_new_heading']?></h2>
                        <div class="content">
                            <p><b><?=$text['reg_title']?></b></p>
                            <p><?=$text['text_reg_account']?></p>
                            <?=HTML::anchor('account/register', $text['button_register'], array("class" => "button"))?>
                        </div>
                    </div>
                </div>
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
//--></script>
<script type="text/javascript"><!--
 function reload(){
    id=Math.floor(Math.random()*1000000);
    $("img.captcha").attr("src","/captcha/default?id="+id);
}
//--></script>