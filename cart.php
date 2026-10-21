<?php
session_start(); // Bắt đầu phiên làm việc để lưu giỏ hàng
include("header.php"); // Gọi thanh menu chung
include_once("connect.php"); // Kết nối database

// XỬ LÝ KHÍ BẤM NÚT XÓA SẢN PHẨM
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $key_xoa = $_GET['key'];
    // Nếu sản phẩm tồn tại trong giỏ hàng thì tiến hành xóa bỏ
    if (isset($_SESSION['cart'][$key_xoa])) {
        unset($_SESSION['cart'][$key_xoa]);
    }
    // Chuyển hướng lại trang cart.php để cập nhật lại giao diện sạch sẽ
    header("Location: cart.php");
    exit();
}

// Xử lý khi bấm nút "MUA NGAY" mang theo tham số action=add
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = intval($_GET['id']);
    $type = $_GET['type'];
    
    // Tạo khóa duy nhất cho sản phẩm trong giỏ hàng dựa vào loại sản phẩm và id
    $cart_key = $type . '_' . $id;
    
    // Nếu sản phẩm đã có trong giỏ hàng thì tăng số lượng, chưa có thì đặt bằng 1
    if (isset($_SESSION['cart'][$cart_key])) {
        $_SESSION['cart'][$cart_key]['soluong']++;
    } else {
        // Lấy thông tin sản phẩm từ database tùy theo danh mục
        $ten_sp = "";
        $gia_ban = 0;
        $hinh_anh = "";
        
        if ($type == 'banchay') {
            $res = $conn->query("SELECT * FROM sanpham_banchay WHERE id_sp = $id");
            if($res && $row = $res->fetch_assoc()) { $ten_sp = $row['ten_sp']; $gia_ban = $row['gia_ban']; $hinh_anh = $row['hinh_anh']; }
        } elseif ($type == 'chuot') {
            $res = $conn->query("SELECT * FROM danhsachchuot WHERE id = $id");
            if($res && $row = $res->fetch_assoc()) { $ten_sp = $row['ten_chuot']; $gia_ban = $row['gia_ban']; $hinh_anh = $row['hinh_anh']; }
        } elseif ($type == 'banphim') {
            $res = $conn->query("SELECT * FROM dsbanphim WHERE id = $id");
            if($res && $row = $res->fetch_assoc()) { $ten_sp = $row['ten_bp']; $gia_ban = $row['gia_ban']; $hinh_anh = $row['hinh_anh']; }
        } elseif ($type == 'tainghe') {
            $res = $conn->query("SELECT * FROM dstainghe WHERE id_tn = $id");
            if($res && $row = $res->fetch_assoc()) { $ten_sp = $row['ten_tn']; $gia_ban = $row['gia_ban']; $hinh_anh = $row['hinh_anh']; }
        }
        
        if (!empty($ten_sp)) {
            $_SESSION['cart'][$cart_key] = [
                'ten' => $ten_sp,
                'gia' => $gia_ban,
                'anh' => $hinh_anh,
                'soluong' => 1
            ];
        }
    }
    
    // Làm sạch đường dẫn để tránh bị lặp lại hành động thêm khi F5 trang
    header("Location: cart.php");
    exit();
}
?>

<div style="padding: 50px 20px; background-color: #000; min-height: 80vh; color: #fff; font-family: sans-serif;">
    <h2 style="text-align: center; color: #00ffff; text-transform: uppercase; margin-bottom: 30px; font-weight: bold; letter-spacing: 1px;">Giỏ Hàng Của Bạn</h2>
    
    <div style="max-width: 1000px; margin: 0 auto; background: #111; padding: 20px; border-radius: 8px; border: 1px solid #333;">
        <?php if (!empty($_SESSION['cart'])): ?>
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 2px solid #00ffff; color: #00ffff;">
                        <th style="padding: 10px;">Hình ảnh</th>
                        <th style="padding: 10px;">Tên sản phẩm</th>
                        <th style="padding: 10px;">Giá bán</th>
                        <th style="padding: 10px;">Số lượng</th>
                        <th style="padding: 10px;">Tổng tiền</th>
                        <th style="padding: 10px; text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $tong_gio_hang = 0;
                    foreach ($_SESSION['cart'] as $cart_key => $item): 
                        $tong_tien_sp = $item['gia'] * $item['soluong'];
                        $tong_gio_hang += $tong_tien_sp;
                    ?>
                        <tr style="border-bottom: 1px solid #222;">
                            <td style="padding: 15px;"><img src="img/<?php echo $item['anh']; ?>" style="width: 60px; height: 60px; object-fit: contain; background: white; border-radius: 4px; padding: 2px;"></td>
                            <td style="padding: 15px;"><?php echo $item['ten']; ?></td>
                            <td style="padding: 15px; color: #00ffff;"><?php echo number_format($item['gia'], 0, ',', '.'); ?> VNĐ</td>
                            <td style="padding: 15px;"><?php echo $item['soluong']; ?></td>
                            <td style="padding: 15px; color: #00ffff; font-weight: bold;"><?php echo number_format($tong_tien_sp, 0, ',', '.'); ?> VNĐ</td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="cart.php?action=delete&key=<?php echo $cart_key; ?>" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa gear này khỏi giỏ hàng không?');" 
                                   style="color: #ff4d4d; font-size: 18px; text-decoration: none; transition: 0.2s;" 
                                   title="Xóa sản phẩm">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="text-align: right; margin-top: 30px;">
                <h3 style="color: #fff;">Tổng thanh toán: <span style="color: #00ffff; font-size: 24px;"><?php echo number_format($tong_gio_hang, 0, ',', '.'); ?> VNĐ</span></h3>
                <a href="checkout.php" style="text-decoration: none;">
                    <button style="background: #00ffff; color: #000; border: none; padding: 12px 30px; font-weight: bold; font-size: 16px; border-radius: 6px; cursor: pointer; text-transform: uppercase; margin-top: 15px;">Tiến Hành Thanh Toán</button>
                </a>
            </div>
        <?php else: ?>
            <p style="text-align: center; color: #aaa; padding: 30px 0;">Giỏ hàng của bạn đang trống rỗng. Hãy quay lại mua sắm nhé!</p>
        <?php endif; ?>
    </div>
</div>

<?php 
    include("footer.php"); // Gọi chân trang
?>