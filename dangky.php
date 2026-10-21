<?php
session_start();
include 'connect.php';

$msg = ""; $error = "";
$type = isset($_GET['type']) ? $_GET['type'] : 'register';

// --- XỬ LÝ ĐĂNG KÝ ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    $check = $conn->prepare("SELECT id FROM dangky WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $error = "Username hoặc Email đã tồn tại!";
    } else {
        $ins = $conn->prepare("INSERT INTO dangky (username, email, password) VALUES (?, ?, ?)");
        $ins->bind_param("sss", $username, $email, $password);
        if ($ins->execute()) {
            $msg = "Đăng ký thành công! <a href='dangky.php?type=login' style='color:#0f0'>Đăng nhập ngay</a>";
        } else { $error = "Lỗi hệ thống!"; }
    }
}

// --- XỬ LÝ ĐĂNG NHẬP ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password FROM dangky WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("Location: index.php"); exit();
        } else { $error = "Sai mật khẩu!"; }
    } else { $error = "Tài khoản không tồn tại!"; }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tuấn Anh Gear - Thành Viên</title>
   <style>
    body, html { 
        margin: 0; padding: 0; height: 100%; width: 100%; 
        background-color: #000; 
        display: flex; justify-content: center; align-items: center; 
    }

    .full-wrapper { 
        position: relative; 
        width: 95%; max-width: 1200px; /* Tăng độ rộng tổng thể */
        display: flex; align-items: center; justify-content: center;
    }

    .img-bg { width: 100%; border-radius: 15px; display: block; }

    /* --- PHẦN FORM ĐÃ ĐƯỢC MỞ RỘNG --- */
    .form-overlay { 
        position: absolute; 
        top: 50%; transform: translateY(-50%); 
        right: 5%; 
        width: 35%;          /* Tăng từ 28% lên 35% để rộng rãi hơn */
        padding: 45px;       /* Tăng padding để nội dung không bị sát mép */
        background: rgba(0, 0, 0, 0.8); 
        border: 1px solid #00ffff;
        border-radius: 20px; /* Bo góc mềm mại hơn */
        box-sizing: border-box;
        box-shadow: 0 0 30px rgba(0, 255, 255, 0.15); /* Thêm hiệu ứng phát sáng nhẹ */
    }

    /* Các input rộng và cao hơn để dễ thao tác */
    input { 
        width: 100%; padding: 15px; margin: 12px 0; 
        background: #1a1a1a; border: 1px solid #444; 
        color: #fff; border-radius: 8px; font-size: 16px; 
        box-sizing: border-box; 
    }
    
    button { 
        width: 100%; padding: 15px; background: #00ffff; 
        border: none; font-weight: bold; cursor: pointer; 
        border-radius: 8px; text-transform: uppercase; margin-top: 15px; 
        color: #000; font-size: 16px;
    }
    
    h2 { color: #00ffff; margin-bottom: 30px; font-size: 26px; text-transform: uppercase; text-align: center; }
    
    .social-btn { display: flex; gap: 15px; margin-top: 20px; }
    .social-btn a { flex: 1; padding: 12px; text-align: center; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: bold; color: #000; }
</style>
</head>
<body>

<div class="full-wrapper">
    <img src="img/anhdky.png" class="img-bg">

    <div class="form-overlay">
        <h2><?php echo ($type == 'login') ? 'ĐĂNG NHẬP' : 'ĐĂNG KÝ'; ?></h2>
        
        <?php if($error) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
        <?php if($msg) echo "<p style='color:lime; text-align:center;'>$msg</p>"; ?>

        <form action="dangky.php?type=<?php echo $type; ?>" method="POST">
            <label style="color:#fff;">Username</label>
            <input type="text" name="username" required>
            
            <?php if ($type == 'register'): ?>
                <label style="color:#fff;">Email</label>
                <input type="email" name="email" required>
            <?php endif; ?>
            
            <label style="color:#fff;">Password</label>
            <input type="password" name="password" required>
            
            <button type="submit" name="<?php echo $type; ?>">XÁC NHẬN</button>
        </form>

      <div class="social-btn">
    <a href="https://accounts.google.com/" target="_blank" style="background: #fff;">Google</a>
    <a href="https://www.facebook.com/login/" target="_blank" style="background: #1877f2; color: #fff;">Facebook</a>
</div>

        <div class="toggle-link">
            <?php if ($type == 'login'): ?>
                Chưa có tài khoản? <a href="dangky.php?type=register" style="color: #00ffff;">Đăng ký ngay</a>
            <?php else: ?>
                Đã có tài khoản? <a href="dangky.php?type=login" style="color: #00ffff;">Đăng nhập ngay</a>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>