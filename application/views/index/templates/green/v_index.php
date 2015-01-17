<!DOCTYPE html>
<html dir="ltr" lang="<?=$data['lang']?>">
<head>
    <meta charset="UTF-8" />
    <title><?=$title?></title>
    <base href="<?=$data['base']?>" />
    <?if ($description):?>
    <meta name="description" content="<?=$description?>" />
    <?endif?>
    <?if ($keywords):?>
    <meta name="keywords" content="<?=$keywords?>" />
    <?endif?>
    <?if ($data['icon']):?>
    <link href="<?=$data['icon']?>" rel="icon" />
    <?endif?>
    <meta name="generator" content="Oxidos CMS (http://www.oxidos.ru)" />
    <link href='/styles/index/templates/green/javascript/jquery/ui/themes/smoothness/jquery-ui-1.10.4.custom.min.css' rel='stylesheet' type='text/css'>
    <link href='/styles/index/templates/green/stylesheet/stylesheet.css' rel='stylesheet' type='text/css'>
    <link href='/styles/index/templates/green/javascript/jquery/colorbox/colorbox.css' rel='stylesheet' type='text/css'>
    <?=$data['browser']=='ie' ? "<link href='/styles/index/templates/green/stylesheet/ie.css' rel='stylesheet' type='text/css'>" : ""?>

    <?foreach ($styles as $file_style):?><?=html::style($file_style)?><?endforeach?>
    <?foreach (Controller_Index::$styles as $file_style):?><?=html::style($file_style)?><?endforeach?>

    <script src="/styles/index/templates/green/javascript/jquery/<?=$data['browser'] == 'new' ? 'jquery-2.1.0.min.js' : 'jquery-1.11.0.min.js'?>"></script>
    <?=$data['google_analytics']?>
</head>
<body>
<?=$content?>
<script src="/styles/index/templates/green/javascript/jquery/ui/jquery-ui-1.10.4.custom.min.js"></script>
<script src="/styles/index/templates/green/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<script src="/styles/index/templates/green/javascript/common.js"></script>
<?=$data['browser']=='ie' ? "<script src='/styles/index/templates/green/javascript/ie.js'></script>" : ""?>
<?foreach ($scripts as $file_script):?><?=html::script($file_script)?><?endforeach?>
<?foreach (Controller_Index::$scripts as $file_script):?><?=html::script($file_script)?><?endforeach?>
</body>
</html>
