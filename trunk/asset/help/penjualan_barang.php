﻿<!DOCTYPE HTML>
<html>
<head>
   <title>Sistem Applikasi &gt; Modul Inventory &gt; Penjualan Barang</title>
   <meta name="generator" content="Help & Manual">
   <meta name="keywords" content="">
   <meta name="description" content="Penjualan Barang">
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
     HMSyncTOC("index.html", "penjualan_barang.php");
   </script>
   <script type="text/javascript" src="highlight.js"></script>
   <script type="text/javascript">
     $(document).ready(function(){highlight();});
   </script>
</head>
<body>
<!--ZOOMSTOP-->

<div id="printheader"><h1 class="p_Heading1"><span class="f_Heading1">Penjualan Barang</span></h1>
</div>
<div id="idheader">
<div id="idheaderbg">
<table width="100%" border="0" cellspacing="0" cellpadding="0" 
       style="margin: 0px; background: url(header_bg.jpg);">

  <tr valign="bottom">
    <td align="left" valign="bottom" class="topichead">
   <p class="crumbs" id="idnav"><b>Navigation:</b>&nbsp;
   
   <a href="chapter_2.php">Sistem Applikasi</a> &gt; <a href="modul_inventory.php">Modul Inventory</a>&nbsp;&gt;</p>
   <h1 class="p_Heading1"><span class="f_Heading1">Penjualan Barang</span></h1>

    </td>
    <td align="right" width="120" valign="middle" class="topichead" id="idnav">
    
     <a href="return_pembelian_konsinyasi.php"
        onmouseover="document.images.prev.src='btn_prev_h.gif'" 
        onmouseout="document.images.prev.src='btn_prev_n.gif'"
        ><img name=prev src="btn_prev_n.gif" border=0 alt="Previous page"
        ></a><a href="modul_inventory.php"
        onmouseover="document.images.main.src='btn_home_h.gif'" 
        onmouseout="document.images.main.src='btn_home_n.gif'"><img name=main src="btn_home_n.gif" border=0 alt="Return to chapter overview"
        ></a><a href="return_penjualan.php"
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
<p>Transaksi penjualan barang dilakukan dari modul inventory menu transaksi dan sub menu penjualan.</p>
<p>Penjualan barang dalam sistem ini bisa dilakukan dengan cara penjualan tunai maupun penjualan kredit.</p>
<p><img src="clip0081.png" width="373" height="228" alt="clip0081" style="border:none" /></p>
<p>&nbsp;</p>
<p>dan tampilan menu penjualan adalah sebagai berikut.</p>
<p><img src="clip0082_zoom72.png" width="739" height="431" alt="clip0082" style="border:none" /></p>
<p>Untuk penjualan secara tunai nama anggota sifatnya optional (boleh diisi / tidak) tetapi jika penjualan secara kredit nama anggota harus diisi karena sistem akan meminta untuk memasukan nama anggota terlebih dahulu baru bisa ke step berikutnya.</p>
<p>Untuk menyelesaikan transaki penjualan tekan tombol bayar yang senjutnya akan muncul pop up seperti dibawah ini.</p>
<p>Jika penjualan dilakukan secara tunai</p>
<p><img src="clip0083.png" width="424" height="388" alt="clip0083" style="border:none" /></p>
<p>masukan jumlah uang tunai dari pembayar dan otomatis nilai kembalian akan muncul, tekan tombol proces untuk mengakhirinya. secara default system akan melakukan print struk penjualan.</p>
<p>Jika penjualan dilakukan secara kredit</p>
<p><img src="clip0084.png" width="414" height="429" alt="clip0084" style="border:none" /></p>
<p>Masukan uang muka jika ada dan tentukan jumlah cicilan, kemudian tekan tombol process untuk mengakhirinya dan secara default sistem akan melakukan printout slip penjualan.</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

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






