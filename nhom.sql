-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th1 17, 2026 lúc 11:35 PM
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
-- Cơ sở dữ liệu: `nhom`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`) VALUES
(1, 1, '2025-12-22 04:12:53'),
(2, 2, '2025-12-22 04:39:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`) VALUES
(30, 2, 4026, 2),
(31, 2, 4025, 1),
(32, 2, 4002, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Máy tính'),
(2, 'Tủ Lạnh'),
(3, 'Máy ảnh'),
(4, 'Thể thao'),
(5, 'Biệt thự'),
(20, 'TV'),
(22, 'test');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhasanxuat`
--

CREATE TABLE `nhasanxuat` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhasanxuat`
--

INSERT INTO `nhasanxuat` (`id`, `name`, `description`) VALUES
(2, 'An', 'Lee Wang An'),
(3, 'Minh', 'Minh tồ'),
(4, 'Cường', 'Tiểu Cường'),
(5, 'Tuấn Anh', 'Em rank vàng'),
(809, 'Tấn', '64645');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','paid','shipping','completed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`) VALUES
(2, 2, 1200000.00, 'shipping', '2025-12-05 14:30:00'),
(5, 2, 1800000.00, 'cancelled', '2025-12-10 11:00:00'),
(6, 1, 123141.00, 'pending', '2026-01-17 16:25:56'),
(7, 1, 7750000.00, 'pending', '2026-01-18 01:07:01'),
(8, 1, 31999999.00, 'paid', '2026-01-18 01:07:53'),
(9, 1, 1250000.00, 'shipping', '2026-01-18 01:15:39'),
(10, 2, 450000.00, 'pending', '2026-01-18 01:17:51'),
(11, 1, 1250001.00, 'pending', '2026-01-17 19:31:11'),
(12, 1, 1250000.00, 'pending', '2026-01-18 03:16:07'),
(13, 2, 31999999.00, 'pending', '2026-01-18 03:24:22'),
(14, 2, 1250000.00, 'paid', '2026-01-18 03:24:51'),
(15, 1, 6500000.00, 'pending', '2026-01-18 03:38:37'),
(16, 2, 13360000.00, 'shipping', '2026-01-18 03:43:38'),
(17, 2, 1250000.00, 'paid', '2026-01-18 04:02:28'),
(18, 1, 720000.00, 'pending', '2026-01-18 05:07:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(3, 2, 4007, 2, 600000.00),
(9, 7, 1004, 1, 1250000.00),
(10, 7, 1005, 1, 6500000.00),
(11, 8, 4024, 1, 31999999.00),
(12, 9, 1004, 1, 1250000.00),
(13, 10, 1003, 1, 450000.00),
(14, 11, 1004, 1, 1250000.00),
(16, 12, 1004, 1, 1250000.00),
(17, 13, 4024, 1, 31999999.00),
(18, 14, 1004, 1, 1250000.00),
(19, 15, 1005, 1, 6500000.00),
(20, 16, 4001, 4, 90000.00),
(21, 16, 1005, 2, 6500000.00),
(22, 17, 1004, 1, 1250000.00),
(23, 18, 4007, 1, 600000.00),
(24, 18, 4006, 1, 120000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` enum('cod','banking','momo','vnpay') DEFAULT NULL,
  `payment_status` enum('pending','success','failed') DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `payment_status`, `paid_at`) VALUES
(1, 6, 'banking', 'pending', '2026-01-17 16:25:56'),
(2, 11, 'cod', 'pending', '2026-01-17 19:31:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `description`, `image`, `manufacturer_id`, `category_id`) VALUES
(1003, 'Chuột không dây Logitech', 450000.00, 49, 'Kết nối Wireless, độ nhạy cao', 'wireless_mouse.jpg', NULL, 1),
(1004, 'Bàn phím cơ AKKO 306', 1250000.00, 56, 'Switch gõ êm, đèn LED RGB', '1768687465_696c076994173.jpg', 809, 1),
(1005, 'Màn hình Dell UltraSharp', 6500000.00, 564, 'Độ phân giải 2K, màu sắc chuẩn đồ họa', 'monitor_test.jpg', NULL, 1),
(1006, 'Ổ cứng SSD Samsung 500GB', 1100000.00, 768, 'Tốc độ đọc ghi cực nhanh', 'ssd_test.jpg', NULL, 1),
(4001, 'Quần thể thao Nam', 90000.00, 49, 'quần thể thao XL', 'pant_test.jpg', NULL, 4),
(4002, 'Áo thể thao XL màu trắng', 90000.00, 776, 'là áo thể thao ......', 'shirt_test.jpg', NULL, 4),
(4003, 'Áo khoác gió nhẹ', 150000.00, 49, 'Chống nắng và cản gió hiệu quả', 'coat_test.jpg', NULL, 4),
(4004, 'Tất thể thao cổ ngắn', 25000.00, 56, 'Combo 3 đôi tất cotton cao cấp', 'sock_test.jpg', 4, 4),
(4005, 'Băng bảo vệ cổ tay', 45000.00, 564, 'Hỗ trợ bảo vệ khớp khi nâng tạ', 'protect_wrist_test.jpg', NULL, 4),
(4006, 'Bình nước thể thao 1L', 120000.00, 768, 'Nhựa BPA Free an toàn', 'water_test.jpg', NULL, 4),
(4007, 'Thảm tập Yoga cao cấp', 600000.00, 76, 'Độ bám cao, chất liệu TPE', 'carpet_test.jpg', NULL, 4),
(4023, 'Tủ lạnh LG', 10000000.00, 22, '1 cái tủ lạnh', '1766522938_17686b8b.jpg', 2, 2),
(4024, 'Tủ lạnh Hitachi', 31999999.00, 312, 'vẫn là tủ lạnh nhưng màu đen', '1766523002_2b77d7aa.jpg', 2, 2),
(4025, 'Canon EOS R10 Kit', 1012830178.00, 23, '1 cái máy ảnh khá là đắt', '1766523106_f4c9fd78.png', 2, 3),
(4026, 'Sony Alpha a6400 kit', 100000.00, 1231, 'rẻ', '1766523161_8f6bf6a5.jpg', 2, 3),
(4027, 'Nhà của Tấn', 9999999999.00, 1, 'hẳn 1 cái biệt thự', '1766523350_d34110d6.jpg', NULL, 5),
(4036, 'tivi', 100000000.00, 1, 'hjnkml,', '1768687356_696c06fc89dbe.jpg', 809, 20),
(4041, 'adfasF', 1200000.00, 4, 'SADRFd', '1768687380_696c07144fb17.jpg', 5, 22),
(4043, 'Ư42132', 12321.00, 44, 'AEG AFHD', '1768684277_696bfaf5b8705.jpg', 4, 22),
(4044, 'RTRETREY', 3453453464.00, 1, 'ÉDFSFTGSE', '1768684321_696bfb211cf08.jpg', 2, 22),
(4045, '124dsdasfa', 31412413.00, 2121, 'qAZrfer', '1768684341_696bfb350a696.jpg', 3, 22),
(4046, 'DFJASFHA', 1234.00, 12, 'QẮDeas', '1768685109_696bfe35f0ec4.jpg', 809, 22),
(4047, 'aeAWSafa', 454.00, 343, 'eDRdfd', '1768685127_696bfe47050ba.jpg', 4, 22),
(4048, '4 rf TJNhb', 24232.00, 121, 'Rrfsyguj', '1768687331_696c06e30b7a1.jpg', 809, 22);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(300) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `username`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(21, 1, 'admin', 1005, 5, '5et7usrt', '2026-01-15 22:08:43'),
(28, 2, 'An', 4023, 5, '4154656', '2026-01-18 01:17:56'),
(30, 1, 'admin', 1004, 5, '5641651', '2026-01-18 02:42:33'),
(31, 1, 'admin', 1004, 5, '897456213', '2026-01-18 02:42:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `phone`, `role`) VALUES
(1, 'admin', '22', 'h36661239@gmail.com', '61546', 'admin'),
(2, 'An', '12345678', 'an5@gmail.com', '123456789', 'customer'),
(10, 'Minh', '1', 'gtyuhghbyu@gmail.com', NULL, 'customer');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Chỉ mục cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=810;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4050;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `nhasanxuat` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
