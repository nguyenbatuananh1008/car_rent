-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 04, 2025 lúc 04:29 AM
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
(32, 'Hằng', 'hang@gmail.com', '1736560758_z6068232815213_8b693c5c028e0235e88b1385af981bd2.jpg', '123', 0),
(33, 'admin', 'admin@gmail.com ', '', '1a', 1),
(34, 'hoang1', 'hoang1@gmail.com', '1737601093_33.jpg', '123', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `car`
--

CREATE TABLE `car` (
  `id_car` int(11) NOT NULL,
  `id_c_house` int(11) NOT NULL,
  `c_name` varchar(255) NOT NULL,
  `c_type` varchar(255) NOT NULL,
  `c_color` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `c_plate` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `car`
--

INSERT INTO `car` (`id_car`, `id_c_house`, `c_name`, `c_type`, `c_color`, `img`, `c_plate`, `capacity`) VALUES
(11, 7, 'Huyndai', 'Solati', 'Trắng', '1738633200_Xe-Khach-Hyundai-Solati-16-cho.jpg', '30B-67890', 16),
(12, 7, 'Ford', 'Transit 2023', 'Bạc', '1738633246_03fordtransitmoi-1641112368-16-2604-9668-1641113158.jpg', '29A-12345', 16),
(13, 8, 'Thaco ', 'King Long 2021', 'Xám', '1738633846_thaco-king-long.jpg.jpg', '30B-65432', 16);

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
(7, 'Nhà xe A', '123 Đường 1, Hà Nội', 12345678, 'nhaxeAC@example.com'),
(8, 'Phuong trang', 'VJTI, Matunga, Mumbai, Maharashtra', 123731293, 'test@gmail.com');

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
(72, 'Hà Nội'),
(73, 'Quảng Ninh'),
(74, 'Ninh Bình ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `id_trip` int(11) NOT NULL,
  `name_location` text NOT NULL,
  `time` time NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `route`
--

CREATE TABLE `route` (
  `id_route` int(11) NOT NULL,
  `id_c_house` int(11) NOT NULL,
  `id_city_from` int(11) NOT NULL,
  `id_city_to` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT curdate(),
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `route`
--

INSERT INTO `route` (`id_route`, `id_c_house`, `id_city_from`, `id_city_to`, `date`, `price`) VALUES
(62, 7, 72, 72, '2025-02-04', 100000),
(63, 7, 72, 73, '2025-02-04', 200000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_trip` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `number_seat` int(11) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `status` int(11) NOT NULL,
  `method` int(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trip`
--

CREATE TABLE `trip` (
  `id_trip` int(11) NOT NULL,
  `id_route` int(11) NOT NULL,
  `id_c_house` int(11) NOT NULL,
  `id_car` int(11) NOT NULL,
  `t_pick` time NOT NULL,
  `t_drop` time NOT NULL,
  `t_limit` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL
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
  ADD PRIMARY KEY (`id_c_house`),
  ADD KEY `id_c_house` (`id_c_house`);

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
-- Chỉ mục cho bảng `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id_route`),
  ADD KEY `id_city` (`id_city_from`),
  ADD KEY `id_city_to` (`id_city_to`),
  ADD KEY `id_c_house` (`id_c_house`);

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
  ADD UNIQUE KEY `id_trip` (`id_route`,`id_c_house`,`id_car`),
  ADD KEY `id_car` (`id_car`),
  ADD KEY `id_c_house` (`id_c_house`);

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
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT cho bảng `car`
--
ALTER TABLE `car`
  MODIFY `id_car` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `car_house`
--
ALTER TABLE `car_house`
  MODIFY `id_c_house` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `city`
--
ALTER TABLE `city`
  MODIFY `id_city` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT cho bảng `location`
--
ALTER TABLE `location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `route`
--
ALTER TABLE `route`
  MODIFY `id_route` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `location_trip` FOREIGN KEY (`id_trip`) REFERENCES `route` (`id_route`);

--
-- Các ràng buộc cho bảng `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `route_ibfk_3` FOREIGN KEY (`id_city_from`) REFERENCES `city` (`id_city`),
  ADD CONSTRAINT `route_ibfk_4` FOREIGN KEY (`id_city_to`) REFERENCES `city` (`id_city`),
  ADD CONSTRAINT `route_ibfk_5` FOREIGN KEY (`id_c_house`) REFERENCES `car_house` (`id_c_house`);

--
-- Các ràng buộc cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_trip`) REFERENCES `trip` (`id_trip`);

--
-- Các ràng buộc cho bảng `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `trip_ibfk_1` FOREIGN KEY (`id_car`) REFERENCES `car` (`id_car`),
  ADD CONSTRAINT `trip_ibfk_2` FOREIGN KEY (`id_route`) REFERENCES `route` (`id_route`),
  ADD CONSTRAINT `trip_ibfk_3` FOREIGN KEY (`id_c_house`) REFERENCES `car_house` (`id_c_house`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `ticket` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
