<?php
//define('FPDF_FONTPATH', 'font/');
require('fpdf.php');

class reportProduct extends FPDF {
  var $widths;
  var $aligns;

	function SetWidths($w){
	//lebar kolom
	  $this->widths=$w;
	}
	
	function SetAligns($a){
	//aligment kolom
	  $this->aligns=$a;
	}

function Row($data,$rec=true,$color=false,$kolom='',$kolom1='',$kolom2=''){
//content , isi baris
  $nb=0;
  for($i=0;$i<count($data);$i++) $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	  $h=(5.5*$nb);
	  $this->CheckPageBreak($h);
	  for($i=0;$i<count($data);$i++){
		    $ling3=0;

		   $w=$this->widths[$i];
		   $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		   $x=$this->GetX();
		   $y=$this->GetY();
		   ($color==false)? 
		   		$this->SetTextColor(0):
		  		($kolom==$i || $kolom1==$i || $kolom2==$i)?
					 $this->SetTextColor(255,0,0):
					 $this->SetTextColor(0);
					 
		   ($rec==true)? $this->Rect($x,$y,$w,$h+2):'';
		   $ling=explode('|',$data[$i]);
		   $ling3=count($ling);
		   ($ling3>1)? $jm=base_url().'member/detail/'.$ling[0]:$jm='';
		   $this->AddLink();
		   $this->SetLink($jm);
		   $this->MultiCell($w,6,$ling[0],'',$a,0,$jm);
		   
		   $this->SetXY($x+$w,$y);
	  }
  $this->Ln($h+2);
}

function CheckPageBreak($h){
  if($this->GetY()+$h>$this->PageBreakTrigger)
  $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt){
  $cw=&$this->CurrentFont['cw'];
  if($w==0)
   	$w		=$this->w-$this->rMargin-$this->x;
  	$wmax	=($w-2*$this->cMargin)*1000/$this->FontSize;
  	$s		=str_replace("\r",'',$txt);
  	$nb		=strlen($s);
  if($nb>0 and $s[$nb-1]=="\n")
   	  $nb--;
	  $sep=-1;
	  $i=0;
	  $j=0;
	  $l=0;
	  $nl=1;
  while($i<$nb){
   $c=$s[$i];
   if($c=="\n") {
		$i++;
		$sep=-1;
		$j=$i;
		$l=0;
		$nl++;
		continue;
   }
   if($c==' ')
    $sep=$i;
   $l+=$cw[$c];
   if($l>$wmax) {
    if($sep==-1) {
     if($i==$j)
      $i++;
    }
    else
     $i=$sep+1;
    $sep=-1;
    $j=$i;
    $l=0;
    $nl++;
   }
   else
   $i++;
 }
 return $nl;
}

function Header()
{
	$zn=new zetro_manager();
	$nfile='asset/bin/zetro_config.dll';
  if($this->kriteria=="transkip"){
	$co		=$zn->rContent('InfoCo','subtitle',$nfile);
	$address=$zn->rContent('InfoCo','Address',$nfile);
	$kota	=$zn->rContent('InfoCo','Kota',$nfile);
	$prop	=$zn->rContent('InfoCo','Propinsi',$nfile);
	$telp	=$zn->rContent('InfoCo','Telp',$nfile);
	$fax	=$zn->rContent('InfoCo','Fax',$nfile);
	$BH		=$zn->rContent('InfoCo','BH',$nfile);
	   $this->Ln(2);
	  // $this->Image(base_url().'asset/img/logo100.jpg',5,7,28,28);
	   $this->SetFont('Arial','B',15);
	   $this->Cell(25.5);
	   $this->MultiCell(120,5,$co,0,1,'L');
	   $this->Cell(25.5);
	   $this->SetFont('Arial','B',11);
	   $this->MultiCell(100,5,$BH,0,1,'C');
	   $this->SetFont('Arial','',10);
	   $this->Cell(25.5);
	   $this->MultiCell(0,6,$address." ". $kota." ". $prop,0,1,'C');
	   $this->SetFont('Arial','',10);
	   $this->Cell(25.5);
	   $this->MultiCell(0,4,$telp." ". $fax,0,1,'C');
	   $this->Ln(5);
	   $this->SetFont('Arial','B',10);
	   ($this->CurOrientation=='P')?
	   $this->MultiCell(0,4,str_repeat("_",95),0,1,'C'):
	   $this->MultiCell(0,4,str_repeat("_",140),0,1,'C');
	   $this->SetFont('Arial','B',14);
	   $this->Cell(0,10,$this->nama,2,1,'C');
	   $this->SetFont('Arial','B',10);
			  $this->Ln(2); // spasi enter
			  $this->SetFont('Arial','B',11); // set font,size,dan properti (B=Bold)
			  $n=0;
			  foreach($this->refer as $rr){
				  $this->Cell(40,6,$rr,0,0,'L');
				  $this->Cell(130,6,': '.$this->filter[$n],0,1,'L');
				$n++;
			  }
			  $this->Ln(2);
			  // set nama header tabel transaksi
			  $this->SetFillColor(225,225,225);
			  $kol=$zn->Count($this->section,$this->nfilex);
			  $this->Cell(10,8,'No.',1,0,'C',true);
			  for ($i=1;$i<=$kol;$i++){
				  $d=explode(',',$zn->rContent($this->section,$i,$this->nfilex));
				  $this->Cell($d[9],8,$d[0],1,0,'C',true);
			  }
			  $this->Ln();
	
  }
  if($this->kriteria=='faktur'){
		$co		=$zn->rContent('InfoCo','Name',$nfile);
		$address=$zn->rContent('InfoCo','Address',$nfile);
		$kota	=$zn->rContent('InfoCo','Kota',$nfile);
		$telp	=$zn->rContent('InfoCo','Telp',$nfile);
		$fax	=$zn->rContent('InfoCo','Fax',$nfile);
		$npwp	=$zn->rContent('InfoCo','NPWP',$nfile);
		$nppkp	=$zn->rContent('InfoCo','NPPKP',$nfile);
		
		   $this->Ln(2);
		   $this->SetFont('Arial','B',14);
		   $this->Cell(110,4,$co,0,0,'L');
		   $this->SetFont('Arial','',10);
		   $this->Cell(120,6,$this->nama,0,1,'L');
		   $this->Cell(110,6,$address." ". $kota,0,0,'L');
		   $this->Cell(120,6,'Customer :',0,1,'L');
		   $this->Cell(110,6,$telp." ". $fax,0,0,'L');
		   $this->Cell(120,6,$this->refer,0,1,'L');
		   $this->Cell(110,6,$npwp,0,0,'L');
		   $this->Cell(120,6,$this->filter,0,1,'L');
		   $this->Cell(110,6,$nppkp,0,0,'L');
		   $this->Cell(120,6,'NPWP :',0,1,'L');
		   $this->Cell(110,4,'Nomor Seri faktur: '.date('zYmd-Hs'),0,0,'L');
		   $this->Cell(120,6,'Tanggal : '.date('d F Y'),0,1,'L');
		   $this->SetFont('Arial','B',10);
		   $this->SetLineWidth(0.4);
		   $this->Line(10,50,197,50);
		   $this->Ln();
		   $this->SetLineWidth(0.2);
		   $this->SetFont('Arial','B',12);
			//header table
			// set nama header tabel transaksi
			  $this->Ln(2);
			  $this->SetFillColor(225,225,225);
			  $kol=$zn->Count($this->section,$this->nfilex);
			  $this->Cell(10,8,'No.',1,0,'C',true);
			  for ($i=1;$i<=$kol;$i++){
				  $d=explode(',',$zn->rContent($this->section,$i,$this->nfilex));
				  $this->Cell($d[9],8,$d[0],1,0,'C',true);
			  }
			  $this->Ln();
 }
 if($this->kriteria=='neraca'){
	$co		=$zn->rContent('InfoCo','subtitle',$nfile);
	$address=$zn->rContent('InfoCo','Address',$nfile);
	$kota	=$zn->rContent('InfoCo','Kota',$nfile);
	$prop	=$zn->rContent('InfoCo','Propinsi',$nfile);
	$telp	=$zn->rContent('InfoCo','Telp',$nfile);
	$fax	=$zn->rContent('InfoCo','Fax',$nfile);
	$BH		=$zn->rContent('InfoCo','BH',$nfile);
	   $this->Ln(2);
	   $this->SetFont('Arial','B',15);
	  // $this->Image(base_url().'asset/img/logo100.jpg',5,7,25,25);
	   $this->SetFont('Arial','B',15);
	   $this->Cell(25.5);
	   $this->MultiCell(120,5,$co,0,1,'L');
	   $this->Cell(25.5);
	   $this->SetFont('Arial','B',11);
	   $this->MultiCell(100,5,$BH,0,1,'C');
	   $this->SetFont('Arial','',10);
	   $this->Cell(25.5);
	   $this->MultiCell(0,6,$address." ". $kota." ". $prop,0,1,'C');
	   $this->SetFont('Arial','',10);
	   $this->Cell(25.5);
	   $this->MultiCell(0,4,$telp." ". $fax,0,1,'C');
	   $this->Ln(2);
	   $this->SetFont('Arial','B',10);
	   ($this->CurOrientation=='P')?
	   $this->MultiCell(0,4,str_repeat("_",95),0,1,'C'):
	   $this->MultiCell(0,4,str_repeat("_",140),0,1,'C');
	   $this->SetFont('Arial','B',14);
	   $this->Cell(0,10,$this->nama,2,1,'L');
	   $this->SetFont('Arial','B',10);
			  //$this->Ln(1); // spasi enter
			  $this->SetFont('Arial','B',11); // set font,size,dan properti (B=Bold)
			  $n=0;
			  if(!empty($this->refer)){
				  foreach($this->refer as $rr){
					  $this->Cell(30,6,$rr,0,0,'L');
					  $this->Cell(100,6,': '.$this->filter[$n],0,1,'L');
					$n++;
				  }
			  }
			  $this->Ln(1);
	   $this->SetFont('Arial','B',10);
		   ($this->CurOrientation=='P')?
		   $this->MultiCell(0,4,str_repeat("_",95),0,1,'C'):
		   $this->MultiCell(0,4,str_repeat("_",140),0,1,'C');
 }
}

function Footer(){
 // Position at 1.5 cm from bottom
  ($this->kriteria=='neraca')?$this->SetY(-10):$this->SetY(-15);
  //Arial italic 8
  $this->SetFont('Arial','i',7);
  if($this->kriteria=='faktur'){
  $this->Cell(150,10,'Berlaku sebagai faktur pajak sesuai Peraturan Menkeu No. 38/PMK.03/2010',0,0,'L');
  }else{
  //$this->Cell(0,10,'Print Date :'.date('d F Y'),0,0,'C');
  }
  $this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'R');
}

	public function setKriteria($i){
	  $this->kriteria=$i;
	}
	
	public function getKriteria(){
	  return $this->kriteria;
	}
	
	public function setNama($n){
	  $this->nama=$n;
	}
	public function getNama(){
	  return $this->nama;
	}
	public function setReferer($n){
		$this->refer=$n;
	 
	}
	public function getReferer(){
	  $this->refer;
	}
	
	public function setSection($n){
	  $this->section=$n;
	}
	
	public function getSection(){
	  return $this->section;
	}
	public function setFilter($n){
		$this->filter=$n;
	}
	public function getFilter(){
		return $this->filter;
	}
	public function setDataset($n){
	  $this->dataset=$n;
	}
	
	public function setFilename($n){
		$this->nfilex=$n;
	}
	public function getFilename(){
		return $this->nfilex;
	}
	public function getDataset(){
	  return $this->dataset;
	}
	//put link url
/*function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}

function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}

function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}*/
}

?>