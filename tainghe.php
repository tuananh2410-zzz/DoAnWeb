<?php 
    include("header.php"); // Gọi thanh menu chung gánh đầu trang
?>

<!-- KHU VỰC DANH MỤC TAI NGHE GAMING -->
<div style="padding: 50px 20px; background-color: #000; min-height: 100vh;">
    <h2 style="text-align: center; color: #00ffff; text-transform: uppercase; margin-bottom: 40px; font-family: sans-serif; letter-spacing: 1px; text-shadow: 0 0 10px #00ffff;">
        Danh Mục Tai Nghe Gaming
    </h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto;">
        <?php
        include_once("connect.php"); // Kết nối database xampp
        
        // Truy vấn lấy dữ liệu từ bảng dstainghe vừa nạp dữ liệu ở trên
        $sql = "SELECT * FROM dstainghe"; 
        $result = mysqli_query($conn, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="product-card" style="background: #1a1a1a; border: 1px solid #333; border-radius: 12px; padding: 20px; text-align: center; transition: 0.3s;">
                    <div style="background: white; border-radius: 8px; padding: 15px; margin-bottom: 15px; display: flex; align-items: center; justify-content: center; height: 180px;">
                        <img src="img/<?php echo $row['hinh_anh']; ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                    </div>
                    <h3 style="font-size: 15px; min-height: 40px; margin: 10px 0; color: #fff; font-family: sans-serif; line-height: 1.4;"><?php echo $row['ten_tn']; ?></h3>
                    <p style="color: #00ffff; font-size: 18px; font-weight: bold; margin: 10px 0; font-family: sans-serif;">
                        <?php echo number_format($row['gia_ban'], 0, ',', '.'); ?> VNĐ
                    </p>
                  <a href="cart.php?action=add&id=<?php echo $row['id_tn']; ?>&type=tainghe" style="display: block; text-decoration: none; width: 100%; padding: 12px 0; background: #00ffff; border: none; font-weight: bold; cursor: pointer; border-radius: 8px; color: #000; text-transform: uppercase; text-align: center;">
    MUA NGAY
</a>
                </div>
            <?php 
            }
        } else {
            echo "<p style='color: #00ffff; text-align: center; width: 100%;'>Dữ liệu tai nghe đang được cập nhật...</p>";
        }
        ?>
    </div>
</div>

<?php 
    include("footer.php"); // Gọi khung chat và chân trang
?>