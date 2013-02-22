;;generate form and list data

[klasifikasi]
1|Kode,input,text n,ID,w10,,5%,
2|Klasifikasi,input,text n,Klasifikasi,w90,,80%,


[subklasifikasi]
1|Klasifikasi,select,text n,ID_Klasifikasi,S70,,30%,RD,klasifikasi-ID-Kode+Klasifikasi-
2|Kode,input,text n,Kode,w90,,5%
3|Sub Klasifikasi,input,text n,SubKlasifikasi,w90,,55%

[Departemen]
1|Kode,input,text n,ID,w10,,5%,
2|Departement,input,text n,Departemen,w90,,70%,
3|Title,input,text n,Title,w35,,20%

[perkiraan]
1|Klasifikasi,select,text n,ID_Klas,S70,,18%,RD,klasifikasi-ID-Kode+Klasifikasi-
2|Sub Klasifikasi,select,text n,ID_SubKlas,S70,,22%,
3|Unit,select,text n,ID_Unit,S35,,5%,RD,unit_jurnal-ID-Kode+Unit-
4|Laporan,select,text n,ID_Laporan,S50,,,RD,laporan-ID-JenisLaporan-
5|Lap. Detail,select,text n,ID_LapDetail,S70,,,
6|Sistem Kalkulasi,select,text n,ID_Calc,S50,,,RD,lap_head-ID-header2-
7|Kode,input,text n,Kode,w50,,10%,
8|Nama Perkiraan,input,text n,Perkiraan,w90,,35%,
9|Saldo Awal,input,text d,SaldoAwal,w35 angka,,

;Tanggal,,,,,,,,,22
[rekapsimpanan]
1|Departemen,,,,,,,,,60
2|Simp.Pokok,,,,,,,,,30
3|Simp.Wajib,,,,,,,,,30
4|Simp.Khusus,,,,,,,,,30
5|Total,,,,,,,,,30

[NeracaLajur]
1|Kode,,,,,,,,,15
2|Perkiraan,,,,,,,,,80
3|Saldo Awal,,,,,,,,,12
4|Kredit,,,,,,,,,12
5|Debet,,,,,,,,,12
6|Saldo Akhir,,,,,,,,,12

[jurnal]
1|Tanggal,,,,,,8%,,,18
2|Unit,,,,,,5%,,,10
3|No. Jurnal,,,,,,8%,,,20
4|Keterangan,,,,,,25%,,,60
5|Debet,,,,,,12%,,,25
6|Kredit,,,,,,12%,,,25
7|Balance,,,,,,15%,,,25

[newjurnal]
1|Tanggal,input,text t,Tanggal,w35,,
2|Unit,select,text n,ID_Unit,S50,,,RD,unit_jurnal-ID-Kode+Unit-
3|No.Urut,input,text d,noUrut,w35,,
4|Keterangan,textarea,text n,Keterangan,T90,,

;array(10,25,90,31,31,90)
[addcontent]
1|Kode,,,,,,8%,,,25
2|Perkiraan,,,,,,25%,,,60
3|Debet,,,,,,10%,,,25
4|Kredit,,,,,,10%,,,25
5|Keterangan,,,,,,20%,,,50

[balance]
1|No. Jurnal,input,text n,ID_Jurnale,w35,,,
2|Tipe Transaksi,select,text n,ID_Jenis,S35,,,RD,tipe_transaksi-ID-Tipe-
3|Perkiraan,select,text n,ID_Perkiraan,S90,,,RD,lap_subjenis-ID-SubJenis-where ID_KBR='1'
4|Jumlah,input,text n,jml_bayar,w35 angka,,,
5|Keterangan,textarea,text n,Kete,T90,,

[bukubesar]
1|Tanggal,,,,,,10%,,,25
2|No.Jurnal,,,,,,10%,,,25
3|Keterangan,,,,,,30%,,,25
4|Debet,,,,,,12%,,,25
5|Kredit,,,,,,12%,,,25
6|Saldo,,,,,,12%,,,25

[bukubesartahunan]
1|Bulan,,,,,,10%,,,25
2|Debet,,,,,,15%,,,25
3|Kredit,,,,,,15%,,,25
4|Saldo,,,,,,15%,,,25


