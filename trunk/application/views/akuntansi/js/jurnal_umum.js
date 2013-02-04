// JavaScript Document
$(document).ready(function(e) {
	$('#v_listjurnalumum #ListTable').hide();
	$(':radio#new').attr('checked','checked');
	$(':radio#addcontent').attr('disabled','disabled');
	$('div#addnew').show();
	$('div#addcontent').hide();
	var prs=$('#prs').val();
		$('#listjurnalumum').removeClass('tab_button');
		$('#listjurnalumum').addClass('tab_select');
		$('.plt').hide();
		lock('#process,#cetak');
	$('table#panel tr td:not(.flt,.plt,#kosong)').click(function(){
		var id=$(this).attr('id');
				$('#'+id).removeClass('tab_button');
				$('#'+id).addClass('tab_select');
				$('table#panel tr td:not(#'+id+',.flt,.plt)').removeClass('tab_select');
				$('table#panel tr td:not(#'+id+',#kosong,.flt,.plt)').addClass('tab_button');
				$('span#v_'+id).show();
				$('span:not(#v_'+id+',#bybln,#bytgl,#fltby)').hide();
				if(id=='addjurnal'){
					$('table#panel tr td.plt').hide()
				}else{
					$('table#panel tr td.plt').show()
				}
	})
	var today=new Date()

	$('#addnew').click(function(){
		$('table#panel tr td#addjurnal').click()
	})
	$('#fby').val('bln').select()
	//tampilan baru langsung buka bulan dan tahun existing
	$.post('get_bulan',{'id':''},function(result){$('#Bln').html(result).val(today.getMonth()+1).select})
	$.post('get_tahun',{'id':''},function(result){$('#Thn').html(result).val(today.getFullYear()).select()})
	$('span#bybln').show();	$('span#bytgl').hide();
		unlock('#process')
		$('span#fltby').html($('#fby option:selected').text()+' :');
	_show_data();
   //----------------------------------------------------------
	$('#fby').change(function(){
		unlock('#process,#cetak')
		$('span#fltby').html($('#fby option:selected').text()+' :');
		switch($(this).val()){
			case 'tgl':
				$('#Bln').val('').select();
				$('#Thn').val('').select();
				$('#daritgl').val('');$('#smptgl').val('');
				$('span#bytgl').show();	$('span#bybln').hide();
			break;
			case 'bln':
				$.post('get_bulan',{'id':''},function(result){
						$('#Bln').html(result)
				})
				$.post('get_tahun',{'id':''},function(result){
						$('#Thn').html(result)
				})
				$('span#bybln').show();	$('span#bytgl').hide();
			break;
			case 'all':
				$('#Bln').val('').select();
				$('#Thn').val('').select();
				$('span#bybln').hide();	$('span#bytgl').hide();
			break;
			case '':
				$('#Bln').val('').select();
				$('#Thn').val('').select();
				$('span#bybln').hide();	$('span#bytgl').hide();
				lock('#process');
			break;
		}
	})
	//OK button click
	$('#process').click(function(){
		_show_data()
	})
	
	$('#daritgl').dynDateTime();
	$('#smptgl').dynDateTime();
// addjurnal
	$('#v_addjurnal table#addtxt tr td#c1-2').hide();
	$('#v_addjurnal table#addtxt tr td#c2-2').hide();
	$('#noUrut').attr('readonly','readonly')
	tglNow('#Tanggal');
	$('#Tanggal').dynDateTime({range:[today.getFullYear()-1,today.getFullYear()+1]});
	$('input:radio[name="pilih"]').click(function(){
		var id=$(this).attr('id');
			if (id=='new'){
				$('#v_addjurnal table#addtxt tr td#c1-2').hide();
				$('#v_addjurnal table#addtxt tr td#c2-2').hide();
				$('#NoJurnal').val('');
				$('div#addnew').show();
				$('div#addcontent').hide();
				$(':reset').click();
					tglNow('#Tanggal');
			}else{
				$('#v_addjurnal table#addtxt tr td#c1-2').show();
				$('#v_addjurnal table#addtxt tr td#c2-2').show();
				$('div#addnew').hide();
				$('div#addcontent').hide();
			}
	})
	$('#frm1 #ID_Unit').change(function(){
		$.post('get_last_jurnal',{'ID_Unit':$(this).val()},
			function(result){
				var rst=result.split('-')
					$('#noUrut').val('GJ-'+rst[0]);
					$('#Keterangan').focus();
			})
	})
	$('#NoJurnal')
		.click(function(){
			$('div#addcontent').hide();	
		})
		.coolautosuggest({
				url:'get_no_jurnal?limit=30&str=',
				width:350,
				showDescription	:true,
				onSelected:function(result){
					$.post('get_total_KD',{
						'ID_jurnal'	:result.ID,
						'Tanggal'	:result.Tanggal,
						'NoJurnal'	:result.Nomor,
						'Keterangan':result.description,
						'ID_Unit'	:result.ID_Unit},
					function (data){
						$('div#jdet').html(data);
						$('table#j_det').fixedHeader({width:(screen.width-125),height:60})
					})
					$.post('get_detail_jurnal',{'ID':result.ID,'Tahun':result.Tahun},
					function(hasil){
						$('table#j_content tbody').html(hasil);
						$('div#addcontent').show();	
						$('table#j_content').fixedHeader({width:(screen.width-125),height:(screen.height-450)})
						$('table#bwh').fixedHeader({width:(screen.width-125),height:30})
					});
					if(result.Tahun!=$('#thn').val()){
						lock('#addtrans');
					}else{
						unlock('#addtrans');
					}
				}//
		})
	//add new jurnal
	$('#saved-newjurnal')
		.click(function(){
			$.post('set_jurnal',{
				'Tgl'		:$('#frm1 #Tanggal').val(),
				'ID_Unit'	:$('#frm1 #ID_Unit').val(),
				'nomor'		:$('#frm1 #noUrut').val(),
				'Keterangan':$('#frm1 #Keterangan').val()
			},function(result){
				var has=result.split('-');
				var today=new Date();
				tglNow('#Tanggal')
				//show add transaksi jurnal
				show_jurnal_detail($.trim(has[0]),today.getFullYear());
				$('#frm1 :reset').click();
			})
		})
	//print to pdf
	$('#cetak').click(function(){
			$('#frm_j').attr('action','print_list_jurnal');
			document.frm_j.submit();
	})
	$('#pp-j_detail #batal').click(function(){
		$('#pp-j_detail').hide('slow');
		$('#lock').hide();
		$('table#panel tr td#listjurnalumum').click()

	})
	$('#pp-j_detail #pdf').click(function(){
		$('#frm22').attr('action','print_detail_jurnal');
		document.frm22.submit();
	})
	$('table#bwh #pdf').click(function(){
		$('#frm23').attr('action','print_detail_jurnal');
		document.frm23.submit();
	})
	//add jurnal content
	$('#addtrans').click(function(){
		ajax_start();
		$.post('header_perkiraan',{'id':''},
			function(result){
				$('table#pilihan').html(result)
				process('ID_KBR');
			})
		$.post('add_jurnal_content',{'ID':$('#ID_Jurnal').val(),'Tahun':'','ID_Akun':''},
		function(hasil){
			$('#pp-ad_content').css({'top':'10%','left':'25%','width':(screen.width-500),'height':(screen.height-50)});
			$('table#add_trans tbody').html(hasil);	
			$('#pp-ad_content').show();
			$('table#bwht').fixedHeader({width:(screen.width-500),height:30})
			ajax_stop();
			$('#j_detail #j_hide').show();
			$('#lock').show();
		})
	})
/*	$('#pp-ad_content').hide(function(){
		var today = new Date();
		var nj=$('#nj').val();
			$.post('get_detail_jurnal',{'ID':nj,'Tahun':today.getFullYear()},
					function(result){
						$('table#sj_content tbody').html(result);
						//$('div#addcontent').show();	
						//$('table#sj_content').fixedHeader({width:(screen.width-125),height:(screen.height-450)})
					})
	})
*/	//
	$('#jml_bayar')
		.click(function(){
			$.post('total_perjurnal',{'ID_jurnal':$('#ID_Jurnal').val()},
			function(result){
				var hsl=$.parseJSON(result);
				if($('#j_akun').val()!='1'){
					$('#jml_bayar').val('')
					$('#Kete').val($('#jSimp').val());
				}else{
					$('#jml_bayar').val(hsl.balance);
					$('#Kete').val('Setoran '+hsl.ket);
				}
			})
		})
		.keyup(function(){
			$('#jml_bayar').terbilang({'output_div':'terbilang'})
			pos_info('#jml_bayar','terbilang');
		})
		.focusout(function(e) {
           $('#terbilang').hide();
        });
	//drag div for moving 
	$('table#lvltbl0').css('cursor','pointer');
	$('div#pp-ad_content')
		.draggable().resizable();
})
function images_click(id,aksi){
	var idd=id.split('-');
	var today=new Date();
	switch (aksi){
		case 'edit':
			if(idd[1]!=today.getFullYear()){
				$('.nn').hide();
			}else{
				$('.nn').show();
			}
			show_jurnal_detail(idd[0],idd[1]);
		break;
		case 'del':
		if(confirm('Yakin data ini akan dihapus?')){
			$.post('hapus_jurnal',{'ID':idd[0]},
			function(result){
				$('#process').click();
			})
		}
		break;	
	}
}
function show_jurnal_detail(id,thn){
	ajax_start()
	var today = new Date();
	$.post('header_popup',{
	'ID_jurnal'	:id,
	},function (data){
		$('div#jdete').html('');
		$('div#jdete').html(data);
		$.post('get_detail_jurnal',{'ID':id,'Tahun':thn},
			function(hasil){
				var w=$('#pp-j_detail').width();
				var h=$('#pp-j_detail').height();
				$('#pp-j_detail').css({'top':'15%','left':'8%','width':(screen.width-150),'height':(screen.height-50)});
				$('table#sj_content tbody').html(hasil);	
				$('#pp-j_detail').show();
				$('table#j_dete').fixedHeader({width:(screen.width-186),height:60})
				$('table#sj_content').fixedHeader({width:(screen.width-186),height:(screen.height-450)})
				$('table#bwhe').fixedHeader({width:(screen.width-186),height:30})
					ajax_stop();
					$('#lock').show();
			})
	})

}
function addtojurnal(id,nj,ids){
	var today = new Date();
	$.post('add_to_jurnal',{'id':id,'ID_Jurnal':nj},
	function(result){
		$.post('add_jurnal_content',{'ID':$('#ID_Jurnal').val(),'Tahun':'','ID_Akun':ids},
		function(hasil){
		//$('#simp table#add_trans tbody').html(hasil);
		//update tampilan detail jurnal
		total_KD(nj);
/*			$.post('get_detail_jurnal',{'ID':nj,'Tahun':today.getFullYear()},
					function(result){
						$('table#sj_content tbody').html(result);
						//$('div#addcontent').show();	
						//$('table#sj_content').fixedHeader({width:(screen.width-125),height:(screen.height-450)})
					})
*/		
		})
	})
}
function hapus_content(id){
	if(confirm('Yakin data dalam jurnal ini akan di hapus?')){
		var thn=$('#Tgl').val().split('/');
		$.post('hapus_transaksi',{'ID':id},
			function(result){
				total_KD($('#nj').val());
/*				$.post('get_detail_jurnal',{'ID':$('#ID_Jurnal').val(),'Tahun':thn[2]},
						function(hasil){
							$('table#sj_content tbody').html(hasil);
							//$('div#addcontent').show();	
							//$('table#sj_content').fixedHeader({width:(screen.width-125),height:(screen.height-450)})
							//$('table#bwh').fixedHeader({width:(screen.width-125),height:30})
				
				});
*/				$('#process').click();
			})
	}
}
function edit_content(id){
	var thn		=$('#Tgl').val().split('/');
	var akun	='Kode Akun :'+$('table#sj_content tbody tr#r-'+id+' td:nth-child(2)').html();
	    akun 	+=' - '+$('table#sj_content tbody tr#r-'+id+' td:nth-child(3)').html();
	var jml1	=to_number($('table#sj_content tbody tr#r-'+id+' td:nth-child(4)').html())
	var jml2	=to_number($('table#sj_content tbody tr#r-'+id+' td:nth-child(5)').html())
	var edit=prompt('Masukan Jumlah untuk \n'+akun,(parseInt(jml1)==0)?jml2:jml1)
		if(edit){
			$.post('update_transaksi',{'ID':id,'Debet':jml1,'Kredit':jml2,'hasil':edit},
			function(result){
				total_KD($('#nj').val());
/*				$.post('get_detail_jurnal',{'ID':$('#nj').val(),'Tahun':thn[2]},
						function(hasil){
							$('table#sj_content tbody').html(hasil);
							$('div#addcontent').show();	
							$('#process').click();
						})
*/			})
		}
}
function balance_show(){ //show popup balance
	$('#pp-ad_balance').css({'left':'10%','top':'15%','width':(screen.width-250),'height':(screen.height-50)});
	$('#pp-ad_balance').show();
	$('#lock').show();
}
//process popup addcontent jurna
function process(id){
	switch(id){
		case 'ID_KBR':
			$('#frm3 input:reset').click();
			$('#ID_Jurnale')
				.val($('#NoJ').val())
				.attr('readonly','readonly')
			$.post('get_SubJenis',{'ID':'1','ID_Dept':'1'},
				function(result){
					$('#ID_Perkiraan').html(result);
				})
			$('div#unt').show();
			$('div#simp').hide();
			$('input[name="simpan_x"]').show();
			$('#j_akun').val('1')
			$('#jSimp').val('')
		break;	
		case 'ID_USP':
			$('#frm3 input:reset').click();
			$('#ID_Jurnale')
				.val($('#NoJ').val())
				.attr('readonly','readonly')
			$.post('get_SubJenis',{'ID':'2','ID_Dept':'1'},
				function(result){
					$('#ID_Perkiraan').html(result);
				})
			$('div#unt').show();
			$('div#simp').hide();
			$('input[name="simpan_x"]').show();
			$('#j_akun').val('1')
			$('#jSimp').val('')
		break;	
		default :
		//alert(id)
			$('#frm3 input:reset').click();
			$('#ID_Jurnale')
				.val($('#NoJ').val())
				.attr('readonly','readonly')
			$.post('get_SubJenis',{'ID_Dept':'','ID_Simp':"='"+id+"'"},
				function(result){
					$('#ID_Perkiraan').html(result);
				})
			$('div#unt').show();
			$('div#simp').hide();
			$('input[name="simpan_x"]').show();
			$('#j_akun').val('2')
			$('#jSimp').val($('table tr td#ck-'+id).html())
			//alert($('table tr td#ck-'+id).html());
		break;
	}
}
function simpan_ad_content(){
	$.post('add_balance_jurnal',{
		'ID_Jurnal'		:$('#ID_Jurnal').val(),
		'ID_Perkiraan'	:$('#ID_Perkiraan').val(),
		'Jml'			:to_number($('#jml_bayar').val()),
		'ID_Jenis'		:$('#ID_Jenis').val(),
		'Keterangan'	:$('#Kete').val()
	},function(result){
		var today = new Date();
		alert($.trim(result));//tampilkan status process
		//kosongkan field
		$('#frm3 input:not(#ID_Jurnale)').val('');
		$('#frm3 select').val('').select();
		$('#frm3 textarea').text('');
		//update list detail jurnal parent windows
		total_KD($('#ID_Jurnal').val());
			$.post('get_detail_jurnal',{'ID':$('#ID_Jurnal').val(),'Tahun':today.getFullYear()},
					function(hasil){
						$('table#sj_content tbody').html(hasil);
						//$('div#addcontent').show();	
						//$('table#sj_content').fixedHeader({width:(screen.width-125),height:(screen.height-450)})
						if($('#fby').val()!=''){$('#process').click();}
					})
/**/	})
	
}
function _show_data()
{
		var path=$('#path').val().replace('index.php/','');
		var ajax="<tr><td class='kotak' colspan='9'>Data being processed, please wait...<img src='"+path+"asset/img/indicator.gif'></td></tr>";
		$('#v_listjurnalumum #ListTable').show();
		$('#v_listjurnalumum #ListTable tbody').html(ajax)
		$.post('get_list_jurnal',{
				'filter'	:$('#fby').val(),
				'daritgl'	:$('#daritgl').val(),
				'smptgl'	:$('#smptgl').val(),
				'Bln'		:$('#Bln').val(),
				'Thn'		:$('#Thn').val(),
				'ID_Unit'	:$('#ID_Unit').val()
			},function(result){
			$('#v_listjurnalumum #ListTable tbody').html(result)
			$('#result').html('Total data :'+$('#v_listjurnalumum #ListTable tbody tr').length);
			$('.plt').show();
			$('table#ListTable').fixedHeader({width:(screen.width-30),height:(screen.height-350)})
			})
	
}
function total_KD(id){
	$.post('get_total_KD',{
		'ID_jurnal'	:id,
		'Tanggal'	:$('#Tgl').val(),
		'NoJurnal'	:$('#NoJ').val(),
		'Keterangan':$('#Ket').val(),
		'ID_Unit'	:$('#unit').val()},
		function (data){
			$('div#jdete').html(data);
			//$('table#j_dete').fixedHeader({width:(screen.width-125),height:60})
		})
}

function naikan_posisi(id,id_jurnal){
	var urutan=prompt('Akan ditempatkan diurutan ke',$('table#sj_content tbody tr#r-'+id+' td:nth-child(1)').html());
		if(urutan){
			show_indicator('shiip',1);
			$.post('update_posisi',{'ID':id,'urutan':urutan,'ID_Jurnal':id_jurnal},
			function(result){
				total_KD($('#ID_Jurnal').val());
/*				$.post('get_detail_jurnal',{'ID':$('#ID_Jurnal').val(),'Tahun':$('#Tgl').val().substr(6,4)},
						function(hasil){
							$('table#sj_content tbody').html(hasil);
							$('div#addcontent').show();	
							//$('#process').click();
							$('table#shiip tbody').html('');
						})
*/			})
		}
}
function dragable(div){
var $dragging = null;

    $(document.body).on("mousemove",div, function(e) {
        if ($dragging) {
            $dragging.offset({
                top: e.pageY,
                left: e.pageX
            });
        }
    });
    
    $(document.body).on("mousedown", div, function (e) {
        $dragging = $(e.target);
    });
    
    $(document.body).on("mouseup",div, function (e) {
        $dragging = null;
    });}