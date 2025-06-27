<?php
class qlinhapkhothem extends controller {
    private $nk;

    function __construct() {
        $this->nk = $this->model('Qlinhapkhothem_m');
    }

    function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'Qlinhapkhothem_v'
        ]);
    }

    function them() {
        if (isset($_POST['btnNhapkho'])) {
            $mnk = $_POST['txtMnk'];
            $tenncc = $_POST['slcTncc'];
            $tennn = $_POST['txtTennn'];
            $mncc = $_POST['slcMncc'];
            $sl = $_POST['nbSl'];
            $nn = $_POST['dateNn'];
    
            if ($this->nk->Checkdl($mnk, $tenncc, $tennn, $mncc, $sl, $nn)) {
                $kq = $this->nk->them($mnk, $tenncc, $tennn, $mncc, $sl, $nn);
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
            'Mancc' => $mncc,
            'Soluong' => $sl,
            'Ngaynhap' => $nn
        ]);
    }
}

?>