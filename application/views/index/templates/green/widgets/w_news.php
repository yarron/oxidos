<?if ($news):?>
<div class="box">
  <?if(isset($head)):?>
    <div class="box-heading"><?=$text['heading_title']?></div>
  <?endif?>
  <div id="accordion<?=$widget?>">
    <?foreach ($news as $news_story):?>
        <h4><?=$news_story['title']?></h4>
        <div>
            <p class="description-news" ><?=$news_story['description']?></p>
            <br /><div class="news_date"><?=date("d F Y", $news_story['date_added'])?></div>
        </div>
    <?endforeach?>
  </div>
  <div class="buttons"><div class="right"><?=$all_news?></div></div>
</div>
<script type="text/javascript"><!--
$(function(){
    $( "#accordion<?=$widget?>" ).accordion({
                event: "mouseover"
    });
});
//--></script>
<?endif?>
