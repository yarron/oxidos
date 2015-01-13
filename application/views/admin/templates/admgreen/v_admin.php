<!DOCTYPE html>
<html lang="<?=$language?>">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Oxidos CMS (http://www.oxidos.ru)" />
    <link href='/styles/admin/templates/admgreen/stylesheet/opensans.css' rel='stylesheet' type='text/css'>
    <link href='/styles/admin/templates/admgreen/stylesheet/dashboard.css' rel='stylesheet' type='text/css'>
    <title><?=$page_title?></title>
    <?foreach ($styles as $file_style):?>
    <?=html::style($file_style)?>

    <?endforeach?>

    <script src="/styles/admin/bower_components/jquery/dist/<?=BROWSER != 'new' ? 'jquery-old.min.js' : 'jquery.min.js'?>"></script>
    <?if(BROWSER == 'ie'):?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/styles/admin/templates/admgreen/javascript/html5shiv.min.js"></script>
    <script src="/styles/admin/templates/admgreen/javascript/respond.min.js"></script>
    <![endif]-->
    <?endif?>
    <link href="/image/favicon.ico" rel="shortcut icon" type="image/png" />
</head>
<body>
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="navigation-navbar">
        <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin"><img src="/styles/admin/templates/admgreen/image/logo.png" /></a>
        </div>
        <?if($auth):?>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" >
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="glyphicon glyphicon-cog"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/settings"><?=$text['entry_settings']?></a></li>
                        <li><a href="/admin/logs"><?=$text['entry_logs']?></a></li>
                        <li class="divider"></li>
                        <li><a href="http://www.oxidos.ru/c/documentation" target="_blank"><?=$text['entry_help']?></a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <i class="glyphicon glyphicon-user"></i> <?=$text['entry_username']?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="/admin/users/edit/<?=$text['profile']?>"><?=$text['entry_profile']?></a></li>
                        <li><a href="/" target="_blank">На сайт</a></li>
                        <li class="divider"></li>
                        <li><a href="/admin/logout"><?=$text['entry_exit']?></a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
        <?endif?>
        </div> <!-- /.container -->
    </nav>
    <?if($auth):?>
    <nav class="navbar navbar-inverse" role="navigation" id="navigation-subnavbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#subnavbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="subnavbar">
                <ul class="nav navbar-nav">
                    <?foreach ($menu as $value):?>
                    <?$i=0?>
                    <?foreach ($value as $sub_key => $sub_value):?>
                        <?if(count($value) == 1):?>
                            <?if(in_array($select, $value)):?>
                                <li class="active"><a href="/admin/<?=$sub_value?>"><i class="<?=$icon[$sub_value]?>"></i>
                                        <span><?=$sub_key?></span></a></li>
                            <?else:?>
                                <li><a href="/admin/<?=$sub_value?>"><i class="<?=$icon[$sub_value]?>"></i><span><?=$sub_key?></span></a></li>
                            <?endif?>
                        <?endif?>
                        <?if(count($value) > 1):?>

                            <?if($i==0):?>
                                    <?if(in_array($select, $value)):?>
                                        <li class="dropdown active">
                                    <?else:?>
                                        <li class="dropdown">
                                    <?endif?>
                            <a href="<?=$sub_value?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="<?=$icon[$sub_value]?>"></i>
                                <span><?=$sub_key?></span><b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu" role="menu"><?$i++?><?continue?>
                        <?endif?><?$i++?>
                                <?if($select==$sub_value):?>
                                    <li class="active"><?=Html::anchor('admin/'. $sub_value, $sub_key)?></li>
                                <?else:?>
                                    <li><?=Html::anchor('admin/'. $sub_value, $sub_key)?></li>
                                <?endif?>
                            <?if($i==count($value)):?>
                                </ul>
                                </li>
                            <?endif?>
                        <?endif?>
                    <?endforeach?>
                    <?endforeach?>
                </ul>
            </div> <!-- /.subnav-collapse -->
        </div> <!-- /container -->
    </nav>
    <div id="breadcrumb">
        <ol class="breadcrumb">
            <?$i=0?>
            <? foreach ($page_url as $url):?>
                <?=$i==0 ? "<i class='glyphicon glyphicon-dashboard'></i>" : ''?><?$i++?>
                <li><?=$url?></li>
            <?endforeach?>
        </ol>
    </div>
    <?endif?>
</header>
<main>
    <div class="container-fluid">
        <? if (isset($block_center)):?>
            <? foreach ($block_center as $cblock):?>
                <div class="row" <?=!$auth ? 'id="auth"' : '' ?>><?=$cblock?></div>
            <?endforeach?>
        <?endif?>
    </div>
</main>
<footer>
    <div class="container-fluid">
        <div class="row">
            <div id="footer-copyright" class="col-md-6">
                <a href="<?=$text['text_footer_href']?>"><?=$text['text_footer_title']?></a> &copy; 2015 All Rights Reserved.
            </div>
            <div id="footer-terms" class="col-md-6">
                <?=$text['text_footer_version']?>
            </div>
        </div>
    </div>
</footer>
<script src="/styles/admin/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<?foreach ($scripts as $file_script):?>
    <?=html::script($file_script)?>

<?endforeach?>
</body>
</html>
