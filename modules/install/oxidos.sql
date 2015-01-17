-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 02 2015 г., 17:10
-- Версия сервера: 5.6.22-log
-- Версия PHP: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `oxidos`
--

-- --------------------------------------------------------

--
-- Структура таблицы `adverts`
--
DROP TABLE IF EXISTS `ae_adverts`;
CREATE TABLE `ae_adverts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=2;

--
-- Дамп данных таблицы `adverts`
--
INSERT INTO `ae_adverts` (`id`, `name`, `status`) VALUES
(1, 'Слайдер', 1);
-- --------------------------------------------------------

--
-- Структура таблицы `advertsdescriptions`
--
DROP TABLE IF EXISTS `ae_advertsdescriptions`;
CREATE TABLE `ae_advertsdescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `advert_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=141;

--
-- Дамп данных таблицы `advertsdescriptions`
--
INSERT INTO `ae_advertsdescriptions` (`id`, `image_id`, `advert_id`, `language_id`, `title`) VALUES
(140, 70, 1, 2, 'Demo version Oxidos CMS'),
(139, 70, 1, 1, 'Демонстрационная версия Oxidos CMS'),
(138, 69, 1, 2, 'Oxidos CMS - multilanguage engine'),
(137, 69, 1, 1, 'Oxidos CMS - мультиязычный движок');
-- --------------------------------------------------------

--
-- Структура таблицы `advertsimages`
--
DROP TABLE IF EXISTS `ae_advertsimages`;
CREATE TABLE `ae_advertsimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `advert_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=71 ;

--
-- Дамп данных таблицы `advertsimages`
--
INSERT INTO `ae_advertsimages` (`id`, `advert_id`, `link`, `image`, `sort_order`) VALUES
(69, 1, 'http://www.oxidus.ru/download.html', 'data/show/show1.jpg', 1),
(70, 1, 'http://demo.oxidus.ru/admin', 'data/show/show2.jpg', 2);
-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--
DROP TABLE IF EXISTS `ae_articles`;
CREATE TABLE `ae_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(64) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_modified` datetime NOT NULL,
  `alias` varchar(128) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL DEFAULT '',
  `rating` int(1) NOT NULL DEFAULT '0',
  `viewed` int(11) NOT NULL DEFAULT '0',
  `popup` smallint(1) NOT NULL DEFAULT '0',
  `status` smallint(1) NOT NULL DEFAULT '0',
  `status_comment` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=3;

--
-- Дамп данных таблицы `articles`
--
INSERT INTO `ae_articles` (`id`, `author`, `sort_order`, `date_modified`, `alias`, `image`, `rating`, `viewed`, `popup`, `status`, `status_comment`) VALUES
(1, 'admin', 1, '2014-05-09 17:26:57', 'system-requirements', 'no_image.jpg', 5, 38, 0, 1, 1),
(2, 'admin', 0, '2015-01-01 21:43:25', 'engine-features', 'data/articles/cms.jpg', 4, 104, 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `articlesdescriptions`
--
DROP TABLE IF EXISTS `ae_articlesdescriptions`;
CREATE TABLE `ae_articlesdescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `seo_title` varchar(64) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8  COLLATE=utf8_general_ci AUTO_INCREMENT=5;

--
-- Дамп данных таблицы `articlesdescriptions`
--
INSERT INTO `ae_articlesdescriptions` (`id`, `article_id`, `language_id`, `seo_title`, `meta_description`, `meta_keywords`, `title`, `description`) VALUES
(1, 1, 1, 'Системные требования движка', 'Системные требования движка', 'Системные требования движка', 'Системные требования движка', '<p>Для полноценной работы движка необходимо следующее установленное на сервер программное обеспечение:</p>\n\n<ul>\n	<li><strong>Apache 2.0 и выше</strong></li>\n	<li><strong>PHP 5.2 и выше</strong></li>\n	<li><strong>MySQL 4.0 и выше</strong></li>\n	<li>Установленное расширение PHP&nbsp;<strong>GD</strong></li>\n	<li>Установленное расширение PHP&nbsp;<strong>iconv</strong></li>\n	<li>Установленное расширение PHP&nbsp;<strong>cURL</strong></li>\n	<li>Установленное расширение&nbsp;PHP&nbsp;<strong>PDO</strong></li>\n	<li>Установленное расширение&nbsp;PHP&nbsp;<strong>mbString</strong></li>\n	<li>Установленное расширение&nbsp;PHP&nbsp;<strong>IonCube</strong></li>\n</ul>'),
(2, 1, 2, 'System Requirements', 'System Requirements', 'System Requirements', 'System Requirements', '<p>To complete the work of the engine must have the following installed on the server software:&nbsp;</p>\n\n<ul>\n	<li>Apache 2.0 and above&nbsp;</li>\n	<li>PHP 5.2 and higher&nbsp;</li>\n	<li>MySQL 4.0 and above&nbsp;</li>\n	<li>Installed&nbsp;extension&nbsp;PHP GD &nbsp;</li>\n	<li>Installed&nbsp;extension PHP iconv&nbsp;</li>\n	<li>Installed&nbsp;extension&nbsp;PHP cURL &nbsp;</li>\n	<li>Installed extension&nbsp;PHP PDO &nbsp;</li>\n	<li>Installed extension PHP mbString&nbsp;</li>\n	<li>Installed extension PHP IonCube</li>\n</ul>'),
(3, 2, 1, 'Возможности движка Oxidos CMS', 'Возможности движка Oxidos CMS', '', 'Возможности движка Oxidos CMS', '<p><strong>Oxidos CMS</strong> - это прежде всего мультиязычный движок, который обладает огромными возможностями настройки и манипулирования контентом. Движок предназначен для создания корпоративных сайтов, новостных блогов,сайтов с большим информационным контекстом и также подойдет для создания сайтов-визиток. Несмотря на перечисленные виды сайтов он имеет большое количество настроек, которые позволяют использовать его практически для любых целей. Данный движок не имеет никаких ограничений на создание для него шаблонов, поэтому он может быть интегрирован практически в любой существующий дизайн.</p>\n\n<p><strong>Общие возможности:</strong></p>\n\n<ul>\n	<li>Использует для хранения данных <strong><em>MySQL</em></strong></li>\n	<li>Мощная система безопасности</li>\n	<li>Минимальная нагрузка на базу данных (от 0 до 10 запросов)</li>\n	<li>Использование асинхронной передачи данных <em><strong>AJAX</strong></em> при добавлении/редактировании комментариев</li>\n	<li>Дизайн для сайта создается без каких-либо ограничений</li>\n	<li>Система шаблонов позволяет создавать сайт любой сложности</li>\n	<li>Продуманная система управления баннерами для рекламы</li>\n	<li>Возможность создания не только динамического контента, но и статического</li>\n	<li>Возможность временной блокировки доступа на сайт (режим обслуживания)</li>\n	<li>Вывод на сайт новосте, статей, статических страниц, виджетов и баннеров</li>\n	<li>Все ссылки на сайт имеют <em><strong>ЧПУ</strong></em> (человеко-понятный URL). Ссылки формируются в автоматическом режиме, но есть возможность создавать ЧПУ вручную</li>\n	<li>Возможность использования вложенных категорий</li>\n	<li><em><strong>Каптча</strong></em> при регистрации и отправки сообщений</li>\n	<li>Поддержка неограниченного количества категорий, а также подкатегорий.</li>\n	<li>Рейтинг статей</li>\n	<li>Поиск по статьям</li>\n	<li>Возможность просмотра сколько раз была прочитана статья</li>\n	<li>Поддержка нескольких языков</li>\n	<li>Поддержка неограниченного количества групп пользователей</li>\n	<li>Возможность ограничения доступа к различным разделам админки для определенных групп пользователей.</li>\n	<li><em><strong>RSS</strong></em> Информер статей</li>\n	<li>Мультиязычная поддержка контента на сайте</li>\n	<li>Возможность самостоятельно создавать виджеты для сайта (если вы знакомы с моделью HMVC)</li>\n</ul>\n\n<p><strong>Возможности для посетителей сайта:</strong></p>\n\n<ul>\n	<li>Регистрация на сайте</li>\n	<li>Изменение пароля и данных профиля</li>\n	<li>Добавление комментариев для зарегистрированных пользователей</li>\n	<li>Выставление рейтинга статьям</li>\n	<li>Изменение и удаление пользователями своих собственных комментариев</li>\n	<li>Возможность загрузки фотографии в профиле пользователя</li>\n	<li>Возможность восстановления забытого пароля</li>\n	<li>Возможность переключения языка</li>\n</ul>\n\n<p><strong>Возможности админ панели:</strong></p>\n\n<ul>\n	<li>Добавление, редактирование и удаление новостей, статей, реклам, комментариев, статических страниц, языков, схем отображения, категорий, пунктов меню и другого контента&nbsp;</li>\n	<li>Для создания новостей, статей и статических страниц возможно использование удобного <em><strong>WYSIWYG</strong></em> редактора (упрощенный Microsoft Word)</li>\n	<li>Возможность включать и выключать виджеты, а также задавать их расположение и сотрировку</li>\n	<li>Редактирование пользователей</li>\n	<li>Возможность изменять опции сайта:\n	<ul>\n		<li>-изменять количество символов при отображении статей и новостей в списке</li>\n		<li>-изменять количество отображаемых статей, новостей и комментариев&nbsp;</li>\n		<li>-изменять вид кэширования и его время</li>\n		<li>-изменять почтовый протокол</li>\n		<li>-изменять ширину у изображений на сайте под ваш дизайн</li>\n		<li>-включать и выключать режим комментариев</li>\n	</ul>\n	</li>\n	<li>Имеется возможность использовать смайлы и <em><strong>HTML</strong></em> код</li>\n	<li>Создание неограниченных групп пользователей с возможностью назначения им различных прав доступа в админку на каждый из модулей</li>\n	<li>Создание, изменение и удаление схем отображения виджетов</li>\n	<li>Выбор роли пользователей для новых регистрирующихся посетителей и адмнинистраторов</li>\n	<li>Автоматическое урезание загруженных картинок с сохранением пропорций до указанных размеров</li>\n	<li>Возможность загрузки картинок для каждой конкретной новости и статьи</li>\n	<li>Удобный <em><strong>AJAX</strong></em> менеджер загруженных картинок</li>\n	<li>Удобное управление рекламными материалами</li>\n	<li>Возможность рассылать информацию пользователям сайта на <strong><em>Email</em></strong></li>\n	<li>Создание карты сайта для <em><strong>Google</strong></em></li>\n	<li>Включение и отключение <em><strong>RSS</strong></em> информера</li>\n	<li>Просмотр и удаления логов ошибок за все время</li>\n	<li>Возможность следить за статистикой сайта с помощью внутренних счетчиков</li>\n	<li>Возможность едить за статистикой посещений сайта с помощью интеграции <strong>Google Analytics</strong></li>\n	<li>Возможность добавлять <em><strong>HTML</strong></em> код и отображать его на сайте в указанном блоке</li>\n	<li>Возможность удобной сортировки статей, новостей и пользователей</li>\n	<li>Возможность быстрого включения и отключения новостей, статей, категорий, комментариев и другого контента</li>\n	<li>Возможность менять язык по умолчанию как для админки, так и для видимой части сайта</li>\n</ul>'),
(4, 2, 2, 'Engine features Oxidos CMS', 'Engine features Oxidos CMS', '', 'Engine features Oxidos CMS', '<p><strong>Oxidos CMS </strong> - this is primarily a multilanguage engine, which has huge customization and manipulating content. The engine is designed to create corporate websites , news blogs, sites with great information context and is also suitable for creating business sites . Despite these kinds of sites it has a large number of settings that you can use it for virtually any purpose . This engine has no restrictions on the creation of templates for him , so it can be integrated into virtually any existing design .</p>\n\n<p><strong>General Features:</strong></p>\n\n<ul>\n	<li>Used to store data<strong> <em>MySQL</em></strong></li>\n	<li>Powerful security</li>\n	<li>Minimum load on the database ( from 0 to 10 requests )</li>\n	<li>Using asynchronous data <em> <strong> AJAX </strong> </em> when adding / editing comments</li>\n	<li>Design for the site is created without any restrictions</li>\n	<li>Template system allows you to create a website of any complexity</li>\n	<li>Sophisticated control system for advertising banners</li>\n	<li>Ability to create not only dynamic content , but also static</li>\n	<li>Ability to temporarily block access to the site ( maintenance mode )</li>\n	<li>Conclusion on site news, articles, static pages , widgets and banners</li>\n	<li>All links to the site are <em> <strong> NC </strong> </em> ( human-friendly URL). Links are generated automatically , but you can manually create the NC</li>\n	<li>Ability to use nested categories</li>\n	<li><em><strong>Captcha </strong> </em> when registering and sending messages</li>\n	<li>Supports unlimited number of categories and subcategories .</li>\n	<li>Rating</li>\n	<li>Articles</li>\n	<li>Search for articles</li>\n	<li>Ability to view how many times the article was read</li>\n	<li>Support multiple languages</li>\n	<li>Supports unlimited number of user groups</li>\n	<li>Ability to restrict access to the different sections of the admin for certain user groups .</li>\n	<li><em><strong>RSS </strong> </em> informer articles</li>\n	<li>Multilingual support content on the site</li>\n	<li>Ability to create widgets for the site (if you are familiar with the model HMVC)</li>\n</ul>\n\n<p><strong>Opportunities for visitors to the site: </strong></p>\n\n<ul>\n	<li>Register online</li>\n	<li>Change password and profile data</li>\n	<li>Adding comments to registered users</li>\n	<li>Setting</li>\n	<li>Rated articles</li>\n	<li>Editing and deleting users their own comments</li>\n	<li>Ability to upload photos</li>\n	<li>Profile</li>\n	<li>Ability to recover a forgotten password</li>\n	<li>Ability to switch language</li>\n</ul>\n\n<p><strong>Admin panel Features : </strong></p>\n\n<ul>\n	<li>Add, edit and delete news articles , advertisements, comments , static pages , languages, mapping schemes , categories , menu items and other content</li>\n	<li>To create news, articles and static pages you can use convenient <em> <strong> WYSIWYG </strong> </em> editor ( simple Microsoft Word)</li>\n	<li>Ability to enable and disable widgets, as well as specify their location and sotrirovku</li>\n	<li>Editing users</li>\n	<li>Ability to modify site options :\n	<ul>\n		<li>- changing characters when displaying articles and news items in the list</li>\n		<li>- change the number of displayed articles, news and comments</li>\n		<li>- caching and change the appearance of his time</li>\n		<li>- mail protocol change</li>\n		<li>- change the width of the images on the site under your design</li>\n		<li>- arming and comments</li>\n	</ul>\n	</li>\n	<li>You can use smileys and <em> <strong> HTML </strong> </em> code</li>\n	<li>Create unlimited user groups to assigning them different access rights to the admin panel for each of the modules</li>\n	<li>Create , edit and delete mapping schemes widgets</li>\n	<li>Select user roles for new registrants and visitors admninistratorov</li>\n	<li>Automatic cutting</li>\n	<li>Downloaded images proportionally to the specified dimensions</li>\n	<li>Ability to upload pictures for each news and articles</li>\n	<li>Convenient</li>\n	<li><em><strong>AJAX </strong> </em> manager uploaded images</li>\n	<li>Convenient control</li>\n	<li>Advertising materials</li>\n	<li>Ability</li>\n	<li>Send information to users on the site <strong> <em> Email </em> </strong></li>\n	<li>Creating a site map for <em> <strong> Google </strong> </em></li>\n	<li>Enabling and disabling</li>\n	<li><em><strong>RSS </strong> </em> informer</li>\n	<li>View and delete error logs for all time</li>\n	<li>Ability to follow the statistics website using internal counters</li>\n	<li>Ability</li>\n	<li>edit the statistics of visits by integrating <strong> Google Analytics </strong></li>\n	<li>Ability to add</li>\n	<li><em><strong>HTML </strong> </em> code and display it on the website in this block</li>\n	<li>Ability</li>\n	<li>Comfortable sort of articles, news and users</li>\n	<li>Ability to quickly enable or disable news, articles , categories , comments, and other content</li>\n	<li>Ability to change the default language for both the admin and the visible part of the site</li>\n</ul>');

-- --------------------------------------------------------

--
-- Структура таблицы `articles_categories`
--
DROP TABLE IF EXISTS `ae_articles_categories`;
CREATE TABLE `ae_articles_categories` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`article_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `articles_categories`
--
INSERT INTO `ae_articles_categories` (`article_id`, `category_id`) VALUES
(1, 1),
(2, 1);
-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--
DROP TABLE IF EXISTS `ae_categories`;
CREATE TABLE `ae_categories` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `alias` varchar(64) NOT NULL DEFAULT '',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_modified` varchar(10) NOT NULL DEFAULT '',
  `top` tinyint(1) NOT NULL DEFAULT '0',
  `column` int(3) NOT NULL DEFAULT '1',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `scope` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `categories`
--
INSERT INTO `ae_categories` (`id`, `alias`, `sort_order`, `status`, `date_modified`, `top`, `column`, `parent_id`, `lft`, `rgt`, `lvl`, `scope`) VALUES
(1, 'about-engine', 1, 1, '1399710475', 1, 1, 0, 1, 2, 1, 1),
(2, 'widgets', 2, 1, '1399878958', 1, 1, 0, 1, 2, 1, 2),
(3, 'help', 3, 1, '1399877641', 1, 1, 0, 1, 8, 1, 3),
(6, 'setting', 1, 1, '1400054093', 0, 1, 3, 2, 3, 2, 3),
(8, 'documentation', 2, 1, '1400054080', 1, 0, 3, 4, 5, 2, 3),
(9, 'tips', 3, 1, '1400054320', 0, 0, 3, 6, 7, 2, 3),
(10, 'templates', 4, 1, '1400054489', 1, 2, 0, 1, 6, 1, 4),
(11, 'templates-for-website', 1, 1, '1400054562', 1, 0, 10, 2, 3, 2, 4),
(12, 'templates-for-admin', 2, 1, '1400054612', 1, 0, 10, 4, 5, 2, 4);
-- --------------------------------------------------------

--
-- Структура таблицы `categoriesdescriptions`
--
DROP TABLE IF EXISTS `ae_categoriesdescriptions`;
CREATE TABLE `ae_categoriesdescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `seo_title` varchar(64) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=23;

--
-- Дамп данных таблицы `categoriesdescriptions`
--
INSERT INTO `ae_categoriesdescriptions` (`id`, `category_id`, `language_id`, `seo_title`, `meta_description`, `meta_keywords`, `title`, `description`) VALUES
(1, 1, 1, 'О движке', 'О движке', '', 'О движке', '<p>Информация о движке Oxidos CMS</p>'),
(2, 1, 2, 'About Engine', 'About Engine', '', 'About Engine', '<p>Information about Oxidos CMS</p>'),
(3, 2, 1, 'Виджеты', 'Виджеты', '', 'Виджеты', '<p>Виджеты для Oxidos CMS</p>'),
(4, 2, 2, 'Widgets', 'Widgets', 'Widgets', 'Widgets', '<p>Widgets for Oxidos CMS</p>'),
(5, 3, 1, 'Помощь', 'Помощь', '', 'Помощь', '<p>Помощь</p>'),
(6, 3, 2, 'Help', 'Help', '', 'Help', '<p>Help</p>'),
(11, 6, 1, 'Настройка', 'Настройка', '', 'Настройка', '<p>Настройка</p>'),
(12, 6, 2, 'Setting', 'Setting', '', 'Setting', '<p>Setting</p>'),
(13, 8, 1, 'Документация', 'Документация', '', 'Документация', '<p>Документация</p>'),
(14, 8, 2, 'Documentation', 'Documentation', '', 'Documentation', '<p>Documentation</p>'),
(15, 9, 1, 'Советы', 'Советы', 'Советы', 'Советы', '<p>Советы</p>'),
(16, 9, 2, 'Tips', 'Tips', 'Tips', 'Tips', '<p>Tips</p>'),
(17, 10, 1, 'Шаблоны', 'Шаблоны', '', 'Шаблоны', '<p>Шаблоны</p>'),
(18, 10, 2, 'Templates', 'Templates', '', 'Templates', '<p>Templates</p>'),
(19, 11, 1, 'Шаблоны для сайта', 'Шаблоны для сайта', '', 'Шаблоны для сайта', '<p>Шаблоны для сайта</p>'),
(20, 11, 2, 'Templates for website', 'Templates for website', '', 'Templates for website', '<p>Templates for website</p>'),
(21, 12, 1, 'Шаблоны для админки', 'Шаблоны для админки', '', 'Шаблоны для админки', '<p>Шаблоны для админки</p>'),
(22, 12, 2, 'Templates for admin', 'Templates for admin', '', 'Templates for admin', '<p>Templates for admin</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--
DROP TABLE IF EXISTS `ae_comments`;
CREATE TABLE `ae_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `author` varchar(40) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `ip` varchar(16) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rating` int(1) NOT NULL DEFAULT '0',
  `is_reg` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=5;


-- --------------------------------------------------------


--
-- Структура таблицы `extensions`
--
DROP TABLE IF EXISTS `ae_extensions`;
CREATE TABLE `ae_extensions` (
  `group` varchar(32) NOT NULL,
  `key` varchar(64) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `extensions`
--

INSERT INTO `ae_extensions` (`group`, `key`, `value`) VALUES
('widget', 'wslider', 'a:1:{i:0;a:7:{s:5:"width";s:4:"1078";s:6:"height";s:3:"300";s:9:"advert_id";s:1:"1";s:9:"layout_id";s:1:"3";s:8:"position";s:12:"block_slider";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}'),
('widget', 'wnews', 'a:7:{i:0;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:1;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"5";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:2;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"7";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:3;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"6";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:4;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"8";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:5;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"9";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}i:6;a:7:{s:5:"limit";s:1:"5";s:5:"count";s:3:"100";s:9:"layout_id";s:1:"4";s:8:"position";s:11:"column_left";s:4:"head";s:1:"1";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"2";}}'),
('widget', 'whtml', 'a:1:{i:1;a:6:{s:5:"title";a:2:{i:1;s:86:"Добро пожаловать на демонстрацию движка Oxidos CMS.";i:2;s:54:"Welcome to the demonstration of the engine Oxidos CMS.";}s:11:"description";a:2:{i:1;s:2402:"<p><img alt="" src="/image/data/articles/box.jpg" style="line-height: 1.7em; float: left; height: 200px; width: 200px;" kasperskylab_antibanner="on"></p>\n\n<p><strong>Oxidos CMS</strong> -<span style="line-height: 1.7em;">&nbsp;это прежде всего бесплатный мультиязычный движок, который обладает огромными возможностями настройки и манипулирования контентом.&nbsp;Движок предназначен для создания корпоративных сайтов,&nbsp;новостных блогов, сайтов с большим информационным контекстом и также подойдет для создания сайтов-визиток. Несмотря на перечисленные виды сайтов&nbsp;он имеет большое количество настроек, которые позволяют использовать его практически для любых целей. Данный движок не имеет никаких ограничений на создание для него шаблонов, поэтому он&nbsp;может быть интегрирован практически в любой существующий дизайн.</span></p>\n\n<p>&nbsp;</p>\n\n<p><strong>Ключевыми особенностями движка&nbsp;</strong><strong style="line-height: 22.1000003814697px;">Oxidos CMS</strong><strong>&nbsp;являются:</strong></p>\n\n<ul>\n	<li><em>создание мультиязычного контента</em></li>\n	<li><em>создание неограниченного количества языков для контента</em></li>\n	<li><em>создение категорий неограниченной вложенности</em></li>\n	<li><em>низкая нагрузка на системные ресурсы</em></li>\n	<li><em>все ссылки на контент имеют ЧПУ</em></li>\n	<li><em>высокая скорость работы движка</em></li>\n</ul>\n\n<p>Обо всех функциональных особенностях вы сможете прочитать в статье <a href="http://www.oxidos.ru/c/documentation/cms-dlya-sajta-vozmozhnosti.html" target="_blank">Возможности движка Oxidos CMS</a>.</p>\n";i:2;s:1249:"<p><img alt="" src="/image/data/articles/box.jpg" style="float:left; height:200px; width:200px" kasperskylab_antibanner="on"></p>\n\n<p><strong style="line-height: 22.1000003814697px;">Oxidos CMS</strong>&nbsp;- this is primarily a multilanguage engine, which has huge customization and manipulation of content. The engine is designed to create corporate websites , news blogs and websites to sell their scripts , sites with great information context and is also suitable for creating corporate websites . Despite these kinds of sites it has a large number of settings that allow you to use it for virtually any purpose. This engine has no restrictions on the creation of templates for him , so it can be integrated into virtually any existing design .</p>\n\n<p>The key features of the engine&nbsp;<strong style="line-height: 22.1000003814697px;">Oxidos CMS</strong>&nbsp;are:</p>\n\n<ul>\n	<li>the creation of multilingual content</li>\n	<li>the creation an unlimited number of languages ​​for content</li>\n	<li>the creation categories of unlimited nesting</li>\n	<li>low load on system resources</li>\n	<li>all references to the content are CNC</li>\n	<li>High speed engine</li>\n</ul>\n\n<p>About all the functional features you can read on our page.</p>\n";}s:9:"layout_id";s:1:"3";s:8:"position";s:11:"content_top";s:10:"sort_order";s:1:"1";s:6:"status";s:1:"1";}}'),
('widget', 'wcategory', 'a:4:{i:0;a:4:{s:9:"layout_id";s:1:"3";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:1;a:4:{s:9:"layout_id";s:1:"5";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:2;a:4:{s:9:"layout_id";s:1:"7";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}i:3;a:4:{s:9:"layout_id";s:1:"8";s:8:"position";s:11:"column_left";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}'),
('widget', 'waccount', 'a:1:{i:0;a:4:{s:9:"layout_id";s:1:"3";s:8:"position";s:12:"column_right";s:6:"status";s:1:"1";s:10:"sort_order";s:1:"1";}}');

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--
DROP TABLE IF EXISTS `ae_languages`;
CREATE TABLE `ae_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `ae_languages` (`id`, `name`, `code`, `locale`, `image`, `sort_order`, `status`) VALUES
(1, 'Russian', 'ru', 'ru_RU.UTF-8,ru_RU,russian', 'ru.png', 1, 1),
(2, 'English', 'en', 'en_US.UTF-8,en_US,en-gb,english', 'gb.png', 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `layouts`
--
DROP TABLE IF EXISTS `ae_layouts`;
CREATE TABLE `ae_layouts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `route` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `layouts`
--

INSERT INTO `ae_layouts` (`id`, `name`, `route`) VALUES
(3, 'Home', '/'),
(4, 'Contact', 'contacts'),
(5, 'Article', 'articles'),
(6, 'Account', 'account'),
(7, 'News', 'news'),
(8, 'Static Page', 'page'),
(9, 'Search', 'search');

-- --------------------------------------------------------

--
-- Структура таблицы `ae_menu`
--
DROP TABLE IF EXISTS `ae_menu`;
CREATE TABLE `ae_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `sort_order` int(3) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `ae_menu`
--

INSERT INTO `ae_menu` (`id`, `page_id`, `url`, `sort_order`, `status`) VALUES
(1, 0, '', 1, 1),
(2, 11, '', 2, 1),
(3, 0, 'news', 4, 1),
(4, 0, 'account/account', 3, 1),
(5, 0, 'contacts.html', 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `ae_menudescriptions`
--
DROP TABLE IF EXISTS `ae_menudescriptions`;
CREATE TABLE `ae_menudescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `ae_menudescriptions`
--

INSERT INTO `ae_menudescriptions` (`id`, `menu_id`, `language_id`, `title`) VALUES
(1, 1, 1, 'Главная'),
(2, 1, 2, 'Main'),
(3, 2, 1, 'Демо'),
(4, 2, 2, 'Demo'),
(5, 3, 1, 'Новости'),
(6, 3, 2, 'News'),
(7, 4, 1, 'Аккаунт'),
(8, 4, 2, 'Account'),
(9, 5, 1, 'Контакты'),
(10, 5, 2, 'Contacts');

-- --------------------------------------------------------
--
-- Структура таблицы `news`
--
DROP TABLE IF EXISTS `ae_news`;
CREATE TABLE `ae_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `date_modified` varchar(10) NOT NULL DEFAULT '',
  `alias` varchar(128) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=2;

--
-- Дамп данных таблицы `news`
--
INSERT INTO `ae_news` (`id`, `sort_order`, `date_modified`, `alias`, `image`, `status`) VALUES
(1, 1, '1421155421', 'born-oxidos-cms', 'no_image.jpg', 1);
-- --------------------------------------------------------

--
-- Структура таблицы `newsdescriptions`
--
DROP TABLE IF EXISTS `ae_newsdescriptions`;
CREATE TABLE `ae_newsdescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `new_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `seo_title` varchar(64) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `newsdescriptions`
--
INSERT INTO `ae_newsdescriptions` (`id`, `new_id`, `language_id`, `seo_title`, `meta_description`, `meta_keywords`, `title`, `description`) VALUES
(1, 1, 1, 'Вышел новый движок Oxidos CMS', 'Вышел новый движок Oxidos CMS', '', 'Вышел новый движок Oxidos CMS', '<p><strong>Движок Oxidos CMS</strong> наконец увидел свет и вышел из тени покорять просторы интернета. Он быстр и удобен и уже способен дать фору гигантам и профи. Его легкое управление и настройки сделают создание сайта для вас приятной процедурой. Его гибкая настройка удивит вас и откроет потенциал творить. Если раньше вы думали. что создать сайт - это сложно. Теперь сомнения исчезнут.&nbsp;</p>\n\n<p>Представляем вам мультиязычную систему управлением контента<strong> Oxidos CMS</strong>. Она поможет вам создать сайт и интуитивно подскажет, как нужно быстро и легко добиваться поставленной цели. Команда Oxidos CMS не собирается стоять на месте и будет продолжать наращивать функционал. Удачных вам творений!&nbsp;</p>'),
(2, 1, 2, 'Born new engine Oxidos CMS', 'Born new engine Oxidos CMS', '', 'Born new engine Oxidos CMS', '<p>Oxidos CMS engine finally saw the light and out of the shadows to conquer the vastness of the Internet. It is fast and convenient and is already able to give odds giants and pros. Its easy operation and setup will create a website for you a pleasant procedure. Its flexible configuration surprise you and open up the potential to create. If you previously thought . that create a website - it''s hard. Now doubts disappear.</p>\n\n<p>Introducing you multilanguage content management systems Oxidos CMS. It will help you create a website and intuitively tell how to quickly and easily achieve goals . Team Oxidos CMS is not going to stand still and will continue to build functional. Successful you creations!</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--
DROP TABLE IF EXISTS `ae_pages`;
CREATE TABLE `ae_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `alias` varchar(128) NOT NULL DEFAULT '',
  `date_modified` varchar(10) NOT NULL DEFAULT '',
  `viewed` int(11) NOT NULL DEFAULT '0',
  `main` tinyint(1) NOT NULL DEFAULT '0',
  `status` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `ae_pages` (`id`, `sort_order`, `alias`, `date_modified`, `viewed`, `main`, `status`) VALUES
(9, 0, 'general-rules', '1399629584', 2, 0, 1),
(11, 0, 'demo', '1420205497', 63, 0, 1),
(12, 0, 'gnu', '1420206163', 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `pagesdescriptions`
--
DROP TABLE IF EXISTS `ae_pagesdescriptions`;
CREATE TABLE `ae_pagesdescriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `seo_title` varchar(64) NOT NULL DEFAULT '',
  `meta_description` varchar(255) NOT NULL DEFAULT '',
  `meta_keywords` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `pagesdescriptions`
--

INSERT INTO `ae_pagesdescriptions` (`id`, `page_id`, `language_id`, `seo_title`, `meta_description`, `meta_keywords`, `title`, `description`) VALUES
(3, 9, 1, 'Общие правила', 'Общие правила', '', 'Общие правила', '<p><span style="line-height:1.6">Начнем с того, что на сайте общаются сотни людей, разных религий и взглядов, и все они являются полноправными посетителями нашего сайта, поэтому если мы хотим чтобы это сообщество людей функционировало нам и необходимы правила. Мы настоятельно рекомендуем прочитать данные правила,т.к. это займет всего несколько минут и сбережет нам и вам время и поможет сделать сайт более интересным и организованным.&nbsp;</span></p>\n\n<p><span style="line-height:1.6">На сайте строго запрещены:</span></p>\n\n<ul>\n	<li><span style="line-height:1.6">сообщения, не относящиеся к содержанию статьи или к контексту обсуждения </span></li>\n	<li><span style="line-height:1.6">оскорбления и угрозы в адрес посетителей сайта </span></li>\n	<li><span style="line-height:1.6">в комментариях запрещаются выражения, содержащие ненормативную лексику, унижающие человеческое достоинство, разжигающие межнациональную рознь </span></li>\n	<li><span style="line-height:1.6">спам, а также реклама любых товаров и услуг, иных ресурсов, СМИ или событий, не относящихся к контексту обсуждения статьи.</span></li>\n</ul>\n\n<p><span style="line-height:1.6">Давайте будем уважать друг друга и сайт, на который Вы и другие читатели приходят пообщаться и высказать свои мысли. Администрация сайта оставляет за собой право удалять комментарии или часть комментариев, если они не соответствуют данным требованиям. При нарушении правил вам может быть дано предупреждение. В некоторых случаях может быть дан бан без предупреждений. По вопросам снятия бана писать администратору. Оскорбление администраторов или модераторов также караются баном - уважайте чужой труд.</span></p>'),
(4, 9, 2, 'General rules', 'General rules', '', 'General rules', '<p>To begin with, the site communicate with hundreds of people of different religions and beliefs, and they are full of our site visitors, so if we want a community of people to function and we need rules. We strongly recommend that you read these rules, as it only takes a few minutes and we save you time and help make the site more interesting and organized.</p>\n\n<p>The site is strictly prohibited:</p>\n\n<ul>\n	<li>Messages not related to the content of the article or to the context of the discussion&nbsp;</li>\n	<li>Insults and threats to the visitors&nbsp;</li>\n	<li>In the comments are prohibited words that contain profanity, degrading, inciting ethnic strife&nbsp;</li>\n	<li>Spam and advertising of any goods and services, other resources, media, or events outside the context of the discussion of article.</li>\n</ul>\n\n<p>Let us respect each other and our website on which you and other readers come to talk and express their thoughts. The management reserves the right to remove comments, or part of the comments, if they do not meet these requirements. If you violate the rules you may be given a warning. In some cases, you may be given a ban without warning. Ban reason to write administrator. Insult administrators or moderators also punishable ban - Respect other people&#39;s labor.</p>');
INSERT INTO `ae_pagesdescriptions` (`id`, `page_id`, `language_id`, `seo_title`, `meta_description`, `meta_keywords`, `title`, `description`) VALUES
(9, 12, 1, 'Стандартная Общественная Лицензия GNU', 'Стандартная Общественная Лицензия GNU (GNU General Public License, GNU GPL) - это свободная copyleft лицензия для программного обеспечения (ПО) и других видов произведений.  Большинство лицензий на программное обеспечение и другие произведения спроектиров', '', 'Стандартная Общественная Лицензия GNU', '<h3>СТАНДАРТНАЯ ОБЩЕСТВЕННАЯ ЛИЦЕНЗИЯ GNU</h3><p>Версия 3, от 29 июня 2007</p><p>Copyright © 2007 Free Software Foundation, Inc. &lt;http://fsf.org/&gt;</p><p> Каждый имеет право распространять точные копии этой лицензии, но без внесения изменений.</p><h3><a name="ПРЕАМБУЛА"></a>ПРЕАМБУЛА</h3><p>Стандартная Общественная Лицензия GNU (GNU General Public License, GNU GPL) - это свободная copyleft лицензия для программного обеспечения (ПО) и других видов произведений. </p><p>Большинство лицензий на программное обеспечение и другие произведения спроектированы так, чтобы лишить вас свободы делиться ими и изменять их. Стандартная Общественная Лицензия GNU, напротив, разработана с целью гарантировать Ваше право распространять и вносить изменения во все версии программного обеспечения - для уверенности, что ПО останется свободным для всех пользователей. Мы, Фонд Свободного Программного Обеспечения (Free Software Foundation), используем GNU GPL для большей части нашего программного обеспечения; эта лицензия применяется также к любым другим произведениям, чьи авторы используют её. Вы можете использовать эту лицензию и для своего ПО. </p><p>Когда мы говорим о свободном ПО, мы говорим о свободе, а не цене. Наши лицензии спроектированы так, чтобы удостовериться в Вашем праве распространять копии свободного ПО (и взимать за это плату по своему желанию), чтобы Вы получали исходный код или могли получить его при желании, чтобы Вы могли изменять ПО или использовать его части в новых свободных программах, и чтобы Вы знали что Вы можете это сделать. </p><p>Для защиты Ваших прав, нам необходимо ограничивать других в возможности отказать Вам в Ваших правах или просить Вас отказаться от них. Поэтому если Вы распространяете копии свободного ПО или изменяете его, то на Вас ложатся некоторые обязанности: обязанности уважать свободу других. </p><p>Например, если Вы распространяете копии свободного ПО, бесплатно или по определённой цене, Вы должны предоставлять получателям те же свободы, которые получили сами. Вы должны быть уверены, что они, также как и Вы, получили или могут получить исходный код. И Вы должны донести до них эти условия, чтобы они знали свои права. </p><p>Разработчики, использующие GNU GPL, защищают Ваши права с помощью следующих двух шагов: (1) заявляют авторские права на ПО, и (2) предоставляют Вам эту лицензию, дающую Вам законное право копировать, распространять и/или изменять его. </p><p>Для защиты разработчиков и авторов GPL чётко объясняет, что нет никакой гарантии, распространяемой на свободное ПО. Для удобства пользователей и авторов, GPL требует чтобы модифицированные версии обозначались как "изменённые", таким образом проблемы и ошибки изменённых версий не будут ошибочно приписаны авторам оригинала. </p><p>Некоторые устройства спроектированы так, чтобы запретить пользователю установку или запуск изменённых версии ПО, хотя производитель может это делать. Это абсолютно несовместимо с нашей целью - защитой пользовательских прав изменять ПО. Подобные злоупотребления систематически происходят в сфере продуктов индивидуального использования, в которой это особенно неприемлемо. Именно поэтому мы разработали данную версию GPL чтобы запретить подобную практику на этом рынке. Если подобные проблемы возникнут в других областях, мы, ради защиты свободы пользователей, готовы расширить действие лицензии на эти новые области в будущих версиях GPL. </p><p>Наконец, каждой программе постоянно угрожают софтверные патенты. Государства не должны допускать ограничение патентами разработки и использования ПО на компьютерах общего назначения, но т.к. они это делают, мы хотим избежать опасности наложения патентов на свободные программы, что сделает их, фактически, частной собственностью. Для предотвращения этого, GPL гарантирует, что патенты  не могут быть использованы с целью сделать программу несвободной. </p><p>Ниже следуют точные условия копирования, распространения и изменения. </p><h3><a name="terms"></a>УСЛОВИЯ</h3><h4><a id="section0"></a>0. Определения</h4>    <p>"Данная Лицензия" подразумевает третью версию Стандартной Общественной Лицензии GNU. </p>    <p>"Авторское право" также обозначает законы, схожие с законами об авторском праве, применимые к другим видам произведений, например, топологиям интегральных микросхем. </p>    <p>"Программа" подразумевает любое охраноспособное произведение, лицензированное Данной Лицензией. К каждому владельцу лицензии (лицензиату) обращаются как "Вы". "Владельцы лицензии" и "получатели" могут быть как физическими, так и юридическими лицами. </p>    <p>"Модифицирование" произведения означает копирование или адаптация всего или части произведения в форме, требующей разрешения правообладателя и отличающееся от точного копирования. Результат называется "изменённой версией" предыдущего произведения или произведением, "основанным" на предыдущем произведении. </p>    <p>"Лицензированное произведение" подразумевает немодифицированную Программу, либо произведение, основанное на Программе. </p>    <p>"Тиражировать" произведение означает делать что-либо с ним, что, без разрешения, сделает вас непосредственно либо косвенно ответственным за нарушение авторского права в соответствии с применимым законом, за исключением запуска на компьютере или изменения личной копии. Тиражирование включает в себя копирование, распространение (с или без изменений), публикацию, и, в некоторых странах, некоторые другие действия. </p>    <p>"Передача" произведения означает любой вид тиражирования, который позволяет третьим лицам создавать или получать копии. Простое взаимодействие с пользователем через компьютерную сеть, без получения копии, передачей не является. </p>    <p>Пользовательский интерфейс отображает "Соответствующие правовые уведомления", которые включают, по крайней мере, легко доступные и заметные функции, которые (1) отображают соответствующее уведомление об авторском праве и (2) объясняют пользователю, что нет никакой гарантии на это произведение (кроме тех случаев, когда гарантии явно предоставлены), что владельцы лицензий могут передавать произведение согласно Данной Лицензии, и как посмотреть копию Данной Лицензии. Если интерфейс предоставляет набор пользовательских команд или меню, то соответствующий заметный пункт удовлетворяет данным условиям. </p><h4><a id="section1"></a>1. Исходный код</h4>    <p>"Исходный код" произведения подразумевает предпочитаемую форму произведения для создания его модификаций. "Объектный код" подразумевает любую другую форму произведения. </p>    <p>"Стандартный интерфейс" означает интерфейс, который либо является официальным стандартом, установленным признанным органом по стандартизации, либо, в случае интерфейсов, специфичных для конкретного языка программирования, тот, что широко распространён среди разработчиков на данном языке. </p>    <p>"Системные библиотеки" исполнимых произведений включают в себя всё отличное от произведения как целого, (а) включающееся в стандартную поставку Главного компонента, но не являющееся его частью, и (б) служащее только для использования других произведений с Главным Компонентом, либо для предоставления Стандартного Интерфейса, который доступен общественности в форме исходного кода. "Главный Компонент" в этом контексте означает главный существенный компонент (ядро, оконная система и т.д.) конкретной операционной системы (если присутствует) на которой выполняется произведение, либо компилятор, использованный для создания произведения, либо интерпретатор объектного кода, использованный для запуска произведения. </p>    <p>"Соответствующий Исходный Код" произведения в форме объектного кода подразумевает весь исходный код, необходимый для генерации, установки, выполнения(для выполнимых произведений) объектного кода и модификации произведения, включая скрипты, контролирующие эти действия. Однако, он не содержит Системные Библиотеки произведения, утилиты общего назначения или свободно доступные программы, которые использовались в немодифицированном виде для осуществления деятельности, но не являются частью произведения. Например, Соответствующий Исходный Код включает файлы определения интерфейса, связанные с файлами исходного кода произведения, и исходный код общих библиотек и динамически связанных подпрограмм, которые необходимы по идее автора произведения, таких как прямая передача данных или контрольный поток между этими подпрограммами и другими частями произведения. </p>    <p>Соответствующий Исходный Код не обязан включать в себя что-либо, что пользователь может автоматически сгенерировать из остальных частей Соответствующего Исходного Кода. </p>    <p>Соответствующий Исходный Код произведения в форме исходного кода - то же самое произведение. </p><h4><a id="section2"></a>2. Основные свободы</h4>    <p>Все права, предоставленные Данной Лицензией предоставляются на срок авторских прав на Программу и не могут быть отозваны при условии, что установленные условия соблюдены. Данная Лицензия однозначно подтверждает Ваши неограниченные права на запуск немодифицированной Программы. Действие Данной Лицензии на вывод произведения, защищённого Данной Лицензией, распространяется только в том случае, если вывод представляет собой лицензированное произведение. Данная Лицензия признаёт Ваши права на свободное использование или его эквивалент в соответствии с законом об авторском праве. </p>    <p>Вы можете создавать, запускать и тиражировать лицензированные произведения, которые Вы не передаёте, без условий, до тех пор, пока лицензия остаётся в силе. Вы можете передать лицензированное произведение третьим лицам с единственной целью - модификацией произведения исключительно для Вас, либо для предоставления Вам возможности запуска этих произведений, при условии что Вы выполняете условия Данной Лицензии при передаче материалов, на которые не обладаете авторским правом. Третьи лица, создающие или запускающие лицензированные произведения должны делать это исключительно от Вашего имени, под Вашим контролем, на условиях запрета создания копий материалов, защищённых авторским правом, без Вашего разрешения. </p>    <p>Передача при любых других обстоятельствах разрешена исключительно при условиях, установленных ниже. Сублицензирование запрещено; секция 10 исключает необходимость в этом. </p><h4><a id="section3"></a>3. Защита Законных Прав Пользователей от Противотехнических Законов</h4><p>Ни одно из лицензированных произведений не должно считаться частью технического средства защиты согласно любому применимому закону, выполняющему обязательства, наложенные статьёй 11 соглашения авторского права Всемирной Организации Интеллектуальной Собственности (<a href="http://en.wikipedia.org/wiki/WIPO" rel="nofollow">WIPO</a>), принятой 20 декабря 1996 года, или схожим законам, запрещающим или ограничивающим обход таких средств. </p><p>При передаче Вами лицензированного произведения, Вы отказываетесь от каких-либо юридических полномочий запрещать обход технических средств, пока такой обход находится в рамках осуществления прав, выданных Данной Лицензии, в знак уважения к лицензированному произведению, и Вы отказываетесь от любых намерений ограничить работу или модификацию произведения, как средств давления, направленных на пользователей произведения, Ваши законные права и права третьих лиц запретить обход технологических средств защиты. </p><h4><a id="section4"></a>4. Передача Точных Копий</h4>    <p>Вы можете передавать точные копии исходного кода Программы так же, как и получили, на любом носителе, при условии что в заметной и соответствующей форме публикуете уведомление об авторском праве на каждой копии; сохраняете нетронутыми все уведомления, устанавливающие что Данная Лицензия и любые неразрешающие условия, добавленные в соответствии с главой 7, применимы к тексту программы; сохраняете нетронутыми все уведомления об отсутствии гарантий; предоставляете всем получателям копию Данной Лицензии вместе с Программой. </p>    <p>Вы можете установить любую цену, либо не устанавливать цену, за каждую копию, которую Вы передаёте, также Вы можете предлагать поддержку или гарантии за плату.  </p><h4><a id="section5"></a>5. Передача Версий Модифицированного исходного кода</h4>    <p>Вы можете передавать произведения, основанные на Программе, или модификации программы в форме исходного кода на условиях главы 4, также выполняя следующие условия: </p><ul>    <li>a) Произведение должно содержать заметные уведомления, утверждающие что Вы изменили код, и содержащие действительную дату изменений.</li>    <li>б) Произведение должно содержать заметные уведомления, утверждающие что оно выпущена в соответствии с Данной Лицензией и любыми дополнительными условиями, установленными в соответствии с главой 7. Данное требование изменяет требование секции 4 "оставлять нетронутыми все уведомления".</li>    <li>в) Вы должны выдать лицензии на произведение, как единое целое, в соответствии с Данной Лицензией, всем, кто захочет получить копию. Данная Лицензия распространяться со всеми применимыми условиями главы 7, на всё произведение, и каждую его часть, безотносительно того, как они поставляются. Данная Лицензия не допускает выдачи лицензий на произведение другими способами, но не запрещает этого, если Вы получили разрешение на выдачу лицензий отдельно.</li>г) Если в произведении присутствуют пользовательские интерфейсы, каждый должен отображать "Соответствующие Правовые Уведомления"; если же Программа имеет пользовательские интерфейсы, которые не отображают "Соответствующие Правовые Уведомления", Ваше произведение должно это исправить.</ul>    <p>Компиляция лицензированного произведения с другими отдельными и независимыми произведениями, которые по своей природе не являются расширениями лицензированного произведения и не соединены с ним с целью сформировать большую программу, на носителе хранения или распространения, называется "агрегацией", если компиляция и её суммарные авторские права не ограничивают доступ и юридические права пользователя компиляции относительно исходного произведения. Включение лицензированного произведения в агрегацию не распространяет действие Данной Лицензии на остальные части агрегации. </p><h4><a id="section6"></a>6. Передача не-исходных форм</h4>    <p>Вы можете передавать лицензированные произведения в форме объектного кода на условиях глав 4 и 5, в том случае если Вы также передаёте машиночитаемый Соответствующий Исходный Код на условиях Данной Лицензии, одним из следующих путей: </p><ul>    <li>а) Передаёте объектный код в (или встроенным в) физическом продукте (включая физический дистрибутивный носитель) вместе с Соответствующим Исходным Кодом, расположенным на физическом носителе, широко используемом для обмена ПО.</li>    <li>б) Передаёте объектный код в (или встроенным в) физическом продукте (включая физический дистрибутивный носитель) вместе с письменным обещанием, действительным по меньшей мере в течение трёх лет и до тех пор, пока Вы предоставляете запасные части или поддержку для данной модели продукта, предоставить любому обладателю объектного кода либо (1) копию Соответствующего Исходного Кода для всего ПО продукта, лицензированного Данной Лицензией, на физическом носителе, широко используемом для обмена ПО, по цене, не превышающей физические затраты на передачу исходного кода, либо (2) возможность скопировать Соответствующий Исходный Код с сетевого сервера без взимания платы.</li>    <li>в) Передаёте персональные копии объектного кода с копией письменного обещания предоставить Соответствующий Исходный Код. Данный способ разрешён только в редких случаях и на некоммерческой основе, только если Вы получили объектный код в такой форме, в соответствии с пунктом 6б.</li>    <li>г) Передаёте объектный код, предоставляя доступ из обозначенного места (бесплатно, либо за определённую плату) и предоставляете аналогичный доступ к Соответствующему Исходному Коду тем же путём, из того же места, без последующей оплаты. Нет необходимости предоставлять Соответствующий Исходный Код в комплекте с объектным кодом. Если местом доступа является сетевой сервер, Соответствующий Исходный Код может находиться на другом сервере (обслуживаемом Вами, либо третьими лицами), предоставляющем аналогичные возможности копирования; объектный код должен сопровождаться ясными указаниями местоположения Соответствующего Исходного Кода. Независимо от того, на каком сервере расположен Соответствующий Исходный Код, Вы обязаны убедиться в том, что он доступен столько, сколько необходимо для соответствия данным требованиям.</li>    <li>д) Передаёте объектный код, используя передачу от пользователя к пользователю (peer-to-peer), сообщая пользователям где объектный код и Соответствующий Исходный Код общедоступен без взимания платы согласно пункту 6г.</li></ul>    <p>Нет необходимости включать в передачу произведения в форме объектного кода отделимые части объектного кода, чей исходный код исключён из Соответствующего Исходного Кода как Системная Библиотека. </p>    <p>"Пользовательский Продукт" это либо (1) "потребительский товар", подразумевающий любые формы материального личного имущества, которые используются для личных, семейных или домовладельческих целей, либо (2) что-либо спроектированное или продающееся для установки дома. При определении является ли продукт потребительским товаром, случаи, вызывающие сомнения, будут решены в пользу лицензирования. Для конкретного продукта, полученного конкретным пользователем, "обычное использование" подразумевает типичное или распространённое использование такого типа продуктов, безотносительно статуса конкретного пользователя или того, как конкретный пользователь использует, или рассчитывает, или будет использовать продукт. Продукт является потребительским товаром безотносительно того, имеет ли он существенные коммерческие, промышленные или непотребительские применения до тех пор, пока такие применения не являются единственными существенными применениями продукта. </p>    <p>"Установочная Информация" Пользовательского Продукта подразумевает методы, процедуры, ключи доступа и другую информацию, необходимую для установки и запуска модифицированных версий лицензированного произведения в Пользовательском Продукте из модифицированной версий Соответствующего Исходного Кода. Информация должна быть достаточна для гарантирования того, что стандартный функционал изменённого объектного кода ни в каком случае не ограничивается или искажается из-за произведённых изменений. </p>    <p>Если Вы передаёте объектный код согласно данной главе б, или в, или исключительно для использования в Пользовательском Продукте, и передача происходит как часть сделки, в которой права владения и использования Пользовательского Продукта переходят получателю пожизненно либо на определённый срок (безотносительно того, как характеризована сделка), Соответствующий Исходный Код, передаваемый согласно данной главе должен быть сопровождён Установочной Информацией. Данное требование не действует если ни Вы, ни третьи лица не имеете возможности установить модифицированный объектный код на Пользовательский Продукт (например, произведение установлено в ROM). </p>    <p>Требование предоставления Установочной Информации не включает требование предоставления поддержки, гарантии или обновлений на произведения, которое было модифицировано либо установлено получателем, или для Пользовательского Продукта, в котором произведение модифицировано или установлено. Доступ к сети может быть запрещён, если сама модификация существенно и негативно действует на работу сети, либо нарушает правила и протоколы передачи данных в сети. </p>    <p>Предоставленные Соответствующий Исходный Код и Установочная Информация в соответствии с данной главой должны быть в открыто-документированном формате(имеющем реализацию, доступную в форме исходного кода), и не должны запрашивать пароля либо ключа для распаковки, чтения или копирования.  </p><h4><a id="section7"></a>7. Дополнительные свободы</h4>    <p>"Дополнительные свободы" - это условия, которые дополняют Данную Лицензию путём создания исключений из одного или нескольких условий. Дополнительные свободы, применимые ко всей Программе, должны быть расценены как если бы они были включены в Данную Лицензию, в случае если они действительны согласно применимому закону. Если дополнительные свободы применяются только к части Программы, эта часть может быть использована отдельно на этих условиях, но вся Программа остаётся под действием Данной лицензии без учёта дополнительных условий. </p>    <p>Когда Вы передаёте копию лицензированного произведения, Вы имеете право убрать любые дополнительные свободы из этой копии, либо из любой её части. (Дополнительные свободы могут требовать их удаления в конкретных случаях когда Вы модифицируете произведение.) Вы можете добавить дополнительные свободы к материалам, добавленным Вами в лицензированное произведение и на которые Вы имеете или можете предоставить разрешение правообладателя. </p>    <p>Несмотря на любые другие положения Данной Лицензии, на материал, добавленный Вами к лицензированному произведению, Вы можете (если разрешено держателями авторских прав на материал) дополнить условия Данной Лицензии следующими условиями: </p><ul><li>а) Отказ от гарантий или ограничения ответственности иначе, чем установлено в главах 15 и 16 данной лицензии; либо</li>    <li>б) Требование сохранения определённых действительных юридических уведомлений или авторства в материале, или в Соответствующих Правовых Уведомлениях, отображаемых произведением, их содержащим; либо</li>    <li>в) Запрет на искажение оригинального материала, либо требование к модифицированным версиям такого материала содержать пометку в надлежащей форме о том, что материал отличается от оригинальной версии; либо</li>    <li>г) Ограничение на использование, в целях публикации, имён лицензоров либо авторов материала; либо</li>    <li>д) Отказ предоставлять права согласно закону о торговых марках на использование некоторых торговых имён, торговых марок, сервисных марок; либо</li>    <li>е) Требование компенсации лицензорам и авторам материала кем либо, кто передаёт материал (или модифицированные версии материала) с договорным принятием ответственности получателем, для любой ответственности, которую данное договорное принятие непосредственно налагает на правообладателей и авторов.</li></ul>    <p>Все остальные не-разрешающие дополнительные условия считаются "дополнительными запретами", что попадает под действие главы 10. Если Программа в том виде, в котором Вы её получили, либо её часть, содержит уведомление, устанавливающее, что она защищена Данной Лицензией и при этом содержит дополнительные запреты, Вы можете удалить данные запреты. Если документ лицензии содержит дополнительные запреты, но допускает релицензирование или передачу на условиях Данной Лицензии, Вы можете добавить к лицензированному произведению материал, защищённый условиями того лицензионного документа, при условии что дополнительный запрет не сохраняется при таком релицензировании или передаче. </p>    <p>Если Вы добавляете условия в лицензированное произведение в соответствии с данной главой, Вы должны добавить в затронутые исходные файлы, утверждение о том, что дополнительные условия применяются к этим файлам, а также уведомление о том где искать данные условия. </p>    <p>Дополнительные условия, разрешающие либо неразрешающие, могут быть установлены в форме отдельной лицензии, либо установлены как исключения; требования, перечисленные Выше применяются в любом случае. </p><h4><a id="section8"></a>8. Окончание действия</h4>    <p>Вы не можете тиражировать или изменять лицензированное произведение, за исключением тех случаев когда это в прямой форме изложено в условиях Данной Лицензии. Любая попытка тиражирования или модификации произведения на иных условиях недействительна и автоматически снимает с Вас все права выданные Данной Лицензией (включая любые патенты, предоставленные лицензией согласно третьему параграфу главы 11). </p>    <p>Однако, в том случае, когда Вы прекращаете нарушение Данной Лицензии, лицензия от конкретного правообладателя восстанавливается (а) временно, до тех пор пока правообладатель явно и окончательно не окончит действие Вашей лицензии, и (б) на постоянной основе, если правообладателю не удастся уведомить Вас о нарушении с помощью надлежащих средств в срок 60 дней с момента прекращения нарушений. </p>    <p>Кроме того, Ваша лицензия от конкретного правообладателя восстанавливается на постоянной основе в случае если правообладатель уведомляет Вас о нарушении с помощью надлежащих средств, но Вы впервые получаете уведомление о нарушении Данной Лицензии (для любого произведения) от этого правообладателя и устраняете нарушение в течение 30 дней после получения уведомления. </p>    <p>Лишение Вас прав согласно данной секции не лишает прав людей, которые получили от Вас копии или права согласно Данной Лицензией. Если Ваши права приостановлены и не восстановлены на постоянной основе, Вы не можете получить новую лицензию на тот же материал согласно главе 10. </p><h4><a id="section9"></a>9. Соглашение не требуется для копирования</h4>    <p>Вы не обязаны принимать Данную Лицензию чтобы получить или запустить копию Программы. В дополнении, тиражирование лицензированного произведения, происходящее исключительно как совокупность передач от пользователя к пользователю, требуемых для получения копии также не требует соглашения. Однако, только Данная Лицензия даёт Вам права тиражирования или изменения любых лицензированных произведений. Такие действия нарушают авторское право, если Вы не приняли Данную Лицензию. Поэтому изменяя или тиражируя лицензированное произведение, Вы подтверждаете своё согласие с Данной Лицензией. </p><h4><a id="section10"></a>10. Автоматическое Лицензирование Последующих Получателей</h4>    <p>Каждый раз, когда Вы передаёте лицензированное произведение, получатель автоматически получает лицензию от первоначального лицензора на запуск, изменение и тиражирование произведения, подчинённого Данной Лицензии. Вы не ответственны за соблюдение Данной Лицензии третьими лицами. </p>    <p>"Юридическая сделка" - сделка передающая контроль организации, или практически все активы таковой, или разделение организации, или слияние организаций. Если тиражирование лицензированного произведения является результатом юридической сделки, каждая сторона сделки, получающая копию произведения также получает все лицензии на произведение, которые предшественник стороны имел или мог выдать согласно предыдущему параграфу, плюс право владения Соответствующим Исходным Кодом произведения от предшественника, если он обладал Соответствующим Исходным Кодом, либо мог получить его при соответствующем запросе. </p>    <p>Вы не можете налагать никакие дополнительные запреты на осуществление прав выданных или подтверждённых согласно Данной Лицензии. Например, Вы не можете налагать лицензионные сборы, авторский гонорар, или другие виды выплат за осуществление прав, выданных согласно Данной Лицензии, и Вы не можете инициировать судебный процесс (включая встречный иск), заявляя что любое патентное требование нарушено путём создания, использования, продажи, предложения продажи или импортирования Программы либо любой её части. </p><h4><a id="section11"></a>11. Патенты</h4>    <p>"Вкладчик" - правообладатель, разрешающий использование согласно Данной Лицензии Программы либо произведения, на котором основана Программа. Произведение, лицензированное таким образом, называется "версией вкладчика".  </p>    <p>"Основные патентные требования" вкладчика - все патентные требования которые имеет или контролирует вкладчик, либо уже приобретённые, либо намеченные для приобретения, которые будут нарушены тем или иным образом, допускающимся Данной Лицензией, включая создание, использование или продажа версии вкладчика, но исключая требования, которые будут нарушены только в форме совокупности будущих изменений версии вкладчика. В рамках данного определения, "контроль" включает в себя право выдавать патентные сублицензии в форме, следующей требованиям Данной Лицензии. </p>    <p>Каждый вкладчик выдаёт Вам неэксклюзивные, международные, свободные от отчислений патентные лицензии, согласно основным патентным требованиям вкладчика, на использование, продажу, предложение продажи, импортирование и запуск, изменение и тиражирование содержимого версии вкладчика. </p>    <p>В следующих трёх параграфах, "патентная лицензия" - любое выражение соглашения или обязательства не применять патент(например, выдача прав на использование патентованного произведения или обязательство не подавать исков за нарушение патента). "Выдать" такую патентную лицензию одной из сторон означает заключить такое соглашение или обязательство не применять патент против этой стороны. </p>    <p>Если Вы передаёте лицензированное произведение, сознательно основываясь на патентной лицензии и при этом Соответствующий Исходный Код произведения не доступен никому для копирования бесплатно и в соответствии с условиями Данной Лицензии через общедоступный сервер или другими легкодоступными методами, Вы должны либо (1) сделать так чтобы Соответствующий Исходный Код был доступен, либо (2) лишить себя патентной лицензии на данное конкретное произведение, либо (3) оговорить, соответствующим Данной Лицензии образом, расширение патентной лицензии для последующих получателей. "Сознательно основываясь" означает что Вы знаете условия патентной лицензии, но передача лицензированного произведения в стране, либо использование лицензированного произведения получателями в стране, нарушит один или более патент, который можно идентифицировать, в этой стране и который Вы имеете основания считать действительным. </p>    <p>Если в соответствии с или в связи с конкретной сделкой или соглашением Вы передаёте, тиражируете, путём наладки передачи, лицензированное произведение и предоставляете одной из сторон патентную лицензию после получения лицензированного произведения, давая им право использовать, тиражировать, модифицировать или передавать конкретную копию лицензионного произведения, в этом случае патентная лицензия, которую Вы предоставляете автоматически расширяет своё действие на всех получателей лицензированного произведения основанного на ней. </p>    <p>Патентная лицензия является "дискриминационной", если она не описывает свою сферу применения, запрещает осуществление или обусловлена неосуществлением одного или более прав, которые явно выдаются согласно Данной Лицензии. Вы не можете передавать лицензированное произведение если Вы - одна из сторон соглашения с третьей стороной, которая занимается дистрибуцией ПО, согласно которой Вы производите выплату третьему лицу в зависимости от объёма осуществляемых передач, и согласно которой третье лицо выдаёт, любой стороне, получающей лицензированное произведение от Вас, дискриминационную патентную лицензию (а) вместе с копиями лицензированного произведения, переданными Вами (или копиями, сделанными с этих копий), или (б) вместе с конкретными продуктами или сборками, содержащими лицензированное произведение, в случае если Вы не вступили в соглашение или патентная лицензия не предоставлена до 28 марта 2007г. </p>    <p>Ничто в Данной Лицензии не должно быть рассмотрено как исключение или ограничение любой подразумеваемой лицензии или других способов противодействия нарушению, которые в других случаях могут быть доступны для Вас согласно применимому патентному закону. </p><h4><a id="section12"></a>12. Не отказывать свободе других</h4>    <p>Условия, наложенные на Вас (судебным приказом, соглашением или как-либо ещё), которые противоречат условиям Данной лицензии, не освобождают Вас от условий, наложенных Данной Лицензией. Если Вы не можете передавать лицензированное произведение так, чтобы удовлетворять одновременно Вашим обязательствам согласно Данной Лицензии и любым другим релевантным обязательствам, то Вы можете не распространять её вовсе. Например, если Вы согласны с условиями, обязывающими Вас собирать авторские отчисления с тех, кому Вы передаёте Программу, за право последующей передачи, единственный способ удовлетворить этим условиям и Данной Лицензии будет полное воздержание от передачи Программы. </p><h4><a id="section13"></a>13. Использование совместно со Стандартной Общественной Лицензией редакции Афферо</h4><p>Несмотря на любые другие положения настоящей Лицензии, Вы имеете разрешение подключать или совмещать любое лицензированное произведение с произведением, лицензированным согласно версии 3 Стандартной Общественной Лицензии редакции Афферо (<a href="http://www.affero.org/oagpl.html" rel="nofollow">Affero</a>) в единое комбинированное произведение и передавать его. Условия Данной Лицензии продолжат применяться к той части произведения, которая изначально находилась под ней, но специальные требования главы 13 редакции Афферо, касающиеся взаимодействия через компьютерную сеть, будут применяться ко всему объединённому произведению. </p><h4><a id="section14"></a>14. Пересмотренные Версии Данной Лицензии</h4>    <p>Фонд Свободного Программного Обеспечения может публиковать пересмотренные и/или новые версии Стандартной Общественной Лицензии GNU время от времени. Такие пересмотренные версии будут схожи по духу нынешней версии, но могут отличаться в деталях, чтобы соответствовать новым проблемам. </p>    <p>Каждой версии выдаётся отличительный номер. Если Программа устанавливает, что конкретный номер версии GNU GPL "или любая более поздняя версия" применима к ней, Вы можете следовать условиям либо версии указанного номера, либо более поздних версий, опубликованных Фондом Свободного Программного Обеспечения. Если программа не указывает номер версии GNU GPL, Вы можете выбрать любую версию, когда либо опубликованную Фондом. </p>    <p>Если программа уточняет, что уполномоченный представитель может решать какая из будущих версий GNU GPL может быть использована, публичное заявление этого представителя о принятии версии на постоянной основе даёт Вам право выбрать эту версию для Программы. </p>    <p>Следующие версии лицензии могут давать Вам дополнительные или другие разрешения. Несмотря на это, дополнительные обязательства не возлагаются на автора или правообладателя как результат Вашего выбора следующих версий. </p><h4><a id="section15"></a>15. Отказ от гарантий</h4>    <p>НА ПРОГРАММУ НЕ РАСПРОСТРАНЯЮТСЯ НИКАКИЕ ГАРАНТИИ ДО РАМОК, ДОПУСТИМЫХ ПРИМЕНИМЫМ ЗАКОНОМ. ЕСЛИ ИНОЕ НЕ УСТАНОВЛЕНО В ПИСЬМЕННОЙ ФОРМЕ, ПРАВООБЛАДАТЕЛЬ И/ИЛИ ДРУГИЕ СТОРОНЫ ПРЕДОСТАВЛЯЮТ ПРОГРАММУ «КАК ЕСТЬ», БЕЗ КАКИХ ЛИБО ГАРАНТИЙ (ЗАЯВЛЕННЫХ ИЛИ ПОДРАЗУМЕВАЕМЫХ), ВКЛЮЧАЯ, НО НЕ ОГРАНИЧИВАЯСЬ, ПОДРАЗУМЕВАЕМЫМИ ГАРАНТИЯМИ ТОВАРНОГО СОСТОЯНИЯ ПРИ ПРОДАЖЕ И ГОДНОСТИ ДЛЯ ОПРЕДЕЛЁННОГО ПРИМЕНЕНИЯ. ВЕСЬ РИСК КАК В ОТНОШЕНИИ КАЧЕСТВА, ТАК И ПРОИЗВОДИТЕЛЬНОСТИ ПРОГРАММЫ ВЫ БЕРЁТЕ НА СЕБЯ. ЕСЛИ В ПРОГРАММЕ ОБНАРУЖЕН ДЕФЕКТ, ВЫ БЕРЁТЕ НА СЕБЯ СТОИМОСТЬ НЕОБХОДИМОГО ОБСЛУЖИВАНИЯ, ПОЧИНКИ ИЛИ ИСПРАВЛЕНИЯ. </p><h4><a id="section16"></a>16. Ограничение ответственности</h4>    <p>НИ В КОЕМ СЛУЧАЕ, ЕСЛИ НЕ ТРЕБУЕТСЯ ПРИМЕНИМЫМ ЗАКОНОМ ИЛИ ПИСЬМЕННЫМ СОГЛАШЕНИЕМ, НИ ОДИН ИЗ ПРАВООБЛАДАТЕЛЕЙ ИЛИ СТОРОН, ИЗМЕНЯВШИХ И/ИЛИ ПЕРЕДАВАВШИХ ПРОГРАММУ, КАК БЫЛО РАЗРЕШЕНО ВЫШЕ, НЕ ОТВЕТСТВЕНЕН ЗА УЩЕРБ, ВКЛЮЧАЯ ОБЩИЙ, КОНКРЕТНЫЙ, СЛУЧАЙНЫЙ ИЛИ ПОСЛЕДОВАВШИЙ УЩЕРБ, ВЫТЕКАЮЩИЙ ИЗ ИСПОЛЬЗОВАНИЯ ИЛИ НЕВОЗМОЖНОСТИ ИСПОЛЬЗОВАНИЯ ПРОГРАММЫ (ВКЛЮЧАЯ, НО НЕ ОГРАНИЧИВАЯСЬ ПОТЕРЕЙ ДАННЫХ ИЛИ НЕВЕРНОЙ ОБРАБОТКОЙ ДАННЫХ, ИЛИ ПОТЕРИ, УСТАНОВЛЕННЫЕ ВАМИ ИЛИ ТРЕТЬИМИ ЛИЦАМИ, ИЛИ НЕВОЗМОЖНОСТЬ ПРОГРАММЫ РАБОТАТЬ С ДРУГИМИ ПРОГРАММАМИ), ДАЖЕ В СЛУЧАЕ ЕСЛИ ПРАВООБЛАДАТЕЛЬ ЛИБО ДРУГАЯ СТОРОНА БЫЛА ИЗВЕЩЕНА О ВОЗМОЖНОСТИ ТАКОГО УЩЕРБА. </p><h4><a id="section17"></a>17. Интерпретация глав 15 и 16</h4>    <p>Если отказ от гарантии или ограничение ответственности представленные выше не могут быть исполнены согласно их условиям, рассматривающие суды должны применить местный закон, который наиболее приближен к абсолютному отказу от всей гражданской ответственности в связи с Программой, исключая случаи когда гарантия или принятие ответственности сопровождают копию Программы за плату. </p><h3><a name="КОНЕЦ_УСЛОВИЙ"></a>КОНЕЦ УСЛОВИЙ</h3><h4><a name="howto"></a>Как применить данные условия к Вашим Новым Программам</h4>    <p>Если Вы разрабатываете новую программу и хотите чтобы она была максимально полезна общественности, лучший способ добиться желаемого - сделать программу свободным ПО, которое каждый сможет распространять и изменять согласно данным условиям. </p>    <p>Для этого укомплектуйте программу нижеследующими уведомлениями. Безопаснее всего присоединить их к началу каждого файла исходных кодов для наиболее эффективного указания отсутствия гарантий; каждый файл должен, по крайней мере, иметь линию авторских прав и указатель на нахождение полного списка уведомлений. </p><pre>&lt;название программы и краткое описание того, что она делает&gt;Copyright (C) &lt;год&gt; &lt;имя автора&gt;Это программа является свободным программным обеспечением. Вы можете распространять и/или модифицировать её согласно условиям Стандартной Общественной Лицензии GNU, опубликованной Фондом Свободного Программного Обеспечения, версии 3 или, по Вашему желанию, любой более поздней версии.Эта программа распространяется в надежде, что она будет полезной, но БЕЗ ВСЯКИХ ГАРАНТИЙ, в том числе подразумеваемых гарантий ТОВАРНОГО СОСТОЯНИЯ ПРИ ПРОДАЖЕ и ГОДНОСТИ ДЛЯ ОПРЕДЕЛЁННОГО ПРИМЕНЕНИЯ. Смотрите Стандартную Общественную Лицензию GNU для получения дополнительной информации. Вы должны были получить копию Стандартной Общественной Лицензии GNU вместе с программой. В случае её отсутствия, посмотрите &lt;<a href="http://www.gnu.org/licenses/&gt;" rel="nofollow">http://www.gnu.org/licenses/&gt;</a>.</pre><p>Так же добавьте информацию о том, как можно связаться с вами по электронной и обычной почте. </p><p>Если программа взаимодействует с пользователем при помощи терминала, сделайте так, чтобы она выводила краткое сообщение наподобие нижеследующего при запуске в интерактивном режиме: </p><pre>&lt;название программы&gt; Copyright (C) &lt;год&gt; &lt;имя автора&gt;Это программа распространяется БЕЗ ВСЯКИХ ГАРАНТИЙ; для получения дополнительной информации наберите <tt>show w</tt>. Это свободное программное обеспечение, и Вы можете распространять её в соответствии с конкретными условиями; для получения дополнительной информации наберите <tt>show c</tt>.</pre><p>Гипотетические команды <tt>show w</tt> и <tt>show c</tt> должны показывать соответствующие части Стандартной Общественной Лицензии. Конечно, команды Вашей программы могут быть другими; в случае графического интерфейса пользователя, Вы можете использовать диалоговое окно &lt;О программе&gt;. </p><p>Так же, в случае необходимости, Вам следует получить от Вашего работодателя (если Вы работаете программистом) или учебного заведения (если учитесь) письменный отказ от авторских прав на программу. Для дополнительной информации об этом, а также о применении и исполнении условий GNU GPL, смотрите &lt;<a href="http://www.gnu.org/licenses/&gt;" rel="nofollow">http://www.gnu.org/licenses/&gt;</a>. </p><p>Стандартная Общественная Лицензия GNU не разрешает включение Вашей программы в собственническое ПО. Если Вы хотите этого, используйте Малую Стандартную Общественную Лицензию GNU (GNU Lesser General Public License, GNU LGPL) вместо этой лицензии, но, пожалуйста, прочитайте сначала &lt;<a href="http://www.gnu.org/philosophy/why-not-lgpl.html&gt;" rel="nofollow">http://www.gnu.org/philosophy/why-not-lgpl.html&gt;</a>. </p>');
INSERT INTO `ae_pagesdescriptions` (`id`, `page_id`, `language_id`, `seo_title`, `meta_description`, `meta_keywords`, `title`, `description`) VALUES
(7, 11, 1, 'Демонстрационная версия Oxidos CMS', 'Демонстрационная версия Oxidos CMS', '', 'Демонстрационная версия Oxidos CMS', '<p><strong>Уважаемые посетители</strong></p><p><strong style="line-height: 1.7em;">Демонстрационная версия: </strong><span style="line-height: 1.7em;">http://demo.oxidos.ru/</span><br></p>\n\n<p><em>Логин: demo</em></p>\n\n<p><em>Пароль: demodemo</em></p>\n\n<p><em><strong>С уважением,</strong></em></p>\n\n<p><em><strong>Команда Oxidos CMS</strong></em></p>'),
(8, 11, 2, 'Demo version Oxidos CMS', 'Demo version Oxidos CMS', '', 'Demo version Oxidos CMS', '<p><strong style="line-height: 1.7em;">Demo: </strong><span style="line-height: 1.7em;">http://demo.oxidos.ru/</span><br></p>\n\n<p><em>Login: demo</em></p>\n\n<p><em>Password: demodemo</em></p>\n\n<p><em><strong>Best regards,</strong></em></p>\n\n<p><em><strong>Team Oxidos CMS</strong></em></p>'),
(10, 12, 2, 'The GNU General Public License is a free', 'The GNU General Public License is a free, copyleft license for software and other kinds of works.  The licenses for most software and other practical works are designed to take away your freedom to share and change the works. By contrast, the GNU General', '', 'The GNU General Public License is a free', '<h3>GNU GENERAL PUBLIC LICENSE</h3>\n        <p>Version 3, 29 June 2007</p>\n        <p>Copyright © 2007 Free Software Foundation, Inc. &lt;http://fsf.org/&gt;</p>\n        <p> Everyone is permitted to copy and distribute verbatim copies          of this license document, but changing it is not allowed.</p>\n        <h3><a name="preamble"></a>Preamble</h3>\n        <p>The GNU General Public License is a free, copyleft license for          software and other kinds of works.</p>\n        <p>The licenses for most software and other practical works are designed          to take away your freedom to share and change the works.  By contrast,          the GNU General Public License is intended to guarantee your freedom to          share and change all versions of a program--to make sure it remains free          software for all its users.  We, the Free Software Foundation, use the          GNU General Public License for most of our software; it applies also to          any other work released this way by its authors.  You can apply it to          your programs, too.</p>\n        <p>When we speak of free software, we are referring to freedom, not          price.  Our General Public Licenses are designed to make sure that you          have the freedom to distribute copies of free software (and charge for          them if you wish), that you receive source code or can get it if you          want it, that you can change the software or use pieces of it in new          free programs, and that you know you can do these things.</p>\n        <p>To protect your rights, we need to prevent others from denying you          these rights or asking you to surrender the rights.  Therefore, you have          certain responsibilities if you distribute copies of the software, or if          you modify it: responsibilities to respect the freedom of others.</p>\n        <p>For example, if you distribute copies of such a program, whether          gratis or for a fee, you must pass on to the recipients the same          freedoms that you received.  You must make sure that they, too, receive          or can get the source code.  And you must show them these terms so they          know their rights.</p>\n        <p>Developers that use the GNU GPL protect your rights with two steps:          (1) assert copyright on the software, and (2) offer you this License          giving you legal permission to copy, distribute and/or modify it.</p>\n        <p>For the developers'' and authors'' protection, the GPL clearly explains          that there is no warranty for this free software.  For both users'' and          authors'' sake, the GPL requires that modified versions be marked as          changed, so that their problems will not be attributed erroneously to          authors of previous versions.</p>\n        <p>Some devices are designed to deny users access to install or run          modified versions of the software inside them, although the manufacturer          can do so.  This is fundamentally incompatible with the aim of          protecting users'' freedom to change the software.  The systematic          pattern of such abuse occurs in the area of products for individuals to          use, which is precisely where it is most unacceptable.  Therefore, we          have designed this version of the GPL to prohibit the practice for those          products.  If such problems arise substantially in other domains, we          stand ready to extend this provision to those domains in future versions          of the GPL, as needed to protect the freedom of users.</p>\n        <p>Finally, every program is threatened constantly by software patents.          States should not allow patents to restrict development and use of          software on general-purpose computers, but in those that do, we wish to          avoid the special danger that patents applied to a free program could          make it effectively proprietary.  To prevent this, the GPL assures that          patents cannot be used to render the program non-free.</p>\n        <p>The precise terms and conditions for copying, distribution and          modification follow.</p>\n        <h3><a name="terms"></a>TERMS AND CONDITIONS</h3>\n        <h4><a id="section0"></a>0. Definitions.</h4>\n        <p>“This License” refers to version 3 of the GNU General Public License.</p>\n        <p>“Copyright” also means copyright-like laws that apply to other kinds of          works, such as semiconductor masks.</p>\n        <p>“The Program” refers to any copyrightable work licensed under this          License.  Each licensee is addressed as “you”.  “Licensees” and          “recipients” may be individuals or organizations.</p>\n        <p>To “modify” a work means to copy from or adapt all or part of the work          in a fashion requiring copyright permission, other than the making of an          exact copy.  The resulting work is called a “modified version” of the          earlier work or a work “based on” the earlier work.</p>\n        <p>A “covered work” means either the unmodified Program or a work based          on the Program.</p>\n        <p>To “propagate” a work means to do anything with it that, without          permission, would make you directly or secondarily liable for          infringement under applicable copyright law, except executing it on a          computer or modifying a private copy.  Propagation includes copying,          distribution (with or without modification), making available to the          public, and in some countries other activities as well.</p>\n        <p>To “convey” a work means any kind of propagation that enables other          parties to make or receive copies.  Mere interaction with a user through          a computer network, with no transfer of a copy, is not conveying.</p>\n        <p>An interactive user interface displays “Appropriate Legal Notices”          to the extent that it includes a convenient and prominently visible          feature that (1) displays an appropriate copyright notice, and (2)          tells the user that there is no warranty for the work (except to the          extent that warranties are provided), that licensees may convey the          work under this License, and how to view a copy of this License.  If          the interface presents a list of user commands or options, such as a          menu, a prominent item in the list meets this criterion.</p>\n        <h4><a id="section1"></a>1. Source Code.</h4>\n        <p>The “source code” for a work means the preferred form of the work          for making modifications to it.  “Object code” means any non-source          form of a work.</p>\n        <p>A “Standard Interface” means an interface that either is an official          standard defined by a recognized standards body, or, in the case of          interfaces specified for a particular programming language, one that          is widely used among developers working in that language.</p>\n        <p>The “System Libraries” of an executable work include anything, other          than the work as a whole, that (a) is included in the normal form of          packaging a Major Component, but which is not part of that Major          Component, and (b) serves only to enable use of the work with that          Major Component, or to implement a Standard Interface for which an          implementation is available to the public in source code form.  A          “Major Component”, in this context, means a major essential component          (kernel, window system, and so on) of the specific operating system          (if any) on which the executable work runs, or a compiler used to          produce the work, or an object code interpreter used to run it.</p>\n        <p>The “Corresponding Source” for a work in object code form means all          the source code needed to generate, install, and (for an executable          work) run the object code and to modify the work, including scripts to          control those activities.  However, it does not include the work''s          System Libraries, or general-purpose tools or generally available free          programs which are used unmodified in performing those activities but          which are not part of the work.  For example, Corresponding Source          includes interface definition files associated with source files for          the work, and the source code for shared libraries and dynamically          linked subprograms that the work is specifically designed to require,          such as by intimate data communication or control flow between those          subprograms and other parts of the work.</p>\n        <p>The Corresponding Source need not include anything that users          can regenerate automatically from other parts of the Corresponding          Source.</p>\n        <p>The Corresponding Source for a work in source code form is that          same work.</p>\n        <h4><a id="section2"></a>2. Basic Permissions.</h4>\n        <p>All rights granted under this License are granted for the term of          copyright on the Program, and are irrevocable provided the stated          conditions are met.  This License explicitly affirms your unlimited          permission to run the unmodified Program.  The output from running a          covered work is covered by this License only if the output, given its          content, constitutes a covered work.  This License acknowledges your          rights of fair use or other equivalent, as provided by copyright law.</p>\n        <p>You may make, run and propagate covered works that you do not          convey, without conditions so long as your license otherwise remains          in force.  You may convey covered works to others for the sole purpose          of having them make modifications exclusively for you, or provide you          with facilities for running those works, provided that you comply with          the terms of this License in conveying all material for which you do          not control copyright.  Those thus making or running the covered works          for you must do so exclusively on your behalf, under your direction          and control, on terms that prohibit them from making any copies of          your copyrighted material outside their relationship with you.</p>\n        <p>Conveying under any other circumstances is permitted solely under          the conditions stated below.  Sublicensing is not allowed; section 10          makes it unnecessary.</p>\n        <h4><a id="section3"></a>3. Protecting Users'' Legal Rights From Anti-Circumvention Law.</h4>\n        <p>No covered work shall be deemed part of an effective technological          measure under any applicable law fulfilling obligations under article          11 of the WIPO copyright treaty adopted on 20 December 1996, or          similar laws prohibiting or restricting circumvention of such          measures.</p>\n        <p>When you convey a covered work, you waive any legal power to forbid          circumvention of technological measures to the extent such circumvention          is effected by exercising rights under this License with respect to          the covered work, and you disclaim any intention to limit operation or          modification of the work as a means of enforcing, against the work''s          users, your or third parties'' legal rights to forbid circumvention of          technological measures.</p>\n        <h4><a id="section4"></a>4. Conveying Verbatim Copies.</h4>\n        <p>You may convey verbatim copies of the Program''s source code as you          receive it, in any medium, provided that you conspicuously and          appropriately publish on each copy an appropriate copyright notice;          keep intact all notices stating that this License and any          non-permissive terms added in accord with section 7 apply to the code;          keep intact all notices of the absence of any warranty; and give all          recipients a copy of this License along with the Program.</p>\n        <p>You may charge any price or no price for each copy that you convey,          and you may offer support or warranty protection for a fee.</p>\n        <h4><a id="section5"></a>5. Conveying Modified Source Versions.</h4>\n        <p>You may convey a work based on the Program, or the modifications to          produce it from the Program, in the form of source code under the          terms of section 4, provided that you also meet all of these conditions:</p>\n        <ul>\n          <li>a) The work must carry prominent notices stating that you modified            it, and giving a relevant date.</li>\n          <li>b) The work must carry prominent notices stating that it is            released under this License and any conditions added under section            7.  This requirement modifies the requirement in section 4 to            “keep intact all notices”.</li>\n          <li>c) You must license the entire work, as a whole, under this            License to anyone who comes into possession of a copy.  This            License will therefore apply, along with any applicable section 7            additional terms, to the whole of the work, and all its parts,            regardless of how they are packaged.  This License gives no            permission to license the work in any other way, but it does not            invalidate such permission if you have separately received it.</li>\n          <li>d) If the work has interactive user interfaces, each must display            Appropriate Legal Notices; however, if the Program has interactive            interfaces that do not display Appropriate Legal Notices, your            work need not make them do so.</li>\n        </ul>\n        <p>A compilation of a covered work with other separate and independent          works, which are not by their nature extensions of the covered work,          and which are not combined with it such as to form a larger program,          in or on a volume of a storage or distribution medium, is called an          “aggregate” if the compilation and its resulting copyright are not          used to limit the access or legal rights of the compilation''s users          beyond what the individual works permit.  Inclusion of a covered work          in an aggregate does not cause this License to apply to the other          parts of the aggregate.</p>\n        <h4><a id="section6"></a>6. Conveying Non-Source Forms.</h4>\n        <p>You may convey a covered work in object code form under the terms          of sections 4 and 5, provided that you also convey the          machine-readable Corresponding Source under the terms of this License,          in one of these ways:</p>\n        <ul>\n          <li>a) Convey the object code in, or embodied in, a physical product            (including a physical distribution medium), accompanied by the            Corresponding Source fixed on a durable physical medium            customarily used for software interchange.</li>\n          <li>b) Convey the object code in, or embodied in, a physical product            (including a physical distribution medium), accompanied by a            written offer, valid for at least three years and valid for as            long as you offer spare parts or customer support for that product            model, to give anyone who possesses the object code either (1) a            copy of the Corresponding Source for all the software in the            product that is covered by this License, on a durable physical            medium customarily used for software interchange, for a price no            more than your reasonable cost of physically performing this            conveying of source, or (2) access to copy the            Corresponding Source from a network server at no charge.</li>\n          <li>c) Convey individual copies of the object code with a copy of the            written offer to provide the Corresponding Source.  This            alternative is allowed only occasionally and noncommercially, and            only if you received the object code with such an offer, in accord            with subsection 6b.</li>\n          <li>d) Convey the object code by offering access from a designated            place (gratis or for a charge), and offer equivalent access to the            Corresponding Source in the same way through the same place at no            further charge.  You need not require recipients to copy the            Corresponding Source along with the object code.  If the place to            copy the object code is a network server, the Corresponding Source            may be on a different server (operated by you or a third party)            that supports equivalent copying facilities, provided you maintain            clear directions next to the object code saying where to find the            Corresponding Source.  Regardless of what server hosts the            Corresponding Source, you remain obligated to ensure that it is            available for as long as needed to satisfy these requirements.</li>\n          <li>e) Convey the object code using peer-to-peer transmission, provided            you inform other peers where the object code and Corresponding            Source of the work are being offered to the general public at no            charge under subsection 6d.</li>\n        </ul>\n        <p>A separable portion of the object code, whose source code is excluded          from the Corresponding Source as a System Library, need not be          included in conveying the object code work.</p>\n        <p>A “User Product” is either (1) a “consumer product”, which means any          tangible personal property which is normally used for personal, family,          or household purposes, or (2) anything designed or sold for incorporation          into a dwelling.  In determining whether a product is a consumer product,          doubtful cases shall be resolved in favor of coverage.  For a particular          product received by a particular user, “normally used” refers to a          typical or common use of that class of product, regardless of the status          of the particular user or of the way in which the particular user          actually uses, or expects or is expected to use, the product.  A product          is a consumer product regardless of whether the product has substantial          commercial, industrial or non-consumer uses, unless such uses represent          the only significant mode of use of the product.</p>\n        <p>“Installation Information” for a User Product means any methods,          procedures, authorization keys, or other information required to install          and execute modified versions of a covered work in that User Product from          a modified version of its Corresponding Source.  The information must          suffice to ensure that the continued functioning of the modified object          code is in no case prevented or interfered with solely because          modification has been made.</p>\n        <p>If you convey an object code work under this section in, or with, or          specifically for use in, a User Product, and the conveying occurs as          part of a transaction in which the right of possession and use of the          User Product is transferred to the recipient in perpetuity or for a          fixed term (regardless of how the transaction is characterized), the          Corresponding Source conveyed under this section must be accompanied          by the Installation Information.  But this requirement does not apply          if neither you nor any third party retains the ability to install          modified object code on the User Product (for example, the work has          been installed in ROM).</p>\n        <p>The requirement to provide Installation Information does not include a          requirement to continue to provide support service, warranty, or updates          for a work that has been modified or installed by the recipient, or for          the User Product in which it has been modified or installed.  Access to a          network may be denied when the modification itself materially and          adversely affects the operation of the network or violates the rules and          protocols for communication across the network.</p>\n        <p>Corresponding Source conveyed, and Installation Information provided,          in accord with this section must be in a format that is publicly          documented (and with an implementation available to the public in          source code form), and must require no special password or key for          unpacking, reading or copying.</p>\n        <h4><a id="section7"></a>7. Additional Terms.</h4>\n        <p>“Additional permissions” are terms that supplement the terms of this          License by making exceptions from one or more of its conditions.          Additional permissions that are applicable to the entire Program shall          be treated as though they were included in this License, to the extent          that they are valid under applicable law.  If additional permissions          apply only to part of the Program, that part may be used separately          under those permissions, but the entire Program remains governed by          this License without regard to the additional permissions.</p>\n        <p>When you convey a copy of a covered work, you may at your option          remove any additional permissions from that copy, or from any part of          it.  (Additional permissions may be written to require their own          removal in certain cases when you modify the work.)  You may place          additional permissions on material, added by you to a covered work,          for which you have or can give appropriate copyright permission.</p>\n        <p>Notwithstanding any other provision of this License, for material you          add to a covered work, you may (if authorized by the copyright holders of          that material) supplement the terms of this License with terms:</p>\n        <ul>\n          <li>a) Disclaiming warranty or limiting liability differently from the            terms of sections 15 and 16 of this License; or</li>\n          <li>b) Requiring preservation of specified reasonable legal notices or            author attributions in that material or in the Appropriate Legal            Notices displayed by works containing it; or</li>\n          <li>c) Prohibiting misrepresentation of the origin of that material, or            requiring that modified versions of such material be marked in            reasonable ways as different from the original version; or</li>\n          <li>d) Limiting the use for publicity purposes of names of licensors or            authors of the material; or</li>\n          <li>e) Declining to grant rights under trademark law for use of some            trade names, trademarks, or service marks; or</li>\n          <li>f) Requiring indemnification of licensors and authors of that            material by anyone who conveys the material (or modified versions of            it) with contractual assumptions of liability to the recipient, for            any liability that these contractual assumptions directly impose on            those licensors and authors.</li>\n        </ul>\n        <p>All other non-permissive additional terms are considered “further          restrictions” within the meaning of section 10.  If the Program as you          received it, or any part of it, contains a notice stating that it is          governed by this License along with a term that is a further          restriction, you may remove that term.  If a license document contains          a further restriction but permits relicensing or conveying under this          License, you may add to a covered work material governed by the terms          of that license document, provided that the further restriction does          not survive such relicensing or conveying.</p>\n        <p>If you add terms to a covered work in accord with this section, you          must place, in the relevant source files, a statement of the          additional terms that apply to those files, or a notice indicating          where to find the applicable terms.</p>\n        <p>Additional terms, permissive or non-permissive, may be stated in the          form of a separately written license, or stated as exceptions;          the above requirements apply either way.</p>\n        <h4><a id="section8"></a>8. Termination.</h4>\n        <p>You may not propagate or modify a covered work except as expressly          provided under this License.  Any attempt otherwise to propagate or          modify it is void, and will automatically terminate your rights under          this License (including any patent licenses granted under the third          paragraph of section 11).</p>\n        <p>However, if you cease all violation of this License, then your          license from a particular copyright holder is reinstated (a)          provisionally, unless and until the copyright holder explicitly and          finally terminates your license, and (b) permanently, if the copyright          holder fails to notify you of the violation by some reasonable means          prior to 60 days after the cessation.</p>\n        <p>Moreover, your license from a particular copyright holder is          reinstated permanently if the copyright holder notifies you of the          violation by some reasonable means, this is the first time you have          received notice of violation of this License (for any work) from that          copyright holder, and you cure the violation prior to 30 days after          your receipt of the notice.</p>\n        <p>Termination of your rights under this section does not terminate the          licenses of parties who have received copies or rights from you under          this License.  If your rights have been terminated and not permanently          reinstated, you do not qualify to receive new licenses for the same          material under section 10.</p>\n        <h4><a id="section9"></a>9. Acceptance Not Required for Having Copies.</h4>\n        <p>You are not required to accept this License in order to receive or          run a copy of the Program.  Ancillary propagation of a covered work          occurring solely as a consequence of using peer-to-peer transmission          to receive a copy likewise does not require acceptance.  However,          nothing other than this License grants you permission to propagate or          modify any covered work.  These actions infringe copyright if you do          not accept this License.  Therefore, by modifying or propagating a          covered work, you indicate your acceptance of this License to do so.</p>\n        <h4><a id="section10"></a>10. Automatic Licensing of Downstream Recipients.</h4>\n        <p>Each time you convey a covered work, the recipient automatically          receives a license from the original licensors, to run, modify and          propagate that work, subject to this License.  You are not responsible          for enforcing compliance by third parties with this License.</p>\n        <p>An “entity transaction” is a transaction transferring control of an          organization, or substantially all assets of one, or subdividing an          organization, or merging organizations.  If propagation of a covered          work results from an entity transaction, each party to that          transaction who receives a copy of the work also receives whatever          licenses to the work the party''s predecessor in interest had or could          give under the previous paragraph, plus a right to possession of the          Corresponding Source of the work from the predecessor in interest, if          the predecessor has it or can get it with reasonable efforts.</p>\n        <p>You may not impose any further restrictions on the exercise of the          rights granted or affirmed under this License.  For example, you may          not impose a license fee, royalty, or other charge for exercise of          rights granted under this License, and you may not initiate litigation          (including a cross-claim or counterclaim in a lawsuit) alleging that          any patent claim is infringed by making, using, selling, offering for          sale, or importing the Program or any portion of it.</p>\n        <h4><a id="section11"></a>11. Patents.</h4>\n        <p>A “contributor” is a copyright holder who authorizes use under this          License of the Program or a work on which the Program is based.  The          work thus licensed is called the contributor''s “contributor version”.</p>\n        <p>A contributor''s “essential patent claims” are all patent claims          owned or controlled by the contributor, whether already acquired or          hereafter acquired, that would be infringed by some manner, permitted          by this License, of making, using, or selling its contributor version,          but do not include claims that would be infringed only as a          consequence of further modification of the contributor version.  For          purposes of this definition, “control” includes the right to grant          patent sublicenses in a manner consistent with the requirements of          this License.</p>\n        <p>Each contributor grants you a non-exclusive, worldwide, royalty-free          patent license under the contributor''s essential patent claims, to          make, use, sell, offer for sale, import and otherwise run, modify and          propagate the contents of its contributor version.</p>\n        <p>In the following three paragraphs, a “patent license” is any express          agreement or commitment, however denominated, not to enforce a patent          (such as an express permission to practice a patent or covenant not to          sue for patent infringement).  To “grant” such a patent license to a          party means to make such an agreement or commitment not to enforce a          patent against the party.</p>\n        <p>If you convey a covered work, knowingly relying on a patent license,          and the Corresponding Source of the work is not available for anyone          to copy, free of charge and under the terms of this License, through a          publicly available network server or other readily accessible means,          then you must either (1) cause the Corresponding Source to be so          available, or (2) arrange to deprive yourself of the benefit of the          patent license for this particular work, or (3) arrange, in a manner          consistent with the requirements of this License, to extend the patent          license to downstream recipients.  “Knowingly relying” means you have          actual knowledge that, but for the patent license, your conveying the          covered work in a country, or your recipient''s use of the covered work          in a country, would infringe one or more identifiable patents in that          country that you have reason to believe are valid.</p>\n        <p>If, pursuant to or in connection with a single transaction or          arrangement, you convey, or propagate by procuring conveyance of, a          covered work, and grant a patent license to some of the parties          receiving the covered work authorizing them to use, propagate, modify          or convey a specific copy of the covered work, then the patent license          you grant is automatically extended to all recipients of the covered          work and works based on it.</p>\n        <p>A patent license is “discriminatory” if it does not include within          the scope of its coverage, prohibits the exercise of, or is          conditioned on the non-exercise of one or more of the rights that are          specifically granted under this License.  You may not convey a covered          work if you are a party to an arrangement with a third party that is          in the business of distributing software, under which you make payment          to the third party based on the extent of your activity of conveying          the work, and under which the third party grants, to any of the          parties who would receive the covered work from you, a discriminatory          patent license (a) in connection with copies of the covered work          conveyed by you (or copies made from those copies), or (b) primarily          for and in connection with specific products or compilations that          contain the covered work, unless you entered into that arrangement,          or that patent license was granted, prior to 28 March 2007.</p>\n        <p>Nothing in this License shall be construed as excluding or limiting          any implied license or other defenses to infringement that may          otherwise be available to you under applicable patent law.</p>\n        <h4><a id="section12"></a>12. No Surrender of Others'' Freedom.</h4>\n        <p>If conditions are imposed on you (whether by court order, agreement or          otherwise) that contradict the conditions of this License, they do not          excuse you from the conditions of this License.  If you cannot convey a          covered work so as to satisfy simultaneously your obligations under this          License and any other pertinent obligations, then as a consequence you may          not convey it at all.  For example, if you agree to terms that obligate you          to collect a royalty for further conveying from those to whom you convey          the Program, the only way you could satisfy both those terms and this          License would be to refrain entirely from conveying the Program.</p>\n        <h4><a id="section13"></a>13. Use with the GNU Affero General Public License.</h4>\n        <p>Notwithstanding any other provision of this License, you have          permission to link or combine any covered work with a work licensed          under version 3 of the GNU Affero General Public License into a single          combined work, and to convey the resulting work.  The terms of this          License will continue to apply to the part which is the covered work,          but the special requirements of the GNU Affero General Public License,          section 13, concerning interaction through a network will apply to the          combination as such.</p>\n        <h4><a id="section14"></a>14. Revised Versions of this License.</h4>\n        <p>The Free Software Foundation may publish revised and/or new versions of          the GNU General Public License from time to time.  Such new versions will          be similar in spirit to the present version, but may differ in detail to          address new problems or concerns.</p>\n        <p>Each version is given a distinguishing version number.  If the          Program specifies that a certain numbered version of the GNU General          Public License “or any later version” applies to it, you have the          option of following the terms and conditions either of that numbered          version or of any later version published by the Free Software          Foundation.  If the Program does not specify a version number of the          GNU General Public License, you may choose any version ever published          by the Free Software Foundation.</p>\n        <p>If the Program specifies that a proxy can decide which future          versions of the GNU General Public License can be used, that proxy''s          public statement of acceptance of a version permanently authorizes you          to choose that version for the Program.</p>\n        <p>Later license versions may give you additional or different          permissions.  However, no additional obligations are imposed on any          author or copyright holder as a result of your choosing to follow a          later version.</p>\n        <h4><a id="section15"></a>15. Disclaimer of Warranty.</h4>\n        <p>THERE IS NO WARRANTY FOR THE PROGRAM, TO THE EXTENT PERMITTED BY          APPLICABLE LAW.  EXCEPT WHEN OTHERWISE STATED IN WRITING THE COPYRIGHT          HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM “AS IS” WITHOUT WARRANTY          OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT LIMITED TO,          THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR          PURPOSE.  THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE PROGRAM          IS WITH YOU.  SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF          ALL NECESSARY SERVICING, REPAIR OR CORRECTION.</p>\n        <h4><a id="section16"></a>16. Limitation of Liability.</h4>\n        <p>IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING          WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MODIFIES AND/OR CONVEYS          THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES, INCLUDING ANY          GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE          USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED TO LOSS OF          DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY YOU OR THIRD          PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER PROGRAMS),          EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF          SUCH DAMAGES.</p>\n        <h4><a id="section17"></a>17. Interpretation of Sections 15 and 16.</h4>\n        <p>If the disclaimer of warranty and limitation of liability provided          above cannot be given local legal effect according to their terms,          reviewing courts shall apply local law that most closely approximates          an absolute waiver of all civil liability in connection with the          Program, unless a warranty or assumption of liability accompanies a          copy of the Program in return for a fee.</p>\n        <p>END OF TERMS AND CONDITIONS</p>\n        <h3><a name="howto"></a>How to Apply These Terms to Your New Programs</h3>\n        <p>If you develop a new program, and you want it to be of the greatest          possible use to the public, the best way to achieve this is to make it          free software which everyone can redistribute and change under these terms.</p>\n        <p>To do so, attach the following notices to the program.  It is safest          to attach them to the start of each source file to most effectively          state the exclusion of warranty; and each file should have at least          the “copyright” line and a pointer to where the full notice is found.</p>\n        <pre>&lt;one line to give the program''s name and a brief idea of what it does.&gt;    Copyright (C) &lt;year&gt;  &lt;name of author&gt;    This program is free software: you can redistribute it and/or modify    it under the terms of the GNU General Public License as published by    the Free Software Foundation, either version 3 of the License, or    (at your option) any later version.    This program is distributed in the hope that it will be useful,    but WITHOUT ANY WARRANTY; without even the implied warranty of    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    GNU General Public License for more details.    You should have received a copy of the GNU General Public License    along with this program.  If not, see &lt;http://www.gnu.org/licenses/&gt;.</pre>\n        <p>Also add information on how to contact you by electronic and paper mail.</p>\n        <p>If the program does terminal interaction, make it output a short          notice like this when it starts in an interactive mode:</p>\n        <pre>&lt;program&gt;  Copyright (C) &lt;year&gt;  &lt;name of author&gt;    This program comes with ABSOLUTELY NO WARRANTY; for details type `show w''.    This is free software, and you are welcome to redistribute it    under certain conditions; type `show c'' for details.</pre>\n        <p>The hypothetical commands `show w'' and `show c'' should show the appropriate          parts of the General Public License.  Of course, your program''s commands          might be different; for a GUI interface, you would use an “about box”.</p>\n        <p>You should also get your employer (if you work as a programmer) or school,          if any, to sign a “copyright disclaimer” for the program, if necessary.          For more information on this, and how to apply and follow the GNU GPL, see          &lt;http://www.gnu.org/licenses/&gt;.</p>\n        <p>The GNU General Public License does not permit incorporating your program          into proprietary programs.  If your program is a subroutine library, you          may consider it more useful to permit linking proprietary applications with          the library.  If this is what you want to do, use the GNU Lesser General          Public License instead of this License.  But first, please read          &lt;http://www.gnu.org/philosophy/why-not-lgpl.html&gt;.</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--
DROP TABLE IF EXISTS `ae_roles`;
CREATE TABLE `ae_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `ae_roles` (`id`, `name`, `description`, `permission`) VALUES
(1, 'user', 'user', 'N;'),
(2, 'admin', 'admin', 'a:2:{s:6:"access";a:24:{i:0;s:13:"Admin/Adverts";i:1;s:14:"Admin/Articles";i:2;s:16:"Admin/Categories";i:3;s:14:"Admin/Comments";i:4;s:11:"Admin/Image";i:5;s:15:"Admin/Languages";i:6;s:13:"Admin/Layouts";i:7;s:10:"Admin/Logs";i:8;s:10:"Admin/Main";i:9;s:10:"Admin/Menu";i:10;s:10:"Admin/News";i:11;s:11:"Admin/Pages";i:12;s:11:"Admin/Roles";i:13;s:14:"Admin/Settings";i:14;s:16:"Admin/Subscribes";i:15;s:11:"Admin/Users";i:16;s:22:"Admin/Widgets/Waccount";i:17;s:23:"Admin/Widgets/Wcategory";i:18;s:19:"Admin/Widgets/Whtml";i:19;s:19:"Admin/Widgets/Wnews";i:20;s:21:"Admin/Widgets/Wslider";i:21;s:17:"Admin/Widgets/Wvk";i:22;s:16:"Admin/Feeds/Frss";i:23;s:20:"Admin/Feeds/Fsitemap";}s:6:"modify";a:24:{i:0;s:13:"Admin/Adverts";i:1;s:14:"Admin/Articles";i:2;s:16:"Admin/Categories";i:3;s:14:"Admin/Comments";i:4;s:11:"Admin/Image";i:5;s:15:"Admin/Languages";i:6;s:13:"Admin/Layouts";i:7;s:10:"Admin/Logs";i:8;s:10:"Admin/Main";i:9;s:10:"Admin/Menu";i:10;s:10:"Admin/News";i:11;s:11:"Admin/Pages";i:12;s:11:"Admin/Roles";i:13;s:14:"Admin/Settings";i:14;s:16:"Admin/Subscribes";i:15;s:11:"Admin/Users";i:16;s:22:"Admin/Widgets/Waccount";i:17;s:23:"Admin/Widgets/Wcategory";i:18;s:19:"Admin/Widgets/Whtml";i:19;s:19:"Admin/Widgets/Wnews";i:20;s:21:"Admin/Widgets/Wslider";i:21;s:17:"Admin/Widgets/Wvk";i:22;s:16:"Admin/Feeds/Frss";i:23;s:20:"Admin/Feeds/Fsitemap";}}'),
(6, 'demo', 'demo', 'a:1:{s:6:"access";a:24:{i:0;s:13:"Admin/Adverts";i:1;s:14:"Admin/Articles";i:2;s:16:"Admin/Categories";i:3;s:14:"Admin/Comments";i:4;s:11:"Admin/Image";i:5;s:15:"Admin/Languages";i:6;s:13:"Admin/Layouts";i:7;s:10:"Admin/Logs";i:8;s:10:"Admin/Main";i:9;s:10:"Admin/Menu";i:10;s:10:"Admin/News";i:11;s:11:"Admin/Pages";i:12;s:11:"Admin/Roles";i:13;s:14:"Admin/Settings";i:14;s:16:"Admin/Subscribes";i:15;s:11:"Admin/Users";i:16;s:22:"Admin/Widgets/Waccount";i:17;s:23:"Admin/Widgets/Wcategory";i:18;s:19:"Admin/Widgets/Whtml";i:19;s:19:"Admin/Widgets/Wnews";i:20;s:21:"Admin/Widgets/Wslider";i:21;s:17:"Admin/Widgets/Wvk";i:22;s:16:"Admin/Feeds/Frss";i:23;s:20:"Admin/Feeds/Fsitemap";}}');

-- --------------------------------------------------------

--
-- Структура таблицы `roles_users`
--
DROP TABLE IF EXISTS `ae_roles_users`;
CREATE TABLE `ae_roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `roles_users`
--

INSERT INTO `ae_roles_users` (`user_id`, `role_id`) VALUES
(1, 2);


-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--
DROP TABLE IF EXISTS `ae_settings`;
CREATE TABLE `ae_settings` (
  `group_name` varchar(128) NOT NULL DEFAULT 'config',
  `config_key` varchar(128) NOT NULL,
  `config_value` text NOT NULL,
  PRIMARY KEY (`group_name`,`config_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `ae_settings` (`group_name`, `config_key`, `config_value`) VALUES
('config', 'company_director', 's:38:"Иванов Иван Иванович";'),
('config', 'company_email', 's:15:"admin@yandex.ru";'),
('config', 'company_name', 's:15:"Мой сайт";'),
('config', 'meta_keywords', 's:0:"";'),
('config', 'meta_description', 's:15:"Мой сайт";'),
('config', 'title', 's:15:"Мой сайт";'),
('config', 'site_description', 's:15:"Мой сайт";'),
('config', 'site_name', 's:15:"Мой сайт";'),
('config', 'company_address', 's:6:"Russia";'),
('config', 'company_phone', 's:16:"+7-999-999-99-99";'),
('config', 'company_fax', 's:0:"";'),
('config', 'admin_language_id', 's:1:"1";'),
('config', 'index_language_id', 's:1:"1";'),
('config', 'admin_language_folder', 's:2:"ru";'),
('config', 'index_language_folder', 's:2:"ru";'),
('config', 'hash_key', 's:9:"4ebf028ad";'),
('config', 'maintenance', 's:1:"0";'),
('config', 'salt', 's:32:"b9ce648a8cf33572cc8e98f1fae0c5b4";'),
('config', 'session', 's:6:"native";'),
('config', 'cache', 's:4:"file";'),
('config', 'google', 's:0:"";'),
('config', 'mail_protocol', 's:6:"native";'),
('config', 'smtp_host', 's:0:"";'),
('config', 'smtp_login', 's:0:"";'),
('config', 'smtp_password', 's:0:"";'),
('config', 'smtp_port', 's:2:"25";'),
('config', 'smtp_timeout', 's:2:"30";'),
('config', 'mail_registration', 's:1:"1";'),
('config', 'optional_address', 's:0:"";'),
('config', 'google_login', 's:0:"";'),
('config', 'google_password', 's:0:"";'),
('config', 'google_report_id', 's:0:"";'),
('config', 'logo', 's:13:"data/logo.png";'),
('config', 'newsletter', 's:1:"9";'),
('config', 'company_description', 's:15:"Мой сайт";'),
('config', 'company_code', 's:0:"";'),
('config', 'icon', 's:16:"data/favicon.png";'),
('config', 'image_category', 's:3:"250";'),
('config', 'image_article', 's:3:"200";'),
('config', 'image_news', 's:3:"100";'),
('config', 'image_search', 's:3:"200";'),
('config', 'image_popup', 's:3:"500";'),
('config', 'limit_article', 's:2:"50";'),
('config', 'count_article', 's:1:"5";'),
('config', 'limit_new', 's:3:"100";'),
('config', 'count_new', 's:1:"5";'),
('config', 'count_comment', 's:1:"5";'),
('config', 'mode_comment', 's:1:"1";'),
('config', 'maintenance_info', 's:266:"Сайт находится на текущей реконструкции, после завершения всех работ сайт будет открыт.\n\nПриносим вам свои извинения за доставленные неудобства.";'),
('config', 'user_role', 's:1:"1";'),
('config', 'admin_role', 's:1:"2";'),
('config', 'cache_compression', 's:1:"1";'),
('config', 'cache_time', 's:4:"3600";'),
('config', 'limit_search', 's:3:"100";'),
('config', 'cache_host', 's:9:"localhost";'),
('config', 'cache_port', 's:5:"11211";'),
('config', 'count_search', 's:1:"5";'),
('config', 'statistic', 's:36:"/VrPn2hgzpY+UG35x5Kz8l2xyenRSx0Y7Jg=";'),
('config', 'template_index', 's:5:"green";'),
('config', 'template_admin', 's:8:"admgreen";'),
('config', 'comment_moderation', 's:1:"0";'),
('config', 'comment_guest', 's:1:"1";');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
DROP TABLE IF EXISTS `ae_users`;
CREATE TABLE `ae_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `skype` varchar(20) NOT NULL DEFAULT '',
  `icq` varchar(20) NOT NULL DEFAULT '',
  `username` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `code` varchar(40) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `ip` varchar(16) NOT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  `ava` varchar(30) NOT NULL DEFAULT '',
  `status` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`),
  KEY `first_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `ae_users` (`id`, `email`, `phone`, `skype`, `icq`, `username`, `name`, `password`, `code`, `logins`, `last_login`, `ip`, `newsletter`, `info`, `ava`, `status`) VALUES
(1, 'admin@yandex.ru', '', '', '', 'admin', 'admin', 'ffa30b7172cd186223d3371424a7b61679f0b7f3080bc491e8a943d82f263f3e', '', 66, '2015-01-02 16:27:09', '127.0.0.1', 0, '', 'data/ava/admin.jpg', 1);


-- --------------------------------------------------------

--
-- Структура таблицы `user_tokens`
--
DROP TABLE IF EXISTS `ae_user_tokens`;
CREATE TABLE `ae_user_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `type` varchar(100) NOT NULL,
  `created` int(10) unsigned NOT NULL,
  `expires` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ;

--
-- Дамп данных таблицы `user_tokens`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
