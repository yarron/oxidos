<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Europe/Moscow');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');
define('DIR_IMAGE', DOCROOT.'image/');
define('HTTP_IMAGE', "http://".$_SERVER['HTTP_HOST'].'/image/');
define('VERSION', 'Version 1.0.0');
/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ru');
Cookie::$salt = 'random';
if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
$_SERVER['KOHANA_ENV'] = 'TESTING';
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
    'base_url'   => '/',
    'index_file' => false,
    'charset'    => 'utf-8',
    'cache_dir'  => APPPATH.'cache',
    'errors'     => true,
    'profile'    => true,
    'caching'    => false
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
    'install'       => MODPATH.'install',
    'auth'          => MODPATH.'auth',       // Basic authentication
    'cache'         => MODPATH.'cache',      // Caching with multiple backends
    'database'      => MODPATH.'database',   // Database access
    'image'         => MODPATH.'image',      // Image manipulation
    'orm'           => MODPATH.'orm',        // Object Relationship Mapping
    'pagination'    => MODPATH.'pagination', //модуль пагинации
    'orm-mptt'      => MODPATH.'orm-mptt',   // модуль вложенных категорий Nested Sets
    'email'         => MODPATH.'email',      // модуль для отправки писем
    'kohanalytics'  => MODPATH.'kohanalytics',// модуль для статистики Google
    'captcha'       => MODPATH.'captcha',    // модуль для каптчи
    'sitemap'       => MODPATH.'sitemap',    // модуль для карты сайта
));
Kohana::$config->attach(new Config_Database(
    array(
        'instance' => Kohana_Database::instance(),
        'table_name' => 'settings',)), FALSE // указываем имя таблицы для присоединения
);
/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
if ( ! Route::cache()) {
    /*
     * Роут с контроллером ошибок на сайте
     */
    Route::set('errors', 'errors(/<action>(/<message>))', array( 'action' => '[0-9]++','message' => '.+'))
        ->defaults(array(
            'directory'  => 'Index',
            'controller' => 'Errors',

        ));

    /*
     * Роут с контроллером  для статей
     */
    Route::set('articles', 'c/<category>(/page/<page>)(/<alias>.html(<href>))', array(
        'category'    => '[a-z0-9-_]+',
        'alias'  => '[a-z0-9-_]+',
        'page'   => '[0-9]+',
    ))
        ->defaults(array(
            'directory'  => 'Index',
            'action' => 'index',
            'controller' => 'Articles',
        ));
    /*
     * Роут для страницы контактов
     */
    Route::set('contacts', 'contacts.html')
        ->defaults(array(
            'directory'  => 'Index',
            'action' => 'index',
            'controller' => 'Contacts',
        ));

    /*
     * Роут для статических страниц
     */
    Route::set('pages', '<alias>.html')
        ->defaults(array(
            'directory'  => 'Index',
            'action' => 'index',
            'controller' => 'Page',
        ));

    /*
     * Роут для статических страниц
     */
    Route::set('info', 'info/<alias>.html')
        ->defaults(array(
            'directory'  => 'Index',
            'action' => 'info',
            'controller' => 'Page',
        ));

    /*
     * Роут для новостей
     */
    Route::set('news', 'news(/page/<page>)(/<alias>.html)', array(
        'alias'  => '[a-z0-9-_]+',
        'page'   => '[0-9]+',
    ))
        ->defaults(array(
            'directory'  => 'Index',
            'action' => 'index',
            'controller' => 'News',
        ));

    /*
     * Роут для отображения виджетов
     */
    Route::set('widgets', 'index/widgets(/<controller>(/<param>))', array('param' => '.+'))
        ->defaults(array(
            'directory'  => 'Index/Widgets',
            'action'     => 'index',
        ));

    /*
     * Роут для отображения RSS
     */
    Route::set('rss', 'rss.xml')
        ->defaults(array(
            'directory'  => 'Index/Feeds',
            'controller' => 'Frss',
            'action'     => 'index',
        ));


    /*
     * Роут для поиска
     */
    Route::set('search', 'search(/filter_name(/<filter_name>))(/filter_category_id/<filter_category_id>)(/filter_description/<filter_description>)(/page/<page>)(/<sort>/<type>)')
        ->defaults(array(
            'directory'  => 'Index',
            'controller' => 'Search',
            'action'     => 'index',
        ));


    /*****************************Роуты админки*******************************************************/
    /*
     * Роут с контроллером ошибок в админке
     */
    Route::set('admin_errors', 'admin/errors(/<message>(/<action>))', array( 'action' => '[0-9]++','message' => '.+'))
        ->defaults(array(
            'directory'  => 'Admin',
            'controller' => 'Errors',
            'action'     => 'index',
        ));

    /*
     * Роут с контроллером категорий
     */
    Route::set('admin_category', 'admin/categories(/path(/<path>))', array(
        'path'   => '[0-9_]+',
    ))
        ->defaults(array(
            'controller'  => 'Categories',
            'directory'  => 'Admin',
            'action'     => 'index',
        ));

    /*
     * Роут с контроллером авторизации в админку
     */
    Route::set('admin_auth', 'admin/<action>(/<id>)', array(
        'action' => '(index|login|logout)',
    ))
        ->defaults(array(
            'controller'  => 'Auth',
            'directory'  => 'Admin',

        ));

    /*
     * Роут для загрузки изображений админки
     */
    Route::set('admin_uploader', 'admin/image(/<action>(/<field>))', array(
        'action'    => 'files|directory|create|delete|move|copy|folders|rename|upload|image|index',
    ))
        ->defaults(array(
            'directory'  => 'Admin',
            'controller' => 'Image',
            'action'     => 'index',
        ));

    /*
     * Роут для просмотра логов
     */
    Route::set('admin_logs', 'admin/logs(/<action>)', array(
        'action'    => 'files|directory|delete|index|log',
    ))
        ->defaults(array(
            'directory'  => 'Admin',
            'controller' => 'Logs',
            'action'     => 'index',
        ));

    /*
     * Роут для виджетов админки
     */
    Route::set('admin_widgets', 'admin/widgets/<controller>')
        ->defaults(array(
            'directory'  => 'Admin/Widgets',
            'action'     => 'index',
        ));

    /*
     * Роут для каналов продвижения админки
     */
    Route::set('admin_feeds', 'admin/feeds/<controller>(/<action>)')
        ->defaults(array(
            'directory'  => 'Admin/Feeds',
            'action'     => 'index',
        ));

    /*
     * Роут для контроллеров админки
     */
    $admin = 'admin(/<controller>(/page/<page>)(/<sort>/<type>)(/<action>(/<id>(/status_<status>)))'.
        '(/filter_title/<title>)(/filter_name/<name>)(/filter_alias/<alias>)(/filter_date/<date>)(/filter_sort_order/<sort_order>)(/filter_status/<fstatus>)'.
        '(/filter_username/<username>)(/filter_ip/<ip>)'.
        ')';
    Route::set('admin', $admin,
        array(
            'page'      => '[0-9]+',
            'action'    => '[a-z0-9]+',
            'id'        => '[a-z0-9]+',
            'status'    => '[0-9]+',
            'fstatus'   => '[0-9]+',
            'fid'       => '[0-9]+',
            'type'      => 'asc|desc',
        ))
        ->defaults(array(
            'directory'  => 'Admin',
            'controller' => 'Main',
            'action'     => 'index',

        ));

    /*
     * Роут по-умолчанию, если ни один не найден
     */
    Route::set('default', '(<controller>(/<action>(/<id>))(/page)(/<page>))', array(
        'page'      => '[0-9]+',
        'action'    => '[a-z0-9]+',
        'id'        => '[a-z0-9]+',
    ))
        ->defaults(array(
            'directory'  => 'index',
            'controller' => 'main',
            'action'     => 'index',
        ));

    Route::cache(TRUE);
}

$version = 'new';
if (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "MSIE")){
    if(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 5")) $version = 'UPDATE';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 6.0")) $version = 'UPDATE';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 7.0")) $version = 'ie';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "MSIE 8.0")) $version = 'ie';
}
elseif (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Firefox")){
    if (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Firefox/1")) $version = 'UPDATE';
    elseif (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Firefox/2")) $version = 'UPDATE';
    elseif (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Firefox/3")) $version = 'old';
}
elseif (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Safari")){
    if(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Version/2")) $version = 'UPDATE';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Version/3")) $version = 'UPDATE';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Version/4")) $version = 'old';
}
elseif (UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Presto")){
    if(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Version/9")) $version = 'UPDATE';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Version/10")) $version = 'old';
    elseif(UTF8::stristr($_SERVER["HTTP_USER_AGENT"], "Version/11")) $version = 'old';
}
define('BROWSER', $version);
