<?if ($categories):?>
    <div id="global-wrap">
    <section id="global-nav">
         <nav>
            <div id="menu">
                <ul>
                <?foreach ($categories as $category):?>
                    <li>
                    <?if (in_array($category['alias'], $parts)):?>
                        <a href="<?=$category['href']?>" class="active"><?=$category['name']?></a>
                    <?else:?>
                        <a href="<?=$category['href']?>"><?=$category['name']?></a>
                    <?endif?>
                    <?if ($category['children']):?>
                        <div>
                        <?for ($i = 0; $i < count($category['children']);):?>
                            <ul>
                                <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
                                <?for (; $i < $j; $i++):?>
                                    <?if (isset($category['children'][$i])):?>
                                    <li><a href="<?=$category['children'][$i]['href']?>"><?=$category['children'][$i]['name']?></a></li>
                                    <?endif?>
                                <?endfor?>
                            </ul>
                        <?endfor?>
                        </div>
                    <?endif?>
                    </li>
                <?endforeach?>
                </ul>
            </div>
        </nav>
    </section>
    </div> 
<?endif?>