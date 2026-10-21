<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);

    $sql = "INSERT INTO products (name, price) VALUES ('$name', '$price')";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
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
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #0f172a; 
            color: #f8fafc; 
            padding: 40px; 
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: #1e293b; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.3); 
        }
        h2 { color: #38bdf8; margin-bottom: 20px; border-bottom: 2px solid #334155; padding-bottom: 12px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #cbd5e1; }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 12px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 6px;
            color: #fff;
            font-size: 15px;
        }
        input:focus { border-color: #38bdf8; outline: none; }
        .btn-container { display: flex; align-items: center; gap: 15px; margin-top: 25px; }
        .btn { 
            padding: 10px 20px; 
            border-radius: 6px; 
            font-weight: 600; 
            font-size: 14px; 
            border: none; 
            cursor: pointer; 
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-save { background: #10b981; color: #fff; }
        .btn-back { background: #475569; color: #fff; }
        .btn:hover { opacity: 0.9; }
        .error { color: #ef4444; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa fa-plus-circle"></i> Thêm Sản Phẩm Mới</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" placeholder="Nhập tên bàn phím, chuột, tai nghe..." required>
        </div>
        
        <div class="form-group">
            <label>Giá (VNĐ):</label>
            <input type="number" step="0.01" name="price" placeholder="Nhập giá sản phẩm..." required>
        </div>
        
        <div class="btn-container">
            <button type="submit" class="btn btn-save"><i class="fa fa-save"></i> Lưu sản phẩm</button>
            <a href="admin.php" class="btn btn-back"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>