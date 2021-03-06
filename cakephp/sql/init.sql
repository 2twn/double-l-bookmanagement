SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `users` (`id`, `username`, `name`, `password`, `role`, `location_id`, `valid`, `created`, `modified`) VALUES
('admin', 'admin', 'Default Admin', 'b54025851dd54398f9c83ae6b3a0a376e0b28095', 'admin', 'A', 1, '2012-11-12 15:18:25', '2012-11-12 15:18:25');

INSERT INTO `book_catagorys` (`id`, `catagory_name`, `catagory_color`, `valid`, `create_time`) VALUES
('0100', '100', '#FFC0CB', 1, '2012-11-12 22:53:48'),
('0200', '200', '#FF00FF', 1, '2012-11-18 23:04:38'),
('0300', '300', '#FF0000', 1, '2012-12-27 22:19:17'),
('0400', '400', '#FFA500', 1, '2012-12-27 22:19:32'),
('0500', '500', '#FFFF00', 1, '2012-12-27 22:20:29'),
('0600', '600', '#AAFF2F', 1, '2012-12-27 22:20:46'),
('0700', '700', '#008000', 1, '2012-12-27 22:21:02'),
('0800', '800', '#00FFFF', 1, '2012-12-27 22:21:15'),
('0900', '900', '#0000FF', 1, '2012-12-27 22:21:30'),
('1000', '1000', '#800080', 1, '2012-12-27 22:22:04');

INSERT INTO `system_locations` (`id`, `location_name`, `create_time`, `modi_time`, `valid`) VALUES
('A', '總部', '0000-00-00 00:00:00', '2013-01-02 21:47:31', 1),
('B', '新生校', '0000-00-00 00:00:00', '2013-01-02 21:47:41', 1),
('C', '敦南校', '0000-00-00 00:00:00', '2013-01-02 21:47:31', 1),
('D', '天母校', '0000-00-00 00:00:00', '2013-01-02 21:47:41', 1),
('E', '金山校', '0000-00-00 00:00:00', '2013-01-02 21:47:31', 1),
('F', '民生校', '0000-00-00 00:00:00', '2013-01-02 21:47:41', 1),
('G', '光復校', '0000-00-00 00:00:00', '2013-01-02 21:47:31', 1),
('H', '仁愛校', '0000-00-00 00:00:00', '2013-01-02 21:47:41', 1);

INSERT INTO `book_status` (`id`, `status_name`) VALUES
(0, '購買中'),
(1, '在庫'),
(2, '借出'),
(3, '已歸還'),
(4, '整理中'),
(5, '運送中'),
(6, '預約中');

INSERT INTO `lend_status` (`id`, `lend_status_name`) VALUES
('C', '出借中'),
('D', '遺失'),
('E', '續借中'),
('I', '歸還'),
('R', '預約'),
('S', '取消');


