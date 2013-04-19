<?php
//class Name: formBuilder
//version	: 1.2
//Author	: Iswan Putera
//function	: Build automatic generate form and field from file zetro_ .frm

class zetro_frmBuilder extends zetro_manager {
	public $brs;
	public $tambahtxt;
	function zetro_frmBuilder($path=''){
		$this->path=$path;
	}
	function frm_filename($path){
		$this->path=$path;
	}
	function start_form($stat=false,$formid='frm1',$action=''){
	    $this->statu=$stat;
		return ($stat==true)?
	   	$this->start_frm="<form id='$formid' name='$formid' method='post' action='$action'>\n":
		$this->start_frm="\n";	
	}
	function end_form(){
		return ($this->statu==true)? "</form>":"";
	}
	function BuildForm($section,$button=false,$width='100%',$idTable='',$buttonCount='2'){
		//$zm= new zetro_manager;
		$jml=$this->Count($section,$this->path);
		($idTable!=='')?$idt=$idTable:$idt='fmrTable';
		echo $this->start_frm;
		echo "<table id='".$idt."' width='$width'>\n";
		// add baris kosong 
		echo ($this->posisi=='top')?$this->brs:"<tr><td colspan='3'>&nbsp;</td></tr>\n";
		for ($i=1;$i<=$jml;$i++){
			$fld=explode(',',$this->rContent($section,$i,$this->path));
			(!empty($fld[10]))?$ad="<input type='button' id='add-".$fld[3]."' value='+' title='Add ".$fld[0]."'>":$ad='';
			echo "<tr id='$i'>\n
				  <td id='c1$i' ";
				   if($fld[0]==''){echo "class=''";}else{echo "class='border_b'";}
				   echo " width='42%'>&nbsp;&nbsp;".$fld[0]."</td>\n
				  <td id='c2$i' width='60%' >";
				  $tp=explode(" ",$fld[2]);
				  //if ($fld[1]!='')
				  switch($fld[1]){
					  case 'input':
				  		echo "<".$fld[1]." type='".$tp[0]."' id='".$fld[3]."' name='".$fld[3]."' value='".$fld[5]."' class='".$fld[4]."'>".$ad;
					  break;
					  case 'select':
					  	echo "<".$fld[1]." id='".$fld[3]."' name='".$fld[3]."' class='".$fld[4]."'>";
						if (count($fld)>=9){
							if($fld[7]=='RS'){
							echo "<option></option>";
								for ($x=1;$x<=$this->Count($fld[8],$this->path);$x++){
									$data=explode(",",$this->rContent($fld[8],$x,$this->path));
								echo "<option value='".$data[0]."'>".$data[1]."</option>\n\r";
								}
							}else if($fld[7]=='RD'){
								$data=explode("-",$fld[8]);
								dropdown($data[0],$data[1],$data[2],$data[3]);
							}
						}
						echo "</select>".$ad ;
					  break;
					  case 'textarea':
					  	echo "<".$fld[1]." id='".$fld[3]."' name='".$fld[3]."' class='".$fld[4]."'></textarea>".$ad;
					  break;
					  case 'button':
				  		//echo "<".$fld[1]." type='".$fld[2]."' id='".$fld[3]."' value='".$fld[5]."' class='".$fld[4]."'></td>";
					  break;	   
				  }
			echo "</td>\n<td id='c3$i' width='8%'>&nbsp;</td>\n</tr>";
		}
		if($button==false){echo "</table>".$this->tambahtxt."<input type='reset' style='display:none' id='xx'>"; 
			echo $this->end_form();}else{
			if($fld[1]=='button'){$this->BuildFormButton($fld[5],$fld[4],$buttonCount);}
		}
	}
	function BuildFormButton($value,$id='',$action='button',$buttonCount=2,$tableCol=3){
		echo $this->brs;
		echo "<tr><td>&nbsp;</td>
				<td><input type='$action' id='saved-$id' title='$value' value='$value'>";
				if($buttonCount >2){
					$btn=explode(',',$this->caption);
					for ($i=0;$i< count($btn);$i++){
					echo "<input type='button' id='".strtolower(str_replace(" ","",$btn[$i]))."' value='".$btn[$i]."' thitle='".$btn[$i]."'>";
					}
				}else if($buttonCount==2){
				  echo "<input type='reset' id='batal' value='Cancel' Title='Cancel'>";
				}
				echo "</td>
				<td></td></tr>\n";
				$this->posisi='bawah';
				echo $this->brs;
                echo "</table>\n";
				echo $this->end_form();
	}
	function AddBarisKosong($brs=false,$pos='top'){
		$this->dat='';$this->brs=$brs;$this->posisi=$pos;
		$di=($pos!='top')? "<div id='addData'></div>":"";
		if($this->brs==true){ $this->brs= "<tr><td>&nbsp;</td><td colspan='2' id='brs'>$di</td></tr>\n";}
		return $this->brs;
		return $this->posisi;
	}
	function AddButton($caption){
		return $this->caption=$caption;
	}
	function Addinput($tambahtxt=''){
		 $this->tambahtxt=$tambahtxt;	
	}
	//create grid editable
	function section($section=''){
		$this->section=$section;	
	}
	function rowCount($row=1){
		$this->row=$row;
	}
	function button($button){
		$this->button=$button;	
	}
	function BuildGrid($button=true){
		$bl=new zetro_listBuilder();
		$jml=$this->Count($this->section,$this->path);
		for ($rw=1;$rw<=$this->row;$rw++){
		echo "<tr class='' align='' id='r-".$rw."'>\n
			  <td class='kotak' align='center'>
			  <span id='s-$rw' style='display:block'>$rw</span>
			  <span id='e-$rw' style='display:none'><img src='".base_url()."asset/images/no.png' id='l-$rw' class='del' style='cursor:pointer'></span></td>\n";
			for ($i=1;$i<=$jml;$i++){
				$fld=explode(",",$this->rContent($this->section,"$i",$this->path));
				$tp=explode(" ",$fld[2]);
				echo "<td class='kotak' style='padding-right:3px'>";
					switch($fld[1]){
						case 'input':
							echo "<".$fld[1]." type='".$tp[0]."' id='".$rw.'__'.$fld[3]."' name='".$rw.'__'.$fld[3]."' value='".$fld[5]."' class='".$fld[4]."' abbr='$rw'>";
						break;
						case 'select':
					  case 'select':
					  	echo "<".$fld[1]." id='".$rw.'__'.$fld[3]."' name='".$rw.'__'.$fld[3]."' class='".$fld[4]."'>";
						if (count($fld)>=9){
							if($fld[7]=='RS'){
							echo "<option></option>";
								for ($x=1;$x<=$this->Count($fld[8],$this->path);$x++){
									$data=explode(",",$this->rContent($fld[8],$x,$this->path));
								echo "<option value='".$data[0]."'>".$data[1]."</option>\n\r";
								}
							}else if($fld[7]=='RD'){
								$data=explode("-",$fld[8]);
								dropdown($data[0],$data[1],$data[2],$data[3]);
							}
						}
						echo "</select>";
					}
				echo "</td>\n";
			}
		echo ($button==true)?"<td class='kotak'>".$bl->event('dt-'.$rw,'',$this->button)."</td>\n":'';
		echo "</tr>";	
		}
	}
}
?>
