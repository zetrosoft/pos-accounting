/*!
Premium Pack iPad Skin Version 2.02 script functions
For Help & Manual 6 only 
Copyright (c) 2008-2011 by Tim Green. 
All rights reserved.
*/
var hmTouch={myScroll:{},navOfs:parent.window.hmMobile.navOfs,scrW:parent.window.hmMobile.scrW,scrH:parent.window.hmMobile.scrH,ctDoc:parent.document.getElementById("hmcontent").contentWindow,wHorizontal:function(){return(Math.abs(parent.window.orientation)-90===0)?true:false},resizeWin:function(a){var b=hmTouch.wHorizontal()?hmTouch.scrW-hmTouch.navOfs:hmTouch.scrH-hmTouch.navOfs;var c=$("#hmnavbox",parent.document).width();$("div#pageScroller, div#pageContent").css("width",(c-2)+"px");$("div#pageScroller").css("padding-bottom","6px");$("div#pageContent").css("height",(b+5)+"px");if(a&&parent.hmMobile.idxLoaded){setTimeout(function(){hmTouch.myScroll.refresh()},0)}},fixLinks:function(){$("a").bind("touchstart",function(){$("#current").attr("id","");$(this).attr("id","current");setTimeout(function(){hmTouch.myScroll.refresh()},300)}).not("[href^='javascript']").click(function(b){b.preventDefault();var c=$(this).attr("href");var a=c.indexOf("#");if(a>-1){parent.window.hmMobile.anchorTarget=c.substr(a);c=c.substr(0,a)}if(parent.hmMobile.isIOS5){hmTouch.ctDoc.location.assign(c)}else{hmTouch.ctDoc.location.replace(c)}}).filter(function(a){return $(this).parent("td").length<1}).bind("touchend",function(){setTimeout(function(){hmhideLinks();hmTouch.myScroll.refresh()},300)})},init:function(){$(document).bind("touchmove",function(a){a.preventDefault()});hmTouch.fixLinks();hmTouch.resizeWin(false);hmTouch.myScroll=new iScroll("pageContent",{zoom:false,fadeScrollbar:false})}};$(document).ready(function(){hmTouch.init();parent.window.hmMobile.oUnbind(parent.window.hmMobile.loaded);parent.window.hmMobile.idxLoaded=true;parent.window.hmMobile.idxDoc=parent.document.getElementById("hmindex").contentWindow;parent.window.hmMobile.oBind(parent.window.hmMobile.loaded);$("div#loader").fadeOut("slow")});