<?php
class Qlixuatkhothem extends controller {
    private $xk;

    function __construct() {
        $this->xk = $this->model('Qlixuatkhothem_m');
    }

    function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'Qlixuatkhothem_v'
        ]);
    }

    function them() {
        if (isset($_POST['btnXuatkho'])) {
            $mxk = $_POST['txtMxk'];
            $ngxk = $_POST['txtNxk'];
            $sl = $_POST['nbSl'];
            $nxk = $_POST['dateNxk'];

            if (!$this->xk->Checkdl($mxk, $ngxk, $sl, $nxk)) {
                return;
            }
            if($this->xk->Checktrungma($mxk)){
                echo "<script>alert('Mã xuất kho đã tồn tại!');</script>";
                echo "<script>window.history.back();</script>";
                return;
            }
            $kq = $this->xk->them($mxk, $ngxk, $sl, $nxk);
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
            'Soluong' => $sl,
            'Ngayxuatkho' => $nxk
        ]);
    }
}

?>