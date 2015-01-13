<div id="container">
    <div id="wrap">
        <div id="sub-wrap">
            <div id="content">
                <? if (isset($page_url)):?><div class="breadcrumb"><?=$page_url?></div><?endif?> 
                <hr class="dots" /> 
                <?=$text['head']?>
                <table class="form" >
                <tr>
                <?foreach($browsers as $browser):?>
                <td align="center"><?=HTML::anchor($browser['url'],HTML::image($browser['image'],array('alt' => $browser['name'])),array('target'=> '_blank'))?></td>
                <?endforeach?>
                <tr>
                <tr>
                <?foreach($browsers as $browser):?>
                <td align="center"><?=HTML::anchor($browser['url'],$browser['name'], array('target'=> '_blank'))?></td>
                <?endforeach?>
                <tr>
                </table>
                <?=$text['end']?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>