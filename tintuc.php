<?php 
    include("header.php"); // Gọi Menu Tuấn Anh Gear gánh lên đầu trang này
?>

<style>
.news-container { 
    width: 90%; 
    max-width: 1200px; 
    margin: 0 auto; 
    padding: 40px 20px;
}
h2.section-title { 
    text-align: center; 
    color: #00ffff; 
    text-transform: uppercase; 
    margin-bottom: 30px; 
    letter-spacing: 2px;
    text-shadow: 0 0 10px #00ffff;
}
.news-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
    gap: 25px; 
}
.new-item { 
    background: #1a1a1a; 
    border-radius: 12px; 
    overflow: hidden; 
    box-shadow: 0 4px 12px rgba(0,255,255,0.1); 
    transition: all 0.3s ease; 
    display: flex; 
    flex-direction: column; 
    border: 1px solid #333; 
}
.new-item:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 0 15px #00ffff; 
    border-color: #00ffff;
}
.image-box { 
    width: 100%; 
    height: 200px; 
    overflow: hidden; 
    border-bottom: 2px solid #00ffff;
}
.new-item img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; 
    transition: 0.5s; 
}
.new-item:hover img { 
    transform: scale(1.1); 
}
.content-box { 
    padding: 15px; 
    flex-grow: 1; 
}
.new-item h3 { 
    font-size: 17px; 
    color: #fff; 
    line-height: 1.4; 
    margin: 0; 
    display: -webkit-box; 
    -webkit-line-clamp: 2; 
    -webkit-box-orient: vertical; 
    overflow: hidden; 
    cursor: pointer; 
}
.new-item h3:hover {
    color: #00ffff;
}
@media (max-width: 768px) { 
    .news-container { width: 100%; } 
    .news-grid { gap: 15px; } 
}
</style>

<div class="news-container">
    <h2 class="section-title">TIN TỨC NỔI BẬT</h2>
    <div class="news-grid">
        <?php
        include_once("connect.php"); 
        $sql = "SELECT tieude_tt, anh_tt FROM tintuc LIMIT 8";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while ($tt = $result->fetch_assoc()) {
        ?>
                <div class="new-item">
                    <div class="image-box">
                        <img src="img/<?php echo $tt['anh_tt']; ?>" alt="Tin tức">
                    </div>
                    <div class="content-box">
                        <h3><?php echo $tt['tieude_tt']; ?></h3>
                    </div>
                </div>
        <?php 
            } 
        } else { 
            echo "<p style='color:#00ffff; text-align: center; width: 100%;'>Chưa có tin tức nào được cập nhật.</p>";
        }
        ?>
    </div> 
</div> 

<?php 
    include("footer.php"); // Gọi khung chat và đóng thẻ html ở cuối trang tin tức
?>