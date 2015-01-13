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
                <h1><?=$text['title']?></h1>
                <?if(isset($message)):?>
                <div class="success"><?=$message?></div>
                <?endif?>
                <?if(isset($errors['captcha'])):?>
                <div class="warning"><?=$errors['captcha']?></div>
                <?endif?>
                <h2><?=$text['entry_company']?></h2>
                <div class="content">
                    <div class="left"><?=$text['company']?><br /></div>
                    <div class="right"><?=$text['description']?><br /><br /></div>
                </div>
                <h2><?=$text['entry_address']?></h2>
                <div class="content">
                    <div class="left"><b><?=$text['text_address']?></b><br /><?=$text['address']?></div>
                    <div class="right">
                        <?if ($text['phone']):?>
                            <b><?=$text['text_phone']?></b><br />
                            <?=$text['phone']?><br />
                        <?endif?>
                        <?if ($text['fax']):?>
                            <b><?=$text['text_fax']?></b><br />
                            <?=$text['fax']?>
                        <?endif?>
                    </div>
                </div>
                <div class="content">
                    <div class="left">
                        <h2><?=$text['entry_feedback']?></h2>
                        <?=Form::open('contacts.html', array('enctype' => 'multipart/form-data', "id" => "form"))?>
                            <div class="content">
                                <b><?=$text['label_name']?></b><br />
                                <?=Form::input('name', isset($data['name']) ? $data['name'] : "", array('size' => 20))?><br />
                                <?if (isset($errors['name'])):?>
                                    <span class="error"><?=$errors['name']?></span>
                                <?endif?><br />
                                <b><?=$text['label_email']?></b><br />
                                <?=Form::input('email', isset($data['email']) ? $data['email'] : "", array('size' => 20))?><br />
                                <?if (isset($errors['email'])):?>
                                    <span class="error"><?=$errors['email']?></span>
                                <?endif?><br />
                                <b><?=$text['label_enquiry']?></b><br />
                                <?=Form::textarea('enquiry',isset($data['enquiry']) ? $data['enquiry'] : "", array('cols' => 40, 'rows' => 6))?><br />
                                <?if (isset($errors['enquiry'])):?>
                                    <span class="error"><?=$errors['enquiry']?></span>
                                <?endif?><br />
                                <b><?=Form::label('captcha', $text['label_captcha'])?></b><br />
                                <?=Form::input('captcha', "", array('size' => 13))?><br />
                                <?=$captcha?>&nbsp;<?=HTML::image('styles/'.$template . 'image/update.png', Array('onclick' =>'reload()'))?> <br /><br />
                                <?=Form::submit('send', $text['button_post'], array('class' => 'button'))?>
                            </div>
                        <?=Form::close()?>   
                    </div>
                    <div class="right">
                    <?if ($text['code']):?>
                        <h2><?=$text['entry_code']?></h2>
                        <?=$text['code']?>
                    <?endif?>    
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

function reload(){
    id=Math.floor(Math.random()*1000000);
    $("img.captcha").attr("src","/captcha/default?id="+id);
}

//--></script>