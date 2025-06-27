<?php
class qlixuatkho extends controller{
    private $xk;
    function Get_data(){
        $this->view('Masterlayout', [
            'page' => 'Qlixuatkho_v'
        ]);
    }
    function __construct(){
        $this->xk = $this->model('Qlixuatkho_m');
    }
    function all(){
        $dulieu = $this->xk->all();
        $this->view('Masterlayout', [
            'page' => 'Qlixuatkho_v',
            'dulieu' => $dulieu
        ]);
    }
    function sua($mxk){
        $data = $this->xk->timkiem($mxk, '');
        $this->view('Masterlayout', [
            'page' => 'Qlixuatkhosua_v',
            'dulieu' => $data
        ]);
    }    
    function suadl(){
        if(isset($_POST['btnXuatkho'])){
            $mxk=$_POST['txtMxk'];
            $ngxk=$_POST['txtNxk'];
            $mdh = $_POST['slcMadh'];
            $msp = $_POST['slcMaSP'];
            $tsp = $_POST['txtTenSP'];
            $dg = $_POST['nbGia'];
            $sl = $_POST['nbSl'];
            $mk = $_POST['txtMk'];
            $nxk = $_POST['dateNxk'];
            
            if(!$this->xk->Checkdl($mxk,$ngxk,$mdh, $msp,$tsp, $dg, $sl, $mk, $nxk)){           
                return;
            }
            else{
                $kq = $this->xk->sua($mxk,$ngxk,$mdh, $msp,$tsp, $dg, $sl, $mk, $nxk);
                if($kq){
                    echo"<script>alert('Sửa thành công!')</script>";
                    echo "<script>window.location.href='http://localhost/baitaplon/Qlixuatkho/all';</script>";
                }else{
                    echo "<script>alert('Sửa thất bại!')</script>";
                }
            }
            $dulieu = $this->xk->timkiem($mxk, $mdh);
            $this->view('Masterlayout', [
                'page' => 'Qlixuatkho_v',
                'dulieu' => $dulieu
            ]);
        }
    }
    function xoa($mxk){
        $kq=$this->xk->xoa($mxk);
        $mdh = isset($_POST['slcMadh']) ? $_POST['slcMadh'] : '';
        $mxk = isset($_POST['txtMxk']) ? $_POST['txtMaxk'] : ''; 
        $dulieu=$this->xk->timkiem($mdh,$mxk);
        $this->view('Masterlayout',[
            'page'=>'Qlixuatkho_v',
            'dulieu'=>$dulieu,
            'Madonhang'=>$mdh,
            'Maxuatkho'=>$mxk
        ]);
    }
    function xuatexcel(){
        if(isset($_POST['btnXuatExcel'])){
            //code xuất excel
            $objExcel = new PHPExcel();
            $objExcel->setActiveSheetIndex(0);
            $sheet = $objExcel->getActiveSheet()->setTitle('Nhập kho');
            $rowCount = 1; //bắt đầu từ dòng 1 
            
            //Tạo tiêu đề cho cột trong excel
            $sheet->setCellValue('A'.$rowCount,'STT');
            $sheet->setCellValue('B'.$rowCount,'Mã xuất kho');
            $sheet->setCellValue('C'.$rowCount,'Người xuất kho');
            $sheet->setCellValue('D'.$rowCount,'Mã đơn hàng');
            $sheet->setCellValue('E'.$rowCount,'Mã sản phẩm'); 
            $sheet->setCellValue('F'.$rowCount,'Tên sản phẩm');
            $sheet->setCellValue('G'.$rowCount,'Đơn giá');
            $sheet->setCellValue('H'.$rowCount,'Số lượng');
            $sheet->setCellValue('I'.$rowCount,'Mã kho');
            $sheet->setCellValue('J'.$rowCount,'Ngày xuất kho');
        
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
            $sheet->getColumnDimension('J')->setAutoSize(true);
            //gán màu nền
            $sheet->getStyle('A1:J1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('00FF00');
            //căn giữa
            $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            //Điền dữ liệu vào các dòng. Dữ liệu lấy từ DB
            $mdh = isset($_POST['slcMadh']) ? $_POST['slcMadh'] : '';
            $mxk = isset($_POST['txtMxk']) ? $_POST['txtMxk'] : '';
            $data = $this->xk->timkiem($mxk, $mdh);

            while ($row = mysqli_fetch_array($data)) { 
                $rowCount++;
                $sheet->setCellValue('A'.$rowCount, $rowCount - 1);
                $sheet->setCellValue('B' . $rowCount, $row['Maxuatkho']);
                $sheet->setCellValue('C' . $rowCount, $row['Nguoixuatkho']);
                $sheet->setCellValue('D' . $rowCount, $row['Madonhang']);
                $sheet->setCellValue('E' . $rowCount, $row['MaSP']);
                $sheet->setCellValue('F' . $rowCount, $row['TenSP']);
                $sheet->setCellValue('G' . $rowCount, $row['Dongia']);
                $sheet->setCellValue('H' . $rowCount, $row['Soluong']);
                $sheet->setCellValue('I' . $rowCount, $row['Makho']);
                $sheet->setCellValue('J' . $rowCount, $row['Ngayxuatkho']);
            }
            
            //Kẻ bảng 
            $styleAray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $sheet->getStyle('A1:' . 'J' . ($rowCount))->applyFromArray($styleAray);
            $objWriter = new PHPExcel_Writer_Excel2007($objExcel);
            $fileName = 'xuatkho.xlsx';
            $objWriter->save($fileName);
            header('Content-Disposition: attachment; filename="'.$fileName.'"');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Length: '.filesize($fileName));
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate');
            header('Pragma: no-cache');
            readfile($fileName);
        }
    }
    function timkiem(){
        if(isset($_POST['btnTimkiem'])){
            $mxk=$_POST['txtMxk'];
            $mdh=$_POST['txtMadh'];
            $dulieu=$this->xk->timkiem($mxk,$mdh);
            $this->view('Masterlayout',[
                'page'=>'Qlixuatkho_v',
                'dulieu'=>$dulieu,
                'Maxuatkho'=>$mxk,
                'Madonhang'=>$mdh
            ]);
        }
    }
}
?>
