<!DOCTYPE HTML>
<html><head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />

   <!-- This line includes the general project style sheet (not required) -->
   <link type="text/css" href="default.css" rel="stylesheet">

   <style type="text/css">
       a { color: black; text-decoration: none }
       a:visited {color: black}
       a:hover { text-decoration: underline }
       .navtitle    { font-size: 14pt; font-weight: bold; margin-bottom: 16px; }
       .navbar      { font-size: 10pt; }
       .idxsection  { font-family: Arial,Helvetica; font-weight: bold; font-size: 21px; color: #000000; text-decoration: none;
                    margin-top: 15px; margin-bottom: 0px; }
       .idxkeyword  { font-family: Arial,Helvetica; font-weight: normal; font-size: 15px; color: #000000; text-decoration: none }
       .idxkeyword2 { font-family: Arial,Helvetica; font-weight: normal; font-size: 15px; color: #000000; text-decoration: none }
       .idxlink     { font-family: Arial,Helvetica; font-weight: normal; font-size: 14px; color: #000000; text-decoration: none }
       TABLE.idxtable { background: #F4F4F4; border-width: 1px; border-color: #000000; border-collapse: collapse;
                        filter: progid:DXImageTransform.Microsoft.Shadow(color=B0B0B0, Direction=135, Strength=4) }
       TD.idxtable    { background: #F4F4F4; }
       span#navsearch {display: none;}
   </style>
<!--[if lt IE 7]>
<style type="text/css">
html { overflow-x: hidden;} 
</style> 
<![endif]-->
   <script type="text/javascript" src="jquery.js"></script>
   <script type="text/javascript" src="helpman_settings.js"></script>
</head>
<body style="background-color: #FFFFFF; background-image: url(lines.gif); ">
<p class="navtitle">User Manual</p>
<p class="navbar">
<a href="help_content.php">Contents</a>&nbsp;
|&nbsp;<b>Index</b>&nbsp;
<span id="navsearch">|&nbsp;<a href="help_ftsearch.php">Search</a></span>
</p><hr size="1" />

<br/><a href="#A">A</a>
  <a href="#B">B</a>
  <a href="#C">C</a>
  <a href="#D">D</a>
  <a href="#E">E</a>
  <a href="#F">F</a>
  <a href="#G">G</a>
  <a href="#H">H</a>
  <a href="#I">I</a>
  <a href="#J">J</a>
  <a href="#K">K</a>
  <a href="#L">L</a>
  <a href="#M">M</a>
  <a href="#N">N</a>
  <a href="#O">O</a>
  <a href="#P">P</a>
  <a href="#Q">Q</a>
  <a href="#R">R</a>
  <a href="#S">S</a>
  <a href="#T">T</a>
  <a href="#U">U</a>
  <a href="#V">V</a>
  <a href="#W">W</a>
  <a href="#X">X</a>
  <a href="#Y">Y</a>
  <a href="#Z">Z</a>

<!-- Placeholder for the keyword index - this variable is REQUIRED! -->
<script type="text/javascript">

  function hmInitHideLinks(cssCode) {
  	var styleElement = document.createElement("style");
  	styleElement.type = "text/css";
  	if (styleElement.styleSheet) {
    	styleElement.styleSheet.cssText = cssCode;
  	}
  	else {
    	styleElement.appendChild(document.createTextNode(cssCode));
  	}
  	document.getElementsByTagName("head")[0].appendChild(styleElement);
  }

  hmInitHideLinks("#idx div { display: none }");

  var currentdiv = null;
  var canhidelinks = true;

  function hmshowLinks(divID) {
    var thisdiv = document.getElementById(divID);
    canhidelinks = true;
    hmhideLinks();
    if (thisdiv) {
      currentdiv = thisdiv;
      $(currentdiv).show();
      $(currentdiv).mouseover(hmdivMouseOver).mouseout(hmdivMouseOut);
      $(document).mouseup(hmhideLinks);
    }
  }
  function hmdivMouseOver() { canhidelinks = false; };
  function hmdivMouseOut() { canhidelinks = true; };
  function hmhideLinks() {
    if (canhidelinks) {
      if (currentdiv) {
        $(currentdiv).hide();
        $(currentdiv).unbind("onmouseover", "onmouseout");
      }
      currentdiv = null;
      $(document).unbind("onmouseup");
    }
  }
</script>
<div id="idx" style="margin:0;padding:0;border:none">
</div>

<script type="text/javascript">
document.getElementById("navsearch").style.display="inline";
</script> 
</body>
</html>








