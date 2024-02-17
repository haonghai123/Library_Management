-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th2 17, 2024 lúc 03:04 AM
-- Phiên bản máy phục vụ: 8.0.30
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lms`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_admin`
--

CREATE TABLE `lms_admin` (
  `admin_id` int NOT NULL,
  `admin_email` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `admin_password` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_admin`
--

INSERT INTO `lms_admin` (`admin_id`, `admin_email`, `admin_password`) VALUES
(1, 'admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_author`
--

CREATE TABLE `lms_author` (
  `author_id` int NOT NULL,
  `author_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `author_status` enum('Enable','Disable') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `author_created_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `author_updated_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_author`
--

INSERT INTO `lms_author` (`author_id`, `author_name`, `author_status`, `author_created_on`, `author_updated_on`) VALUES
(1, 'Lê Hoàng Hà', 'Enable', '2023-11-11 15:45:14', '2023-12-22 15:50:34'),
(2, 'GS. Nguyễn Cường', 'Enable', '2023-11-12 12:48:40', ''),
(3, 'Lý Huy', 'Enable', '2023-11-12 12:49:00', ''),
(4, 'Văn lý', 'Enable', '2023-11-12 12:49:18', ''),
(5, 'Hoàng Sĩ', 'Enable', '2023-11-12 12:49:38', ''),
(6, 'Á Quân anh', 'Enable', '2023-11-12 12:49:54', '2023-12-29 01:15:10'),
(21, 'Conan Doyle', 'Enable', '2023-12-23 00:09:32', NULL),
(22, 'Ng Anh Quân', 'Enable', '2023-12-29 00:16:33', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_book`
--

CREATE TABLE `lms_book` (
  `book_id` int NOT NULL,
  `book_category` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_author` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_location_rack` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_name` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_isbn_number` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_no_of_copy` int NOT NULL,
  `book_status` enum('Enable','Disable') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_added_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_updated_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_book`
--

INSERT INTO `lms_book` (`book_id`, `book_category`, `book_author`, `book_location_rack`, `book_name`, `book_isbn_number`, `book_no_of_copy`, `book_status`, `book_added_on`, `book_updated_on`) VALUES
(15, 'Lập trình', 'Lý Huy', 'A7', 'Chương trình PHP cho người  mới bắt đầu', '744785963520', 5, 'Enable', '2023-11-12 13:07:27', '2023-12-09 18:37:14'),
(16, 'Dữ liệu', 'Văn lý', 'A2', 'Lập trình PHP và kết nối MySQL', '753951852123', 1, 'Enable', '2023-11-17 10:43:19', '2023-12-29 00:20:06'),
(17, 'Lập trình web', 'Lê Hoàng Hà', 'A11', 'JS từ zero đến hero', '852369753951', 1, 'Enable', '2023-12-08 18:48:11', '2023-12-28 18:03:30'),
(18, 'Dữ liệu', 'Á Quân', 'A4', 'Sherlock Holmes', '1234345', 1, 'Enable', '2023-12-22 14:18:51', '2023-12-29 01:07:02'),
(19, 'Lập trình web', 'GS. Nguyễn Cường', 'A2', 'LocPHP', '192837483', 14, 'Enable', '2023-12-28 15:40:03', NULL),
(20, 'Trinh thám', 'Conan Doyle', 'A5', 'Domino', '1728739820', 13, 'Enable', '2023-12-28 23:40:48', NULL),
(21, 'Ngôn tình', 'Ng Anh Quân', 'C11', 'Chuyện tình mùa xuân', '1829474399272', 12, 'Enable', '2023-12-29 00:19:24', '2023-12-29 08:49:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_category`
--

CREATE TABLE `lms_category` (
  `category_id` int NOT NULL,
  `category_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `category_status` enum('Enable','Disable') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `category_created_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `category_updated_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_category`
--

INSERT INTO `lms_category` (`category_id`, `category_name`, `category_status`, `category_created_on`, `category_updated_on`) VALUES
(1, 'Lập trình', 'Enable', '2023-11-10 19:02:37', '2023-11-27 11:56:18'),
(2, 'Dữ liệu', 'Enable', '2023-11-17 10:36:53', '2023-12-22 00:50:05'),
(3, 'Thiết kế web', 'Enable', '2023-11-26 16:14:18', '2023-11-27 12:28:03'),
(4, 'Lập trình web', 'Enable', '2023-11-26 16:15:38', '2023-11-27 12:28:11'),
(5, 'Trinh thám', 'Enable', '2023-12-22 00:49:45', '2023-12-22 00:52:47'),
(6, 'Khoa học', 'Enable', '2023-12-22 12:40:14', NULL),
(7, 'Giáo dục', 'Enable', '2023-12-22 13:58:16', NULL),
(8, 'Chính trị_1', 'Enable', '2023-12-22 17:28:01', '2023-12-29 01:18:23'),
(9, 'Ngôn tình', 'Enable', '2023-12-29 00:17:15', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_issue_book`
--

CREATE TABLE `lms_issue_book` (
  `issue_book_id` int NOT NULL,
  `book_id` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `issue_date_time` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `expected_return_date` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `return_date_time` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_fines` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `book_issue_status` enum('Issue','Return','Not Return') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_issue_book`
--

INSERT INTO `lms_issue_book` (`issue_book_id`, `book_id`, `user_id`, `issue_date_time`, `expected_return_date`, `return_date_time`, `book_fines`, `book_issue_status`) VALUES
(4, '856325774562', 'U37570190', '2023-11-13 15:57:29', '2023-11-23 15:57:29', '2023-11-14 16:51:42', '0', 'Return'),
(5, '856325774562', 'U37570190', '2023-11-14 17:04:13', '2023-11-24 17:04:13', '2023-11-14 17:05:47', '0', 'Return'),
(6, '85478569856', 'U37570190', '2023-11-14 17:07:04', '2023-11-24 17:07:04', '2023-11-14 17:07:55', '0', 'Return'),
(7, '753951852123', 'U52357788', '2023-11-17 11:03:04', '2023-11-27 11:03:04', '2023-11-17 11:05:29', '0', 'Return'),
(8, '852369852123', 'U59564819', '2023-12-28 17:59:06', '2023-01-07 17:59:06', '2023-01-03 12:44:15', '0', 'Return'),
(9, '852369753951', 'U59564819', '2023-12-28 18:03:30', '2023-01-07 18:03:30', '2023-01-03 12:43:28', '0', 'Return'),
(10, '123', 'U42695185', '2023-12-22 14:28:54', '2023-01-01 14:28:54', '2023-12-22 17:27:23', '0', 'Return'),
(11, '753951852123', 'U42695185', '2023-12-22 21:53:39', '2023-01-01 21:53:39', '2023-12-22 22:58:29', '210', 'Return'),
(12, '1234345', 'U42695185', '2023-12-22 23:06:38', '2023-12-23 23:06:38', '2023-12-28 23:44:35', '0', 'Return'),
(13, '1234345', 'U42695185', '2023-12-23 00:16:42', '2023-12-24 00:16:42', '2023-12-23 00:17:34', '0', 'Return'),
(14, '1234345', 'U42695185', '2023-12-23 01:44:57', '2023-12-24 01:44:57', '2023-12-28 01:42:52', '0', 'Return'),
(15, '1234345', 'U42695185', '2023-12-28 23:45:29', '2023-12-29 23:45:29', '2023-12-28 23:45:53', '0', 'Return'),
(16, '1234345', 'U42695185', '2023-12-28 23:49:22', '2023-12-30 23:49:22', '2024-01-01 23:45:53', '800', 'Not Return'),
(17, '753951852123', 'U81944373', '2023-12-29 00:20:06', '2024-01-01 00:20:06', '2023-12-29 00:20:26', '0', 'Return'),
(18, '1234345', 'U42695185', '2023-12-29 01:07:02', '2024-01-01 01:07:02', '2023-12-29 08:44:21', '0', 'Return'),
(19, '1829474399272', 'U42695185', '2023-12-29 08:49:02', '2023-12-30 08:49:02', '2023-12-29 08:50:18', '0', 'Return');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_location_rack`
--

CREATE TABLE `lms_location_rack` (
  `location_rack_id` int NOT NULL,
  `location_rack_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `location_rack_status` enum('Enable','Disable') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `location_rack_created_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `location_rack_updated_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_location_rack`
--

INSERT INTO `lms_location_rack` (`location_rack_id`, `location_rack_name`, `location_rack_status`, `location_rack_created_on`, `location_rack_updated_on`) VALUES
(1, 'A1', 'Enable', '2023-11-11 16:16:27', '2023-12-22 19:16:42'),
(2, 'A2', 'Enable', '2023-11-12 12:53:49', ''),
(3, 'A3', 'Enable', '2023-11-12 12:53:57', ''),
(4, 'A4', 'Enable', '2023-11-12 12:54:06', ''),
(5, 'A5', 'Enable', '2023-11-12 12:54:14', ''),
(6, 'A6', 'Enable', '2023-11-12 12:54:22', ''),
(7, 'A7', 'Enable', '2023-11-12 12:54:30', ''),
(8, 'A8', 'Enable', '2023-11-12 12:54:38', ''),
(9, 'A9', 'Enable', '2023-11-12 12:54:52', ''),
(10, 'A10', 'Enable', '2023-11-12 12:55:02', '2023-12-04 13:03:28'),
(11, 'A11', 'Enable', '2023-12-03 18:20:16', '2023-12-04 12:45:09'),
(12, 'B1', 'Enable', '2023-12-23 01:14:43', NULL),
(13, 'C11', 'Enable', '2023-12-29 00:17:52', NULL),
(14, 'b9', 'Enable', '2023-12-29 08:42:47', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_setting`
--

CREATE TABLE `lms_setting` (
  `setting_id` int NOT NULL,
  `library_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `library_address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `library_contact_number` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `library_email_address` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `library_total_book_issue_day` int NOT NULL,
  `library_one_day_fine` int DEFAULT NULL,
  `library_issue_total_book_per_user` int NOT NULL,
  `library_currency` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `library_timezone` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_setting`
--

INSERT INTO `lms_setting` (`setting_id`, `library_name`, `library_address`, `library_contact_number`, `library_email_address`, `library_total_book_issue_day`, `library_one_day_fine`, `library_issue_total_book_per_user`, `library_currency`, `library_timezone`) VALUES
(1, 'OpenLibrary', 'Bình Dương', '7539518521', 'admin@gmail.com', 1, 100, 2, 'VND', 'Asia/Ho_Chi_Minh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lms_user`
--

CREATE TABLE `lms_user` (
  `user_id` int NOT NULL,
  `user_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_address` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_contact_no` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_profile` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_email_address` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_password` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_verificaton_code` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_verification_status` enum('No','Yes') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_unique_id` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_status` enum('Enable','Disable') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_created_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_updated_on` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `lms_user`
--

INSERT INTO `lms_user` (`user_id`, `user_name`, `user_address`, `user_contact_no`, `user_profile`, `user_email_address`, `user_password`, `user_verificaton_code`, `user_verification_status`, `user_unique_id`, `user_status`, `user_created_on`, `user_updated_on`) VALUES
(3, 'Dương', 'Bình Dương', '7539518520', '1636699900-2617.jpg', 'Duong@gmail.com', '123456', 'b190bcd6e3b29674db036670cf122724', 'Yes', '', 'Enable', '2023-11-12 12:21:40', '2023-11-14 17:40:05'),
(4, 'Khánh', 'Bình Dương', '8569856321', '1636905360-32007.jpg', 'khanhcute@gmail.com', '123456', 'add84abb895484d12344316eccb78a62', 'Yes', 'U37570190', 'Enable', '2023-11-12 16:39:20', '2023-11-17 10:49:20'),
(5, 'Lộc', 'Bình Dương', '85214796930', '1637041684-15131.jpg', 'lochehe@gmail.com', '123456', '7013df5205011ffcb99ea57902c17369', 'Yes', 'U24567871', 'Enable', '2023-11-16 11:18:04', ''),
(6, 'Kiệt', 'Bình Dương', '8521479630', '1637126571-21753.jpg', 'Kietm23@gmail.com', '123456', 'a6c2623984d590239244f8695df3a30b', 'Yes', 'U52357788', 'Enable', '2023-11-17 10:52:51', ''),
(10, 'Triết', 'Bình Dương', '8523698520', '1639658464-10192.jpg', 'minhtriet@gmail.com', '123456', '337ea20da40326d134fe5eca3fb03464', 'Yes', 'U59564819', 'Enable', '2023-12-14 12:56:29', '2023-12-20 15:21:45'),
(16, 'phong', 'BinhDuong', '928273827', '1703194688-607853189.png', 'nhahangthanhbinh748@gmail.com', '123456', 'd4caf569b85a91262f79d1166571ee4f', 'Yes', 'U68506974', 'Enable', '2023-12-22 03:08:08', NULL),
(17, 'phong', 'BinhDuong', '928273821', '1703194820-919535470.png', 'phongha676@gmail.com', '123456', 'f36021008b9e626d83a485221c5e70eb', 'Yes', 'U42695185', 'Enable', '2023-12-22 03:10:21', '2023-12-24 17:12:16'),
(20, 'root', 'BinhDuong', '928273827', '1703809308-263550183.png', 'mtpskypro22234@gmail.com', '123456', '43b8c4ac9bb19d0faa3d42c680ed6718', 'No', 'U36799255', 'Enable', '2023-12-29 07:21:48', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `lms_admin`
--
ALTER TABLE `lms_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `lms_author`
--
ALTER TABLE `lms_author`
  ADD PRIMARY KEY (`author_id`);

--
-- Chỉ mục cho bảng `lms_book`
--
ALTER TABLE `lms_book`
  ADD PRIMARY KEY (`book_id`);

--
-- Chỉ mục cho bảng `lms_category`
--
ALTER TABLE `lms_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `lms_issue_book`
--
ALTER TABLE `lms_issue_book`
  ADD PRIMARY KEY (`issue_book_id`);

--
-- Chỉ mục cho bảng `lms_location_rack`
--
ALTER TABLE `lms_location_rack`
  ADD PRIMARY KEY (`location_rack_id`);

--
-- Chỉ mục cho bảng `lms_setting`
--
ALTER TABLE `lms_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Chỉ mục cho bảng `lms_user`
--
ALTER TABLE `lms_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `lms_admin`
--
ALTER TABLE `lms_admin`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `lms_author`
--
ALTER TABLE `lms_author`
  MODIFY `author_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `lms_book`
--
ALTER TABLE `lms_book`
  MODIFY `book_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `lms_category`
--
ALTER TABLE `lms_category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `lms_issue_book`
--
ALTER TABLE `lms_issue_book`
  MODIFY `issue_book_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `lms_location_rack`
--
ALTER TABLE `lms_location_rack`
  MODIFY `location_rack_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `lms_setting`
--
ALTER TABLE `lms_setting`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `lms_user`
--
ALTER TABLE `lms_user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
