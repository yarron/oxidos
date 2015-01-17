<?php defined('SYSPATH') or die('No direct script access.');

return array(
	/**
	 * Gzip can dramatically reduce the size of the sitemap. We recommend you use
	 * this option with more than 1,000 entries. Gzipped entries are computed by
	 * appending the .gz extension to the url (sitemap.xml.gz)
	 */
	'gzip' => array
	(
		'enabled' => TRUE,
		/*
		 * From 1-9
		 */
		'level' => 9
	),
	/**
	 * Array of URLs to ping. This lets the provider know you have updated your
	 * sitemap. sprintf string.
	 */
	'ping' => array
	(
		'Bing'   => 'http://www.bing.com/webmaster/ping.aspx?siteMap=%s',
        'YandexBlogs' => 'http://ping.blogs.yandex.ru/ping?sitemap=%s',
        'Live Search' => 'http://webmaster.live.com/ping.aspx?siteMap=%s',
        'Weblogs' => 'http://rpc.weblogs.com/pingSiteForm?name=InfraBlog&url=%s'
	)
);
