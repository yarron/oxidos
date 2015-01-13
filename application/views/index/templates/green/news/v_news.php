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
                <div class="article_list">
                    <h2><?=$news['title']?></h2>         
                    <div class="content">
                        <div class="description" ><?=$news['description']?></div>
                        <div class="link">
                            <div class="more"><a href="javascript:history.go(-1)" class="button"><?=$text['text_return']?></a></div>
                            <div class="info">
                                <div class="date" title="<?=$text['text_date'].date("d F Y",$news['date_modified'])?>"><?=date("d F Y",$news['date_modified'])?></div>   
                            </div>
                        </div>
                    </div>
                </div>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
       </div> 
    </div>  
</div>