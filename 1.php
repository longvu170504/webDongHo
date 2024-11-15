<?php

session_start();
// Tạo một session có tên mycart để lưu trữ giỏ hàng dưới dạng một mảng.
$_SESSION['mycart']= array(); 
// tạo dữ liệu sp 
$sp1=[1,"sanpham1",100,2];
$sp2=[2,"sanpham1",200,3];
// Tạo một mảng trống tên là $cart, đại diện cho giỏ hàng.
$cart=[];
// Thêm các sản phẩm $sp1 và $sp2 vào giỏ hàng.
$cart[]=$sp1;
$cart[]=$sp2;
$_SESSION['mycart']=$cart;
// Hiển thị một thông báo lên trình duyệt cho biết session đã được tạo thành công.
echo'<h1>Session đã tạo</h1>';
// Liên kết đến trang 2.php, nơi có thể sẽ hiển thị dữ liệu session giỏ hàng.
echo'<a href="2.php">Show dữ liệu session</a>';
// Liên kết đến trang 3.php, có thể sẽ thực hiện hủy session (xoá giỏ hàng).
echo'<a href="3.php">Hủy session</a>'

?>