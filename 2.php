<?php

session_start();
// Kiểm tra xem session mycart có tồn tại hay không.
if (isset($_SESSION['mycart'])) {
    // Duyệt qua từng sản phẩm trong giỏ hàng
    foreach ($_SESSION['mycart']as $cart) {
        //  Mỗi phần tử của giỏ hàng là một mảng lưu thông tin về một sản phẩm. Các giá trị của sản phẩm
        echo"Mã sp:".$cart[0];
        echo"Tên sp:".$cart[1];
        echo"Giá:".$cart[2];
        echo"Số lượng:".$cart[3]."<br>";
    }
    echo"<h1>Session đã show</h1>";
}else{
    echo"<h1>Session đã hủy</h1>";
}
// Liên kết này đưa người dùng trở lại trang 1.php, nơi session giỏ hàng sẽ được khởi tạo lại với các sản phẩm.
echo'<a href=""1.php>Khởi tạo</a>';
// Liên kết này đưa người dùng đến trang 3.php, nơi session giỏ hàng sẽ bị hủy bỏ.
echo'<a href="3.php">Hủy Session</a>';
?>