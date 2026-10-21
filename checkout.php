
<?php
session_start();
include("header.php");
include_once("connect.php");

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

$tong_gio_hang = 0;
foreach ($_SESSION['cart'] as $item) {
    $tong_gio_hang += $item['gia'] * $item['soluong'];
}

$thanh_cong = false;
$thong_tin_khach = [];

if (isset($_POST['btn_dathang'])) {
    $thong_tin_khach = [
        'hoten' => $_POST['hoten'],
        'diachi' => $_POST['diachi']
    ];
    // Xóa giỏ hàng sau khi đặt thành công
    unset($_SESSION['cart']);
    $thanh_cong = true;
}
?>

<div style="padding: 50px 20px; background-color: #000; min-height: 80vh; color: #fff; font-family: sans-serif;">
    <?php if ($thanh_cong): ?>
        <div style="text-align: center; padding: 60px; border: 2px solid #00ffff; border-radius: 8px; max-width: 600px; margin: 50px auto; background: #111;">
            <h1 style="color: #00ffff; font-size: 40px;"><i class="fa fa-check-circle"></i></h1>
            <h2 style="color: #fff;">Đặt hàng thành công!</h2>
            <p>Cảm ơn <strong><?php echo htmlspecialchars($thong_tin_khach['hoten']); ?></strong> đã ủng hộ Tuấn Anh Gear.</p>
            <p>Đơn hàng sẽ được gửi tới: <strong><?php echo htmlspecialchars($thong_tin_khach['diachi']); ?></strong></p>
            <a href="index.php" style="display: inline-block; margin-top: 20px; padding: 12px 30px; background: #00ffff; color: #000; text-decoration: none; border-radius: 6px; font-weight: bold; text-transform: uppercase;">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <h2 style="text-align: center; color: #00ffff; text-transform: uppercase; margin-bottom: 30px; letter-spacing: 1px;">Thông Tin Thanh Toán</h2>
        
        <div style="max-width: 1100px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 30px;">
            <div style="flex: 1; min-width: 320px; background: #111; padding: 25px; border-radius: 8px; border: 1px solid #333;">
                <form action="" method="POST">
                    <h3 style="color: #00ffff; border-bottom: 1px solid #333; padding-bottom: 10px; margin-top: 0;">1. Thông tin giao hàng</h3>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; color: #ccc;">Họ và tên:</label>
                        <input type="text" name="hoten" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; border-radius: 4px; color: #fff;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; color: #ccc;">Số điện thoại:</label>
                        <input type="text" name="sodienthoai" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; border-radius: 4px; color: #fff;">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 5px; color: #ccc;">Địa chỉ nhận gear:</label>
                        <input type="text" name="diachi" required style="width: 100%; padding: 10px; background: #222; border: 1px solid #444; border-radius: 4px; color: #fff;">
                    </div>

                    <h3 style="color: #00ffff; border-bottom: 1px solid #333; padding-bottom: 10px; margin-top: 30px;">2. Phương thức thanh toán</h3>
                    <label style="display: flex; align-items: center; background: #1a1a1a; padding: 15px; border-radius: 6px; border: 1px solid #333; margin-bottom: 12px; cursor: pointer;">
                        <input type="radio" name="phuongthuc" value="COD" checked onclick="toggleQR(false)" style="margin-right: 15px; accent-color: #00ffff;">
                        <strong style="color: #fff;"><i class="fa fa-truck"></i> Thanh toán khi nhận hàng (COD)</strong>
                    </label>
                    <label style="display: flex; align-items: center; background: #1a1a1a; padding: 15px; border-radius: 6px; border: 1px solid #333; margin-bottom: 10px; cursor: pointer;">
                        <input type="radio" name="phuongthuc" value="BANK" onclick="toggleQR(true)" style="margin-right: 15px; accent-color: #00ffff;">
                        <strong style="color: #fff;"><i class="fa fa-university"></i> Chuyển khoản ngân hàng</strong>
                    </label>

                    <div id="qr-area" style="display: none; background: #fff; padding: 15px; border-radius: 6px; text-align: center; margin-bottom: 20px;">
                        <img src="img/qr_code.jpg" style="width: 200px; height: 200px; display: block; margin: 0 auto;">
                        <p style="color: #000; font-weight: bold; margin-top: 10px;">Quét mã QR để thanh toán</p>
                    </div>

                    <button type="submit" name="btn_dathang" style="width: 100%; background: #00ffff; color: #000; border: none; padding: 14px; font-weight: bold; font-size: 16px; border-radius: 6px; cursor: pointer; text-transform: uppercase;">Xác Nhận Đặt Hàng</button>
                </form>
            </div>
            
            <div style="width: 380px; background: #111; padding: 25px; border-radius: 8px; border: 1px solid #333; height: fit-content;">
                <h3 style="color: #00ffff; border-bottom: 1px solid #333; padding-bottom: 10px; margin-top: 0;">Đơn hàng</h3>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div style="display: flex; align-items: center; padding: 10px 0; border-bottom: 1px solid #222;">
                        <img src="img/<?php echo trim($item['anh']); ?>" style="width: 50px; height: 50px; object-fit: contain; background: #fff; border-radius: 4px; margin-right: 15px;">
                        <div style="flex: 1;">
                            <div style="font-size: 14px;"><?php echo $item['ten']; ?> (x<?php echo $item['soluong']; ?>)</div>
                            <div style="color: #00ffff; font-weight: bold;"><?php echo number_format($item['gia'] * $item['soluong'], 0, ',', '.'); ?> VNĐ</div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div style="margin-top: 20px; text-align: right;">
                    <strong>Tổng cộng: </strong> <span style="color: #00ffff; font-size: 20px;"><?php echo number_format($tong_gio_hang, 0, ',', '.'); ?> VNĐ</span>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function toggleQR(show) {
    document.getElementById('qr-area').style.display = show ? 'block' : 'none';
}
</script>

<?php include("footer.php"); ?>