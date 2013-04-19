// JavaScript Document
$(document).ready(function(e){
	var path=$('#path').val();
	$('#setoranpinjaman').removeClass('tab_button');
	$('#setoranpinjaman').addClass('tab_select');
	var tday=new Date;
	$('table#panel tr td:not(.flt,.plt)').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
				$('#prs').val(id);
	})
	//transaksi pinjaman
	//inisilisasi dropdown bulan/tahun
	$('#frm1 #ID_Bulan')
		.html("<option value='1-"+tday.getFullYear()+"'>Januari-"+tday.getFullYear()+"</option><option value='2-"+tday.getFullYear()+"'>Februari-"+tday.getFullYear()+"</option><option value='3-"+tday.getFullYear()+"'>Maret-"+tday.getFullYear()+"</option><option value='4-"+tday.getFullYear()+"'>April-"+tday.getFullYear()+"</option><option value='5-"+tday.getFullYear()+"'>Mei-"+tday.getFullYear()+"</option><option value='6-"+tday.getFullYear()+"'>Juni-"+tday.getFullYear()+"</option><option value='7-"+tday.getFullYear()+"'>Juli-"+tday.getFullYear()+"</option><option value='8-"+tday.getFullYear()+"'>Agustus-"+tday.getFullYear()+"</option><option value='9-"+tday.getFullYear()+"'>September-"+tday.getFullYear()+"</option><option value='10-"+tday.getFullYear()+"'>Oktober-"+tday.getFullYear()+"</option><option value='11-"+tday.getFullYear()+"'>November-"+tday.getFullYear()+"</option><option value='12-"+tday.getFullYear()+"'>Desember-"+tday.getFullYear()+"</option>")
		.val((tday.getMonth()+1)+'-'+tday.getFullYear()).select();
	$('#frm1 #ID_Jenis')
		.val('1').select()
		.attr('disabled','disabled')
	$('#frm1 #mulai_bayar')
		.html("<option value=''>&nbsp;</option><option value='1-"+tday.getFullYear()+"'>Januari-"+tday.getFullYear()+"</option><option value='2-"+tday.getFullYear()+"'>Februari-"+tday.getFullYear()+"</option><option value='3-"+tday.getFullYear()+"'>Maret-"+tday.getFullYear()+"</option><option value='4-"+tday.getFullYear()+"'>April-"+tday.getFullYear()+"</option><option value='5-"+tday.getFullYear()+"'>Mei-"+tday.getFullYear()+"</option><option value='6-"+tday.getFullYear()+"'>Juni-"+tday.getFullYear()+"</option><option value='7-"+tday.getFullYear()+"'>Juli-"+tday.getFullYear()+"</option><option value='8-"+tday.getFullYear()+"'>Agustus-"+tday.getFullYear()+"</option><option value='9-"+tday.getFullYear()+"'>September-"+tday.getFullYear()+"</option><option value='10-"+tday.getFullYear()+"'>Oktober-"+tday.getFullYear()+"</option><option value='11-"+tday.getFullYear()+"'>November-"+tday.getFullYear()+"</option><option value='12-"+tday.getFullYear()+"'>Desember-"+tday.getFullYear()+"</option>")
	$('#frm1 #ID_Dept').change(function(){
		//copy data anggota ke table temporary
		$.post('set_copy_agt',{'ID_Dept':$(this).val(),'ID_Pinj':''},
		function (result){
		})
	})
	//call autosugest nama anggota on keyup
	$('#frm1 #ID_Agt').focus(function(){
	var dept=$('#ID_Dept').val();
		if(dept!=''){
			$('#frm1 #ID_Agt')
				.coolautosuggest({
				url				:path+'member/get_anggota?limit=10&dept=1&str=',
				width			:290,
				showThumbnail	:false,
				showDescription	:true,
					onSelected:function(result){
						$('#frm1 #ID_Perkiraan').val(result.ID);
						$('#frm1 #pinjaman').focus().select();
							
					}
				})
		}else{
			alert('Tentukan departement nya terlebih dahulu');
		}
	})
	$('#frm1 #pinjaman')
		.click(function(){		
		})
		.focus(function(){
			$(this).select();
			$('#frm1 #pinjaman').terbilang({'output_div':'kekata'})
			$(this).attr('title',$('#kekata').html());
		})
		.keyup(function(){
			$('#frm1 #pinjaman').terbilang({'output_div':'kekata'})
			pos_info('#frm1 #pinjaman','#kekata')
			$('#frm1 #lama_cicilan').val('1')
			$('#frm1 #cicilan').val(($(this).val()/$('#frm1 #lama_cicilan').val()))	
			$('#frm1 table#fmrTable tr td#c110').html('&nbsp;&nbsp;Cicilan Terakhir [ Ke 1 ]')
			$('#frm1 #end_cicilan')
				.val($('#frm1 #cicilan').val())
				.attr('readonly','readonly');
		})
		.focusout(function(){
			$('#kekata').hide();
		})
		.keypress(function(e){
			if(e.which==13){
				$('#frm1 #lama_cicilan').focus().select();
				$(this).focusout();
			}
		})
	$('#frm1 #lama_cicilan')
		.keyup(function(){
			$('#frm1 #cicilan').val(roundNumber(($('#frm1 #pinjaman').val()/$(this).val()),-3))
			$('#frm1 #cicilan').terbilang({'output_div':'kekata'});
			pos_info('#frm1 #cicilan','kekata')	
			$('#frm1 table#fmrTable tr td#c110').html('&nbsp;&nbsp;Cicilan Terakhir [ Ke '+$(this).val()+' ]')
			var ccl_end=($('#frm1 #pinjaman').val()-($('#frm1 #cicilan').val()*$(this).val()))
			$('#frm1 #end_cicilan')
				.val((parseFloat(ccl_end)+parseFloat($('#frm1 #cicilan').val())))
				.attr('readonly','readonly');
		})
		.focusout(function(){
			$('#kekata').hide();
		})
	$('#frm1 #lama_cicilan')
		.keypress(function(e){
			if(e.which==13){
				$('#frm1 #cicilan').focus().select()
			}
		})
	$('#frm1 #cicilan')
		.focus(function(){
			$('#kekata').html('')
			$(this).select();
			$('#frm1 #cicilan').terbilang({'output_div':'kekata'})
			$(this).attr('title',$('#kekata').html());
		})

	$('#frm1 #end_cicilan')
		.focus(function(){
			$('#kekata').html('')
			$(this).select();
			$('#frm1 #end_cicilan').terbilang({'output_div':'kekata'})
			$(this).attr('title',$('#kekata').html());
		})
	//simpan pinjaman
	$('#frm1 #saved-pinjaman').click(function(){
		unlock('#frm1 #ID_Jenis');
		var bln=$('#frm1 #ID_Bulan').val().split('-');
		$.post('set_pinjaman',{
			'ID_Agt'	:$('#frm1 #ID_Perkiraan').val(),
			'ID_Bulan'	:bln[0],
			'Tahun'		:bln[1],
			'ID_Jenis'	:$('#frm1 #ID_Jenis').val(),
			'ID_Unit'	:$('#frm1 #ID_Unit').val(),
			'ID_Dept'	:$('#frm1 #ID_Dept').val(),
			'Pinjaman'	:$('#frm1 #pinjaman').val(),
			'cicilan'	:$('#frm1 #cicilan').val(),
			'cicilan_end':$('#frm1 #end_cicilan').val(),
			'lama_cicilan':$('#frm1 #lama_cicilan').val(),
			'cara_bayar':$('#frm1 #cbayar').val(),
			'mulai_bayar':$('#frm1 #mulai_bayar').val(),
			'keterangan':$('#frm1 #keterangan').val(),
			'ID_Pinjaman':$('#frm1 #ID_Simpanan').val()},
			function(result){
				$('#frm1 input:reset').click();
				$('#frm1 #ID_Jenis').val('1').select();
				$('#frm2 #ID_Jenis').val('2').select();
				lock('#frm1 #ID_Jenis');
			})
	})
	//transaksi setoran pinjaman
	$('#frm2 #ID_Bulan')
		.html("<option value='1-"+tday.getFullYear()+"'>Januari-"+tday.getFullYear()+"</option><option value='2-"+tday.getFullYear()+"'>Februari-"+tday.getFullYear()+"</option><option value='3-"+tday.getFullYear()+"'>Maret-"+tday.getFullYear()+"</option><option value='4-"+tday.getFullYear()+"'>April-"+tday.getFullYear()+"</option><option value='5-"+tday.getFullYear()+"'>Mei-"+tday.getFullYear()+"</option><option value='6-"+tday.getFullYear()+"'>Juni-"+tday.getFullYear()+"</option><option value='7-"+tday.getFullYear()+"'>Juli-"+tday.getFullYear()+"</option><option value='8-"+tday.getFullYear()+"'>Agustus-"+tday.getFullYear()+"</option><option value='9-"+tday.getFullYear()+"'>September-"+tday.getFullYear()+"</option><option value='10-"+tday.getFullYear()+"'>Oktober-"+tday.getFullYear()+"</option><option value='11-"+tday.getFullYear()+"'>November-"+tday.getFullYear()+"</option><option value='12-"+tday.getFullYear()+"'>Desember-"+tday.getFullYear()+"</option>")
		.val((tday.getMonth()+1)+'-'+tday.getFullYear()).select();
	$('#frm2 #ID_Jenis')
		.val('2').select()
		.attr('disabled','disabled')
	$('#frm2 #ID_Dept').change(function(){
		var path=$('#path').val().replace('index.php/','');
		var bln=$('#frm2 #ID_Bulan').val().split('-');
		//copy data anggota ke table temporary
		$.post('set_copy_agt',{'ID_Dept':$(this).val(),'ID_Pinj':'pinjaman'},
		function (result){
		})
	})
	//call autosugest nama anggota on keyup
	$('#frm2 #ID_Agt').click(function(){
		$('div#dat_pinjm').hide();
	})
	$('#frm2 #ID_Agt').focus(function(){
	var dept=$('#frm2 #ID_Dept').val();
		if(dept!=''){
			$('#frm2 #ID_Agt')
				.coolautosuggest({
				url				:path+'member/get_anggota?limit=10&dept=1&str=',
				width			:290,
				showThumbnail	:false,
				showDescription	:true,
					onSelected:function(result){
						$('#ID_Perkiraane').val(result.ID);
						$.post('data_pinjaman',{'ID_Agt':result.ID},
						function(data){
							$('#dat_pinjm table#dat_simp tbody').html('');
							$('#dat_pinjm table#dat_simp tbody').html(data);
							$('div#dat_pinjm').show();
							$('#dat_pinjm table#dat_simp').fixedHeader({width:(screen.width-350),height:265});
						})
							
					}
				})
		}else{
			alert('Tentukan departement nya terlebih dahulu');
		}
	})
	$('#frm2 #pinjaman')
		.focus(function(){
			$.post('get_total_pinjaman',{'ID_Agt':$('#frm2 #ID_Perkiraan').val()},
			function(result){
				var hsl=$.parseJSON(result);
				var ccl=(hsl.cicilanke=='1')?'1':(parseInt(hsl.cicilanke)+1)
				$('#frm2 #pinjaman').val(hsl.pinjaman);
				$('#frm2 #angsuran_ke').val(ccl);
				$('#frm2 #jml_setoran').val(hsl.cicilan);
				$('#frm2 #keterangan').val('Angs. ke '+ccl+' bulan '+ $('#frm2 #ID_Bulan option:selected').text());
			})
		})
	//simpan angsuran
	$('#saved-setoran').click(function(){
		//$.post('set_bayar_pinjaman',{
			
	})
})

function bayar(row){
	$('img#g-'+row).hide();
	$('#baris').val(row);
	$('#dat_pinjm table#dat_simp tbody tr#r-'+row+' td:nth-child(5)').append($('#ild').html());
	$('#inedit-frm2').val($('#dat_pinjm table#dat_simp tbody tr#r-'+row+' td:nth-child(3)').html());
	$('#inedit-frm2').focus().select();
	
//	$('div#ild').css({'left':(pos.left+2),'top':pos.top,'position':'fixed'});//.html($('#ild').contents())
//	$('div#ild').show();
}

function batal_frm2(){
	var ID=$('#ID_Perkiraane').val();
	$.post('data_pinjaman',{'ID_Agt':ID},
	function(data){
		$('#dat_pinjm table#dat_simp tbody').html('');
		$('#dat_pinjm table#dat_simp tbody').html(data);
		$('div#dat_pinjm').show();
		$('#dat_pinjm table#dat_simp').fixedHeader({width:(screen.width-450),height:265});
	})
}

function simpan_frm2(){
	var bln=$('#frm2 #ID_Bulan').val().split('-')
	$.post('set_bayar_pinjaman',{
		'ID_Unit'		:$('#frm2 #ID_Unit').val(),
		'ID_Dept'		:$('#frm2 #ID_Dept').val(),
		'ID_Pinj'		:$('#ID_Pinj').val(),
		'ID_Pinjaman'	:$('#frm2 #ID_Simpanan').val(),
		'ID_Agt'		:$('#ID_Perkiraane').val(),
		'ID_Bulan'		:bln[0],
		'Tahun'			:bln[1],
		'angs_ke'		:$('#baris').val(),
		'Kredit'		:to_number($('#inedit-frm2').val()),
		'Keterangan'	:$('#dat_pinjm table#dat_simp tbody tr#r-'+$('#baris').val()+' td:nth-child(2)').html()
	},function(result){
		$.post('data_pinjaman',{'ID_Agt':$('#ID_Perkiraane').val()},
		function(data){
			$('#dat_pinjm table#dat_simp tbody').html('');
			$('#dat_pinjm table#dat_simp tbody').html(data);
			$('div#dat_pinjm').show();
			$('#dat_pinjm table#dat_simp').fixedHeader({width:(screen.width-350),height:265});
		})
	})
}