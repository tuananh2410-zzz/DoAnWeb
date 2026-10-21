<style>
.mySlides { display: none; }
.mySlides img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 0;
}
.slideshow-container {
    max-width: 100%;
    margin: 0;
    border-radius: 0;
    position: relative;
}
.dot {
    height: 12px;
    width: 12px;
    margin: 0 2px;
    background-color: #333; /* Đổi sang màu tối phù hợp giao diện */
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}
.dot.active {
    background-color: #00ffff; /* Chấm tròn chuyển sang màu Cyan phát sáng khi active */
}
.fade {
    animation: fade 1s;
}
@keyframes fade {
    from { opacity: .4 }
    to { opacity: 1 }
}
</style>

<div class="slideshow-container">
<?php
// Gọi kết nối database nếu file index.php chưa gọi
include_once("connect.php"); 

$sql = "SELECT anh_sl FROM slide LIMIT 3";
$result = $conn->query($sql);
$count = 0;

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $count++;
        echo "<div class='mySlides fade'>";
        echo "<img src='img/".$row['anh_sl']."' alt='Ảnh slide'>"; /* Đổi chữ IMG thành chữ thường img cho đồng bộ thư mục */
        echo "</div>";
    }
} else {
    echo "<div style='color: #00ffff; text-align: center; padding: 20px;'>Không có ảnh slide trong database</div>";
}
?>
</div>

<br>

<div style="text-align:center">
<?php
for($i = 1; $i <= $count; $i++){
    echo "<span class='dot'></span>";
}
?>
</div>

<script>
let slideIdx = 0;
runSlides();

function runSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");

    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }

    slideIdx++;
    if (slideIdx > slides.length) {
        slideIdx = 1;
    }

    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    if (slides[slideIdx-1]) {
        slides[slideIdx-1].style.display = "block";
    }
    if (dots[slideIdx-1]) {
        dots[slideIdx-1].className += " active";
    }

    setTimeout(runSlides, 3000); /* Chạy 3 giây chuyển ảnh 1 lần cho người dùng kịp nhìn */
}
</script>