-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2021 年 10 月 25 日 23:18
-- サーバのバージョン： 5.7.32
-- PHP のバージョン: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mountain_connect`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `diaries`
--

CREATE TABLE `diaries` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `body` varchar(512) NOT NULL COMMENT '本文',
  `created_at` date DEFAULT NULL COMMENT '登録日時',
  `update_at` date DEFAULT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `diaries`
--

INSERT INTO `diaries` (`id`, `user_id`, `title`, `body`, `created_at`, `update_at`) VALUES
(16, 23, '涸沢カールの紅葉', '日本一の紅葉と言われる涸沢の紅葉。上高地までシャトルバスで30分。上高地から目的地の涸沢カールまでは6時間ほど。モルゲンロートも綺麗でした。', '2021-10-18', '2021-10-23'),
(25, 5, '涸沢カールの紅葉最高', '涸沢カールと言えばモルゲンロートですね！', '2021-10-18', '2021-10-18'),
(26, 23, '富士山（吉田ルート）', '吉田ルートにて御来光を拝みにナイトハイク。', '2021-10-23', '2021-10-23'),
(27, 35, '筑波山', '百名山の中で一番標高が低いです。', '2021-10-23', '2021-10-23'),
(31, 23, 'diary_update', 'diary_update', '2021-10-24', '2021-10-24'),
(32, 23, '<script>alert(\'JavaScriptのアラート\');</script>', '<script>alert(\'JavaScriptのアラート\');</script>\r\n<script>alert(\'JavaScriptのアラート\');</script><script>alert(\'JavaScriptのアラート\');</script>\r\n', '2021-10-24', '2021-10-24');

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `title` varchar(255) NOT NULL COMMENT 'タイトル',
  `body` varchar(512) NOT NULL COMMENT '本文',
  `created_at` date DEFAULT NULL COMMENT '登録日時',
  `update_at` date DEFAULT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`id`, `user_id`, `title`, `body`, `created_at`, `update_at`) VALUES
(14, 23, '富士山登山募集', '富士山に一緒に登って頂ける方よろしくお願い致します。日時等は相談させて頂きたいです。', '2021-10-18', '2021-10-23'),
(21, 23, '<script>alert(\'JavaScriptのアラート\');</script>', '<script>alert(\'JavaScriptのアラート\');</script>', '2021-10-24', '2021-10-24'),
(22, 23, 'test_update', 'test_update', '2021-10-24', '2021-10-24');

-- --------------------------------------------------------

--
-- テーブルの構造 `likes`
--

CREATE TABLE `likes` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `event_id` int(32) NOT NULL COMMENT 'イベントID',
  `created_at` date DEFAULT NULL COMMENT '登録日時',
  `update_at` date DEFAULT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `event_id`, `created_at`, `update_at`) VALUES
(6, 23, 7, NULL, NULL),
(160, 23, 15, NULL, NULL),
(161, 23, 14, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `messages`
--

CREATE TABLE `messages` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `user_id` int(32) NOT NULL COMMENT 'ユーザーID',
  `event_id` int(32) NOT NULL COMMENT 'イベントID',
  `body` varchar(512) NOT NULL COMMENT '本文',
  `created_at` date DEFAULT NULL COMMENT '登録日時',
  `update_at` date DEFAULT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `event_id`, `body`, `created_at`, `update_at`) VALUES
(14, 15, 7, 'd', '2021-10-16', '2021-10-16'),
(16, 5, 13, 'testの本文', '2021-10-16', '2021-10-16'),
(17, 5, 13, 'test2', '2021-10-16', '2021-10-16'),
(18, 5, 13, 'test2', '2021-10-16', '2021-10-16'),
(19, 23, 13, 'testの本文', '2021-10-18', '2021-10-18'),
(32, 5, 14, '        aa', '2021-10-18', '2021-10-18'),
(33, 5, 14, 'ああ', '2021-10-18', '2021-10-18'),
(48, 23, 14, 'test', '2021-10-24', '2021-10-24'),
(49, 23, 14, '<script>alert(\'JavaScriptのアラート\');</script>', '2021-10-24', '2021-10-24');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(32) NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'ユーザーネーム',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) DEFAULT NULL COMMENT 'パスワード',
  `body` varchar(512) DEFAULT NULL COMMENT '自己紹介文',
  `role` int(32) NOT NULL DEFAULT '0' COMMENT '権限',
  `created_at` date DEFAULT NULL COMMENT '登録日時',
  `update_at` date DEFAULT NULL COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `body`, `role`, `created_at`, `update_at`) VALUES
(16, 'admin', 'admin@admin', '$2y$10$RhLXWRWIph/9S/OX9rNH6u6UpaQMvKcNyy23HAG5etAjj7gKTNdSm', NULL, 1, '2021-10-16', '2021-10-16'),
(23, 'Test_user', 'test@test.com', '$2y$10$LQzfUjWR6BmBYnCShDO0fefBmQkDx7ll52De9/ZeEXrqB3FPO0UGa', '自己紹介（一例）: 27歳、埼玉在住、登るスピードのんびりです。よろしくお願い致します。', 0, '2021-10-17', '2021-10-23'),
(40, 'hikari moriwaki', 'testmail.mitsunari@gmail.com', NULL, NULL, 0, '2021-10-24', '2021-10-24'),
(41, 'test_user2', 'test@test2.com', '$2y$10$YaaKYI9XSKciKsKJq5XwWuOM5rGmCKxqh0fRYcLpH2qjPLYlZzITK', NULL, 0, '2021-10-24', '2021-10-24'),
(42, '<script>alert(\'JavaScriptのアラート\');</script>', 'aaa@aaa', '$2y$10$xdFWtBjpTdhSNq99.tuChOuQlR3qE7UdkCn0EYSNBzIVyZeKrXM7C', NULL, 0, '2021-10-24', '2021-10-24'),
(43, 'ketugou_test_user', 'ketugou@test.com', '$2y$10$khm9WqKlo9E1fa3N57wG9.79VYUz2QI8V9J2F9U33bPLxUZ9ojv2C', NULL, 0, '2021-10-24', '2021-10-24');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `diaries`
--
ALTER TABLE `diaries`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `diaries`
--
ALTER TABLE `diaries`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=34;

--
-- テーブルの AUTO_INCREMENT `events`
--
ALTER TABLE `events`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=24;

--
-- テーブルの AUTO_INCREMENT `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=163;

--
-- テーブルの AUTO_INCREMENT `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=51;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
