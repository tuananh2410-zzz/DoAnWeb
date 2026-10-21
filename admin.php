<?php
include 'connect.php';

// --- XỬ LÝ XÓA SẢN PHẨM ---
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $sql_delete = "DELETE FROM products WHERE id = $id";
    if ($conn->query($sql_delete) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Lỗi xóa: " . $conn->error;
    }
}

// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Trị Sản Phẩm - Tuấn Anh Gear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #0f172a; 
            color: #f8fafc; 
            padding: 30px; 
        }
        .container { 
            max-width: 1000px; 
            margin: 0 auto; 
            background: #1e293b; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.3); 
        }
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #334155;
            padding-bottom: 15px;
        }
        h2 { color: #38bdf8; font-size: 24px; }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn { 
            padding: 10px 16px; 
            text-decoration: none; 
            border-radius: 6px; 
            font-weight: 600; 
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .btn-add { background: #10b981; color: #fff; }
        .btn-home { background: #6366f1; color: #fff; }
        .btn-edit { background: #f59e0b; color: #000; padding: 6px 12px; font-size: 13px; }
        .btn-delete { background: #ef4444; color: #fff; padding: 6px 12px; font-size: 13px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; background: #0f172a; border-radius: 8px; overflow: hidden; }
        th, td { padding: 14px 16px; text-align: left; }
        th { background: #334155; color: #38bdf8; font-weight: 600; text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px; }
        tr:not(:last-child) td { border-bottom: 1px solid #1e293b; }
        tr:hover { background: rgba(56, 189, 248, 0.05); }
        .empty-row { text-align: center; color: #94a3b8; padding: 30px; }
    </style>
</head>
<body>

<div class="container">
    <div class="header-flex">
        <h2><i class="fa fa-cogs"></i> Quản Trị Hệ Thống Gear</h2>
        <div class="action-buttons">
            <a href="index.php" class="btn btn-home"><i class="fa fa-home"></i> Về Trang Chủ</a>
            <a href="add_product.php" class="btn btn-add"><i class="fa fa-plus"></i> Thêm sản phẩm</a>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Tên sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th style="width: 180px; text-align: center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td style="font-weight: 500;"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td style="color: #34d399; font-weight: 600;"><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                    <td style="text-align: center;">
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-edit"><i class="fa fa-pencil"></i> Sửa</a>
                        <a href="admin.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');"><i class="fa fa-trash"></i> Xóa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="empty-row">Chưa có sản phẩm nào trong cơ sở dữ liệu. Nhấn "Thêm sản phẩm" để bắt đầu!</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>