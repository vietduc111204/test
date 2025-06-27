<?php
class qlinhapkho extends controller{
    private $nk;
    function Get_data(){
        $this->view('Masterlayout',[
            'page'=>'Qlinhapkho_v'
        ]);
    }
    function __construct()
    {
        $this->nk = $this-> model('Qlinhapkho_m');
    }
    function all(){
        $dulieu = $this->nk->all();
        $this->view('Masterlayout', [
            'page' => 'Qlinhapkho_v',
            'dulieu' => $dulieu
        ]);
    }
    function timkiem(){
        if(isset($_POST['btnTimkiem'])){
            $msp=$_POST['txtMaSP'];
            $mnk=$_POST['txtMnk']; 
            $dulieu=$this->nk->timkiem($mnk,$msp);
            $this->view('Masterlayout',[
                'page'=>'Qlinhapkho_v',
                'dulieu'=>$dulieu,
                'MaSP'=>$msp,
                'Manhapkho'=>$mnk
            ]);
        }
        if(isset($_POST['btnXuat'])){
            //code xuất excel
            $objExcel=new PHPExcel();
            $objExcel->setActiveSheetIndex(0);
            $sheet=$objExcel->getActiveSheet()->setTitle('Nhập kho');
            $rowCount=1;//bắt đầu từ dòng 1 
            
            //Tạo tiêu đề cho cột trong excel
            $sheet->setCellValue('A'.$rowCount,'STT');
            $sheet->setCellValue('B'.$rowCount,'Mã nhập kho');
            $sheet->setCellValue('C'.$rowCount,'Tên nhà cung cấp');
            $sheet->setCellValue('D'.$rowCount,'Tên người nhập');
            $sheet->setCellValue('E'.$rowCount,'Mã sản phẩm');
            $sheet->setCellValue('F'.$rowCount,'Tên sản phẩm');
            $sheet->setCellValue('G'.$rowCount,'Mã nhà cung cấp');
            $sheet->setCellValue('H'.$rowCount,'Mã kho');
            $sheet->setCellValue('I'.$rowCount,'Số lượng');
            $sheet->setCellValue('J'.$rowCount,'Giá');
            $sheet->setCellValue('K'.$rowCount,'Ngày nhập');
            $sheet->setCellValue('L'.$rowCount,'Mô tả');
       
            $sheet->setCellValue('M'.$rowCount,'Mã danh mục');
        
            //định dạng cột tiêu đề
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);
            $sheet->getColumnDimension('M')->setAutoSize(true);
          
            //gán màu nền
            $sheet->getStyle('A1:M1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');
            //căn giữa
            $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //Điền dữ liệu vào các dòng. Dữ liệu lấy từ DB
            $msp=$_POST['txtMaSP'];
            $mnk=$_POST['txtMnk'];

            $data=$this->nk->timkiem($mnk,$msp);

    
                while ($row = mysqli_fetch_array($data)) { 
                    $rowCount++;
                    $sheet->setCellValue('A'.$rowCount,$rowCount - 1);
                    $sheet->setCellValue('B'.$rowCount,$row['Manhapkho']);
                    $sheet->setCellValue('C'.$rowCount,$row['Tenncc']);
                    $sheet->setCellValue('D'.$rowCount,$row['Tennguoinhap']);
                    $sheet->setCellValue('E'.$rowCount,$row['MaSP']);
                    $sheet->setCellValue('F'.$rowCount,$row['TenSP']);
                    $sheet->setCellValue('G'.$rowCount,$row['Mancc']);
                    $sheet->setCellValue('H'.$rowCount,$row['Makho']);
                    $sheet->setCellValue('I'.$rowCount,$row['Soluong']);
                    $sheet->setCellValue('J'.$rowCount,$row['Dongia']);
                    $sheet->setCellValue('K'.$rowCount,$row['Ngaynhap']);
                    $sheet->setCellValue('L'.$rowCount,$row['Mota']);
                  
                    $sheet->setCellValue('M'.$rowCount,$row['Madanhmuc']);
                }
                
                //Kẻ bảng 
                $styleAray=array(
                    'borders'=>array(
                        'allborders'=>array(
                            'style'=>PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                    );
                $sheet->getStyle('A1:'.'M'.($rowCount))->applyFromArray($styleAray);
                $objWriter=new PHPExcel_Writer_Excel2007($objExcel);
                $fileName='nhapkho.xlsx';
                $objWriter->save($fileName);
                header('Content-Disposition: attachment; filename="'.$fileName.'"');
                header('Content-Type: application/vnd.openxlmformatsofficedocument.speadsheetml.sheet');
                // header('Content-Type: application/vnd.ms-excel');
                header('Content-Length: '.filesize($fileName));
                header('Content-Transfer-Encoding:binary');
                header('Cache-Control: must-revalidate');
                header('Pragma: no-cache');
                readfile($fileName);
        }
    }
    function sua($mnk){
        $data=$this->nk->timkiem($mnk,'');
        $this->view('Masterlayout',[
            'page'=>'Qlinhapkhosua_v',
            'dulieu'=>$data
        ]);
    }
    function suadl() {
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
            if (!$this->nk->Checkdl($mnk, $tenncc, $tennn, $msp, $tsp, $mncc, $mk, $sl, $gia, $nn, $mt, $mdm)) {
                return;
            }
            if ($this->nk->sua($mnk, $tenncc, $tennn, $msp, $tsp, $mncc, $mk, $sl, $gia, $nn, $mt, $mdm)) {
                echo "<script>alert('Sửa thành công!')</script>";
                echo "<script>window.location.href='http://localhost/baitaplon/Qlinhapkho/All';</script>";
            } else {
                echo "<script>alert('Sửa thất bại!')</script>";
            }
            $dulieu = $this->nk->timkiem($mnk, $msp);
            $this->view('Masterlayout', [
                'page' => 'Qlinhapkho_v',
                'dulieu' => $dulieu
            ]);
        }
    }
    
    function xoa($mnk){
        $kq=$this->nk->xoa($mnk);
        $mnk = isset($_POST['txtMnk']) ? $_POST['txtMnk'] : ''; 
        $msp = isset($_POST['txtMaSP']) ? $_POST['txtMaSP'] : '';
        
        $dulieu=$this->nk->timkiem($mnk, $msp);
        $this->view('Masterlayout',[
            'page'=>'Qlinhapkho_v',
            'dulieu'=>$dulieu,
            'Manhapkho'=>$mnk,
            'MaSP'=>$msp
        ]);
    }
}
?>