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
                <h1><?=$text['heading_title']?></h1>
                <?if(count($news)>0):?>
                    <?foreach($news as $new):?>
                    <div class="article_list">
                        <h2><?=$new['title']?></h2>
                        <div class="content">
                            <?if($new['image'] != "no_image.jpg" && $new['image'] != ""):?>
                                <div class="image"><?=HTML::image(HTTP_IMAGE.$new['image'], array('alt' => $new['title'], 'width' => $new['width'],'align' => 'left'));?></div>    
                            <?endif?>
                            <div class="description" ><?=Text::limit_words($new['short'],$new['limit'])?></div>
                            <div class="link">
                                    <div class="more"><?=HTML::anchor($new['uri'], $text['text_read_more'], array('class' => 'button'));?></div>
                                    <div class="info">
                                        <div class="date" title="<?=$text['text_date'].date("d F Y",$new['date_modified'])?>"><?=date("d F Y",$new['date_modified'])?></div>   
                                    </div>
                            </div>
                        </div>
                    </div>
                    <?endforeach?>
                    <?=$pagination?>
                    <?else:?>
                        <div><b><?=$text['text_no']?></b></div>
                    <?endif?> 
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>