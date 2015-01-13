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
                <?if($message):?>
                    <div class="success"><?=$message?></div>
                <?endif?>   
                <h1><?=$text['account_title']?></h1>
                <h2><?=$text['text_my_account']?></h2>
                <div class="content">
                    <ul>
                        <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;">
                            <?=HTML::anchor('account/edit', HTML::image('styles/'.$template . 'image/account/information.png', array('alt' => 'account edit', 'style' => 'float: left; margin-right: 8px;')).$text['text_edit_title']);?>
                            <br /><?=$text['text_edit_description']?>
                        </div>
                        <div style="float: right; width: 260px; margin-bottom: 10px; padding: 5px;">
                            <?=HTML::anchor('account/password', HTML::image('styles/'.$template . 'image/account/password.png', array('alt' => 'password edit', 'style' => 'float: left; margin-right: 8px;')).$text['text_password_title']);?>
                            <br /><?=$text['text_password_description']?>
                        </div>
                    </ul>
                </div>  
                <h2><?=$text['text_my_settings']?></h2>
                <div class="content">
                    <ul>
                        <div style="float: left; width: 260px; margin-bottom: 10px; padding: 5px;">
                            <?=HTML::anchor('account/newsletter', HTML::image('styles/'.$template . 'image/account/newsletter.png', array('alt' => 'newsletter', 'style' => 'float: left; margin-right: 8px;')).$text['text_newsletter_title']);?>
                            <br /><?=$text['text_newsletter_description']?>
                        </div>
                    </ul>
                </div>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>