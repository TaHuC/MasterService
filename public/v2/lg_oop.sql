-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 20 май 2016 в 22:49
-- Версия на сървъра: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lg_oop`
--

-- --------------------------------------------------------

--
-- Структура на таблица `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(30) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `brand`
--

INSERT INTO `brand` (`id`, `brand`, `type`) VALUES
(1, 'Samsung', 1),
(2, 'Iphone', 1),
(3, 'Test', 1),
(4, 'Alcatel', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `joined` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `clients`
--

INSERT INTO `clients` (`id`, `name`, `last_name`, `email`, `phone`, `joined`) VALUES
(1, 'Test', 'Test', 'test@test.com', '089547663298', '2016-05-12 23:05:33'),
(2, 'Bla', 'Bla', 'blabla@bla.com', '76239384093', '2016-05-13 17:05:59');

-- --------------------------------------------------------

--
-- Структура на таблица `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `EIK` int(11) NOT NULL,
  `city` varchar(20) NOT NULL,
  `street` varchar(30) NOT NULL,
  `n_street` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `mol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL,
  `nominal` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `modelId` int(11) NOT NULL,
  `serial` varchar(50) NOT NULL,
  `clientId` int(11) NOT NULL,
  `vrSerial` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `device`
--

INSERT INTO `device` (`id`, `modelId`, `serial`, `clientId`, `vrSerial`) VALUES
(1, 2, '4RF45F45F445', 1, 0),
(2, 5, '3267554768237852897', 2, 0),
(3, 6, 'JHSDFHJSDKK', 2, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `groups`
--

INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES
(1, 'Standard user', '{"check":1}'),
(100, 'Administrator', '{"admin":1}'),
(101, 'Prodavach', '{"all_orders":1 , "addDv":1 , "addCl":1 , "finalPer":1 }'),
(103, 'Test', '{"all_orders":1 , "addDv":1 , "addCl":1 , "servicePer":1}');

-- --------------------------------------------------------

--
-- Структура на таблица `inboxUser`
--

CREATE TABLE `inboxUser` (
  `id` int(11) NOT NULL,
  `textMess` varchar(150) NOT NULL,
  `dateMess` datetime NOT NULL,
  `userId` int(11) NOT NULL,
  `sendUser` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `inboxUser`
--

INSERT INTO `inboxUser` (`id`, `textMess`, `dateMess`, `userId`, `sendUser`, `active`) VALUES
(1, 'da we ', '2016-05-11 23:13:14', 20, 23, 0),
(2, 'a ne we', '2016-05-11 23:13:36', 23, 20, 0),
(3, 'ne ti ela', '2016-05-11 23:13:54', 20, 23, 0),
(4, 'ms,anf m,sadnf,m adskljfhjk jsdfhjhsadkfhk jsadhfkjhsadk fhaskdhfk jsdafk sadkfhg aksfjkasdkfk sadhkf jadhskf asdjhfk jsadhkfj adsjfk sdjhfak jadhsfkj', '2016-05-11 23:14:36', 20, 23, 0),
(5, 'Da we stava', '2016-05-11 23:15:36', 23, 20, 0),
(6, 'test send', '2016-05-12 08:57:36', 23, 20, 0),
(7, 'dsaf,masdhf djsfahjks df', '2016-05-15 21:41:08', 20, 23, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `inoutservice`
--

CREATE TABLE `inoutservice` (
  `id` int(11) NOT NULL,
  `inOrder` varchar(10) NOT NULL DEFAULT '0',
  `outOrder` varchar(10) NOT NULL DEFAULT '0',
  `idOrder` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `dateOrder` datetime NOT NULL,
  `active` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `inoutservice`
--

INSERT INTO `inoutservice` (`id`, `inOrder`, `outOrder`, `idOrder`, `idUser`, `dateOrder`, `active`) VALUES
(1, '20', '0', 3, 20, '2016-05-15 18:05:42', 0),
(3, '30', '0', 7, 20, '2016-05-15 20:05:29', 1),
(4, '200', '0', 8, 20, '2016-05-15 20:25:38', 0),
(5, '120', '0', 23, 20, '2016-05-15 21:05:50', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `measure`
--

CREATE TABLE `measure` (
  `id` int(11) NOT NULL,
  `name` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `measure`
--

INSERT INTO `measure` (`id`, `name`) VALUES
(1, 'бр'),
(2, 'л'),
(3, 'кг');

-- --------------------------------------------------------

--
-- Структура на таблица `model`
--

CREATE TABLE `model` (
  `id` int(11) NOT NULL,
  `model` varchar(30) NOT NULL,
  `brand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `model`
--

INSERT INTO `model` (`id`, `model`, `brand`) VALUES
(1, 'Galaxy S7 (SM-G930F)', 1),
(2, 'Galaxy S6', 1),
(3, 'Galaxy S6 Edge', 1),
(4, '6S', 2),
(5, 'test', 3),
(6, 'Pop 3', 4);

-- --------------------------------------------------------

--
-- Структура на таблица `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `note` text NOT NULL,
  `dateTime` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `idOrder` int(11) NOT NULL,
  `idDelivery` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `orderParts`
--

CREATE TABLE `orderParts` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `storeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `companiId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `serialId` int(11) NOT NULL,
  `modelId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `timeOrder` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `snapshop` varchar(50) NOT NULL,
  `problem` varchar(50) NOT NULL,
  `info` text NOT NULL,
  `password` varchar(30) NOT NULL,
  `account` varchar(50) NOT NULL,
  `repair` varchar(72) NOT NULL,
  `repairImg` varchar(128) NOT NULL,
  `repairInfo` text NOT NULL,
  `impossibleRepair` tinyint(4) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `orders`
--

INSERT INTO `orders` (`id`, `clientId`, `companiId`, `userId`, `serialId`, `modelId`, `brandId`, `timeOrder`, `status`, `snapshop`, `problem`, `info`, `password`, `account`, `repair`, `repairImg`, `repairInfo`, `impossibleRepair`, `active`) VALUES
(1, 1, 0, 20, 1, 2, 1, '2016-05-12 23:05:00', 1, 'sdfsdfsd', 'sdfsdfsd', 'sdfsdf', '', '', '', '', '', 0, 1),
(2, 2, 0, 20, 2, 5, 3, '2016-05-13 17:05:43', 5, 'hjksgjf', 'hjdsgjhfgjsd', 'dskjhfksdhfjk sdhkf dsjfh ufhkjsdbnfmsdmnf bmsdf', 'parola', 'askjhfdsjkf@shfkjdlg.com', 'mlsdhflkjsdh', '', '', 0, 0),
(3, 2, 0, 20, 3, 6, 4, '2016-05-15 18:05:42', 5, 'raboteshto', 'za internet nastroiki', '', '', '', 'jhdfsdhafksjh', '', '', 0, 0),
(7, 2, 0, 20, 3, 6, 4, '2016-05-15 20:05:29', 2, '', 'sdafsdfasdf', '', '', '', '', '', '', 0, 1),
(8, 2, 0, 20, 2, 5, 3, '2016-05-15 20:05:01', 5, '', 'dsfisdoi', '', '', '', 'adskjfhsdhq', '', '', 0, 0),
(23, 2, 0, 20, 2, 5, 3, '2016-05-15 21:05:50', 2, '', 'dsafsdf', '', '', '', '', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `orderTime`
--

CREATE TABLE `orderTime` (
  `id` int(11) NOT NULL,
  `startOrder` varchar(30) NOT NULL,
  `updateOrder` varchar(30) NOT NULL,
  `endOrder` varchar(30) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `orderTime`
--

INSERT INTO `orderTime` (`id`, `startOrder`, `updateOrder`, `endOrder`, `userId`, `orderId`) VALUES
(1, '2016-05-15 18:12:52', '', '', 20, 3),
(2, '', '2016-05-15 18:13:20', '', 20, 3),
(3, '', '', '2016-05-15 20:00:36', 20, 3),
(4, '2016-05-15 20:10:36', '', '', 20, 7),
(5, '2016-05-15 20:15:04', '', '', 20, 2),
(6, '', '2016-05-15 20:15:27', '', 20, 2),
(7, '', '', '2016-05-15 20:15:53', 20, 2),
(8, '2016-05-15 20:17:05', '', '', 20, 8),
(9, '', '2016-05-15 20:22:30', '', 20, 8),
(10, '', '', '2016-05-15 20:22:58', 20, 8),
(11, '', '', '2016-05-15 20:25:38', 20, 8),
(12, '2016-05-15 21:09:33', '', '', 20, 23);

-- --------------------------------------------------------

--
-- Структура на таблица `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `url` varchar(50) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `photos`
--

INSERT INTO `photos` (`id`, `url`, `userId`, `orderId`, `active`) VALUES
(1, 'images/works/23_202854.', 23, 0, 0),
(2, 'images/works/20_204150.jpg', 20, 0, 0),
(3, 'images/works/20_082543.png', 20, 0, 1),
(4, 'images/works/23_213945.jpg', 23, 0, 1),
(5, 'images/works/20_201527.jpeg', 0, 2, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `nameProject` varchar(50) NOT NULL,
  `companyId` int(11) NOT NULL,
  `primaryProject` int(11) NOT NULL,
  `dateCreate` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `orderStatus` int(11) NOT NULL,
  `storeStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `status`
--

INSERT INTO `status` (`id`, `name`, `orderStatus`, `storeStatus`) VALUES
(1, 'Приета', 1, 0),
(2, 'В процес', 2, 0),
(3, 'За тест', 3, 0),
(4, 'Приключена', 4, 0),
(5, 'Взета', 5, 0);

-- --------------------------------------------------------

--
-- Структура на таблица `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `typeStoreId` int(11) NOT NULL,
  `barcode` varchar(100) NOT NULL,
  `name` varchar(128) NOT NULL,
  `groupId` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `measureId` int(11) NOT NULL,
  `price` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура на таблица `storeGroup`
--

CREATE TABLE `storeGroup` (
  `id` int(11) NOT NULL,
  `storeGroup` varchar(30) NOT NULL,
  `underGroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `storeGroup`
--

INSERT INTO `storeGroup` (`id`, `storeGroup`, `underGroup`) VALUES
(1, 'Test', 0),
(2, 'Test 2', 0),
(3, 'Test 3', 2),
(4, 'Test 5', 1);

-- --------------------------------------------------------

--
-- Структура на таблица `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `type`
--

INSERT INTO `type` (`id`, `type`) VALUES
(1, 'GSM');

-- --------------------------------------------------------

--
-- Структура на таблица `typeStore`
--

CREATE TABLE `typeStore` (
  `id` int(11) NOT NULL,
  `type` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `typeStore`
--

INSERT INTO `typeStore` (`id`, `type`) VALUES
(1, 'Стока'),
(2, 'Услуга');

-- --------------------------------------------------------

--
-- Структура на таблица `userOrder`
--

CREATE TABLE `userOrder` (
  `id` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `orderTimeId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `userOrder`
--

INSERT INTO `userOrder` (`id`, `orderId`, `orderTimeId`, `userId`, `active`) VALUES
(1, 3, 1, 20, 1),
(2, 7, 4, 20, 1),
(3, 2, 5, 20, 1),
(4, 8, 8, 20, 1),
(5, 23, 12, 20, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `joined` datetime NOT NULL,
  `groups` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `name`, `last_name`, `phone`, `email`, `joined`, `groups`, `company`, `active`) VALUES
(20, 'TaHuC', '?D[????\0???R?P]Zg!Ko%i,G	', '?l0t1Q???z??B???\\>???8b', 'Стоян', 'Бакъров', '0898709501', 'TaHuC@hotmail.com', '2015-11-30 08:11:56', 100, 0, 1),
(23, 'test', '?V?#P9/????VN3???????W', '}??W?w??4p??\0&e??L???=?.b???', 'Test', 'Test', '08094858340', 'test@test.com', '2016-05-09 20:05:54', 103, 0, 1);

-- --------------------------------------------------------

--
-- Структура на таблица `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `inboxUser`
--
ALTER TABLE `inboxUser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inoutservice`
--
ALTER TABLE `inoutservice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `measure`
--
ALTER TABLE `measure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderParts`
--
ALTER TABLE `orderParts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderTime`
--
ALTER TABLE `orderTime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storeGroup`
--
ALTER TABLE `storeGroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typeStore`
--
ALTER TABLE `typeStore`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userOrder`
--
ALTER TABLE `userOrder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT for table `inboxUser`
--
ALTER TABLE `inboxUser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `inoutservice`
--
ALTER TABLE `inoutservice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `measure`
--
ALTER TABLE `measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orderParts`
--
ALTER TABLE `orderParts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `orderTime`
--
ALTER TABLE `orderTime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `storeGroup`
--
ALTER TABLE `storeGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `typeStore`
--
ALTER TABLE `typeStore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `userOrder`
--
ALTER TABLE `userOrder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
