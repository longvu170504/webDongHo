<?php
// import file
session_start();
include "model/pdo.php";
include "model/danhmuc.php";
include "model/sanpham.php";
include "model/taikhoan.php";
include "view/header.php";
include "global.php";

// khai báo biến
$spnew = loadall_sanpham_home();
$dsdm = loadall_danhmuc();
$dstop10 = loadall_sanpham_top10();

// kiểm tra tham số act trong url nếu có sẽ thực hiện hđ tương ứng với gái trị
if ((isset($_GET['act'])) && ($_GET['act'] != "")) {
    $act = $_GET['act'];
    switch ($act) {
// nếu kh ycau xem sp thì ktra từ khóa và danh mục sp
        case 'sanpham':
            if (isset($_POST['kyw']) && ($_POST['kyw'] != "")) {
                $kyw = $_POST['kyw'];
            } else {
                $kyw = "";
            }
            if (isset($_GET['iddm']) && ($_GET['iddm'] > 0)) {
                $iddm = $_GET['iddm'];
            } else {
                $iddm = 0;
            }
            // hiển thị sp và tên danh mục trong view/sp
            $dssp = loadall_sanpham($kyw, $iddm);
            $tendm = load_ten_dm($iddm);
            include "view/sanpham.php";
            break;
            
            
        case 'sanphamct':
            // Kiểm tra tham số idsp
            if (isset($_GET['idsp']) && ($_GET['idsp'] > 0)) {
                $id = $_GET['idsp'];
                $onesp = loadone_sanpham($id);
                extract($onesp);
                //Tải chi tiết sản phẩm từ cơ sở dữ liệu và các sản phẩm cùng loại.
                $sp_cung_loai = load_sanpham_cungloai($id, $iddm);
                // Hiển thị trong view/sanphamct.php
                include "view/sanphamct.php";
            } else {
                include "view/home.php";
            }
            break;

            
        case 'dangky':
            // Kiểm tra thông tin đăng ký từ form
            if (isset($_POST['dangky']) && ($_POST['dangky'] > 0)) {
                $email = $_POST['email'];
                $user = $_POST['user'];
                $pass = $_POST['pass'];
                // Thêm thông tin người dùng vào cơ sở dữ liệu thông qua hàm insert_taikhoan()
                insert_taikhoan($email, $user, $pass, );
                $thongbao = "Đã đăng ký thành công. Vui lòng đăng nhập để thực hiện các chức năng";
            }
        case 'dangnhap':
            // Kiểm tra thông tin tài khoản
            if (isset($_POST['dangnhap']) && ($_POST['dangnhap'])) {
                $user = $_POST['user'];
                $pass = $_POST['pass'];
                // Xác minh tài khoản bằng hàm checkuser() và lưu vào session nếu thành công.
                $checkuser = checkuser($user, $pass);
                if (is_array($checkuser)) {
                    $_SESSION['user'] = $checkuser;
                    // $thongbao = "Bạn đã đăng nhập thành công";
                    header('Location: index.php');
                } else {
                    $thongbao = "Tài khoản không tồn tại vui lòng kiểm tra lại";
                }
            }
            include "view/taikhoan/dangky.php";
            break;
            
            case 'edit_taikhoan':
                // Kiểm tra và lấy thông tin người dùng
                if (isset($_POST['capnhat']) && ($_POST['capnhat'])) {
                    $email = $_POST['email'];
                    $user = $_POST['user'];
                    $pass = $_POST['pass'];
                    $address = $_POST['address'];
                    $tel = $_POST['tel'];
                    $id = $_POST['id'];
                    // Cập nhật thông tin người dùng trong cơ sở dữ liệu.
                    update_taikhoan($id,$user,$pass,$email,$address,$tel);
                    // Lưu thông tin cập nhật vào session và chuyển hướng.
                    $_SESSION['user'] = checkuser($user,$pass);
                        header('Location: index.php?act=edit_taikhoan');
                }
                include "view/taikhoan/edit_taikhoan.php";
                break;
                
                case 'quenmk':
                    // Nhập email, kiểm tra email có tồn tại trong hệ thống hay không.
                    if (isset($_POST['guiemail']) && ($_POST['guiemail'])) {
                        $email = $_POST['email'];
                        $checkemail=checkemail($email);
                        // Nếu có, hiển thị mật khẩu tương ứng. 
                        if (is_array($checkemail)) {
                            $thongbao="Mật khẩu của bạn là".$checkemail['pass'];
                        }
                        else{
                            $thongbao="Email này không tồn tại";
                        }
                    }
                    include "view/taikhoan/quenmk.php";
                    break;
        case 'gioithieu':
            include "view/gioithieu.php";
            break;
            case 'thoat':
                // Đăng xuất người dùng bằng cách xóa session và chuyển hướng về trang chủ.
                session_unset();
                header('Location:index.php');
                break;
        case 'lienhe':
            include "view/lienhe.php";
            break;
        default:
            include "view/home.php";
            break;
    }
} else {
    include "view/home.php";
}
include "view/footer.php";
?>