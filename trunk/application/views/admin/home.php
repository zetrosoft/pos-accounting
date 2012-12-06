<div id="" style="display:; padding-top:70px;">
<? 
	$zz= new zetro_manager;
	$file='asset/bin/zetro_menu.dll';
	$z_config='asset/bin/zetro_config.dll';
?>
<table width="100%" border='0'>
<tr><td colspan="2" align="center"><img src='<?=base_url();?>asset/img/sim.png' /></td></tr>
<tr valign="bottom" align="" style="padding:20px">
<td width='40%' align="center" valign="middle"><img src='<?=base_url();?>asset/img/about.png' /></td>
<td width='60%' valign="middle">
    <table width='70%' border="0">
    <tr align="center">
    <? $mnu=$zz->Count('Menu Utama',$file);
    $x=0;
        for ($i=1;$i<=$mnu;$i++ ){
            $gbr=explode('|',$zz->rContent('Menu Utama',$i,$file));
            if($gbr[3]!=''){
                $x++;
                if($x> 1){
                    echo tr('').
                    td("<img src='".base_url()."asset/img/".$gbr[3]."' class='menux' onclick=\"kliked('".base64_encode($gbr[4])."');\">",'left',' \' height=\'69px\' valign=\'middle').
                    _tr();
                }else{
                echo td("<img src='".base_url()."asset/img/".$gbr[3]."' class='menux' onclick=\"kliked('".base64_encode($gbr[4])."');\">",'left',' \' height=\'69px\' valign=\'middle');
                }
            }else{
                echo '';
            }
        }
        
    ?>
    </tr>
    </table>
</td>
</tr>
</table>
<hr />
<div id='xxx' align="right">
 <img src='<?=base_url();?>asset/img/logout.png' onclick="logout();" width="50" height="50" style='cursor:pointer' />
</div>
<? //echo (no_ser()=='6953b843f6cb0cd37e11d1cc485d2d79')?
	?>
<input type='hidden' id='lcs' value='<?=empty($serial)?'x2cdg':$serial;?>' />
</div>
<script language="javascript">
	$(document).ready(function(e) {
		///($('#lcs').val()!='x2cdg')?
       // $('div.menu').show():
		$('div.menu').hide();
    });
		function kliked(id){
			var path=$('#path').val();
			document.location.href=path+'admin/masuk?id='+id;
			
		}
     function logout(){
			var path=$('#path').val();
			document.location.href=path+'admin/logout';
	 }
</script>
