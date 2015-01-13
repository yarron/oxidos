<!DOCTYPE html>
<html lang="<?=$lang?>">
<head>
<meta charset="UTF-8" />
<title><?=$text['text_title']?></title>
<link rel="stylesheet" type="text/css" href="/styles/install/css/css.css" />
<script type="text/javascript" src="/styles/install/js/jquery-1.7.1.min.js"></script>
</head>
<body>
<div id="container">
<div id="header">
  <div id="logo"><img src="/styles/install/image/logo.png" alt="Oxidos CMS" title="Oxidos CMS" /></div>
  <div id="language">
  <?=Form::open('install', array('enctype' => 'multipart/form-data'))?>
    <?foreach ($languages as $language):?>
        <img src="/styles/install/image/<?=$language['code']?>.png" alt="<?=$language['name']?>" title="<?=$language['name']?>" onclick="$('input[name=\'language_code\']').attr('value', '<?=$language['code']?>'); $(this).parent().submit();" />
    <?endforeach?>
    <input type="hidden" name="language_code" value="" />
    <input type="hidden" name="redirect" value="<?=$redirect?>" />
  <?=Form::close()?>
  </div>
</div> 
<div id="wrap">
    <h1><?=$step_title?></h1>
    <div id="subwrap">
        <div id="column-left">
          <ul>
              <?if($step == 1):?>
                <li><b><?=$text['text_license']?></b></li>
                <li><?=$text['text_install']?></li>
                <li><?=$text['text_config']?></li>
                <li><?=$text['text_final']?></li>
              <?endif?>
              <?if($step == 2):?>
                <li><?=$text['text_license']?></li>
                <li><b><?=$text['text_install']?></b></li>
                <li><?=$text['text_config']?></li>
                <li><?=$text['text_final']?></li>
              <?endif?>
              <?if($step == 3):?>
                <li><?=$text['text_license']?></li>
                <li><?=$text['text_install']?></li>
                <li><b><?=$text['text_config']?></b></li>
                <li><?=$text['text_final']?></li>
              <?endif?>
              <?if($step == 4):?>
                <li><?=$text['text_license']?></li>
                <li><?=$text['text_install']?></li>
                <li><?=$text['text_config']?></li>
                <li><b><?=$text['text_final']?></b></li>
              <?endif?>
            </ul>
        </div>
        <div id="content">
            <?if ($error_warning):?>
            <div class="warning"><?=$error_warning?></div>
            <?endif?>
            <?if ($success):?>
            <div class="message"><?=$success?></div>
            <?endif?>
            <?=$content?>
        </div>
        <div id="footer">
            <a onclick="window.open('http://www.oxidos.ru');">Oxidos CMS</a>|<a onclick="window.open('http://www.oxidos.ru/c/documentation');"><?=$text['text_doc']?></a>
            <br />
            <?=$text['text_copy']?>
        </div>
    </div>
</div>
</div>
</body></html>