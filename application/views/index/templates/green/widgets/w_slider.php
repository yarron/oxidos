<div class="slider">
  <div id="slider<?=$widget?>" class="nivoSlider" style="width: <?=$width?>px; height: <?=$height?>px;">
    <?foreach ($adverts as $advert):?>
        <?if ($advert['link']):?>
        <a href="<?=$advert['link']?>"><img src="<?=$advert['image']?>" alt="<?=$advert['title']?>" title="<?=$advert['title']?>" /></a>
        <?else:?>
        <img src="<?=$advert['image']?>" alt="<?=$advert['title']?>" title="<?=$advert['title']?>" />
        <?endif?>
    <?endforeach ?>  
  </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#slider<?=$widget?>').nivoSlider();
});
--></script>