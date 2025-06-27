<?php
class Qlixuatkhochitiet extends controller {
    private $xk;

    function __construct() {
        $this->xk = $this->model('Qlixuatkhochitiet_m');
    }

    function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'Qlixuatkhochitiet_v'
        ]);
    }

    function them() {
        if (isset($_POST['btnXuatkho'])) {
            $mxk = $_POST['txtMxk'];
            $ngxk = $_POST['txtNxk'];
            $mdh = $_POST['slcMadh'];
            $msp = $_POST['slcMaSP'];
            $tsp = $_POST['txtTenSP']; 
            $dg = $_POST['nbGia'];
            $sl = $_POST['nbSl'];
            $mk = $_POST['txtMk']; 
            $nxk = $_POST['dateNxk'];
            if (!$this->xk->Checkdl($mxk, $ngxk, $mdh, $msp, $tsp, $dg, $sl, $mk, $nxk)) {
                return;
            }
            $kq = $this->xk->them($mxk, $ngxk, $mdh, $msp, $tsp, $dg, $sl, $mk, $nxk);
            if ($kq) {
                echo "<script>alert('Xuất kho thành công!')</script>";
                echo "<script>window.location.href='http://localhost/baitaplon/Qlixuatkho/all';</script>";
            } else {
                echo "<script>alert('Xuất kho thất bại!')</script>";
            }
        }
        $this->view('Masterlayout', [
            'page' => 'Qlixuatkho_v',
            'Maxuatkho' => $mxk,
            'Nguoixuatkho' => $ngxk,
            'Madonhang' => $mdh,
            'MaSP' => $msp,
            'TenSP' => $tsp,
            'Dongia' => $dg,
            'Soluong' => $sl,
            'Makho' => $mk,
            'Ngayxuatkho' => $nxk
        ]);
    }
}
?>