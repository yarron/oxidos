<?php

// Sanity check, install should only be checked from index.php
defined('SYSPATH') or exit('Install tests must be loaded from within index.php!');
header('Content-Type: text/html; charset=utf8');
if (version_compare(PHP_VERSION, '5.3', '<'))
{
	// Clear out the cache to prevent errors. This typically happens on Windows/FastCGI.
	clearstatcache();
}
else
{
	// Clearing the realpath() cache is only possible PHP 5.3+
	clearstatcache(TRUE);
}

?>
<html dir="ltr" lang="ru">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Oxidos CMS Check</title>

	<style type="text/css">
	body { width: 42em; margin: 0 auto; font-family: sans-serif; background: #fff; font-size: 1em; }
	h1 { letter-spacing: -0.04em; }
	h1 + p { margin: 0 0 2em; color: #333; font-size: 90%; font-style: italic; }
	code { font-family: monaco, monospace; }
	table { border-collapse: collapse; width: 100%; }
		table th,
		table td { padding: 0.4em; text-align: left; vertical-align: top; }
		table th { width: 12em; font-weight: normal; }
		table tr:nth-child(odd) { background: #eee; }
		table td.pass { color: #191; }
		table td.fail { color: #911; }
	#results { padding: 0.8em; color: #fff; font-size: 1.5em; }
	#results.pass { background: #191; }
	#results.fail { background: #911; }
	</style>

</head>
<body>

	<h1>Проверка сервера</h1>

	<p>
            Здесь проводится проверка для корретной установки системы Oxidos CMS. Необходим файл c именем <b>.htaccess</b> в корне вашего сайта и установленное расширение <b>Ioncube Loader</b> на вашем сервере.
	</p>

	<?php $failed = FALSE ?>

	<table cellspacing="0">
            <tr> 
                <td>Расширение IonCube</td>
                <?php if (extension_loaded('ionCube Loader')): ?>
                        <td class="pass"><img src="/styles/install/image/good.png" alt="Good" /></td>
                        <td>&nbsp;</td>
                <?php else: $failed = TRUE ?>
                        <td class="fail"><img src="/styles/install/image/bad.png" alt="Bad" /></td>
                        <td>
                            <a target="_blank" href="/check/ioncube_ru.php">Установить</a> |
                            <a target="_blank" href="/check/ioncube_en.php">Install</a>
                        </td> 
                <?php endif ?>           
            </tr>
            <tr> 
                <td>Файл .htaccess</td>
                <?php if (is_file('.htaccess')): ?>
                        <td class="pass"><img src="/styles/install/image/good.png" alt="Good" /></td>
                        <td>&nbsp;</td>
                <?php else: $failed = TRUE ?>
                        <td class="fail"><img src="/styles/install/image/bad.png" alt="Bad" /></td>
                        <td>В корне сайта переименуйте файл "htaccess.txt" в ".htaccess"</td>
                <?php endif ?>
            </tr>
	</table>

	<?php if ($failed === TRUE): ?>
		<p id="results" class="fail">✘ Движок не может быть установлен, пока Вы не устраните неполадки.</p>
	<?php else: ?>
		<p id="results" class="pass">✔ Все требования выполнены<br />
			Удалите или переименуйте папку <code>check</code> и перезапустите страницу</p>
	<?php endif ?>

	
</body>
</html>
