<div class="box">
  <div class="box-heading"><?=$text['heading_title']?></div>
  <div class="box-content">  <div style="background:none;"><div id="vk_groups<?=$widget?>"></div></div></div>
</div>

<script type="text/javascript"><!--
    VK.Widgets.Group("vk_groups<?=$widget?>", {mode: <?=$setting['mode']?>, width: "<?=$setting['width']?>", height: "<?=$setting['height']?>", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, <?=$setting['id_public']?>);
//--></script>

