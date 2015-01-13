<div id="mainmenu">
    <ul>
    <?foreach($menu as $item):?>
        <li class="menu-item"><a href="<?=$item['url']?>"><?=$item['title'] ?></a></li>
    <?endforeach?>
    </ul>
</div>
<?if($rss):?>
<div id="rss"><a href="/rss.xml"><img src="<?=HTTP_IMAGE.'feed.png'?>" /></a></div>
<?endif?>