-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 14, 2025 lúc 08:53 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dat_ve`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(120) DEFAULT NULL,
  `usertype` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `email`, `image`, `password`, `usertype`) VALUES
(29, 'admin', 'admin@gmail.com', '1736562479_2023_05_27_19_30_IMG_4082.PNG', '123', 1),
(30, 'Nguyễn Bá Tuấn Anhh', 'nhanvien@gmail.com', '1736567225_2023_02_14_00_10_IMG_3217.JPG', '123', 0),
(31, 'Linh', 'linh@gmial.com', '1736563206_2023_10_20_12_39_IMG_5696.JPG', '123', 0),
(32, 'Hằng', 'hang@gmail.com', '1736560758_z6068232815213_8b693c5c028e0235e88b1385af981bd2.jpg', '123', 0),
(33, 'admin', 'admin@gmail.com ', '', '1a', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `car`
--

CREATE TABLE `car` (
  `id_car` int(11) NOT NULL,
  `id_c_house` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `c_plate` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `car`
--

INSERT INTO `car` (`id_car`, `id_c_house`, `c_name`, `img`, `c_plate`, `capacity`) VALUES
(4, 1, 'Xe 14 chỗ', '1736750467_360x280_1.jpg', '30B-67890', 16),
(5, 1, 'Xe 16 chỗ', '1736753494_380x280.jpg', '30B-67890', 16),
(6, 2, 'Xe 16 chỗ', '1736822464_1600x800.jpg', '29A-12345', 16);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `car_house`
--

CREATE TABLE `car_house` (
  `id_c_house` int(11) NOT NULL,
  `name_c_house` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `car_house`
--

INSERT INTO `car_house` (`id_c_house`, `name_c_house`, `address`, `phone`, `email`) VALUES
(1, 'Nhà xe A', '123 Đường 1, Hà Nội', 123456789, 'nhaxeA@example.com'),
(2, 'Nhà xe B', '456 Đường 2, Hồ Chí Minh', 987654321, 'nhaxeB@example.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `city`
--

CREATE TABLE `city` (
  `id_city` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `city`
--

INSERT INTO `city` (`id_city`, `city_name`) VALUES
(8, 'Hà Nội'),
(9, 'Hải Phòng'),
(10, 'Đà Nẵng'),
(11, 'Hồ Chí Minh'),
(12, 'Cần Thơ'),
(13, 'Nha Trang'),
(14, 'Huế'),
(15, 'Vũng Tàu'),
(16, 'Biên Hòa'),
(17, 'Thủ Dầu Một'),
(18, 'Đà Lạt'),
(19, 'Mỹ Tho'),
(20, 'Vĩnh Long'),
(21, 'Cà Mau'),
(22, 'Rạch Giá'),
(23, 'Long Xuyên'),
(24, 'Sóc Trăng'),
(25, 'Bạc Liêu'),
(26, 'Trà Vinh'),
(27, 'Bến Tre'),
(28, 'Quy Nhơn'),
(29, 'Pleiku'),
(30, 'Kon Tum'),
(31, 'Tuy Hòa'),
(32, 'Phan Thiết'),
(33, 'Phan Rang-Tháp Chàm'),
(34, 'Ninh Thuận'),
(35, 'Quảng Ngãi'),
(36, 'Tam Kỳ'),
(37, 'Hội An'),
(38, 'Đông Hà'),
(39, 'Huế'),
(40, 'Sầm Sơn'),
(41, 'Thanh Hóa'),
(42, 'Vinh'),
(43, 'Hà Tĩnh'),
(44, 'Đồng Hới'),
(45, 'Ninh Bình'),
(46, 'Nam Định'),
(47, 'Hải Dương'),
(48, 'Hưng Yên'),
(49, 'Thái Bình'),
(50, 'Bắc Ninh'),
(51, 'Bắc Giang'),
(52, 'Lạng Sơn'),
(53, 'Cao Bằng'),
(54, 'Hà Giang'),
(55, 'Tuyên Quang'),
(56, 'Yên Bái'),
(57, 'Sơn La'),
(58, 'Điện Biên Phủ'),
(59, 'Lai Châu'),
(60, 'Lào Cai'),
(61, 'Hòa Bình'),
(62, 'Thái Nguyên'),
(63, 'Quảng Ninh'),
(64, 'Bắc Kạn'),
(65, 'Hà Nam'),
(66, 'Ninh Bình');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `id_trip` int(11) NOT NULL,
  `name_location` text NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_trip` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `number_seat` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '',
  `method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trip`
--

CREATE TABLE `trip` (
  `id_trip` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `id_city_from` int(11) NOT NULL,
  `id_city_to` int(11) NOT NULL,
  `t_pick` time NOT NULL,
  `t_drop` time NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Chỉ mục cho bảng `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id_car`),
  ADD KEY `id_c_house` (`id_c_house`);

--
-- Chỉ mục cho bảng `car_house`
--
ALTER TABLE `car_house`
  ADD PRIMARY KEY (`id_c_house`);

--
-- Chỉ mục cho bảng `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id_city`);

--
-- Chỉ mục cho bảng `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`),
  ADD KEY `location_trip` (`id_trip`);

--
-- Chỉ mục cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_trip` (`id_trip`),
  ADD KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`id_trip`),
  ADD KEY `id_car` (`id_car`),
  ADD KEY `id_city` (`id_city_from`),
  ADD KEY `id_city_to` (`id_city_to`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `car`
--
ALTER TABLE `car`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `car_house`
--
ALTER TABLE `car_house`
  MODIFY `id_c_house` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `trip`
--
ALTER TABLE `trip`
  MODIFY `id_trip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`id_c_house`) REFERENCES `car_house` (`id_c_house`);

--
-- Các ràng buộc cho bảng `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_trip` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id_trip`);

--
-- Các ràng buộc cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id_trip`);

--
-- Các ràng buộc cho bảng `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`),
  ADD CONSTRAINT `trip_ibfk_3` FOREIGN KEY (`id_city_from`) REFERENCES `city` (`id_city`),
  ADD CONSTRAINT `trip_ibfk_4` FOREIGN KEY (`id_city_to`) REFERENCES `city` (`id_city`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
