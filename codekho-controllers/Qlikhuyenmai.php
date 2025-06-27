<?php
class QLikhuyenmai extends controller{
    private $km;
    function Get_data(){
        $this->view('Masterlayout',[
            'page'=>'Qlikhuyenmai_v'
        ]);
    }
    function __construct()
    {
        $this->km=$this->model('Qlikhuyenmai_m');
    }
    function timkiem(){
        if(isset($_POST['btnTimkiem'])){
            $mkm=$_POST['txtMakm'];
            $msp=$_POST['txtMaSP'];
            $dulieu=$this->km->timkiem($mkm,$msp);
            $this->view('Masterlayout',[
                'page'=>'Qlikhuyenmai_v',
                'dulieu'=>$dulieu,
                'Makhuyenmai'=>$mkm,
                'MaSP'=>$msp
            ]);
        }
    }
    function sua($mkm){
        $data=$this->km->timkiem($mkm,'');
        $this->view('Masterlayout',[
            'page'=>'Qlikhuyenmaisua_v',
            'dulieu'=>$data
        ]);
    }
    function suadl(){
        if(isset($_POST['btnThem'])){
            $mkm=$_POST['txtMakm'];
            $gtkm=$_POST['txtGtrikm'];
            $msp=$_POST['slcMaSP'];
            $mt=$_POST['txtMota'];

            if(!$this->km->checkdl($mkm,$gtkm,$msp, $mt)){
                return;
            }
            
            else{
                $kq=$this->km->sua($mkm, $gtkm,$msp,$mt);
                if($kq){
                    echo "<script>alert('Sửa thành công!')</script>";
                    echo "<script>window.location.href='http://localhost/baitaplon/Qlikhuyenmai/all';</script>";
                }else{
                    echo "<script>alert('Sửa thất bại!')</script>";
                }
            }
            $dulieu=$this->km->timkiem($mkm,$msp);
            $this->view('Masterlayout',[
                'page'=>'Qlikhuyenmai_v',
                'dulieu'=>$dulieu
            ]);
        }
    }
    function xoa($mkm){
        $kq=$this->km->xoa($mkm);
        if($kq){
            echo "<script>alert('Xóa thành công!')</script>";
        }else{
            echo "<script>alert('Xóa thất bại!')</script>";
        }
        $mkm = isset($_POST['txtMakm']) ? $_POST['txtMakm'] : '';
        $msp = isset($_POST['slcMaSP']) ? $_POST['slcMaSP'] : ''; 
        $dulieu=$this->km->timkiem($msp, $msp);
        $this->view('Masterlayout',[
            'page'=>'Qlikhuyenmai_v',
            'dulieu'=>$dulieu,
            'Makhuyenmai'=>$mkm,
            'MaSP'=>$msp
        ]);
    }
    function all(){
        $dulieu = $this->km->all();
        $this->view('Masterlayout', [
            'page' => 'Qlikhuyenmai_v',
            'dulieu' => $dulieu
        ]);
    }
}
?>