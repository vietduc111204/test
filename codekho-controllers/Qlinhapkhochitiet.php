<?php
class qlinhapkhochitiet extends controller {
    private $nk;

    function __construct() {
        $this->nk = $this->model('Qlinhapkhochitiet_m');
    }

    function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'Qlinhapkhochitiet_v'
        ]);
    }

    function them() {
        if (isset($_POST['btnNhapkho'])) {
            $mnk = $_POST['txtMnk'];
            $tenncc = $_POST['slcTncc'];
            $tennn = $_POST['txtTennn'];
            $msp = $_POST['txtMaSP'];
            $tsp = $_POST['txtTenSP'];
            $mncc = $_POST['slcMncc'];
            $mk = $_POST['slcMk'];
            $sl = $_POST['nbSl'];
            $gia = $_POST['nbGia'];
            $nn = $_POST['dateNn'];
            $mt = $_POST['txtMota'];
            $mdm = $_POST['slcMdm'];
    
            if ($this->nk->Checkdl($mnk, $tenncc, $tennn, $msp, $tsp, $mncc, $mk, $sl, $gia, $nn, $mt, $mdm)) {
                $kq = $this->nk->them($mnk, $tenncc, $tennn, $msp, $tsp, $mncc, $mk, $sl, $gia, $nn, $mt, $mdm);
                if ($kq) {
                    echo "<script>alert('Nhập kho thành công!')</script>";
                    echo "<script>window.location.href='http://localhost/baitaplon/Qlinhapkho/all';</script>";
                } else {
                    echo "<script>alert('Nhập kho thất bại!')</script>";
                }
            }
        }
    
        $this->view('Masterlayout', [
            'page' => 'Qlinhapkho_v',
            'Manhapkho' => $mnk,
            'Tenncc' => $tenncc,
            'Tennguoinhap' => $tennn,
            'Msp' => $msp,
            'Tsp' => $tsp,
            'Mancc' => $mncc,
            'Makho' => $mk,
            'Soluong' => $sl,
            'Gia' => $gia,
            'Ngaynhap' => $nn,
            'Motangan' => $mt,
            'Madanhmuc' => $mdm
        ]);
    }
}

?>