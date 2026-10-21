<?php
include("header.php");
include_once("connect.php");

$tukhoa = isset($_GET['tukhoa']) ? mysqli_real_escape_string($conn, $_GET['tukhoa']) : '';
?>

<div style="padding: 50px 20px; background-color: #000; min-height: 80vh; color: #fff; font-family: sans-serif;">
    <h2 style="text-align: center; color: #00ffff; text-transform: uppercase; margin-bottom: 40px;">
        Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($tukhoa); ?>"
    </h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; max-width: 1200px; margin: 0 auto;">
        <?php
        // Danh sách bảng: Hãy chắc chắn cột khóa chính là 'id'. Nếu là 'id_sp' hãy sửa lại ở đây.
        $tables = [
            'dsbanphim' => ['col' => 'ten_bp'],
            'danhsachchuot' => ['col' => 'ten_chuot'],
            'dstainghe' => ['col' => 'ten_tn']
        ];

        $found = false;

        foreach ($tables as $table => $data) {
            $column = $data['col'];
            // Dùng SELECT * chỉ khi bạn chắc chắn có cột 'id'
            $sql = "SELECT * FROM $table WHERE $column LIKE '%$tukhoa%'";
            $result = mysqli_query($conn, $sql);
            
            if($result && mysqli_num_rows($result) > 0) {
                $found = true;
                while($row = mysqli_fetch_assoc($result)) {
                    $ten_sp = $row[$column];
                    $anh = trim($row['hinh_anh']);
                    $gia = $row['gia_ban'];
                    // Đảm bảo lấy đúng cột id, nếu cột khác hãy đổi 'id' thành tên cột đó
                    $id_sp = isset($row['id']) ? $row['id'] : 0; 
        ?>
                    <div style="background: #1a1a1a; padding: 20px; text-align: center; border-radius: 12px; border: 1px solid #333;">
                        <div style="height: 180px; display: flex; align-items: center; justify-content: center; background: #fff; border-radius: 8px; margin-bottom: 15px;">
                            <img src="img/<?php echo htmlspecialchars($anh); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="Product">
                        </div>
                        
                        <h3 style="font-size: 15px; color: #fff; margin: 10px 0; min-height: 40px;">
                            <?php echo htmlspecialchars($ten_sp); ?>
                        </h3>
                        
                        <p style="color: #00ffff; font-weight: bold; font-size: 18px; margin: 10px 0;">
                            <?php echo number_format($gia, 0, ',', '.'); ?> VNĐ
                        </p>
                        
                        <a href="cart.php?action=add&id=<?php echo $id_sp; ?>&type=<?php echo $table; ?>" 
                           style="display: block; background: #00ffff; color: #000; padding: 12px; text-decoration: none; border-radius: 8px; font-weight: bold; text-transform: uppercase; text-align: center;">
                           Mua Ngay
                        </a>
                    </div>
        <?php
                }
            }
        }

        if (!$found) {
            echo "<p style='text-align: center; width: 100%; color: #aaa; font-size: 18px;'>Không tìm thấy sản phẩm nào phù hợp!</p>";
        }
        ?>
    </div>
</div>

<?php include("footer.php"); ?>