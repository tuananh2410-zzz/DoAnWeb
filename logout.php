<?php
// Bắt đầu session để có thể truy cập và hủy nó
session_start();

// Hủy bỏ tất cả các biến session đã lưu
session_unset();

// Hủy hoàn toàn phiên làm việc của session
session_destroy();

// Chuyển hướng người dùng về trang chủ sau khi đăng xuất
header("Location: index.php");
exit();
?>