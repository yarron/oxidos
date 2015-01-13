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
                <h3><?=$text['text_criteria']?></h3>
                <div class="content">
                    <p>
                        <?=$text['entry_search']?>
                        <?if ($filter_name):?>
                            <?=Form::input('filter_name', $filter_name, array('size' => 40))?>
                        <?else:?>
                            <?=Form::input('filter_name', $filter_name, array('size' => 40,'onclick' => "this.value = ''", 'onkeydown' => "this.style.color = '000000'", 'style' => 'color: #999'))?>
                        <?endif?>
                        <select name="filter_category_id">
                            <option value="0"><?=$text['text_category']?></option>
                            <?foreach ($categories as $category_1):?>
                                <?if ($category_1['category_id'] == $filter_category_id):?>
                                    <option value="<?=$category_1['category_id']?>" selected="selected"><?=$category_1['name']?></option>
                                <?else:?>
                                    <option value="<?=$category_1['category_id']?>"><?=$category_1['name']?></option>
                                <?endif?>
                                <?foreach ($category_1['children'] as $category_2):?>
                                    <?if ($category_2['category_id'] == $filter_category_id):?>
                                        <option value="<?=$category_2['category_id']?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$category_2['name']?></option>
                                    <?else:?>
                                        <option value="<?=$category_2['category_id']?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$category_2['name']?></option>
                                    <?endif?>
                                    <?foreach ($category_2['children'] as $category_3):?>
                                        <?if ($category_3['category_id'] == $filter_category_id):?>
                                            <option value="<?=$category_3['category_id']?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$category_3['name']?></option>
                                        <?else:?>
                                            <option value="<?=$category_3['category_id']?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$category_3['name']?></option>
                                        <?endif?>
                                    <?endforeach?>
                                <?endforeach?>
                            <?endforeach ?>
                        </select>
                    </p>
                    <p>
                        <?if ($filter_description):?>
                            <?=Form::checkbox('filter_description', 1, true, array('id' => 'description'))?>
                        <?else:?>
                            <?=Form::checkbox('filter_description', 1, false, array('id' => 'description'))?>
                        <?endif?>
                        <?=Form::label('description', $text['text_description'])?>
                    </p>
                    <p><?=Form::button('filter_description', $text['button_search'], array('id' => 'button-search','class' => 'button'))?></p>
                </div>
                <h2><?=$text['text_search']?></h2>
                <?if(count($articles)>0):?>
                    <div class="article_list">
                        <?foreach($articles as $article):?>
                            <h2><?=$article['title']?></h2>
                            <div class="content">
                                <?if($article['image'] != "no_image.jpg" && $article['image'] != ""):?>
                                <div class="image"><?=HTML::image(HTTP_IMAGE.$article['image'], array('alt' => $article['title'], 'width' => $article['width'],'align' => 'left'));?></div>    
                                <?endif?>
                                <div class="description" ><?=Text::limit_words($article['short'],$article['limit'])?></div>
                                <div class="link">
                                    <div class="rating" title="<?=$text['text_rating'].$article['rating']?>"><?=HTML::image($template."image/stars-".$article['rating'].".png", array('alt' => $article['title']))?></div>
                                    <div class="cat"><?=$text['text_category']?>&nbsp;<?=$article['categories']?></div>
                                    <div class="more"><?=HTML::anchor($article['category'].$article['alias'].".html", $text['text_read_more'], array('class' => 'button'));?></div>
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
                    <div class="content"><?=$text['text_empty']?></div>
                <?endif?>
                <?=$content_bottom?>
            </div>
            <?=$footer?>
        </div> 
    </div>  
</div>
<script type="text/javascript"><!--
$('#content input[name=\'filter_name\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').on('click',function() {
	url = $('base').attr('href') + 'search';
	
	var filter_name = $('#content input[name=\'filter_name\']').val();
	
	if (filter_name) {
		url += '/filter_name/' + encodeURIComponent(filter_name);
	}

	var filter_category_id = $('#content select[name=\'filter_category_id\']').val();
	
	if (filter_category_id > 0) {
		url += '/filter_category_id/' + encodeURIComponent(filter_category_id);
	}
	
	var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').val();
	
	if (filter_sub_category) {
		url += '/filter_sub_category/true';
	}
		
	var filter_description = $('#content input[name=\'filter_description\']:checked').val();
	
	if (filter_description) {
		url += '/filter_description/true';
	}

	location = url;
});

//--></script> 