-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- 생성 시간: 20-09-08 13:14
-- 서버 버전: 10.1.30-MariaDB
-- PHP 버전: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 데이터베이스: `daegu_2`
--

-- --------------------------------------------------------

--
-- 테이블 구조 `meeting`
--

CREATE TABLE `meeting` (
  `id` int(11) NOT NULL,
  `book_name` varchar(150) NOT NULL,
  `writer_name` varchar(150) NOT NULL,
  `book_image` varchar(50) NOT NULL,
  `target` varchar(150) NOT NULL,
  `created_at` date NOT NULL,
  `pos_week` int(11) NOT NULL,
  `pos_time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `meeting`
--

INSERT INTO `meeting` (`id`, `book_name`, `writer_name`, `book_image`, `target`, `created_at`, `pos_week`, `pos_time`) VALUES
(16, '페인트', '이희영', '페인트.jpg', '초등학생', '2019-04-19', 1, '11:00~13:00'),
(17, '체리새우', '황영미', '체리새우.jpg', '초등학생', '2019-01-28', 2, '13:00~15:00'),
(18, '시간을 파는 상점', '김선영', '시간을 파는 상점.jpg', '초등학생', '2012-04-10', 3, '15:00~17:00'),
(19, '아몬드', '손원평', '아몬드.jpg', '초등학생', '2017-03-31', 4, '10:00~12:00'),
(20, '완득이', '김려령', '완득이.jpg', '초등학생', '2008-03-17', 5, '14:00~16:00'),
(21, '단편소설 베스트35', '김형주', '단편소설 베스트35.jpg', '중학생', '2015-07-13', 1, '11:00~13:00'),
(22, '그들도 아이였다', '김은우', '그들도 아이였다.jpg', '중학생', '2018-03-25', 2, '13:00~15:00'),
(23, '십대를 위한 실패수업', '정화진', '십대를 위한 실패수업.jpg', '중학생', '2019-06-12', 3, '15:00~17:00'),
(24, '중학국어 비문학 독해 한권으로 끝내기', '정문경', '중학국어 비문학 독해 한권으로 끝내기.jpg', '중학생', '2019-06-05', 4, '10:00~12:00'),
(25, '바다소', '양태은', '바다소.jpg', '중학생', '2018-06-10', 5, '14:00~16:00'),
(26, '선생님과 함께 읽는 우리 소설', '권순긍', '선생님과 함께 읽는 우리 소설.jpg', '고등학생', '2011-05-03', 1, '11:00~13:00'),
(27, '스프링벅', '배유안', '스프링벅.jpg', '고등학생', '2008-10-13', 2, '13:00~15:00'),
(28, '생각한다는것', '고병권', '생각한다는것.jpg', '고등학생', '2010-03-31', 3, '15:00~17:00'),
(29, '개똥 세개', '강수돌', '개똥 세개.jpg', '고등학생', '2013-07-30', 4, '10:00~12:00'),
(30, '아이는 사춘기 엄마는 성장기', '이윤정', '아이는 사춘기 엄마는 성장기.jpg', '고등학생', '2010-03-26', 5, '14:00~16:00'),
(32, '뭔가 멋진 이름', '멋진 작가', '1599553019-Cartography1.png', '멋진 대상', '2020-09-03', 0, '0:00~13:00');

-- --------------------------------------------------------

--
-- 테이블 구조 `reserves`
--

CREATE TABLE `reserves` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rdate` date NOT NULL,
  `rtime` varchar(10) NOT NULL,
  `content` text NOT NULL,
  `mid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `reserves`
--

INSERT INTO `reserves` (`id`, `uid`, `rdate`, `rtime`, `content`, `mid`, `status`) VALUES
(3, 5, '2020-09-17', '10:00', 'asdqwewqe\r\n\r\nqweqwe\r\nqweqwe', 19, 1),
(4, 5, '2020-09-11', '16:00', 'ㅁㄴㅇㄴㅁㅇ', 25, 0),
(5, 5, '2020-09-18', '14:00', 'ㅁㄴㅇㄴㅁㅇㅁㄴㅇㅁㄴㅇ', 25, 0);

-- --------------------------------------------------------

--
-- 테이블 구조 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_name` varchar(150) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `age` int(11) NOT NULL,
  `school` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 테이블의 덤프 데이터 `users`
--

INSERT INTO `users` (`id`, `user_email`, `password`, `user_name`, `gender`, `age`, `school`) VALUES
(4, 'admin', '1234', '관리자', '', 0, ''),
(5, 'user1@gmail.com', '1234', '일유저', '남', 19, '고등학교');

--
-- 덤프된 테이블의 인덱스
--

--
-- 테이블의 인덱스 `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `reserves`
--
ALTER TABLE `reserves`
  ADD PRIMARY KEY (`id`);

--
-- 테이블의 인덱스 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 덤프된 테이블의 AUTO_INCREMENT
--

--
-- 테이블의 AUTO_INCREMENT `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 테이블의 AUTO_INCREMENT `reserves`
--
ALTER TABLE `reserves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 테이블의 AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
