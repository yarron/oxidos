<?if (count($languages) > 1):?>
<?=Form::open('index/widgets/language', array('enctype' => 'multipart/form-data', "id" => "form"))?>
  <div id="language">
    <?foreach ($languages as $language):?>
        <img src="<?=HTTP_IMAGE?>flags/<?=$language['code']?>.png" alt="<?=$language['name']?>" title="<?=$language['name']?>" onclick="$('input[name=\'language_code\']').attr('value', '<?=$language['code']?>'); $(this).parent().parent().submit();" />
    <?endforeach?>
    <input type="hidden" name="language_code" value="">
    <input type="hidden" name="redirect" value="<?=$redirect?>">
  </div>
<?=Form::close()?> 
<?endif?>