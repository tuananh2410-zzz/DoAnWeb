<?php
// BẮT BUỘC CÓ DÒNG NÀY ĐỂ DÙNG ĐƯỢC SESSION TRÊN MỌI TRANG
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Tự động lấy tên file hiện tại
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tuấn Anh Gear - Gaming Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/css.css?v=<?php echo time(); ?>">
</head>
<body>

<script>
function closeAd() {
    var popup = document.getElementById("adPopup");
    if (popup) popup.style.display = "none";
}
</script>

<?php if ($current_page == 'index.php'): ?>
<div class="popup-overlay" id="adPopup">
    <div class="popup-box"> 
        <div class="close-popup" onclick="closeAd()">X</div> 
        <img src="img/hd.png" alt="Promotion">
    </div>
</div>
<?php endif; ?>

<div class="nav-links">
    <div class="menu-left">
        <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Trang Chủ</a>
        <a href="chuot.php" class="<?php echo ($current_page == 'chuot.php') ? 'active' : ''; ?>">Chuột Gaming</a>
        <a href="banphim.php" class="<?php echo ($current_page == 'banphim.php') ? 'active' : ''; ?>">Bàn Phím</a>
        <a href="tainghe.php" class="<?php echo ($current_page == 'tainghe.php') ? 'active' : ''; ?>">Tai Nghe</a>
        <a href="tintuc.php" class="<?php echo ($current_page == 'tintuc.php') ? 'active' : ''; ?>">Tin Tức</a> 
    </div>

   <div class="search-container">
        <form action="timkiem.php" method="GET" style="display: flex;">
            <input type="text" name="tukhoa" placeholder="Tìm gear..." required style="padding: 5px; border: 1px solid #333; border-radius: 3px 0 0 3px;">
            <button type="submit" style="padding: 5px 10px; background: #00ffff; border: none; cursor: pointer; border-radius: 0 3px 3px 0; font-weight: bold;">Tìm</button>
        </form>
    </div>

   <div class="menu-right">
        <!-- Thêm nút Quản trị vào đây -->
        <a href="admin.php" class="cart-btn" style="background: #ffc107; color: #000; margin-right: 10px;">
            <i class="fa fa-cogs"></i> Quản trị
        </a>

        <div class="dropdown">
            <a href="#" class="dropbtn">
                <i class="fa fa-user"></i> 
                <?php echo isset($_SESSION['user']) ? "Xin chào, " . htmlspecialchars($_SESSION['user']) : "Tài khoản"; ?>
                <i class="fa fa-caret-down"></i>
            </a>
            <div class="dropdown-content">
                <?php if(isset($_SESSION['user'])): ?>
                    <a href="logout.php"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                <?php else: ?>
                    <a href="dangky.php?type=login"><i class="fa fa-sign-in"></i> Đăng nhập</a> 
                    <a href="dangky.php?type=register"><i class="fa fa-user-plus"></i> Đăng ký</a> 
                <?php endif; ?>
            </div>
        </div>
        <a href="cart.php" class="cart-btn"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a>
    </div>
</div>