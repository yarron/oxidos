<header>
    <?=$category?>
    <?=$language?>
    <div id="header">
        <?if ($data['logo']):?>
        <div id="logo">
            <a href="<?=$data['home']?>">
                <img src="<?=$data['logo']?>" title="<?=$data['name']?>" alt="<?=$data['name']?>" />
            </a>
        </div>
        <?endif?>
        <div id="welcome">
        <?if (!$data['logged']): ?>
            <div class="button-wrap">
                <a href="/account/register" >
                    <div><?=HTML::image('styles/'.$template . 'image/account/button-register.png', array('alt' => $text['button_register']))?></div>
                    <div><?=$text['button_register']?></div>
                </a>
            </div>
            <div class="button-wrap">
                <a href="/account" >
                    <div><?=HTML::image('styles/'.$template . 'image/account/button-login.png', array('alt' => $text['button_login']))?></div>
                    <div><?=$text['button_login']?></div>
                </a>
            </div>
        <?else:?>
            <div class="button-wrap">
                <a href="/account/logout" >
                    <div><?=HTML::image('styles/'.$template . 'image/account/button-logout.png', array('alt' => $text['button_logout']))?></div>
                    <div><?=$text['button_logout']?></div>
                </a>
            </div>
            <div class="button-wrap">
                <a href="/account/account" >
                    <div><?=HTML::image('styles/'.$template . 'image/account/button-account.png', array('alt' => $text['button_account']))?></div>
                    <div><?=$text['button_account']?></div>
                </a>
            </div>
            <div id="stat">
                <span><?=$text['text_logged'] ?></span><br /><br />
                <span><?=$text['text_ip'] ?></span><br />
                <span><?=$text['text_date'] ?></span>
            </div>
        <?endif?>
        </div>   
    </div>
   <div id="main">
        <?=$menu?>
        <div class="searchform">
            <div class="icon-search"></div>
            <?if ($data['filter_name']):?>
                <input type="text" name="filter_name" value="<?=$data['filter_name']?>" />
            <?else:?>
                <input type="text" name="filter_name" value="<?=$text['text_search']?>" onclick="this.value = '';" onkeydown="this.style.color = '#ffffff';" />
            <?endif?>
        </div>
    </div>
</header>
<div id="notification"></div>
