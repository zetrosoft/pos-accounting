<!DOCTYPE HTML>
<html><head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- This line includes the general project style sheet (not required) -->
   <link type="text/css" href="default.css" rel="stylesheet">

<!-- This block defines the styles of the TOC headings, change them as needed -->
<style type="text/css">
       a { color: black; text-decoration: none }
       a:visited {color: black}
       a:hover { text-decoration: underline }
       .navtitle    { font-size: 14pt; font-weight: bold; margin-bottom: 16px; }
       .navbar      { font-size: 10pt; }
       span#navsearch {display: none;}

.heading1 { font-size: 10pt; color: #000000; text-decoration: none; }
.heading2 { font-size: 10pt; color: #000000; text-decoration: none; }
.heading3 { font-size: 10pt; color: #000000; text-decoration: none; }
.heading4 { font-size: 10pt; color: #000000; text-decoration: none; }
.heading5 { font-size: 10pt; color: #000000; text-decoration: none; }
.heading6 { font-size: 10pt; color: #000000; text-decoration: none; }

.hilight1 { font-size: 10pt; color: #FFFFFF; background: #004101; text-decoration: none; }
.hilight2 { font-size: 10pt; color: #FFFFFF; background: #004101; text-decoration: none; }
.hilight3 { font-size: 10pt; color: #FFFFFF; background: #004101; text-decoration: none; }
.hilight4 { font-size: 10pt; color: #FFFFFF; background: #004101; text-decoration: none; }
.hilight5 { font-size: 10pt; color: #FFFFFF; background: #004101; text-decoration: none; }
.hilight6 { font-size: 10pt; color: #FFFFFF; background: #004101; text-decoration: none; }

/* TOC LIST CSS */
#toc    { padding:0; margin:0 }
#toc li { margin-top:2px; margin-left:0px; padding:1px; }
#toc ul { padding-left:0; margin-left:-16px; }
/* TOC LIST CSS */

</style>
<!--[if lt IE 7]>
<style type="text/css">
 html {padding: 0; margin: 0;overflow-x: hidden;}
 body { margin: 0; padding: 15px 0 0 10px;} 
</style> 
<![endif]-->
   <script type="text/javascript" src="jquery.js"></script>
   <script type="text/javascript" src="helpman_settings.js"></script>
   <script type="text/javascript">
     var parentScope = (parent.hmNavigationFrame);
     if (!parentScope) {
		      var s = document.createElement("script");
		      s.setAttribute("type","text/javascript");
		      s.setAttribute("src", "helpman_navigation.js");
		      document.getElementsByTagName("head")[0].appendChild(s);
	    }
     else {
       if (initialtocstate != "expandall") parent.hmAddCss(document, "#toc li ul { display: none }");
     }
     function loadicons() { var icons = new Array(); for (i=0; i<arguments.length; i++) { icons[i] = new Image(); icons[i].src = arguments[i]; } }
     function loadtoc() { if (parentScope) parent.loadstate(document.getElementById("toc")); else loadstate(document.getElementById("toc")); }
     function savetoc() { if (parentScope) parent.savestate(document.getElementById("toc")); else savestate(document.getElementById("toc")); }
     function clicked(node, event) { deselect(); if (parentScope) parent.hmNodeClicked(node, event); else hmNodeClicked(node, event); }
     function dblclicked(node) { if (parentScope) parent.hmNodeDblclicked(node); else hmNodeDblclicked(node); }
     function deselect() { if (window.getSelection) window.getSelection().removeAllRanges(); else if (document.selection) document.selection.empty(); }
     $(document).ready(function(){
       loadtoc();
       $(window).onunload = savetoc;
     });
   </script>
</head>
<body style="background-color: #FFFFFF; background-image: url(lines.gif); ">
<p class="navtitle">User Manual</p>
<p class="navbar">
<b>Contents</b>&nbsp;|&nbsp;<a href="help_kwindex.php">Index</a>&nbsp;
<span id="navsearch">|&nbsp;<a href="help_ftsearch.php">Search</a></span>
<hr size="1" />

<!-- Placeholder for the TOC - this variable is REQUIRED! -->
<ul id="toc" style="list-style-type:none;display:block;padding-left:0">
<li class="heading1" id="i1" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading1" id="a1" href="introduction.php" target="hmcontent"><span class="heading1" id="s1" ondblclick="return dblclicked(this)">Pendahuluan</span></a>
<ul id="ul1" style="list-style-type:none">
<li class="heading2" id="i1.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a1.1" href="welcome_topic.php" target="hmcontent"><span class="heading2" id="s1.1">Pendahuluan</span></a>
</li>
<li class="heading2" id="i1.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a1.2" href="ruang_lingkup.php" target="hmcontent"><span class="heading2" id="s1.2">Ruang Lingkup</span></a>
</li>
<li class="heading2" id="i1.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a1.3" href="modul-modul.php" target="hmcontent"><span class="heading2" id="s1.3">Modul-modul</span></a>
</li>
</ul>
</li>
<li class="heading1" id="i2" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading1" id="a2" href="chapter_2.php" target="hmcontent"><span class="heading1" id="s2" ondblclick="return dblclicked(this)">Sistem Applikasi</span></a>
<ul id="ul2" style="list-style-type:none">
<li class="heading2" id="i2.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a2.1" href="overview.php" target="hmcontent"><span class="heading2" id="s2.1">Kebutuhan Sistem</span></a>
</li>
<li class="heading2" id="i2.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a2.2" href="instalasi_applikasi.php" target="hmcontent"><span class="heading2" id="s2.2">Instalasi Applikasi</span></a>
</li>
<li class="heading2" id="i2.3" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a2.3" href="admin_pengguna.php" target="hmcontent"><span class="heading2" id="s2.3" ondblclick="return dblclicked(this)">Admin Pengguna</span></a>
<ul id="ul2.3" style="list-style-type:none">
<li class="heading3" id="i2.3.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.3.1" href="tambah_user.php" target="hmcontent"><span class="heading3" id="s2.3.1">Tambah User</span></a>
</li>
<li class="heading3" id="i2.3.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.3.2" href="list_user.php" target="hmcontent"><span class="heading3" id="s2.3.2">List User</span></a>
</li>
<li class="heading3" id="i2.3.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.3.3" href="pengaturan_hak_akses.php" target="hmcontent"><span class="heading3" id="s2.3.3">Pengaturan Hak Akses</span></a>
</li>
</ul>
</li>
<li class="heading2" id="i2.4" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a2.4" href="sub_chapter_2_1.php" target="hmcontent"><span class="heading2" id="s2.4" ondblclick="return dblclicked(this)">Modul Akuntansi</span></a>
<ul id="ul2.4" style="list-style-type:none">
<li class="heading3" id="i2.4.1" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.4.1" href="new_topic.php" target="hmcontent"><span class="heading3" id="s2.4.1" ondblclick="return dblclicked(this)">Kode Akuntansi</span></a>
<ul id="ul2.4.1" style="list-style-type:none">
<li class="heading4" id="i2.4.1.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.1.1" href="departement.php" target="hmcontent"><span class="heading4" id="s2.4.1.1">Departement</span></a>
</li>
<li class="heading4" id="i2.4.1.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.1.2" href="klasifikasi.php" target="hmcontent"><span class="heading4" id="s2.4.1.2">Klasifikasi</span></a>
</li>
<li class="heading4" id="i2.4.1.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.1.3" href="sub_klasifikasi.php" target="hmcontent"><span class="heading4" id="s2.4.1.3">Sub Klasifikasi</span></a>
</li>
<li class="heading4" id="i2.4.1.4" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.1.4" href="perkiraan.php" target="hmcontent"><span class="heading4" id="s2.4.1.4" ondblclick="return dblclicked(this)">Perkiraan</span></a>
<ul id="ul2.4.1.4" style="list-style-type:none">
<li class="heading5" id="i2.4.1.4.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.4.1.4.1" href="add_perkiraan.php" target="hmcontent"><span class="heading5" id="s2.4.1.4.1">Add Perkiraan</span></a>
</li>
<li class="heading5" id="i2.4.1.4.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.4.1.4.2" href="perkiraan2.php" target="hmcontent"><span class="heading5" id="s2.4.1.4.2">Daftar Perkiraan</span></a>
</li>
</ul>
</li>
</ul>
</li>
<li class="heading3" id="i2.4.2" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.4.2" href="keanggotaan.php" target="hmcontent"><span class="heading3" id="s2.4.2" ondblclick="return dblclicked(this)">Keanggotaan</span></a>
<ul id="ul2.4.2" style="list-style-type:none">
<li class="heading4" id="i2.4.2.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.2.1" href="tambah_anggota.php" target="hmcontent"><span class="heading4" id="s2.4.2.1">Tambah Anggota</span></a>
</li>
<li class="heading4" id="i2.4.2.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.2.2" href="daftar_anggota.php" target="hmcontent"><span class="heading4" id="s2.4.2.2">Daftar Anggota</span></a>
</li>
<li class="heading4" id="i2.4.2.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.2.3" href="simpanan_anggota.php" target="hmcontent"><span class="heading4" id="s2.4.2.3">Simpanan Anggota</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.4.3" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.4.3" href="jurnal.php" target="hmcontent"><span class="heading3" id="s2.4.3" ondblclick="return dblclicked(this)">Jurnal</span></a>
<ul id="ul2.4.3" style="list-style-type:none">
<li class="heading4" id="i2.4.3.1" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.3.1" href="jurnal_umum.php" target="hmcontent"><span class="heading4" id="s2.4.3.1" ondblclick="return dblclicked(this)">Jurnal Umum</span></a>
<ul id="ul2.4.3.1" style="list-style-type:none">
<li class="heading5" id="i2.4.3.1.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.4.3.1.1" href="add_jurnal.php" target="hmcontent"><span class="heading5" id="s2.4.3.1.1">Add Jurnal</span></a>
</li>
<li class="heading5" id="i2.4.3.1.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.4.3.1.2" href="list_jurnal_umum.php" target="hmcontent"><span class="heading5" id="s2.4.3.1.2">List Jurnal Umum</span></a>
</li>
</ul>
</li>
<li class="heading4" id="i2.4.3.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.3.2" href="buku_besar.php" target="hmcontent"><span class="heading4" id="s2.4.3.2">Buku Besar</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.4.4" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.4.4" href="laporan.php" target="hmcontent"><span class="heading3" id="s2.4.4" ondblclick="return dblclicked(this)">Laporan</span></a>
<ul id="ul2.4.4" style="list-style-type:none">
<li class="heading4" id="i2.4.4.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.4.1" href="neraca_lajur.php" target="hmcontent"><span class="heading4" id="s2.4.4.1">Neraca Lajur</span></a>
</li>
<li class="heading4" id="i2.4.4.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.4.2" href="neraca.php" target="hmcontent"><span class="heading4" id="s2.4.4.2">Neraca</span></a>
</li>
<li class="heading4" id="i2.4.4.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.4.3" href="shu.php" target="hmcontent"><span class="heading4" id="s2.4.4.3">SHU</span></a>
</li>
<li class="heading4" id="i2.4.4.4" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.4.4" href="grafik_shu.php" target="hmcontent"><span class="heading4" id="s2.4.4.4">Grafik SHU</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.4.5" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.4.5" href="tools.php" target="hmcontent"><span class="heading3" id="s2.4.5" ondblclick="return dblclicked(this)">Tools</span></a>
<ul id="ul2.4.5" style="list-style-type:none">
<li class="heading4" id="i2.4.5.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.5.1" href="setting_neraca.php" target="hmcontent"><span class="heading4" id="s2.4.5.1">Setting Neraca</span></a>
</li>
<li class="heading4" id="i2.4.5.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.5.2" href="setting_shu.php" target="hmcontent"><span class="heading4" id="s2.4.5.2">Setting SHU</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.4.6" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.4.6" href="poting_inventory.php" target="hmcontent"><span class="heading3" id="s2.4.6" ondblclick="return dblclicked(this)">Posting Inventory</span></a>
<ul id="ul2.4.6" style="list-style-type:none">
<li class="heading4" id="i2.4.6.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.4.6.1" href="posting_penjualan_kredit.php" target="hmcontent"><span class="heading4" id="s2.4.6.1">Posting Penjualan Kredit</span></a>
</li>
</ul>
</li>
</ul>
</li>
<li class="heading2" id="i2.5" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading2" id="a2.5" href="modul_inventory.php" target="hmcontent"><span class="heading2" id="s2.5" ondblclick="return dblclicked(this)">Modul Inventory</span></a>
<ul id="ul2.5" style="list-style-type:none">
<li class="heading3" id="i2.5.1" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.5.1" href="data_barang.php" target="hmcontent"><span class="heading3" id="s2.5.1" ondblclick="return dblclicked(this)">Data Barang</span></a>
<ul id="ul2.5.1" style="list-style-type:none">
<li class="heading4" id="i2.5.1.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.1.1" href="kategori_barang.php" target="hmcontent"><span class="heading4" id="s2.5.1.1">Kategori Barang</span></a>
</li>
<li class="heading4" id="i2.5.1.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.1.2" href="jenis_barang.php" target="hmcontent"><span class="heading4" id="s2.5.1.2">Jenis Barang</span></a>
</li>
<li class="heading4" id="i2.5.1.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.1.3" href="tambah_barang.php" target="hmcontent"><span class="heading4" id="s2.5.1.3">Tambah Barang</span></a>
</li>
<li class="heading4" id="i2.5.1.4" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.1.4" href="daftar_barang.php" target="hmcontent"><span class="heading4" id="s2.5.1.4">Daftar Barang</span></a>
</li>
<li class="heading4" id="i2.5.1.5" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.1.5" href="konversi_satuan.php" target="hmcontent"><span class="heading4" id="s2.5.1.5">Konversi Satuan</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.5.2" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.5.2" href="pembelian_barang.php" target="hmcontent"><span class="heading3" id="s2.5.2" ondblclick="return dblclicked(this)">Pembelian Barang</span></a>
<ul id="ul2.5.2" style="list-style-type:none">
<li class="heading4" id="i2.5.2.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.2.1" href="return_pembelian_konsinyasi.php" target="hmcontent"><span class="heading4" id="s2.5.2.1">Return Pembelian Konsinyasi</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.5.3" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.5.3" href="penjualan_barang.php" target="hmcontent"><span class="heading3" id="s2.5.3" ondblclick="return dblclicked(this)">Penjualan Barang</span></a>
<ul id="ul2.5.3" style="list-style-type:none">
<li class="heading4" id="i2.5.3.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.3.1" href="return_penjualan.php" target="hmcontent"><span class="heading4" id="s2.5.3.1">Return Penjualan</span></a>
</li>
</ul>
</li>
<li class="heading3" id="i2.5.4" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading3" id="a2.5.4" href="laporan2.php" target="hmcontent"><span class="heading3" id="s2.5.4" ondblclick="return dblclicked(this)">Laporan</span></a>
<ul id="ul2.5.4" style="list-style-type:none">
<li class="heading4" id="i2.5.4.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.4.1" href="anggota.php" target="hmcontent"><span class="heading4" id="s2.5.4.1">Anggota</span></a>
</li>
<li class="heading4" id="i2.5.4.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.4.2" href="pemasok.php" target="hmcontent"><span class="heading4" id="s2.5.4.2">Pemasok</span></a>
</li>
<li class="heading4" id="i2.5.4.3" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.4.3" href="laporan_stock.php" target="hmcontent"><span class="heading4" id="s2.5.4.3" ondblclick="return dblclicked(this)">Laporan Stock</span></a>
<ul id="ul2.5.4.3" style="list-style-type:none">
<li class="heading5" id="i2.5.4.3.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.5.4.3.1" href="stock_barang.php" target="hmcontent"><span class="heading5" id="s2.5.4.3.1">Stock Barang</span></a>
</li>
<li class="heading5" id="i2.5.4.3.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.5.4.3.2" href="stock_history.php" target="hmcontent"><span class="heading5" id="s2.5.4.3.2">Stock History</span></a>
</li>
</ul>
</li>
<li class="heading4" id="i2.5.4.4" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.4.4" href="laporan_pembelian.php" target="hmcontent"><span class="heading4" id="s2.5.4.4">Laporan Pembelian</span></a>
</li>
<li class="heading4" id="i2.5.4.5" data-bg="button_closedbook.gif;button_openbook.gif" style="background:url(button_openbook.gif) no-repeat;cursor:pointer;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.4.5" href="laporan_penjualan.php" target="hmcontent"><span class="heading4" id="s2.5.4.5" ondblclick="return dblclicked(this)">Laporan Penjualan</span></a>
<ul id="ul2.5.4.5" style="list-style-type:none">
<li class="heading5" id="i2.5.4.5.1" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.5.4.5.1" href="penjualan_tunai2.php" target="hmcontent"><span class="heading5" id="s2.5.4.5.1">Penjualan Tunai</span></a>
</li>
<li class="heading5" id="i2.5.4.5.2" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.5.4.5.2" href="penjualan_kredit2.php" target="hmcontent"><span class="heading5" id="s2.5.4.5.2">Penjualan Kredit</span></a>
</li>
<li class="heading5" id="i2.5.4.5.3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.5.4.5.3" href="barang_kredit.php" target="hmcontent"><span class="heading5" id="s2.5.4.5.3">Barang Kredit</span></a>
</li>
<li class="heading5" id="i2.5.4.5.4" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading5" id="a2.5.4.5.4" href="barang_terjual.php" target="hmcontent"><span class="heading5" id="s2.5.4.5.4">Barang Terjual</span></a>
</li>
</ul>
</li>
<li class="heading4" id="i2.5.4.6" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading4" id="a2.5.4.6" href="grafik_penjualan.php" target="hmcontent"><span class="heading4" id="s2.5.4.6">Grafik Penjualan</span></a>
</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
<li class="heading1" id="i3" style="background:url(button_topic.gif) no-repeat;padding-left:34px" onclick="return clicked(this,event)"><a class="heading1" id="a3" href="backup_database.php" target="hmcontent"><span class="heading1" id="s3">Backup Database</span></a>
</li>
</ul>
<script type="text/javascript">loadicons('button_openbook.gif','button_closedbook.gif','button_topic.gif');</script>

<hr size="1" /><p><span style="font-size: 8px">© 2013 zetrosoft.com</span></p>
<script type="text/javascript">
document.getElementById("navsearch").style.display="inline";
</script> 
</body>
</html>









