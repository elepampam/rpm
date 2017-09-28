<?php
class PDF extends FPDF
{
    protected $ppnDebit;
    protected $ppnKredit;
    protected $selisihPpn;
    protected $totalKredit;
    protected $ppnUnKredit;
    protected $totalDebit;
    protected $ppnUnDebit;
    protected $kontrolRekon;
    protected $fakturKredit;
    protected $fakturDebit;

    public function __construct($ppnDebit,$ppnKredit,$selisihPpn,$totalKredit,$ppnUnKredit,
        $totalDebit,$ppnUnDebit,$kontrolRekon,$fakturKredit,$fakturDebit){
        parent::__construct();
        $this->ppnDebit = $ppnDebit;        
        $this->ppnKredit =  $ppnKredit;
        $this->selisihPpn =  $selisihPpn;
        $this->totalKredit =  $totalKredit;
        $this->ppnUnKredit =  $ppnUnKredit;
        $this->totalDebit =  $totalDebit;
        $this->ppnUnDebit =  $ppnUnDebit;
        $this->kontrolRekon =  $kontrolRekon;
        $this->fakturKredit =  $fakturKredit;
        $this->fakturDebit =  $fakturDebit;
    }

    private function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
    {
        // Store reset values for (x,y) positions
        $x = $this->GetX() + $w;
        $y = $this->GetY();

        // Make a call to FPDF's MultiCell
        $this->MultiCell($w,$h,$text,$border,$align,$fill);

        // Reset the line position to the right, like in Cell
        if( $ln==0 )
        {
            $this->SetXY($x,$y);
        }
    }

	//Page header
	public function Header()
	{     
        $this->Image(base_url().'/assets/images/logo-itdc.png',145,10,'50px','20px','PNG');
        
        $this->Line(10,35,350,35);
        $this->Ln(30);

        $this->setFont('Arial','',14);                        
        $this->Cell(340,6,'REKONSILIASI PAJAK MASUKKAN',1,1,'C',0);

        $this->Ln(1);
        $this->setFont('Arial','',10);        
        $this->cell(60,6,'Saldo Pajak Masukkan : ',1,0,'L',0);
        $this->cell(60,6,$this->ppnDebit,1,0,'L',0);
        $this->Cell(95,6,'Jumlah Pajak Masukkan Yang Belum Dikreditkan : ',1,0,'R',0);
        $this->cell(60,6,$this->ppnUnDebit,1,1,'R',0);
        $this->cell(60,6,'Pengkredittan Pajak Masukkan :',1,0,'L',0);
        $this->cell(60,6,$this->ppnKredit,1,0,'L',0);
        $this->Cell(95,6,'Jumlah Faktur Pajak Yang Belum Dikreditkan : ',1,0,'R',0);
        $this->cell(60,6,$this->totalDebit.' Faktur',1,1,'R',0);
        $this->cell(60,6,'Selisih Akibat Rekonsiliasi : ',1,0,'L',0);
        $this->cell(60,6,$this->selisihPpn,1,0,'L',0);
        $this->MultiAlignCell(95,6,'Jumlah Kredit Pajak Masukkan Yang Belum Diakui Sebagai Pajak Masukkan : ',1,0,'R',0);
        $this->cell(60,6,$this->ppnUnKredit,1,1,'R',0);
        $this->SetXY($this->GetX()+120, $this->GetY()+6);
        $this->cell(95,6,'Saldo Pajak Masukkan : ',1,0,'L',0);
        $this->cell(60,6,$this->ppnDebit,1,1,'R',0);

        $this->Ln(5);

        $this->setFont('Arial','B',10);                        
        $this->Cell(275,6,'Penyebab Selisih Akibat Rekonsiliasi Pajak Masukkan',1,1,'L',0);   

        $this->Ln(1);
        $this->SetX($this->GetX()+60);
        $this->setFillColor(159,206,88);
        $this->cell(6,6,' ',1,0,'R',1);
        $this->cell(80,6,'Pajak Masukkan Yang Belum Dikreditkan',1,0,'L',0);
        $this->setFillColor(74,186,243);
        $this->cell(6,6,' ',1,0,'R',1);
        $this->cell(80,6,'Pajak Masukkan Yang Belum Diakui',1,1,'L',0);
        $this->Ln(3);

	}
 
	function Content()
	{
        $count = 0;
        $this->setFont('Arial','',10);
        $this->cell(10,6,'NO',1,0,'C',0);
        $this->cell(40,6,'NO FAKTUR',1,0,'C',0);
        $this->cell(40,6,'TANGGAL FAKTUR',1,0,'C',0);
        $this->cell(40,6,'NPWP',1,0,'C',0);
        $this->cell(40,6,'NAMA',1,0,'C',0);
        $this->cell(50,6,'ALAMAT LENGKAP',1,0,'C',0);
        $this->cell(40,6,'JUMLAH DPP',1,0,'C',0);
        $this->cell(40,6,'JUMLAH PPN',1,0,'C',0);
        $this->cell(40,6,'JUMLAH PPNBM',1,1,'C',0);

        foreach ($this->fakturDebit as $faktur) {
            $this->setFillColor(159,206,88);
            $this->cell(10,6,++$count,1,0,'C',1);
            $this->cell(40,6,$faktur->NO_FAKTUR,1,0,'C',1);
            $this->cell(40,6,$faktur->TANGGAL_FAKTUR,1,0,'C',1);
            $this->cell(40,6,$faktur->NPWP,1,0,'C',1);
            $this->MultiAlignCell(40,6,$faktur->NAMA,1,0,'C',1);
            $this->MultiAlignCell(50,6,$faktur->ALAMAT_LENGKAP,1,0,'C',1);
            $this->cell(40,6,$faktur->JUMLAH_DPP,1,0,'C',1);
            $this->cell(40,6,$faktur->JUMLAH_PPN,1,0,'C',1);
            $this->cell(40,6,$faktur->JUMLAH_PPNBM,1,1,'C',1);
        }
        foreach ($this->fakturKredit as $faktur) {
            $this->setFillColor(74,186,243);
            $this->cell(10,6,++$count,1,0,'C',1);
            $this->cell(40,6,$faktur->NO_FAKTUR,1,0,'C',1);
            $this->cell(40,6,$faktur->TANGGAL_FAKTUR,1,0,'C',1);
            $this->cell(40,6,$faktur->NPWP,1,0,'C',1);
            $this->MultiAlignCell(40,6,$faktur->NAMA,1,0,'C',1);
            $this->MultiAlignCell(50,6,$faktur->ALAMAT_LENGKAP,1,0,'C',1);
            $this->cell(40,6,$faktur->JUMLAH_DPP,1,0,'C',1);
            $this->cell(40,6,$faktur->JUMLAH_PPN,1,0,'C',1);
            $this->cell(40,6,$faktur->JUMLAH_PPNBM,1,1,'C',1);
        }


            // // $ya = 46;
            // // $rw = 6;
            // // $no = 1;
            //     foreach ($data as $key) {

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Nama Lengkap',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);	
            //             $this->cell(90,6,$key->Nama,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Alamat',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->Alamat,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'No Telp',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->NoTelp,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Jenis Transaksi',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->JenisTarif,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Kode Kunci',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->IdKodeKunci,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Berat',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->Berat.' Kg',1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Harga',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,'Rp '.$key->Berat * $key->Tarif,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'No Telp',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->NoTelp,1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Baju Kaos',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->BajuKaos.' buah',1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Celana',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->Celana.' buah',1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Kemeja',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->Kemeja.' buah',1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Handuk',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->Handuk.' buah',1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Pakaian Dalam',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->PakaianDalam.' buah',1,1,'L',1);

            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(230,230,200);
            //             $this->cell(40,6,'Kaos Kaki',1,0,'C',1);
            //             $this->setFont('Arial','',10);
            //             $this->setFillColor(255,255,255);   
            //             $this->cell(90,6,$key->KaosKaki.' pasang',1,1,'L',1);
                        
            //             // $ya = $ya + $rw;
            //             // $no++;

            //             $this->Ln(12);
            //             $this->setFont('Arial','',12);
            //             $this->setFillColor(255,255,255);
            //             $this->cell(10,6,'',0,0,'C',0); 
            //             $this->cell(40,6,'Pegawai',0,0,'C',1);     

            //             $this->setFont('Arial','',12);
            //             $this->setFillColor(255,255,255);
            //             $this->cell(30,6,'',0,0,'C',0); 
            //             $this->cell(40,6,'Penerima',0,1,'C',1); 

            //             $this->Ln(25);
            //             $this->setFont('Arial','',12);
            //             $this->setFillColor(255,255,255);
            //             $this->cell(10,6,'',0,0,'C',0); 
            //             $this->cell(40,6,'..............................',0,0,'C',1);

            //             $this->setFont('Arial','',12);
            //             $this->setFillColor(255,255,255);
            //             $this->cell(30,6,'',0,0,'C',0); 
            //             $this->cell(40,6,'..............................',0,1,'C',1); 
            //     }
                        
 
	}
	function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),140,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
                $this->Cell(0,10,'copyright sila.com ' . date('Y'),0,0,'L');
		// //nomor halaman
		// $this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
$ppnDebit = "Rp ".number_format($ppnDebit, 2, ',', '.');
$ppnKredit = "Rp ".number_format($ppnKredit, 2, ',', '.');
$selisihPpn = "Rp ".number_format($selisihPpn, 2, ',', '.');;
$totalKredit;
$ppnUnKredit = "Rp ".number_format($ppnUnKredit, 2, ',', '.');
$totalDebit;
$ppnUnDebit = "Rp ".number_format($ppnUnDebit, 2, ',', '.');
$kontrolRekon = "Rp ".number_format($kontrolRekon, 2, ',', '.');;
$fakturKredit;
$fakturDebit;

$pdf = new PDF($ppnDebit,$ppnKredit,$selisihPpn,$totalKredit,$ppnUnKredit,
        $totalDebit,$ppnUnDebit,$kontrolRekon,$fakturKredit,$fakturDebit);
$pdf->AliasNbPages();
$pdf->AddPage('L','Legal');
$pdf->Content();
ob_end_clean();
$pdf->Output();