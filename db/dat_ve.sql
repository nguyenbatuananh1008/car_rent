-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 17, 2025 lúc 03:11 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

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
(32, 'Hằng', 'hang@gmail.com', '1736560758_z6068232815213_8b693c5c028e0235e88b1385af981bd2.jpg', '123', 0);

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
(1, 1, 'Xe 16 chỗ', '380x280.jpg', '29A-12345', 16),
(2, 2, 'Xe 45 chỗ', '360x280_1.jpg', '30B-67890', 45);

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
  `name_city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `city`
--

INSERT INTO `city` (`id_city`, `name_city`) VALUES
(3, 'Hà Nội'),
(4, 'Nam Định');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `id_trip` int(11) NOT NULL,
  `name_location` varchar(255) NOT NULL,
  `time` time NOT NULL,
  `type` int(11) NOT NULL,
  `oder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_trip` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `number_seat` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '',
  `method` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `id_trip`, `id_user`, `number_seat`, `total_price`, `status`, `method`, `date`) VALUES
(7, 5, 9, 2, 340000.00, '', '', '2025-01-16');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trip`
--

CREATE TABLE `trip` (
  `id_trip` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `id_city` int(11) NOT NULL,
  `id_city_to` int(11) NOT NULL,
  `t_pick` time NOT NULL,
  `t_drop` time NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `ticket_limit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trip`
--

INSERT INTO `trip` (`id_trip`, `id_car`, `id_city`, `id_city_to`, `t_pick`, `t_drop`, `price`, `date`, `ticket_limit`) VALUES
(5, 1, 3, 4, '18:06:45', '23:06:45', 170000.00, '2025-01-16', 12),
(6, 1, 3, 4, '13:54:34', '15:54:50', 180000.00, '2025-01-16', 12);

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
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`) VALUES
(9, 'Nguyễn Bá Tuấn Anh', 'tuananhnguyenba1008@gmail.com', '123456');

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
  ADD KEY `id_city` (`id_city`),
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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `car`
--
ALTER TABLE `car`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `car_house`
--
ALTER TABLE `car_house`
  MODIFY `id_c_house` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `trip`
--
ALTER TABLE `trip`
  MODIFY `id_trip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `trip_ibfk_3` FOREIGN KEY (`id_city`) REFERENCES `city` (`id_city`),
  ADD CONSTRAINT `trip_ibfk_4` FOREIGN KEY (`id_city_to`) REFERENCES `city` (`id_city`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
