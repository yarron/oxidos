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
                <h1><?=$category_description->title?></h1>
                <?if ($category_description->description):?>
                <div class="category-info"><?=$category_description->description?></div>
                <?endif?>
                <?if ($categories):?>
                <h2><?=$text['text_refine']?></h2>
                <div class="category-list">
                    <?if (count($categories) <= 5) :?>
                    <ul>
                      <?foreach ($categories as $category):?>
                      <li><?=$category?></li>
                      <?endforeach?>
                    </ul>
                    <?else:?>
                    <?for ($i = 0; $i < count($categories);):?>
                    <ul>
                      <?php $j = $i + ceil(count($categories) / 4); ?>
                      <?for (; $i < $j; $i++):?>
                          <?if (isset($categories[$i])) :?>
                          <li><?=$categories[$i]?></li>
                          <?endif?>
                      <?endfor?>
                    </ul>
                    <?endfor?>
                    <?endif?>
                </div>
                <?endif?>
                <?if(count($articles)>0):?>
                    <div class="article_list">
                        <?foreach($articles as $article):?>
                            <h2><?=$article['title']?></h2>
                            <div class="content">
                                <?if($article['image'] != "no_image.jpg" && $article['image'] != ""):?>
                                    <?if($article['popup']):?>
                                    <div class="image"><?=HTML::anchor($article['image_popup'], HTML::image($article['image'], array('alt' => $article['title'],'align' => 'left')), array('class' => 'colorbox'));?></div>
                                    <?else:?>
                                        <div class="image"><?=HTML::image($article['image'], array('alt' => $article['title'],'align' => 'left'));?></div>    
                                    <?endif?>
                                <?endif?>
                                <div class="description" ><?=Text::limit_words($article['short'],$article['limit'])?></div>
                                <div class="link">
                                    <div class="rating" title="<?=$text['text_rating'].$article['rating']?>"><?=HTML::image('styles/'.$template."image/stars-".$article['rating'].".png", array('alt' => $article['title']))?></div>
                                    <div class="cat"><?=$text['text_category']?>&nbsp;<?=$article['categories']?></div>
                                    <div class="more"><?=HTML::anchor($uri.'/'.$article['alias'].".html", $text['text_read_more'], array('class' => 'button'));?></div>
                                    <div class="info">
                                        <? if ($mode):?><div class="colcom" title="<?=$text['text_comment_count'].$article['comments']?>"><?=$article['comments']?></div><?endif?>   
                                        <div class="views" title="<?=$text['text_viewed'].$article['viewed']?>"><?=$article['viewed']?></div>
                                        <div class="author" title="<?=$text['text_author'].$article['author']?>"><?=$article['author']?></div>    
                                        <div class="date" title="<?=$text['text_date'].date("d F Y",$article['date_modified'])?>"><?=date("d F Y",$article['date_modified'])?></div>   
                                    </div>
                                </div>
                            </div>     
                        <?endforeach?>
                    </div>
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