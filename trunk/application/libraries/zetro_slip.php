<?

class zetro_slip{
	public $path;
	function __construct($path=''){
		$this->path=$path;
	}
	function namafile($filename){
		$this->filename=$filename;
	}
	function colom($kolom){
		$this->colom=$colom;
	}
	
	function newline($jmlbaris=1){
		//$this->jmlbaris=1;
		for ($i=1;$i<=$jmlbaris;$i++){
			$this->jmlbaris .="\r\n";		
		}
		return $this->jmlbaris;
	}
	function modele($model="wb"){
		$this->model=$model;	
	}
	
	function create_file($nm=true){
		$newfile=fopen($this->path.'_slip.txt',$this->model);
		if ($nm==true){ fwrite($newfile,$this->newline());}
		foreach($this->isifile as $data){
		fwrite($newfile,$data);
		}
		if ($nm==true){ fwrite($newfile,$this->newline());}
		fclose($newfile);
	}
	function content($isifile=array()){
		$this->isifile=$isifile;
	}
}