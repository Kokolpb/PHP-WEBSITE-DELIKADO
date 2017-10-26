<?php 
require_once("inc/config_admin.php");
//phpinfo()信息列举
switch ($_GET['action']){
	case "phpinfo_GENERAL":
		phpinfo(INFO_GENERAL+INFO_ENVIRONMENT+INFO_VARIABLES);
		exit;
	case "phpinfo_CONFIGURATION":
		phpinfo(INFO_CONFIGURATION);
		exit;
	case "phpinfo_MODULES":
		phpinfo(INFO_MODULES);
		exit;
	case "phpinfo":
		phpinfo();
		exit;
	default:
		break;
}


//获取php.ini配置参数
function getvar($varname)
{
	switch($var=get_cfg_var($varname)?get_cfg_var($varname):ini_get($varname))
	{
		case 0:
		return off;
		break;
		case 1:
		return on;
		break;
		default:
		return $var;
		break;
	}
}

//获取Zend Optimizer版本,方法参考了废墟のPHP探针
function checkoptimizer()
{
	$url= "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=phpinfo";
	$htmlct=file_get_contents($url);
	//echo $htmlct;
	eregi("Optimizer&nbsp;v(.*),&nbsp;Copyright", $htmlct, $regs);
	$optimizerversion=$regs[1];
	$optimizerversion=(''!=$optimizerversion)?$optimizerversion:"<font color=red>获取失败！</font>";
	return $optimizerversion;
}

require_once("inc/config_perm.php");
require_once("inc/function.class.php");
$action=$_SERVER["QUERY_STRING"];




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $companytitle;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="inc/style_admin.css" rel="stylesheet" type="text/css">
<script src="inc/js/jquery.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>
<body>
<?php require "header.php"; ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="87.9%">
  <tr> 
    <td width="15%" align="left" valign="top" bgcolor="#E7F1F8">
	<?php require "leftmenu.php"; ?>
      </td>
    <td width="75%" align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="55" align="right" valign="top" background="inc/pics/bg001.gif" class="txt">&nbsp;<span class="txt_3">欢迎您登陆智能手机管理平台</span></td>
      </tr>
    </table>
      <table width="97%" border="0" align="center" cellpadding="3" cellspacing="3">
        <tr>
          <td colspan="2" align="left" class="txt_lanmu2">Mobi 2013 智能手机管理中心</td>
        </tr>
        <tr bgcolor="#F0F7FD">
          <td  colspan="2" align="left" class="txt_lanmu3">最新公告通知</td>
        </tr>
        <tr>
          <td height="31" colspan="2" align="left" class="txt">
          本公司联合多家移动设备厂商以及软件企业共同发起的的针对触屏智能手机与平板电脑的website以及在线应用的开发<br>
          目前支持的移动平台有苹果公司的iOS（iPhone，ipad，iPod Touch），Android安卓，Black Berry OS6.0，惠普 WebOS，Mozilla的Fennec和Opera Mobile等主流手机操作系统。

          </td>
        </tr>
    </table>
      <table width="97%" border="0" align="center" cellpadding="3" cellspacing="3">
        
        <tr>
          <td width="3%" align="left" class="txt">&nbsp;</td>
          <td width="29%" align="left" class="txt">&nbsp;</td>
          <td width="68%" align="left" class="txt">&nbsp;</td>
        </tr>
      </table>
      <table width="97%" border="0" align="center" cellpadding="3" cellspacing="3">
        <tr bgcolor="#F0F7FD">
          <td align="left" class="txt_lanmu3">系统信息</td>
        </tr>
        <tr>
          <td align="left" class="txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
            <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >程序版本</td>
              <td width="88%" align="left">Website Management 2011</td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
             <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >服务器类型/版本</td>
              <td width="88%" align="left"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
           <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >服务器操作系统</td>
              <td width="88%" align="left"> <?php echo PHP_OS."&nbsp;(".php_uname().")"; ?> </td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
            <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >服务器 MySQL 版本</td>
              <td width="88%" align="left"> <? $res=mysql_query("select VERSION()");$row=mysql_fetch_row($res);echo $row[0];?> </td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
             <tr  class="txt_leftmenu">
               <td height="28" align="left" >Zend Optimizer版本</td>
               <td align="left">至少需要Zend Optimizer 3.3.0</td>
             </tr>
             <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >post最大数据量</td>
              <td width="88%" align="left"><?php echo getvar("post_max_size"); ?></td>
            </tr>
             <tr  class="txt_leftmenu">
               <td height="28" align="left" >上传文件的最大量</td>
               <td align="left"><?php echo getvar("upload_max_filesize"); ?></td>
             </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>

          </table></td>
        </tr>
      </table>
      <table width="97%" border="0" align="center" cellpadding="3" cellspacing="3">
        <tr bgcolor="#F0F7FD">
          <td align="left" class="txt_lanmu3">&nbsp;</td>
        </tr>
        <tr bgcolor="#F0F7FD">
          <td align="left" class="txt_lanmu3">开发团队</td>
        </tr>
        <tr>
          <td align="left" class="txt"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
             <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >总策划兼项目经理</td>
              <td width="88%" align="left">张荣(Alex zhang) 吕品滨(Koko lv) </td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
           <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" valign="top" >开发与支持团队</td>
              <td width="88%" align="left"> Alex zhang, Koko lv, Conner wang ,Sunny chen ,Echo yang ,Rainbow li</td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
             <tr  class="txt_leftmenu">
              <td width="12%" height="28" align="left" >界面设计制作</td>
              <td width="88%" align="left"> Lydia cai  Stone Zhao</td>
            </tr>
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>
            
            <tr bgcolor="#F0F7FD"  class="txt_leftmenu">
              <td  colspan="2" align="left" background="inc/pics/bg002.gif"  style="padding:0; height:1px;"></td>
            </tr>


          </table></td>
        </tr>
      </table></td>
  </tr>
</table>


<?php require "footer.php"; ?>
</body>
</html>

