-- phpMyAdmin SQL Dump
-- version 4.0.10.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 30 2015 г., 15:23
-- Версия сервера: 5.5.45
-- Версия PHP: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `chinavasionparse_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cv_categories`
--

CREATE TABLE IF NOT EXISTS `cv_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `parentname` varchar(300) NOT NULL,
  `img` varchar(300) NOT NULL,
  `url` text NOT NULL,
  `total` int(11) unsigned NOT NULL,
  `parce_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='list of chinavasion categories' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_newproducts`
--

CREATE TABLE IF NOT EXISTS `cv_newproducts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `link` text NOT NULL,
  `sku` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='chinavasion new products' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_products`
--

CREATE TABLE IF NOT EXISTS `cv_products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `model_code` varchar(50) NOT NULL,
  `ean` varchar(100) NOT NULL,
  `full_product_name` varchar(350) NOT NULL,
  `short_product_name` varchar(150) NOT NULL,
  `product_url` text NOT NULL,
  `main_picture` varchar(500) NOT NULL,
  `category_name` varchar(300) NOT NULL,
  `subcategory_name` varchar(300) NOT NULL,
  `price` varchar(10) NOT NULL,
  `retail_price` varchar(10) NOT NULL,
  `meta_keyword` varchar(300) NOT NULL,
  `meta_description` varchar(300) NOT NULL,
  `overview` text NOT NULL,
  `specification` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `continuity` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='chinavasion products' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_products_imgs`
--

CREATE TABLE IF NOT EXISTS `cv_products_imgs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) unsigned NOT NULL,
  `img` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='chinavasion products additional images' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `loginout`
--

CREATE TABLE IF NOT EXISTS `loginout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `loginout`
--

INSERT INTO `loginout` (`id`, `email`, `pwd`) VALUES
(1, 'admin@admin.com', '5ca78ed6885116ce87181e78f01d19b7');

-- --------------------------------------------------------

--
-- Структура таблицы `oc_products`
--

CREATE TABLE IF NOT EXISTS `oc_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sku` varchar(30) NOT NULL,
  `quantity` int(1) unsigned NOT NULL,
  `price` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='opencart products' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sitemap`
--

CREATE TABLE IF NOT EXISTS `sitemap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(300) NOT NULL,
  `datetime` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
