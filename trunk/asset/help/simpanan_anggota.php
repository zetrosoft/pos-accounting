<!DOCTYPE HTML>
<html>
<head>
   <title>Sistem Applikasi &gt; Modul Akuntansi &gt; Keanggotaan &gt; Simpanan Anggota</title>
   <meta name="generator" content="Help & Manual">
   <meta name="keywords" content="">
   <meta name="description" content="Simpanan Anggota">
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <link type="text/css" href="default.css" rel="stylesheet">
   <link type="text/css" href="custom.css" rel="stylesheet">
   <script type="text/javascript" src="nsh.js"></script>

<script type="text/javascript">   
// Toggle Toggler 

var toggleCount=false;
var switchState;

function toggleToggles() {

    if (!toggleCount) {
     toggleCount = true;
     HMToggleExpandAll(true);
     switchState = true;
     }
   
     else if (switchState) {
        HMToggleExpandAll(false);
        switchState = false;
        }
        
     else  {
        HMToggleExpandAll(true);
        switchState = true;
        } 
    }
</script>
   
<!-- non-scrolling headers for CHM and browser-based help, local styles-->
<style type="text/css" media="screen"> 
html, body {    
      margin:0; 
      padding:0; 
      overflow: hidden; 
      background: #FFFFFF; 
   }
 
div#printheader { 
   display: none;
   }
   #idheader { 
      width:100%; 
      height:auto; 
      padding: 0; 
      margin: 0; 
} 
    #idheaderbg  {
    background: #6F6F6F; 
}
   #callout-table, #overview-table {display:block; position:relative; top:0; left:0;}
   #callout-icon {display:block; position:absolute; top:-11px; left:-11px;}
   #callout-icon-flag {display:block; position:absolute; top:-11px; left:-8px;}
   #callout-table a {text-decoration: none; color: blue;}
   #callout-table a:visited {text-decoration: none; color: blue;}
   #overview-table a {text-decoration: none; color: black;}
   #overview-table a:visited {text-decoration: none; color: black;}
   #callout-table a:hover, #overview-table a:hover {text-decoration: underline;}
   p.help-url { margin: 20px 0 5px 0; text-align: center; font-size: 80%; text-decoration: none }
   </style>
<!--[if lt IE 7]>
<style type="text/css">
  #idcontent {padding: 0px;} 
  #innerdiv {padding: 10px 5px 5px 10px ;} 
</style> 
<![endif]-->
   <noscript>
   <style type="text/css">
   html, body { overflow: auto; }
   </style> 
   </noscript>
<style type="text/css" media="print">
span.f_Heading1 { color: black; }
#idheader, #printheader img { display:none; }
#printheader { display: block; margin-top: 20px; }
#idcontent { margin-top: 10px; }
</style>   
   <script type="text/javascript" src="jquery.js"></script>
   <script type="text/javascript" src="helpman_settings.js"></script>
   <script type="text/javascript" src="helpman_topicinit.js"></script>

   <script type="text/javascript">
     HMSyncTOC("index.html", "simpanan_anggota.php");
   </script>
   <script type="text/javascript" src="highlight.js"></script>
   <script type="text/javascript">
     $(document).ready(function(){highlight();});
   </script>
</head>
<body>
<!--ZOOMSTOP-->

<div id="printheader"><h1 class="p_Heading1"><span class="f_Heading1">Simpanan Anggota</span></h1>
</div>
<div id="idheader">
<div id="idheaderbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0" 
       style="margin: 0px; background: url(header_bg.jpg);">

  <tr valign="bottom">
    <td align="left" valign="bottom" class="topichead">
   <p class="crumbs" id="idnav"><b>Navigation:</b>&nbsp;
   
   <a href="chapter_2.php">Sistem Applikasi</a> &gt; <a href="sub_chapter_2_1.php">Modul Akuntansi</a> &gt; <a href="keanggotaan.php">Keanggotaan</a>&nbsp;&gt;</p>
   <h1 class="p_Heading1"><span class="f_Heading1">Simpanan Anggota</span></h1>

    </td>
    <td align="right" width="120" valign="middle" class="topichead" id="idnav">
    
     <a href="daftar_anggota.php"
        onmouseover="document.images.prev.src='btn_prev_h.gif'" 
        onmouseout="document.images.prev.src='btn_prev_n.gif'"
        ><img name=prev src="btn_prev_n.gif" border=0 alt="Previous page"
        ></a><a href="keanggotaan.php"
        onmouseover="document.images.main.src='btn_home_h.gif'" 
        onmouseout="document.images.main.src='btn_home_n.gif'"><img name=main src="btn_home_n.gif" border=0 alt="Return to chapter overview"
        ></a><a href="jurnal.php"
        onmouseover="document.images.next.src='btn_next_h.gif'" 
        onmouseout="document.images.next.src='btn_next_n.gif'"><img name=next src="btn_next_n.gif" border=0 alt="Next page"
        ></a>
    </td>
  </tr>
  <tr><td colspan="2" style="height: 3px; background: url(header_bg_shadow.gif)"></td></tr>
</table>
</div>

<!-- The following code displays Expand All/Collapse All links  below the header in topics containing toggles -->
  

</div>  



<div id="idcontent"><div id="innerdiv"> 
<!--ZOOMRESTART-->
<p><span style="font-size: 11pt;">1. Simpanan Anggota per Anggota</span></p>
<p style="margin: 0px 0px 0px 24px;"><span style="font-size: 11pt;">Untuk melihat transaksi simpanan / pinjamana anggota bisa dilakukan dari menu <a href="keanggotaan.php" class="topiclink">Keanggotaan</a> </span><span style="font-size: 11pt; font-family: 'Wingdings 3';">&quot;</span><span style="font-size: 11pt;"> <a href="daftar_anggota.php" class="topiclink">Daftar Anggota</a>. Setelah tampil pilih dari daftar anggota tersebut dan klik icon </span><img src="clip0011.png" width="20" height="22" alt="clip0011" style="border:none" /><span style="font-size: 11pt;"> untuk membukannya.</span></p>
<p style="margin: 0px 0px 0px 24px;"><span style="font-size: 11pt;">berikut adalah tampilannya</span></p>
<p style="margin: 0px 0px 0px 24px;"><img src="clip0030_zoom78.png" width="714" height="409" alt="clip0030" style="border:none" /></p>
<p style="margin: 0px 0px 0px 24px;"><span style="font-size: 11pt;">Klik pada jenis pada baris di kolom jenis simpanan dan detail nya akan muncul di tabel bawahnya. Jika data tersebut akan di print, tekan tombol cetak.</span></p>
<p><span style="font-size: 11pt;">2. Simpanan Anggota by Departement</span></p>
<p style="margin: 0px 0px 0px 24px;"><span style="font-size: 11pt;">Laporan simpanan anggota per departemen bisa di akses dari menu Rekapitulasi </span><span style="font-size: 11pt; font-family: 'Wingdings 3';">&quot;</span><span style="font-size: 11pt;"> Simpanan Anggota </span></p>
<p style="margin: 0px 0px 0px 24px;"><img src="clip0034.png" width="428" height="153" alt="clip0034" style="border:none" /></p>
<p style="margin: 0px 0px 0px 24px;"><span style="font-size: 11pt;">Klik simpanan anggota dan akan mucul page seperti gambar dibawah</span></p>
<p style="margin: 0px 0px 0px 24px;"><img src="clip0036.png" width="460" height="123" alt="clip0036" style="border:none" /></p>
<p style="margin: 0px 0px 0px 24px;"><span style="font-size: 11pt;">klik field tanggal untuk mengganti periode. Data yang muncul adalah data sampai tanggal yang tercantum di field tersebuk. Kemudian tekan tombol OK dan outputnya sudah dalam bentuk PDF bisa di simpan sebagai file pdf atau langsung di print dengan klik tombol print yang muncul di halaman tersebut.</span></p>
<p style="margin: 0px 0px 0px 24px;"><img src="clip0033_zoom78.png" width="714" height="420" alt="clip0033" style="border:none" /></p>
<p style="margin: 0px 0px 0px 24px;">&nbsp;</p>
<p style="margin: 0px 0px 0px 24px;">&nbsp;</p>
<p style="margin: 0px 0px 0px 24px;">&nbsp;</p>

<!--ZOOMSTOP-->
</div></div>
<script type="text/javascript">

var lastSlashPos = document.URL.lastIndexOf("/") > document.URL.lastIndexOf("\\") ? document.URL.lastIndexOf("/") : document.URL.lastIndexOf("\\");
if( document.URL.substring(lastSlashPos + 1, lastSlashPos + 4).toLowerCase() != "~hh" )
{
 if (document.all) setTimeout(function() {nsrInit();},20); 
    else nsrInit();
 } 


</script>
</body>
</html>







