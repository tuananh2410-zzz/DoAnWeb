<?php
include 'connect.php';

// Xác định đang xem danh mục nào (mặc định là chuột)
$type = isset($_GET['type']) ? $_GET['type'] : 'chuot';

// Xử lý Xóa sản phẩm theo đúng bảng và đúng tên cột khóa chính
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $t = $_GET['type'];
    
    if ($t == 'chuot') {
        $sql_delete = "DELETE FROM danhsachchuot WHERE id = $id";
    } elseif ($t == 'banphim') {
        $sql_delete = "DELETE FROM dsbanphim WHERE id = $id";
    } else {
        $sql_delete = "DELETE FROM dstainghe WHERE id_tn = $id"; // Dùng id_tn cho bảng tai nghe
    }
    
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: admin.php?type=" . $t);
        exit();
    }
}

// Lấy dữ liệu và đồng bộ tên cột id thành 'id' chung để hiển thị
if ($type == 'chuot') {
    $result = $conn->query("SELECT id, ten_chuot AS name, gia_ban FROM danhsachchuot ORDER BY id DESC");
    $title_tab = "Quản Lý Chuột Gaming";
} elseif ($type == 'banphim') {
    $result = $conn->query("SELECT id, ten_bp AS name, gia_ban FROM dsbanphim ORDER BY id DESC");
    $title_tab = "Quản Lý Bàn Phím Gaming";
} else {
    $result = $conn->query("SELECT id_tn AS id, ten_tn AS name, gia_ban FROM dstainghe ORDER BY id_tn DESC");
    $title_tab = "Quản Lý Tai Nghe Gaming";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Trị Hệ Thống - Tuấn Anh Gear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #f8fafc; padding: 30px; }
        .container { max-width: 1000px; margin: 0 auto; background: #1e293b; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #334155; padding-bottom: 15px; }
        h2 { color: #38bdf8; font-size: 22px; }
        .action-buttons { display: flex; gap: 10px; }
        .btn { padding: 10px 16px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; }
        .btn-add { background: #10b981; color: #fff; }
        .btn-home { background: #6366f1; color: #fff; }
        .btn-edit { background: #f59e0b; color: #000; padding: 6px 12px; font-size: 13px; }
        .btn-delete { background: #ef4444; color: #fff; padding: 6px 12px; font-size: 13px; }
        
        /* Tab chuyển đổi danh mục */
        .tab-menu { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab-btn { padding: 8px 16px; background: #334155; color: #94a3b8; border-radius: 6px; text-decoration: none; font-weight: 600; }
        .tab-btn.active { background: #00ffff; color: #000; }

        table { width: 100%; border-collapse: collapse; background: #0f172a; border-radius: 8px; overflow: hidden; }
        th, td { padding: 14px 16px; text-align: left; }
        th { background: #334155; color: #38bdf8; font-weight: 600; }
        tr:not(:last-child) td { border-bottom: 1px solid #1e293b; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-flex">
        <h2><i class="fa fa-cogs"></i> <?php echo $title_tab; ?></h2>
        <div class="action-buttons">
            <a href="index.php" class="btn btn-home"><i class="fa fa-home"></i> Về Trang Chủ</a>
            <a href="add_product.php" class="btn btn-add"><i class="fa fa-plus"></i> Thêm sản phẩm</a>
        </div>
    </div>

    <!-- Thanh chuyển đổi giữa các bảng sản phẩm -->
    <div class="tab-menu">
        <a href="admin.php?type=chuot" class="tab-btn <?php echo ($type == 'chuot') ? 'active' : ''; ?>">Quản lý Chuột</a>
        <a href="admin.php?type=banphim" class="tab-btn <?php echo ($type == 'banphim') ? 'active' : ''; ?>">Quản lý Bàn Phím</a>
        <a href="admin.php?type=tainghe" class="tab-btn <?php echo ($type == 'tainghe') ? 'active' : ''; ?>">Quản lý Tai Nghe</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá bán</th>
                <th style="width: 180px; text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td style="font-weight: 500;"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td style="color: #34d399; font-weight: 600;"><?php echo number_format($row['gia_ban'], 0, ',', '.'); ?> VNĐ</td>
                    <td style="text-align: center;">
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>&type=<?php echo $type; ?>" class="btn btn-edit"><i class="fa fa-pencil"></i> Sửa</a>
                        <a href="admin.php?action=delete&id=<?php echo $row['id']; ?>&type=<?php echo $type; ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="fa fa-trash"></i> Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center; padding: 20px;">Chưa có sản phẩm nào trong danh mục này.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>