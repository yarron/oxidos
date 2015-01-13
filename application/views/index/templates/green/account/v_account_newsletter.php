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
                <h1><?=$text['newsletter_title']?></h1>
                <?=Form::open('account/newsletter')?>
                    <div class="content">
                    <table class="form">
                        <tr>
                            <td><?=$text['text_newsletter_newsletter']?></td>
                            <td>
                                <?if ($data['newsletter'] ): ?>
                                    <?=Form::radio('newsletter', 1, true) ?> <?=$text['text_newsletter_yes']?>&nbsp;
                                    <?=Form::radio('newsletter', 0, false) ?> <?=$text['text_newsletter_no']?>   
                                <?else:?>
                                    <?=Form::radio('newsletter', 1, false) ?> <?=$text['text_newsletter_yes']?>&nbsp;
                                    <?=Form::radio('newsletter', 0, true) ?> <?=$text['text_newsletter_no']?>  
                                <?endif?>
                            </td>
                        </tr>
                    </table>    
                    </div>
                    <div class="buttons">
                        <div class="left"><?=Html::anchor('account/account', $text['button_abort'], array("class" => "button"))?></div>
                        <div class="right"> <?=Form::submit('save', $text['button_save'], array('class' => 'button'))?></div>
                    </div>
                    <?=Form::hidden('action', 'newsletter')?>
                <?=Form::close()?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>
