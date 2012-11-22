// JavaScript Document
$(document).ready(function(e) {
	var path=$('#path').val();
    $('#rekappenjualankredit').removeClass('tab_button');
	$('#rekappenjualankredit').addClass('tab_select');
	$('table#panel tr td').click(function(){
		var id=$(this).attr('id');
			if(id!=''){
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+')').hide();
			}
	})
	//laporan penjualan obat
	$('#frm1 #dari_tgl').dynDateTime();
	$('#frm1 #sampai_tgl').dynDateTime();
	$('#frm1 #dari_tgl')
		.click(function(){
			$(this).focus().select();
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #sampai_tgl').focus().select();
			}
		})
	$('#frm1 #sampai_tgl')
		.click(function(){
			$(this).focus().select();
			tglNow('#frm1 #sampai_tgl');
		})
		.keyup(function(){
			tanggal(this)
		})
		.keypress(function(e){
			if(e.keyCode==13){
				$('#frm1 #nm_produsen').focus().select();
			}
		})
	$('#view').click(function(){
		show_indicator('ListTable',6);
			$.post('lap_tagihan_print',{
				'dari_tgl'	:$('#dari_tgl').val(),
				'sampai_tgl':$('#sampai_tgl').val(),
				'departemen':$('#departemen').val(),
				'cicilan'	:$('#cicilan').val()},
				function(result){
					$('table#ListTable tbody').html(result)
					
				})
	})
	$('#okelah').click(function(){
		$('#frm1').attr('action','lap_kreditur');
		document.frm1.submit();
	})
	
	$('#posting').click(function(){
		var today =new Date();
		if(confirm('Periode posting di setting \nDari        :'+$('#dari_tgl').val()+'\nSampai :'+$('#sampai_tgl').val()+'\nYakin akan diposting')){
		  show_indicator('xx',1);
		  $('table#xx tbody tr td').append('...membuat nomor jurnal');
		  $.post(path+'akuntansi/get_last_jurnal',{'ID_Unit':'1'},
		  	function(res){
				//simpan nomor jurnal ke dalam table jurnal
				var r=res.split('-')
				$.post(path+'akuntansi/set_jurnal',{
					'Tgl'		:'01/'+$('#dari_tgl').val().substr(3,8),
					'ID_Unit'	:'1',
					'nomor'		:'GJ-'+$.trim(r[0]),
					'Keterangan':'Piutang barang '+ nBulan(parseInt($('#dari_tgl').val().substr(3,2))-1)+' '+nYear(''),
					'ID'		:r[1]
				},function(rst){
					show_indicator('xx',1);
					$('table#xx tbody tr td').append(' ....Proses jurnal no GJ-'+$.trim(res)+' ')
					$.post('jual_kredit_posting',{
						'dari_tgl'	:$('#dari_tgl').val(),
						'sampai_tgl':$('#sampai_tgl').val(),
						'departemen':$('#departemen').val(),
						'id_jurnal' :'GJ-'+$.trim(r[0])},
						function(result){
							$('table#xx tbody tr td').html('posting berhasil');
							$('#view').click();
							$('table#xx tbody tr td').html('');
						})
				})
			})
		}
	})
})