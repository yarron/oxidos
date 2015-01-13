<div class="box">
    <div class="box-heading"><?=$text['heading_title']?></div>
    <div class="box-content">
        <ul>
            <?if (!$logged):?>
            <li><?=HTML::anchor($links['login'], $text['text_login'])?>  / <?=HTML::anchor($links['register'], $text['text_register'])?></li>
            <li><?=HTML::anchor($links['forgotten'], $text['text_forgotten'])?></li>
            <?endif?>
            <li><?=HTML::anchor($links['account'], $text['text_account'])?></li>
            <?if ($logged):?>
            <li><?=HTML::anchor($links['edit'], $text['text_edit'])?></li>
            <li><?=HTML::anchor($links['password'], $text['text_password'])?></li>
            <?endif?>
            <li><?=HTML::anchor($links['newsletter'], $text['text_newsletter'])?></li>
            <?if ($logged):?>
            <li><?=HTML::anchor($links['logout'], $text['text_logout'])?></li>
            <?endif?>
        </ul>
    </div>
</div>