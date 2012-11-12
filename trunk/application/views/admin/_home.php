<div id="" style="display:; padding-top:70px;">
<? 
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
	$z_config='asset/bin/zetro_config.dll';
?>
<table width="100%" border='0'>
<tr valign="bottom" align="center" style="padding:20px"><td width='100%'><img src='<?=base_url();?>asset/img/about.png' /></td></tr>
</table>
<? //echo (no_ser()=='6953b843f6cb0cd37e11d1cc485d2d79')?
	?>
<table width='100%'>
<tr height='50px'><td>&nbsp;</td></tr>
<tr><td width='100%' align="left">License To :</td></tr>
<tr><td><font style="font-family:'Arial Black', Gadget, sans-serif; font-size:large">
<?=$zz->rContent('InfoCo',"subtitle",$z_config);?></font></td></tr>
<tr><td><font style="font-size:medium"><?=$zz->rContent('InfoCo',"BH",$z_config);?></font></td></tr>
<tr><td><?=$zz->rContent('InfoCo',"Address",$z_config);?></td></tr>
<tr><td><?=$zz->rContent('InfoCo',"Kota",$z_config)." ".$zz->rContent('InfoCo',"Propinsi",$z_config);?></td></tr>
<tr><td><?=empty($serial)?"Not Licenced":"Serial Number : ".$serial;?></td></tr>
</table>
<input type='hidden' id='lcs' value='<?=empty($serial)?'x2cdg':$serial;?>' />
</div>
<script language="javascript">
	$(document).ready(function(e) {
		($('#lcs').val()!='x2cdg')?
        $('div.menu').show():$('div.menu').hide();
    });
</script>
