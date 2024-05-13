-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 02, 2023 lúc 07:56 AM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `vegetable_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bid`
--

CREATE TABLE `bid` (
  `bid_id` int(11) NOT NULL,
  `product_bid_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid_price` varchar(255) NOT NULL,
  `bid_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bid`
--

INSERT INTO `bid` (`bid_id`, `product_bid_id`, `user_id`, `bid_price`, `bid_time`) VALUES
(55, 28, 21, '301', '2023-10-19 02:52:50'),
(56, 29, 21, '101', '2023-10-19 03:03:18'),
(58, 30, 21, '101', '2023-10-19 03:10:40'),
(59, 30, 20, '201', '2023-10-19 03:10:51'),
(60, 30, 21, '301', '2023-10-19 03:10:59'),
(61, 31, 21, '201', '2023-10-19 03:12:44'),
(62, 32, 21, '101', '2023-10-19 03:17:54'),
(63, 33, 21, '201', '2023-10-19 03:27:10'),
(65, 33, 21, '401', '2023-10-19 03:36:47'),
(66, 33, 20, '601', '2023-10-19 03:36:57'),
(67, 33, 21, '701', '2023-10-19 03:37:55'),
(68, 33, 20, '801', '2023-10-19 03:38:02'),
(69, 34, 21, '101', '2023-10-19 03:39:45'),
(70, 34, 20, '301', '2023-10-19 03:39:53'),
(71, 35, 21, '101', '2023-10-19 03:41:22'),
(72, 35, 20, '301', '2023-10-19 03:41:32'),
(73, 35, 21, '501', '2023-10-19 03:41:36'),
(74, 35, 21, '601', '2023-10-19 03:42:37'),
(75, 35, 20, '801', '2023-10-19 03:42:57'),
(76, 36, 21, '200', '2023-10-19 03:45:00'),
(77, 36, 20, '300', '2023-10-19 03:45:19'),
(78, 36, 21, '400', '2023-10-19 03:45:26'),
(79, 37, 21, '200', '2023-10-19 03:48:34'),
(80, 37, 20, '400', '2023-10-19 03:48:46'),
(82, 37, 20, '500', '2023-10-19 04:04:03'),
(91, 27, 20, '2100', '2023-10-19 04:31:17'),
(94, 38, 20, '200', '2023-10-19 04:38:37'),
(95, 38, 21, '400', '2023-10-19 04:38:59'),
(96, 38, 20, '500', '2023-10-19 04:39:19'),
(97, 38, 21, '600', '2023-10-19 04:41:24'),
(98, 38, 20, '800', '2023-10-19 04:44:00'),
(99, 39, 20, '300', '2023-10-19 04:46:25'),
(100, 39, 30, '400', '2023-10-19 04:46:32'),
(101, 39, 20, '500', '2023-10-19 04:58:54'),
(102, 39, 30, '600', '2023-10-19 04:59:08'),
(103, 39, 20, '700', '2023-10-19 05:03:16'),
(104, 39, 30, '800', '2023-10-19 05:03:32'),
(105, 39, 21, '1000', '2023-10-19 05:08:14'),
(106, 39, 21, '1200', '2023-10-19 05:09:58'),
(107, 39, 20, '1300', '2023-10-19 05:13:05'),
(108, 39, 30, '1400', '2023-10-19 05:13:14'),
(109, 39, 20, '1500', '2023-10-19 05:13:23'),
(110, 39, 21, '1700', '2023-10-19 05:13:32'),
(111, 40, 30, '300', '2023-10-19 05:18:57'),
(112, 40, 20, '700', '2023-10-19 05:19:40'),
(113, 41, 30, '300', '2023-10-19 05:22:58'),
(114, 41, 20, '400', '2023-10-19 05:23:02'),
(115, 41, 30, '700', '2023-10-19 05:23:08'),
(116, 41, 20, '900', '2023-10-19 05:23:13'),
(117, 42, 20, '300', '2023-10-19 05:24:58'),
(118, 42, 30, '400', '2023-10-19 05:25:00'),
(119, 43, 30, '101', '2023-10-19 05:31:07'),
(120, 43, 20, '201', '2023-10-19 05:31:19'),
(121, 43, 30, '301', '2023-10-19 05:39:04'),
(122, 43, 20, '401', '2023-10-19 05:39:09'),
(123, 43, 30, '501', '2023-10-19 05:39:34'),
(124, 43, 20, '601', '2023-10-19 05:40:53'),
(125, 43, 30, '801', '2023-10-19 05:42:13'),
(126, 43, 20, '1101', '2023-10-19 05:45:16'),
(127, 43, 30, '1301', '2023-10-19 05:47:06'),
(128, 43, 20, '1401', '2023-10-19 05:48:58'),
(129, 43, 20, '1501', '2023-10-19 05:59:17'),
(130, 43, 30, '1601', '2023-10-19 06:01:47'),
(131, 43, 30, '1701', '2023-10-19 06:07:53'),
(132, 43, 30, '1801', '2023-10-19 06:10:48'),
(151, 50, 1, '200', '2023-10-22 03:05:42'),
(152, 50, 21, '300', '2023-10-22 03:09:26'),
(153, 50, 21, '500', '2023-10-22 03:11:38'),
(154, 50, 21, '600', '2023-10-22 03:13:15'),
(173, 99, 21, '1098', '2023-11-09 07:59:10'),
(180, 114, 30, '12100', '2023-12-01 02:52:40'),
(181, 114, 30, '12300', '2023-12-01 02:52:42'),
(182, 114, 30, '13100', '2023-12-01 02:53:04'),
(183, 115, 30, '22800', '2023-12-01 03:02:06'),
(184, 115, 30, '23200', '2023-12-01 03:02:10'),
(185, 115, 30, '23600', '2023-12-01 03:02:13'),
(186, 115, 30, '23700', '2023-12-01 03:02:15'),
(187, 115, 30, '24100', '2023-12-01 03:02:17'),
(188, 115, 30, '24200', '2023-12-01 03:02:18'),
(189, 115, 30, '24700', '2023-12-01 03:02:19'),
(190, 115, 30, '24800', '2023-12-01 03:02:49'),
(191, 115, 30, '25000', '2023-12-01 03:02:53');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `business`
--

CREATE TABLE `business` (
  `business_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `city_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tax_code` varchar(13) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `money` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `business`
--

INSERT INTO `business` (`business_id`, `user_id`, `city_address`, `district_address`, `address`, `phone`, `email_address`, `tax_code`, `money`) VALUES
(1, 1, 'Bạc Liêu', 'Phuớc Long', 'Bạc Liêu', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '1124141245124', '103800'),
(2, 20, 'Bạc Liêu', 'Phước Long', 'Bạc Liêu', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '1331111112212', '423'),
(9, 21, 'Bạc Liêu', 'Phước Long', 'Bạc Liêu', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '1124141245124', '6600'),
(10, 30, 'Cần Thơ', 'Ninh Kiều', '12A', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '1234567891211', '1200'),
(11, 31, 'HCM', 'Quận 12', '21C', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '1234537891233', '10412'),
(14, 33, 'Bạc Liêu', 'Phước Long', 'Bạc Liêu', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '1312321411211', '12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity_of_products` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(14, 'Rau xà lách'),
(17, 'Trái cây tươi'),
(18, 'Hạt gia vị'),
(19, 'Củ'),
(20, 'Khoai'),
(21, 'Sản Phẩm Khô');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `deposit`
--

CREATE TABLE `deposit` (
  `deposit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_bid_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `deposit`
--

INSERT INTO `deposit` (`deposit_id`, `user_id`, `product_bid_id`) VALUES
(17, 1, 26),
(18, 21, 3),
(19, 21, 24),
(20, 1, 25),
(21, 21, 26),
(22, 1, 3),
(23, 1, 84),
(24, 1, 85),
(25, 30, 86),
(26, 31, 86),
(27, 1, 87),
(28, 30, 87),
(29, 30, 90),
(30, 30, 91),
(31, 30, 93),
(32, 30, 94),
(33, 30, 97),
(34, 30, 101),
(35, 30, 102),
(36, 21, 99),
(37, 31, 103),
(38, 31, 104),
(39, 30, 104),
(40, 1, 99),
(41, 30, 99),
(42, 1, 106),
(43, 30, 114),
(44, 30, 115);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `order_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cart_total` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date_ordered` date NOT NULL DEFAULT current_timestamp(),
  `role` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `order_name`, `user_id`, `address`, `city_address`, `district_address`, `phone`, `email_address`, `cart_total`, `date_ordered`, `role`) VALUES
(43, 'Khuyen', 30, 'Bạc Liêu', 'Bạc Liêu', 'Phuớc Long', '+8494956012', 'trungkhuyenplbl0931@gmail.com', '3008', '2023-07-12', 2),
(47, 'Khuyen', 21, 'Bạc Liêu', 'bac liêu', 'Phuớc Long', '+8494956012', 'khuyenb1910534@student.ctu.edu.vn', '772', '2023-10-11', 3),
(48, 'Khuyen', 46, 'Bạc Liêu', 'bac liêu', 'Phuớc Long', '+8494956012', 'khuyenb1910534@student.ctu.edu.vn', '468', '2023-09-13', 1),
(49, 'Khuyen', 1, 'Bạc Liêu', 'bac liêu', 'Phuớc Long', '+8494956012', 'khuyenb1910534@student.ctu.edu.vn', '73', '2023-08-16', 1),
(50, 'Khuyen', 1, 'Bạc Liêu', 'bac liêu', 'Phuớc Long', '+8494956012', 'khuyenb1910534@student.ctu.edu.vn', '23', '2023-11-17', 1),
(51, 'Khuyen', 1, 'Bạc Liêu', 'bac liêu', 'Phuớc Long', '+8494956012', 'khuyenb1910534@student.ctu.edu.vn', '2000', '2023-11-17', 1),
(52, 'Khuyen', 44, 'a1', 'Cần Thơ', 'Ni', '94127832173', 'trungkhuyenplbl0931@gmail.com', '514', '2023-11-24', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ordered_products`
--

CREATE TABLE `ordered_products` (
  `ordered_product_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity_of_products` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ordered_products`
--

INSERT INTO `ordered_products` (`ordered_product_id`, `product_id`, `order_id`, `quantity_of_products`) VALUES
(28, 55, 43, '4'),
(29, 47, 43, '12'),
(30, 47, 47, '3.3'),
(31, 47, 48, '2'),
(32, 51, 49, '3.2'),
(33, 52, 50, '1'),
(34, 55, 51, '40'),
(35, 47, 52, '2'),
(36, 52, 52, '2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `content`, `price`, `image`, `warehouse_id`, `category_id`) VALUES
(47, 'Táo', 'táo', '42', 'product-10.jpg', 2, 17),
(51, 'Tỏi', 'Tỏi nhập khẩu từ Trung Quốc', '23', '1698220056product-11.jpg', 13, 19),
(52, 'Bắp Cải Tím', 'Bắp cải nhập khẩu từ Hàn Quốc', '23', '1698220116product-4.jpg', 7, 14),
(53, 'Hành Tây Tím', 'Hành tây Tím là một nguyên liệu phổ biến trong nhiều món ăn, từ súp, nước sốt, món nướng, món xào, đến salad và bánh mì sandwich. Hành tây cũng thường được dùng để làm gia vị và thêm hương vị vào các món ăn.', '23', '1698220349product-9.jpg', 17, 19),
(54, 'Súp Lơ Xanh', 'Súp Lơ Xanh Nhật Bản', '21', '1698220398product-6.jpg', 14, 14),
(55, 'Dâu Tây', 'Dâu tây thường có mùi hương ngọt ngào và thơm ngon, đặc biệt khi chín đủ.', '50', '1698220433product-2.jpg', 15, 17),
(56, 'Cà Chua', 'Cà chua là một nguyên liệu quan trọng trong nhiều món ăn, bao gồm xào, nấu súp, làm nước sốt, chế biến thành mứt, hoặc ăn trực tiếp tươi ngon. Nó cũng thường được sử dụng trong sandwich, pizza, salad, và một loạt các món khác nhau. Cà chua có giá trị dinh dưỡng cao, chứa nhiều vitamin và khoáng chất, đặc biệt là vitamin C và lycopene, có lợi cho sức khỏe tim mạch.', '40', '1698220458product-5.jpg', 16, 17),
(57, 'Ớt Chuông', 'Ớt chuông có hình dáng tròn hoặc hơi hình thoi, với một đỉnh nhọn và mặt dưới phẳng. Quả thường rất đẹp và đều màu, có kích thước nhỏ hơn so với nhiều loại ớt khác.', '12', '1698220501product-1.jpg', 11, 18),
(58, 'Ớt', 'Ớt cay thì thôi luôn.', '12', '1698220559product-12.jpg', 10, 19),
(60, 'Đậu Hà Lan', 'Đậu Hà Lan ở Hà Lan', '41', '1698221222photo-1622886421899-f6d9dfc878bb.png', 19, 14),
(63, 'Cà Rốt', 'Cà rốt là một loại rau có rễ phổ biến và được sử dụng rộng rãi trong nhiều món ăn trên toàn thế giới.', '43', '1698221339product-7.jpg', 12, 19),
(64, 'Chanh', 'Chanh Chua', '21', '1698221428photo-1609639643505-3c158a56de42.png', 18, 17),
(65, 'Củ Sen', 'Củ Sen Việt Nam', '70', '169822152520230425_Pyridoxine-trong-cu-sen-giu-tri-nao-phat-trien.jpg', 20, 19),
(66, 'Cà Tím', 'Cà Tím ', '53', '1698221607photo-1528826007177-f38517ce9a8a.png', 21, 17),
(69, 'Đào', 'Quả đào là một loại hoa quả đặc trưng có vị ngọt mát, thường được ưa chuộng trong mùa hè. Đào chứa nhiều chất chống ô nhiễm và chống oxy hóa, tăng cường sức khỏe da và hỗ trợ hệ tiêu hóa. ', '23', '1700879193peach.png', 145, 17),
(70, 'Dừa', 'phong phú và được ưa chuộng rộng rãi. Nước dừa giữ cơ thể mát mẻ, làm giảm nhiệt độ', '23', '1700879295coconut.png', 146, 17),
(71, 'Khoai Lang', 'Khoai lang là một loại rau củ phổ biến với nhiều lợi ích dinh dưỡng. Chúng chứa nhiều vitamin C, vitamin A, kali và chất xơ, giúp cải thiện sức khỏe tim mạch', '22', '1700879449sweetpotato.png', 147, 20),
(72, 'Bí Ngô', 'Bí ngô, một loại rau củ phổ biến, là nguồn dinh dưỡng đa dạng. Nó chứa nhiều vitamin A, C và E, cũng như chất xơ và kali', '26', '1700879565pumpkin.png', 148, 17),
(73, 'Kiwi', 'Kiwi, còn được biết đến với tên gọi khác là quả mâm xôi Trung Quốc, là một loại hoa quả chứa nhiều dưỡng chất.', '57', '1700879684kiwi.png', 149, 17),
(74, 'Quả Lê', 'Quả lê, với vị ngọt thanh và hương thơm đặc trưng, là một loại hoa quả giàu chất dinh dưỡng.', '26', '1700879753pear.png', 140, 17),
(75, 'Nho', 'Quả nho, một trong những loại trái cây phổ biến, là nguồn dinh dưỡng tuyệt vời.', '45', '1700879833grape.png', 151, 17),
(76, 'Dưa hấu', 'Dưa hấu, một loại trái cây mùa hè phổ biến, là nguồn nước giải khát tốt và cung cấp nhiều dưỡng chất.', '40', '1700880354watermelon.png', 152, 17),
(77, 'Lựu', 'Quả lựu là một loại hoa quả hấp dẫn và giàu chất dinh dưỡng', '26', '1700880488Pomegranate.png', 153, 17),
(78, 'Chuối', 'Chuối, một loại trái cây phổ biến, là nguồn năng lượng và dưỡng chất quan trọng.', '35', '1700881389banana.png', 154, 17),
(79, 'Chôm chôm', ' Chôm chôm là loại hoa quả mát lạnh, giàu vitamin, chất xơ.', '24', '1700881707rambutan.png', 155, 17),
(80, 'Mít', ' Mít là một loại hoa quả giàu chất dinh dưỡng.', '26', '1700881822jackfruit.png', 156, 17),
(81, 'Chuối sấy', 'Chuối sấy', '26', '1700881898chuoi-say-kho-gion-ngot.jpg', 163, 21),
(82, 'Mít sấy', 'Mít sấy thơm ngon', '32', '1700881977mit-1.jpg', 162, 21),
(83, 'Táo', 'táo', '42', 'product-10.jpg', 2, 17),
(85, 'Táo', 'táo', '42', 'product-10.jpg', 2, 17),
(86, 'Tỏi', 'Tỏi nhập khẩu từ Trung Quốc', '23', '1698220056product-11.jpg', 13, 19),
(87, 'Bắp Cải Tím', 'Bắp cải nhập khẩu từ Hàn Quốc', '23', '1698220116product-4.jpg', 7, 14),
(88, 'Hành Tây Tím', 'Hành tây Tím là một nguyên liệu phổ biến trong nhiều món ăn, từ súp, nước sốt, món nướng, món xào, đến salad và bánh mì sandwich. Hành tây cũng thường được dùng để làm gia vị và thêm hương vị vào các món ăn.', '23', '1698220349product-9.jpg', 17, 19),
(89, 'Súp Lơ Xanh', 'Súp Lơ Xanh Nhật Bản', '21', '1698220398product-6.jpg', 14, 14),
(90, 'Dâu Tây', 'Dâu tây thường có mùi hương ngọt ngào và thơm ngon, đặc biệt khi chín đủ.', '50', '1698220433product-2.jpg', 15, 17),
(91, 'Cà Chua', 'Cà chua là một nguyên liệu quan trọng trong nhiều món ăn, bao gồm xào, nấu súp, làm nước sốt, chế biến thành mứt, hoặc ăn trực tiếp tươi ngon. Nó cũng thường được sử dụng trong sandwich, pizza, salad, và một loạt các món khác nhau. Cà chua có giá trị dinh dưỡng cao, chứa nhiều vitamin và khoáng chất, đặc biệt là vitamin C và lycopene, có lợi cho sức khỏe tim mạch.', '40', '1698220458product-5.jpg', 16, 17),
(92, 'Ớt Chuông', 'Ớt chuông có hình dáng tròn hoặc hơi hình thoi, với một đỉnh nhọn và mặt dưới phẳng. Quả thường rất đẹp và đều màu, có kích thước nhỏ hơn so với nhiều loại ớt khác.', '12', '1698220501product-1.jpg', 11, 18),
(93, 'Ớt', 'Ớt cay thì thôi luôn.', '12', '1698220559product-12.jpg', 10, 19),
(94, 'Đậu Hà Lan', 'Đậu Hà Lan ở Hà Lan', '41', '1698221222photo-1622886421899-f6d9dfc878bb.png', 19, 14),
(95, 'Cà Rốt', 'Cà rốt là một loại rau có rễ phổ biến và được sử dụng rộng rãi trong nhiều món ăn trên toàn thế giới.', '43', '1698221339product-7.jpg', 12, 19),
(96, 'Chanh', 'Chanh Chua', '21', '1698221428photo-1609639643505-3c158a56de42.png', 18, 17),
(97, 'Củ Sen', 'Củ Sen Việt Nam', '70', '169822152520230425_Pyridoxine-trong-cu-sen-giu-tri-nao-phat-trien.jpg', 20, 19),
(98, 'Đào', 'Quả đào là một loại hoa quả đặc trưng có vị ngọt mát, thường được ưa chuộng trong mùa hè. Đào chứa nhiều chất chống ô nhiễm và chống oxy hóa, tăng cường sức khỏe da và hỗ trợ hệ tiêu hóa. ', '23', '1700879193peach.png', 145, 17),
(99, 'Dừa', 'phong phú và được ưa chuộng rộng rãi. Nước dừa giữ cơ thể mát mẻ, làm giảm nhiệt độ', '23', '1700879295coconut.png', 146, 17),
(100, 'Khoai Lang', 'Khoai lang là một loại rau củ phổ biến với nhiều lợi ích dinh dưỡng. Chúng chứa nhiều vitamin C, vitamin A, kali và chất xơ, giúp cải thiện sức khỏe tim mạch', '22', '1700879449sweetpotato.png', 147, 20),
(101, 'Bí Ngô', 'Bí ngô, một loại rau củ phổ biến, là nguồn dinh dưỡng đa dạng. Nó chứa nhiều vitamin A, C và E, cũng như chất xơ và kali', '26', '1700879565pumpkin.png', 148, 17),
(102, 'Kiwi', 'Kiwi, còn được biết đến với tên gọi khác là quả mâm xôi Trung Quốc, là một loại hoa quả chứa nhiều dưỡng chất.', '57', '1700879684kiwi.png', 149, 17),
(103, 'Quả Lê', 'Quả lê, với vị ngọt thanh và hương thơm đặc trưng, là một loại hoa quả giàu chất dinh dưỡng.', '26', '1700879753pear.png', 140, 17),
(104, 'Nho', 'Quả nho, một trong những loại trái cây phổ biến, là nguồn dinh dưỡng tuyệt vời.', '45', '1700879833grape.png', 151, 17),
(105, 'Dưa hấu', 'Dưa hấu, một loại trái cây mùa hè phổ biến, là nguồn nước giải khát tốt và cung cấp nhiều dưỡng chất.', '40', '1700880354watermelon.png', 152, 17),
(106, 'Lựu', 'Quả lựu là một loại hoa quả hấp dẫn và giàu chất dinh dưỡng', '26', '1700880488Pomegranate.png', 153, 17),
(107, 'Chuối', 'Chuối, một loại trái cây phổ biến, là nguồn năng lượng và dưỡng chất quan trọng.', '35', '1700881389banana.png', 154, 17),
(108, 'Chôm chôm', ' Chôm chôm là loại hoa quả mát lạnh, giàu vitamin, chất xơ.', '24', '1700881707rambutan.png', 155, 17),
(109, 'Mít', ' Mít là một loại hoa quả giàu chất dinh dưỡng.', '26', '1700881822jackfruit.png', 156, 17),
(110, 'Chuối sấy', 'Chuối sấy', '26', '1700881898chuoi-say-kho-gion-ngot.jpg', 163, 21),
(111, 'Mít sấy', 'Mít sấy thơm ngon', '32', '1700881977mit-1.jpg', 162, 21),
(112, 'Cà Tím', 'Cà Tím ', '53', '1698221607photo-1528826007177-f38517ce9a8a.png', 21, 17),
(113, 'Tỏi', 'Tỏi nhập khẩu từ Trung Quốc', '23', '1698220056product-11.jpg', 13, 19),
(114, 'Bắp Cải Tím', 'Bắp cải nhập khẩu từ Hàn Quốc', '23', '1698220116product-4.jpg', 7, 14),
(115, 'Hành Tây Tím', 'Hành tây Tím là một nguyên liệu phổ biến trong nhiều món ăn, từ súp, nước sốt, món nướng, món xào, đến salad và bánh mì sandwich. Hành tây cũng thường được dùng để làm gia vị và thêm hương vị vào các món ăn.', '23', '1698220349product-9.jpg', 17, 19),
(116, 'Súp Lơ Xanh', 'Súp Lơ Xanh Nhật Bản', '21', '1698220398product-6.jpg', 14, 14),
(117, 'Dâu Tây', 'Dâu tây thường có mùi hương ngọt ngào và thơm ngon, đặc biệt khi chín đủ.', '50', '1698220433product-2.jpg', 15, 17),
(118, 'Ớt', 'Ớt cay thì thôi luôn.', '12', '1698220559product-12.jpg', 10, 19),
(119, 'Ớt Chuông', 'Ớt chuông có hình dáng tròn hoặc hơi hình thoi, với một đỉnh nhọn và mặt dưới phẳng. Quả thường rất đẹp và đều màu, có kích thước nhỏ hơn so với nhiều loại ớt khác.', '12', '1698220501product-1.jpg', 11, 18),
(120, 'Cà Chua', 'Cà chua là một nguyên liệu quan trọng trong nhiều món ăn, bao gồm xào, nấu súp, làm nước sốt, chế biến thành mứt, hoặc ăn trực tiếp tươi ngon. Nó cũng thường được sử dụng trong sandwich, pizza, salad, và một loạt các món khác nhau. Cà chua có giá trị dinh dưỡng cao, chứa nhiều vitamin và khoáng chất, đặc biệt là vitamin C và lycopene, có lợi cho sức khỏe tim mạch.', '40', '1698220458product-5.jpg', 16, 17),
(121, 'Táo', 'táo', '42', 'product-10.jpg', 2, 17);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_bid`
--

CREATE TABLE `product_bid` (
  `product_bid_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `warehouse_bid_id` int(11) NOT NULL,
  `product_bid_name` varchar(255) NOT NULL,
  `product_bid_image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_bid_description` text DEFAULT NULL,
  `start_price` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `current_price` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `end_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `real_end_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `winner_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_bid`
--

INSERT INTO `product_bid` (`product_bid_id`, `user_id`, `warehouse_bid_id`, `product_bid_name`, `product_bid_image`, `product_bid_description`, `start_price`, `current_price`, `end_time`, `real_end_time`, `is_active`, `winner_id`) VALUES
(106, 1, 8, 'Một Tấn Đào', '1700882422_peach.png', 'Một Tấn Đào Từ Thái Lan', '24000', '24000', '2025-06-25 03:20:00', '2025-06-25 03:20:00', 1, 0),
(107, 1, 5, 'Một Tấn Chuối', '1700882643_banana.png', 'Một Tấn Chuối từ Trung Quốc', '22000', '22000', '2024-05-25 03:23:00', '2024-05-25 03:23:00', 1, 0),
(108, 1, 6, 'Một Tấn Dưa Hấu', '1700882706_watermelon.png', 'Một Tấn Dưa Hấu từ Nhật', '13000', '13000', '2026-01-25 03:24:00', '2026-01-25 03:24:00', 1, 0),
(109, 1, 7, 'Một Tấn Dừa', '1700882794_coconut.png', 'Một Tấn Dừa từ Hàn', '14500', '14500', '2024-10-25 03:26:00', '2024-10-25 03:26:00', 1, 0),
(110, 1, 11, 'Một Tấn Chanh', '1700883096_photo-1609639643505-3c158a56de42.png', 'Một Tấn Chanh từ Hàn', '10000', '10000', '2024-09-25 03:31:00', '2024-09-25 03:31:00', 1, 0),
(111, 1, 10, 'Ba Tấn Kiwi', '1700883214_kiwi.png', 'Một Tấn Kiwi', '25000', '25000', '2024-09-25 03:33:00', '2024-09-25 03:33:00', 1, 0),
(112, 1, 9, 'Hai Tấn Nho', '1700883263_grape.png', 'Hai Tấn Nho từ Campuchia', '24000', '24000', '2025-06-25 03:33:00', '2025-06-25 03:33:00', 1, 0),
(113, 1, 13, 'Một Tấn Lựu', '1700883406_Pomegranate.png', 'Một Tấn Lựu', '11000', '11000', '2024-09-25 03:36:00', '2024-09-25 03:36:00', 1, 0),
(114, 1, 14, 'Một Tấn Dâu Tây', '1701399151_category-2.jpg', 'Một Tấn Dâu Tây', '12000', '13100', '2023-12-01 02:54:24', '2023-12-01 02:54:00', 3, 30),
(115, 1, 15, 'Ba Tấn Thanh Long', '1701399712_thanhlong.png', 'Ba Tấn Thanh Long', '22000', '25000', '2023-07-05 03:03:06', '2023-07-05 03:03:12', 3, 30);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `supplier_tax` varchar(13) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `agent` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_tax`, `agent`) VALUES
(1, 'Công Ti Nông Sản A', '123421424214', 'Nguyễn Văn A'),
(3, 'Công Ti Nông Sản B', '123421424214', 'Nguyễn Văn B'),
(4, 'Công Ti Nông Sản C', '512421424214', 'Nguyễn Văn C'),
(5, 'Công Ti Nông Sản D', '7682421424214', 'Nguyễn Văn D');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `fullname`, `role`) VALUES
(1, 'admin', '$2y$10$t6M4g9JLemRmT8nY7v7jRO7VEawbjOfPYZR7AQ.qMchw1xXCmA1Oy', 'Công Ty Farmbid', 0),
(20, 'b1910534', '$2y$10$/dzR9zmeCk/Wx3G5DdZ3lOLBhv3V/oXSXqTNGbvsUaixemTQ3Jb3y', 'Khuyến Huỳnh', 1),
(21, 'user123', '$2y$10$lia5w42QzkNG2BSiwcfdT.ETJ5tpCStI3ZxPnWy11RjyL/jpFzMhm', 'Công ty 1', 1),
(30, 'congty1', '$2y$10$rkvdFBT5R7EETf2xZLvhOeiJAIGKXWwjSikCxpypowbkBSw0u4/iu', 'Công Ty A', 1),
(31, 'congty2', '$2y$10$it2Rgy4HtHudw/vsO3d6HuQHTLAhxDXOvSly1/VWFw3bJPu/znZai', 'Công Ty B', 1),
(33, 'congty3', '$2y$10$wt82owbk034l78BBqi3nHuJgT8ulE2cGhelCJx4QtcziHMsLfZHPe', 'Công Ty C', 1),
(44, 'b19105341', '$2y$10$k81U2cEGgQp6yaJgsj.eOe3AN4j4JwRhcfXiJ.BgnAGgfaQ/fRPm6', 'Huỳnh Trung Khuyến', 2),
(45, 'sinhvienit123', '$2y$10$jT0afYO0g.9xZH6CNZrbMeHiimWl4eikKq4xqJis6OyLfqbicjPIa', 'sinhvienCNTT', 2),
(46, 'userb1910534', '$2y$10$zpKjEgME48sMYugAgrwlHO0lsKAMEN6MWxtZF0LMnm0VRURLUuxY6', 'SinhVienIT', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `warehouse`
--

CREATE TABLE `warehouse` (
  `warehouse_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `imported_product_name` varchar(255) NOT NULL,
  `purchase_price` varchar(255) NOT NULL,
  `seri_number` varchar(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `input_day` date NOT NULL,
  `expired_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `warehouse`
--

INSERT INTO `warehouse` (`warehouse_id`, `supplier_id`, `imported_product_name`, `purchase_price`, `seri_number`, `quantity`, `input_day`, `expired_date`) VALUES
(2, 1, 'Táo', '11', '1231231233', '99.7', '2023-07-12', '2028-01-25'),
(7, 1, 'Bắp Cải', '22', '1231231233', '36', '2023-07-12', '2024-10-25'),
(10, 3, 'Ớt', '23', '2131231233', '712', '2023-07-05', '2024-02-26'),
(11, 3, 'Ớt Chuông', '23', '2131231233', '123', '2023-07-08', '2025-05-25'),
(12, 3, 'Cà rốt', '32', '2131231233', '213', '2023-08-16', '2024-05-25'),
(13, 4, 'Tỏi', '12', '43231256441', '119.8', '2023-08-16', '2024-10-25'),
(14, 5, 'Súp Lơ Xanh', '21', '43231256441', '124', '2023-08-16', '2024-02-25'),
(15, 5, 'Dâu Tây', '11', '6542326573', '80', '2023-08-16', '2024-10-25'),
(16, 5, 'Cà Chua', '34', '6542326573', '213', '2023-09-25', '2024-06-25'),
(17, 4, 'Hành Tây Tím', '32', '6542326573', '199', '2023-09-09', '2024-12-25'),
(18, 4, 'Chanh', '32', '6542326573', '199', '2023-09-09', '2024-10-15'),
(19, 1, 'Đậu Hà Lan', '32', '6542326573', '199', '2023-09-09', '2026-06-25'),
(20, 4, 'Củ Sen', '21', '6542326573', '49', '2023-10-25', '2024-06-25'),
(21, 5, 'Cà Tím', '21', '45124312121', '21', '2023-10-25', '2024-10-25'),
(22, 4, 'Ớt Chuông Campuchia', '20', '6542326573', '42', '2023-10-26', '2024-10-26'),
(132, 1, 'Đậu Hà Lan', '11', '6542326573', '2', '2023-10-28', '2023-10-28'),
(139, 1, 'Bắp Cải', '21', '2123', '53', '2023-11-17', '2024-10-27'),
(140, 1, 'Lê', '21', '2123', '42', '2023-11-17', '2024-10-27'),
(141, 3, 'Đậu', '21', '2123', '23', '2023-11-17', '2024-10-27'),
(145, 1, 'Đào', '21', '42351', '53', '2023-10-27', '2024-10-27'),
(146, 1, 'Dừa', '21', '42351', '42', '2023-10-27', '2024-10-27'),
(147, 3, 'Khoai lang', '21', '42351', '23', '2023-10-27', '2024-10-27'),
(148, 5, 'Bí ngô', '24', '42351', '53', '2023-10-27', '2024-10-27'),
(149, 3, 'Kiwi', '54', '42351', '42', '2023-10-27', '2024-10-27'),
(150, 4, 'Lê', '21', '42351', '23', '2023-10-27', '2024-10-27'),
(151, 1, 'Nho', '41', '42351', '23', '2023-10-27', '2024-10-27'),
(152, 3, 'Dưa hấu', '34', '42351', '53', '2023-10-27', '2024-10-27'),
(153, 4, 'Lựu', '24', '42351', '42', '2023-10-27', '2024-10-27'),
(154, 5, 'Chuối', '32', '42351', '23', '2023-10-27', '2024-10-27'),
(155, 1, 'Chôm chôm', '21', '42351', '53', '2023-10-27', '2024-10-27'),
(156, 5, 'Mít', '25', '42351', '42', '2023-10-27', '2024-10-27'),
(157, 4, 'Mận', '42', '42351', '23', '2023-10-27', '2024-10-27'),
(158, 1, 'Quả cherry', '53', '42351', '53', '2023-10-27', '2024-10-27'),
(159, 3, 'Quả sầu riêng', '42', '42351', '53', '2023-10-27', '2024-10-27'),
(160, 4, 'Nấm đùi gà', '23', '42351', '42', '2023-10-27', '2024-10-27'),
(161, 5, 'Nấm rơm', '23', '42351', '23', '2023-10-27', '2024-10-27'),
(162, 1, 'Mít Sấy', '21', '42351', '53', '2023-10-27', '2024-10-27'),
(163, 3, 'Chuối Sấy', '23', '42351', '42', '2023-10-27', '2024-10-27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `warehouse_bid`
--

CREATE TABLE `warehouse_bid` (
  `warehouse_bid_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `imported_bid_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `purchase_price` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `seri_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `quantity` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `input_day` date NOT NULL,
  `expired_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `warehouse_bid`
--

INSERT INTO `warehouse_bid` (`warehouse_bid_id`, `supplier_id`, `imported_bid_name`, `purchase_price`, `seri_number`, `quantity`, `input_day`, `expired_date`) VALUES
(5, 5, 'Một Tấn Chuối', '22000', '1231231233', '1', '2023-10-20', '2025-05-25'),
(6, 4, 'Một Tấn Dưa Hấu', '12000', '1231231233', '1', '2023-10-19', '2024-10-25'),
(7, 1, 'Một Tấn Dừa', '14000', '1231231233', '1', '2023-09-15', '2024-02-08'),
(8, 3, 'Một Tấn Đào', '24000', '2131231233', '1', '2023-08-17', '2025-10-25'),
(9, 3, 'Hai Tấn Nho', '24000', '341243123', '2', '2023-07-14', '2024-06-25'),
(10, 1, 'Ba Tấn Kiwi', '25000', '45124312121', '3', '2023-11-25', '2025-01-25'),
(11, 5, 'Một Tấn Chanh', '10000', '45124312121', '1', '2023-11-25', '2024-09-25'),
(12, 4, 'Một Tấn Xoài', '12000', '45124312121', '1', '2023-11-25', '2024-09-25'),
(13, 1, 'Một Tấn Lựu', '11000', '1231231233', '1', '2023-11-25', '2025-05-25'),
(14, 5, 'Một Tấn Dâu Tây', '11000', '1231231233', '1', '2023-09-01', '2025-05-01'),
(15, 4, '3 Tấn Thanh Long', '22000', '1231231233', '3', '2023-06-08', '2024-06-20');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`bid_id`);

--
-- Chỉ mục cho bảng `business`
--
ALTER TABLE `business`
  ADD PRIMARY KEY (`business_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`deposit_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `ordered_products`
--
ALTER TABLE `ordered_products`
  ADD PRIMARY KEY (`ordered_product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `product_bid`
--
ALTER TABLE `product_bid`
  ADD PRIMARY KEY (`product_bid_id`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`warehouse_id`);

--
-- Chỉ mục cho bảng `warehouse_bid`
--
ALTER TABLE `warehouse_bid`
  ADD PRIMARY KEY (`warehouse_bid_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bid`
--
ALTER TABLE `bid`
  MODIFY `bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT cho bảng `business`
--
ALTER TABLE `business`
  MODIFY `business_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `deposit`
--
ALTER TABLE `deposit`
  MODIFY `deposit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `ordered_products`
--
ALTER TABLE `ordered_products`
  MODIFY `ordered_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT cho bảng `product_bid`
--
ALTER TABLE `product_bid`
  MODIFY `product_bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT cho bảng `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `warehouse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT cho bảng `warehouse_bid`
--
ALTER TABLE `warehouse_bid`
  MODIFY `warehouse_bid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
