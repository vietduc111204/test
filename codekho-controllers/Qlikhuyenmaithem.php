<?php
class Qlikhuyenmaithem extends controller{
    private $kmt;
    function Get_data(){
        $this->view('Masterlayout',[
            'page'=>'Qlikhuyenmaithem_v'
        ]);
    }
    function __construct()
    {
        $this->kmt=$this->model('Qlikhuyenmaithem_m');
    }
    function them(){
        if(isset($_POST['btnThem'])){
            $mkm=$_POST['txtMakm'];
            $gtkm=$_POST['txtGtrikm'];
            $msp=$_POST['slcMaSP'];
            $mt=$_POST['txtMota'];

            if(!$this->kmt->checkdl($mkm,$gtkm,$msp, $mt)){
                return;
            }
            
            if($this->kmt->Checktrungma($mkm)){
                echo "<script>alert('Mã khuyến mãi đã tồn tại!');</script>";
                echo "<script>window.history.back();</script>";
                return;
            }else{
                $kq=$this->kmt->them($mkm, $gtkm,$msp,$mt);
                if($kq){
                    echo "<script>alert('Thêm thành công!')</script>";
                    echo "<script>window.location.href='http://localhost/baitaplon/Qlikhuyenmai/all';</script>";
                }else{
                    echo "<script>alert('Thêm thất bại!')</script>";
                }
            }
            $this->view('Masterlayout',[
                'page'=>'Qlikhuyenmai_v',
                'Makhuyenmai'=>$mkm,
                'Giatrikm'=>$gtkm,
                'MaSP'=>$msp,
                'Mota'=>$mt
            ]);
        }
    }
}
?>