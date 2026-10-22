<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);
    $category = $_POST['category']; // Nhận giá trị: chuot, banphim, tainghe
    $image = $conn->real_escape_string($_POST['image']);

    // Phân loại câu lệnh INSERT vào đúng bảng và đúng tên cột trong CSDL của bạn
    if ($category == 'chuot') {
        $sql = "INSERT INTO danhsachchuot (ten_chuot, gia_ban, hinh_anh) VALUES ('$name', '$price', '$image')";
    } elseif ($category == 'banphim') {
        $sql = "INSERT INTO dsbanphim (ten_bp, gia_ban, hinh_anh) VALUES ('$name', '$price', '$image')";
    } else {
        $sql = "INSERT INTO dstainghe (ten_tn, gia_ban, hinh_anh) VALUES ('$name', '$price', '$image')";
    }

    if ($conn->query($sql) === TRUE) {
        // Thêm xong chuyển hướng về trang quản trị đúng tab danh mục đó
        header("Location: admin.php?type=" . $category);
        exit();
    } else {
        $error = "Lỗi: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Sản Phẩm - Tuấn Anh Gear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background: #0f172a; color: #f8fafc; padding: 40px; }
        .container { max-width: 600px; margin: 0 auto; background: #1e293b; padding: 30px; border-radius: 12px; }
        h2 { color: #38bdf8; margin-bottom: 20px; border-bottom: 2px solid #334155; padding-bottom: 12px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 6px; color: #cbd5e1; }
        input[type="text"], input[type="number"], select { width: 100%; padding: 10px; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #fff; }
        .btn-container { display: flex; gap: 15px; margin-top: 20px; }
        .btn { padding: 10px 20px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; text-decoration: none; }
        .btn-save { background: #10b981; color: #fff; }
        .btn-back { background: #475569; color: #fff; }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa fa-plus-circle"></i> Thêm Sản Phẩm Mới</h2>
    <?php if(isset($error)) echo "<p style='color:#ef4444;'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" placeholder="VD: Tai nghe Razer BlackShark..." required>
        </div>
        
        <div class="form-group">
            <label>Giá bán (VNĐ):</label>
            <input type="number" step="0.01" name="price" placeholder="VD: 3490000" required>
        </div>

        <div class="form-group">
            <label>Danh mục sản phẩm:</label>
            <select name="category" required>
                <option value="chuot">Chuột Gaming</option>
                <option value="banphim">Bàn Phím</option>
                <option value="tainghe">Tai Nghe</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tên file ảnh (trong thư mục img):</label>
            <input type="text" name="image" placeholder="VD: headphone1.png" required>
        </div>
        
        <div class="btn-container">
            <button type="submit" class="btn btn-save"><i class="fa fa-save"></i> Lưu sản phẩm</button>
            <a href="admin.php" class="btn btn-back"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>