<?php
include 'connect.php';

// Kiểm tra xem có truyền id lên URL hay không, nếu không thì quay về trang admin
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$row = $result->fetch_assoc();

if (!$row) {
    die("<div style='font-family: Arial; padding: 40px; text-align: center;'>
            <h3>Sản phẩm không tồn tại hoặc đã bị xóa!</h3>
            <br><a href='admin.php' style='padding: 10px 20px; background: #38bdf8; color: #000; text-decoration: none; border-radius: 5px; font-weight: bold;'>Quay lại trang quản trị</a>
         </div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $price = floatval($_POST['price']);

    $sql = "UPDATE products SET name='$name', price='$price' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        $error = "Lỗi cập nhật: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Sản Phẩm - Tuấn Anh Gear</title>
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
        .btn-update { background: #f59e0b; color: #000; }
        .btn-back { background: #475569; color: #fff; }
        .btn:hover { opacity: 0.9; }
        .error { color: #ef4444; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fa fa-pencil-square-o"></i> Cập Nhật Thông Tin Sản Phẩm</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <div class="form-group">
            <label>Tên sản phẩm:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Giá (VNĐ):</label>
            <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>" required>
        </div>
        
        <div class="btn-container">
            <button type="submit" class="btn btn-update"><i class="fa fa-check"></i> Cập nhật</button>
            <a href="admin.php" class="btn btn-back"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
    </form>
</div>

</body>
</html>