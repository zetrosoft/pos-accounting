<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	function __construct(){
			
	}
	function check_logged_in($status=FALSE){
        if ( $status!= TRUE) {
            redirect('admin/index', 'refresh');
            exit();
        }
	}

	function hapus_table($table,$where){
		$sql="delete from $table $where";
		mysql_query($sql) or die(mysql_error());	
	}
	function rdb($tabel,$rfield,$sfield='',$where='',$order='',$group=''){
		$datadb="";
		if($sfield==''){
		$sql="select * from ".$tabel." $where $group $order";
		}else{
		$sql="select ".$sfield. " from ".$tabel." $where $group $order";
		}
		//echo $sql."\n"; //for debug only;
		$rs=mysql_query($sql) or die($sql.mysql_error());
		while($rw=mysql_fetch_array($rs)){
			$datadb=$rw[$rfield];
		}
		return $datadb;
	}
	function RowCount($tabel,$where='',$sfield='*'){
		$databd=0;
		$sql="select $sfield from $tabel $where";
		$rs=mysql_query($sql) or die($sql.mysql_error());
		$datadb=mysql_num_rows($rs);
		return $datadb;
	}
	function hapus($tabel,$where){
		$sql="delete from $tabel $where";
		mysql_query($sql) or die(mysql_error());
	}
	function dropdown($tabel,$fieldforval,$fieldforname='',$where='',$pilih='',$bariskosong=true,$sparator=' - '){
		if ($bariskosong==true) echo "<option value=''>&nbsp;</option>";
		$dst=explode(" as ",$fieldforval);
		if($fieldforname!=''){$dst2=explode("+",$fieldforname);}
		($fieldforname=='')?
		$sql="select $fieldforval from $tabel $where":
		(count($dst2)>1)?
		$sql="select * from $tabel $where":
		$sql="select $fieldforval,$fieldforname from $tabel $where";
		//echo $sql;
			$rs=mysql_query($sql) or die(mysql_error());
			while ($rw=mysql_fetch_object($rs)){
			(count($dst)>1)? $valu=$rw->$dst[1]: $valu=$rw->$dst[0];
			($sparator==' [')? $sp_end=' ]':$sp_end='';
			if($fieldforname!='')(count($dst2)>1)? $addnm=$rw->$dst2[0].$sparator.$rw->$dst2[1].$sp_end :$addnm=$rw->$dst2[0];
			echo "<option value='".$valu."'";if ($pilih==$valu){ echo " selected";}
			echo " >";echo ($fieldforname=='')? $rw->$dst[1]:$addnm."</option>";	
			}
	}
	function lama_execute(){
		$awal = microtime(true);
		
		// --- bagian yang akan dihitung execution time --
		
		$bil = 2;
		$hasil = 1;
		for ($i=1; $i<=10000000; $i++)
		{
			 $hasil .= $bil;
		}
		
		// --- bagian yang akan dihitung execution time --
		
		$akhir = microtime(true);
		$lama = $akhir - $awal;
		return $lama;
	}
	
	function nBulan($bln){
		$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September',
					'Oktober','November','Desember');
		return $bulan[(int)$bln];	
	}
	function penomoran($table,$fieldnomor){
		$nom=rdb($table,$fieldnomor,$fieldnomor,"order by $fieldnomor desc limit 1");
		if ($nom==""){
			$nomor=date('Ymd')."-0001";
		}else{
			$noms=explode("-",$nom);
			if (strlen((int)$noms[1])==1){
				$nomor=date('Ymd')."-000".($noms[1]+1);
			}else if(strlen((int)$noms[1])==2){
				$nomor=date('Ymd')."-00".($noms[1]+1);
			}else if(strlen((int)$noms[1])==3){
				$nomor=date('Ymd')."-0".($noms[1]+1);
			}else if(strlen((int)$noms[1])==4){
				$nomor=date('Ymd')."-".($noms[1]+1);
			}
		}
		return $nomor;
	}
	function tglToSql($tgl=''){
		//input dd/mm/yyyy -->output yyyymmdd
		if($tgl==''){
			$tanggal=date('Ymd');
		}else{
			$tanggal=substr($tgl,6,4).substr($tgl,3,2).substr($tgl,0,2);
		}
		return $tanggal;
	}
	function tglfromSql($tgl='',$separator='/'){
		($tgl=='')?
		$tanggal='':
		$tanggal=substr($tgl,8,2).$separator.substr($tgl,5,2).$separator.substr($tgl,0,4);
		return $tanggal;
	}
	function ShortTgl($tgl='',$withYear=false){
		($tgl=='')?
		$tanggal=date('d/m'):
		$tanggal=($withYear==true)?substr($tgl,8,2).'/'.substr($tgl,5,2).'/'.substr($tgl,2,2):substr($tgl,8,2).'/'.substr($tgl,5,2);
		return $tanggal;
	}
	function LongTgl($tgl=''){
	 ($tgl=='')? $tanggal=date('d F Y'):
	 $tanggal=substr($tgl,0,2)." ". nBulan(round(substr($tgl,3,2),0))." ". substr($tgl,6,4);
	 	return $tanggal;
	}
	function no_auth(){
	echo "<img src='".base_url()."asset/images/warning.png'>";?>
	<font style="font-family:'20th Century Font', Arial; color:#DD0000; font-size:x-large">
	<? $zn= new zetro_manager();
        echo $zn->rContent("Message","NoAuth","asset/bin/form.cfg");
        ?>
	</font>
    <?
	}
	function panel_begin($section,$form='',$filter='',$printer='',$file='asset/bin/zetro_menu.dll'){
	//$judul= explode(',',$judul);]
	$data=array();
	$zn=new zetro_manager();
	//echo "<div class='pn_contents t'>\n";
	$jml=$zn->Count($section,$file);
	for($i=1;$i<=$jml;$i++){
		$mnu=explode('|',$zn->rContent($section,$i,$file));
		if(strtolower($mnu[2]=='y')) $data[]=$mnu[0];
	}
	echo str_repeat("<br>",3);	
	echo"<table width='100%' style='border-collapse:collapse' border='0' bordercolor='#CCC' id='panel'>\n
			<tr height='50px' align='center' valign='middle'>\n";
			foreach ($data as $menu){
			  echo "<td nowrap class='tab_button tab_font' id='".strtolower(str_replace(" ",'',$menu))."'>".strtoupper($menu)."</td>\n";
			}
		if($filter!=''){
			echo "<td width='10px' class='flt'>&nbsp;</td>\n";
			$flt=explode(',',$filter);
			for($z=0;$z< count($flt);$z++){
				echo "<td align='left' bgcolor='' id='' width='100px' nowrap class='flt'>".$flt[$z]."</td>\n";
			}
		}
		
		if($printer!=''){
			($filter=='')?$wd='200px':$wd='50px';
			echo "<td style='width:$wd' class='plt'>&nbsp;</td>\n";
			$flt=explode(',',$printer);
			for($z=0;$z< count($flt);$z++){
			echo "<td bgcolor='' id='p-$z' style='padding-right:27px' width='50px' class='plt' align='right' nowrap >";
			echo $flt[$z].'&nbsp;';
			echo "</td>\n";
			}
		}
		echo "<td class='tab_kosong' id='kosong'>&nbsp;</td></tr></table>\n
		 	<div class='content tab_content' style='height:81%'>\n";
		echo ($form!='')? "<form id='$form' name='$form' action='' method='post'>\n":'';
	}
	function panel_multi($id,$display='none',$br=true){
		echo ($br==true)?"<br>":"";
		echo "<span id='v_$id' style='display:$display;padding:5px'>\n";
	}
	function panel_multi_end($br=true){
		//echo ($br==true)? "</div>":"";
		echo "</span>\n";
	}
	function panel_end($form=false){
		echo "</div>\n";
		echo ($form==true)? "</form>\n":'';
	}
	function link_js($js,$path){
	$js=explode(",",$js);$pathe=explode(",",$path);
		for ($i=0;$i< count($js);$i++){
		 echo "<script language='javascript' src='".base_url().$pathe[$i]."/".$js[$i]."' type='text/javascript'></script>\n";	
		}
	}
	function link_css($css,$path){
	$css=explode(",",$css);$pathe=explode(",",$path);
		for ($i=0;$i< count($css);$i++){
		 echo "<link href='".base_url().$pathe[$i]."/".$css[$i]."' type='text/css' rel='stylesheet'>\n";	
		}
	}
	function popup_start($name,$caption='',$width='500',$height='500'){
	?>  <div id='lock<?=$name;?>' class='black_overlay'></div>
        <div id='lock' class='black_overlay'></div>
        <div id='pp-<?=$name;?>' align="center"  style='display:none; background:#CCC; border:5px solid #000; padding:0px; left:0; top:0; width:<?=$width;?>px; max-height:<?=$height;?>px; position:fixed; overflow:auto; z-index:9999'>
        <table id='lvltbl0' width="100%" style='border-collapse:collapse;'>
        <tr><td bgcolor="#000" width='3%' ><img src='<?=base_url();?>asset/images/16/address_16.png' /></td>
        <td colspan=''  bgcolor="#000" class=''>
        <font style='font-size:14px; font-weight:bold; color:#FFFFFF'><?=$caption;?></font></td>
        <td bgcolor="#000" align="center" width="10px"><font color="#FFFFFF">
        <img src="<?=base_url();?>asset/images/no.png" id='<?=$name;?>' onclick="keluar_<?=$name;?>();" class='close' style='cursor:pointer' title="Close"/></font></td></tr>
        <input type='hidden' value='<?=$name;?>' id='nama' />
        </table>
        <script language='javascript'>
				function keluar_<?=$name;?>(){
					$('#pp-<?=$name;?>').hide('slow');
					$('#lock').hide();
					$('#lock<?=$name;?>').hide();
				}
		</script>
        <div id='tbl-<?=$name;?>' style='padding:3px; width:95%' align="left">
        <?	
	}
	
	function popup_end(){
	 echo "</div></div>\n";
	}
	
	function getNextDays($fromdate,$countdays) {
		$dated='';
		$time = strtotime($fromdate); // 20091030
		$day = 60*60*24;
		for($i = 0; $i<$countdays; $i++)
		{
			$the_time = $time+($day*$i);
			$dated = date('Y-m-d',$the_time);
		}
			return $dated;
    }
	function getPrevDays($fromdate,$countdays) {
		$dated='';
		$time = strtotime($fromdate); // 20091030
		$day = 60*60*24;
		for($i = 0; $i <$countdays; $i++)
		{
			$the_time = $time-($day*$i);
			$dated = date('Ymd',$the_time);
		}
			return $dated;
    }
	function  compare_date($date_1,$date_2){
	  list($year, $month, $day) = explode('-', $date_1);
	  $new_date_1 = sprintf('%04d%02d%02d', $year, $month, $day);
	  list($year, $month, $day) = explode('-', $date_2);
	  $new_date_2 = sprintf('%04d%02d%02d', $year, $month, $day);
		
		($new_date_1 <= $new_date_2)? $data=true:$data=false; 
		return $data;
  	}
	function auto_sugest(){
		echo "<div class='autosuggest' id='autosuggest_list'></div>";	
	}
	function tab_select($select){
		echo "<input type='hidden' value='$select' id='prs'>";	
	}
	
	function inline_edit($frm=''){
		echo "<span id='ild' style='display:none'>
			 <input type='text' id='inedit-$frm' value='' style='width:70%; height:20px' class='angka'>
			 <img src='".base_url()."asset/images/Save.png' id='saved-$frm' onclick=\"simpan_$frm('inedit-$frm');\" class='simpan'>
			 <img src='".base_url()."asset/images/no.png' id='gakjadi' onclick=\"batal_$frm();\" class='hapus'>
			 </span>";
	}
	function tab_head($section='Menu Utama',$bg=''){
		$data=array();
		$zn=new zetro_manager();
		$file='asset/bin/zetro_menu.dll';
		$jml=$zn->Count($section,$file);
		for($i=1;$i<=$jml;$i++){
			$mnu=explode("|",$zn->rContent($section,$i,$file));
			if(strtolower($mnu[2])=='y')$data[]=$mnu[0];
		}
		echo"<table width='100%' style='border-collapse:collapse' border='0' bordercolor='#CCC' id='tab'>\n
			<tr height='35px' align='center'>\n";
			foreach($data as $menu){
			  echo "<td width='100px' style='padding:5px' class='tab_button' id='".strtolower(str_replace(" ",'',$menu))."'>".$menu."</td>\n";
			}
		echo "<td class='tab_kosong' id='kosong' $bg>&nbsp;</td></tr></table>
		<div id='v_panel' class='pn_contents tab_content' style='height:75%; overflow:auto'>
		";
	}
	function tab_head_end(){
		echo "</div>";
	}
	function terbilang(){
		echo "<div id='terbilang' class='infox'></div>";	
	}
	function loading_ajax(){
		echo "<div id='ajax_start' style='display:none; position:fixed; left:45%; top:50%; z-index:9999' align='center'>
		 	<img src='".base_url()."asset/images/ajax-loader.gif' /></div>
			<div id='lock' class='black_overlay'></div>";	
	}
	function addText($label,$field,$hr=true){
	echo ($hr==true)?"":"<hr>\n";
	 echo "<table style='border-collapse:collapse' id='addtxt'><tr>\n";
	 $n=0;
		foreach($label as $lbl){
			($lbl=='')?$width="5":$width=(strlen($lbl)*5+20);
			echo "<td id='c1-$n' width='".$width."px' align='' valign='middle' nowrap>".$lbl."</td>
				  <td id='c2-$n'>".$field[$n]."</td>\n";
			echo (count($label)>1 && ($n+1)<count($label))?"<td width='10px' align='center' style='background: url(".base_url()."asset/images/on_bg.png) repeat-y center' >&nbsp;</td>\n":"";
				$n++;
		}
		echo "</tr>\n</table>";
		echo ($hr==true)?"<hr>\n":"";
	}
	function popup_full($include=''){
		echo "<div id='mm_lock' class='black_overlay'></div>";	
		echo "<div id='mm_detail'></div>";
	}
	function calender(){
		link_css('calendar-win2k-cold-1.css','asset/calender/css');
		link_js('jquery.dynDateTime.js,calendar-en.js','asset/calender,asset/calender/lang');	
	}
	function addCopy(){
		$find=fopen("c:\\windows\\wincopy.dll","a+");
		$data= fread($find,1024);	
		return $data;
	}
	function img_aksi($id='',$del=false,$only=''){
		$data='';
		 if($del==false){ 
		   $data="<img src='".base_url()."asset/images/editor.png' id='simpan' onclick=\"images_click('".$id."','edit');\" class='simpan' title='Click to Edit'>";
		 }else if ($del==true && $only=='del'){
		   $data="<img src='".base_url()."asset/images/no.png' id='simpan' onclick=\"images_click('".$id."','del');\" class='simpan' title='Click to delete'>";
		 }else if($del==true && $only==''){
		   $data="<img src='".base_url()."asset/images/editor.png' id='simpan' onclick=\"images_click('".$id."','edit');\" class='simpan' title='Click to Edit '>
			    &nbsp;<img src='".base_url()."asset/images/no.png' id='hapus' onclick=\"images_click('".$id."','del');\" class='hapus' title='Click to Delete'>";
		 }
		 return $data;
	}
	function capital($text,$besar=false){
		($besar==false)?
		ucwords(strtolower($text)):
		strtoupper($text);	
	}

	
	function width_kol_pdf($section,$file){
	$data='10';//array();
	$zn=new zetro_manager();
	//echo "<div class='pn_contents t'>\n";
	$jml=$zn->Count($section,$file);
		for($i=1;$i<=$jml;$i++){
			$mnu=explode(',',$zn->rContent($section,$i,$file));
			$data.=','.$mnu[9];
		}
	echo $data;
	}
//}