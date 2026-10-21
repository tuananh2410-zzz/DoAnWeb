-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2026 at 05:07 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tuananh`
--

-- --------------------------------------------------------

--
-- Table structure for table `danhsachchuot`
--

CREATE TABLE `danhsachchuot` (
  `id` int(11) NOT NULL,
  `ten_chuot` varchar(255) NOT NULL,
  `gia_ban` decimal(10,2) NOT NULL,
  `hinh_anh` varchar(255) NOT NULL,
  `mo_ta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `danhsachchuot`
--

INSERT INTO `danhsachchuot` (`id`, `ten_chuot`, `gia_ban`, `hinh_anh`, `mo_ta`) VALUES
(2, 'Chuột Logitech G Pro X Superlight Wireless Black', '3250000.00', 'spl1.png', 'Chuột Logitech G Pro X Superlight Wireless Black là một trong những dòng chuột gaming nhẹ nhất từ trước tới nay của Logitech, Logitech G Pro X Superlight Wireless White là bước đột phá về kỹ thuật khi đạt được trọng lượng ít hơn 63 gram – nhẹ hơn gần 25% so với chuột PRO không dây tiêu chuẩn của Logitech. '),
(3, 'Chuột Razer Không dây Viper V4 Pro Đen', '4490000.00', 'v4.png', 'Chuột Razer không dây Viper V4 Pro Đen là một trong những siêu phẩm mới nhất thuộc dòng chuột gaming cao cấp của Razer, được thiết kế chuyên biệt để đáp ứng nhu cầu nghiêm khắc của các game thủ chuyên nghiệp. Với sự kết hợp giữa trọng lượng siêu nhẹ và công nghệ cảm biến hàng đầu, thiết bị này không chỉ là một phụ kiện máy tính thông thường mà còn là \"vũ khí\" đắc lực giúp bạn làm chủ mọi cuộc chơi. Phiên bản màu đen truyền thống mang lại vẻ ngoài mạnh mẽ, tinh tế, phù hợp với hầu hết mọi không gian làm việc và giải trí hiện nay.'),
(4, 'Chuột ATK X1 PRO Tri-mode Wireless Black', '1690000.00', 'x1.png', 'ATK Blazing Sky X1 là một chuột gaming cao cấp, được thiết kế dành cho các game thủ chuyên nghiệp và những người yêu thích sự tối ưu hóa. Với thiết kế siêu nhẹ, cảm biến hàng đầu, công nghệ không dây tiên tiến, Blazing Sky X1 mang đến trải nghiệm chơi game mượt mà, chính xác và tốc độ.'),
(5, 'Chuột Pulsar X2 White', '2390000.00', 'pul.png', 'Pulsar X2 là dòng chuột không dây với trọng lượng siêu nhẹ, Form cầm đối xứng tạo cảm giác chắc chắn trong mọi thao tác. Đặc biệt, với thời lượng pin lên tới 70 giờ bạn hoàn toàn có thể mang đi và sử dụng ở bất kỳ đâu.');

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE `slide` (
  `id_slide` int(11) NOT NULL,
  `anh_sl` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slide`
--

INSERT INTO `slide` (`id_slide`, `anh_sl`) VALUES
(1, 'slide1.png\r\n'),
(2, 'slide2.png'),
(3, 'slide3.png'),
(7, 'slide4.png');

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE `tintuc` (
  `id_tt` int(11) NOT NULL,
  `tieude_tt` varchar(255) NOT NULL,
  `anh_tt` varchar(255) NOT NULL,
  `noidung_tt` longtext NOT NULL,
  `danhmuc_tt` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tintuc`
--

INSERT INTO `tintuc` (`id_tt`, `tieude_tt`, `anh_tt`, `noidung_tt`, `danhmuc_tt`) VALUES
(1, 'Đánh giá sức mạnh Ryzen 7 7800X3D: \"Ông vua\" mới của làng FPS.', 'tt1.png', 'Phân tích hiệu năng vượt trội của công nghệ 3D V-Cache trên nền tảng AM5, giúp ổn định khung hình (FPS) cực cao cho các tựa game như Valorant và CS2.', 'Công nghệ.'),
(2, 'Khởi tranh giải đấu Valorant nội bộ tại Cyber Tuấn Anh.', 'tt2.png', 'Thông tin về giải đấu phong trào sắp tới tại cơ sở Ninh Bình, nơi quy tụ các đội tuyển xuất sắc nhất khu vực tranh tài cùng giải thưởng hấp dẫn.', 'Esports'),
(3, 'Top màn hình TN Panel 310Hz giúp tối ưu phản xạ cho game thủ.', 'tt3.png', 'So sánh chi tiết các mẫu màn hình AOC và ASUS VG259QM về độ rõ nét chuyển động và tốc độ phản hồi, những yếu tố then chốt để giành lợi thế trong các pha giao tranh.', 'Công nghệ.'),
(4, 'Cách thiết lập cấu hình 1280x882 tối ưu cho Crossfire Legends.', 'tt4.png', 'Hướng dẫn cộng đồng cách tùy chỉnh độ phân giải đặc biệt và các thông số nhạy của chuột để đạt được cảm giác bắn headshot tốt nhất trên máy tính.', 'Esports.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `danhsachchuot`
--
ALTER TABLE `danhsachchuot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id_slide`);

--
-- Indexes for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`id_tt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `danhsachchuot`
--
ALTER TABLE `danhsachchuot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `id_slide` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `id_tt` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
