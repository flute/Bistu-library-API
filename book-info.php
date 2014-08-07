<?php
header("Content-type: text/html; charset=utf-8");
$id=$_GET['id'];
$ludis = new Info();
$book = $ludis -> book_info($id);
//除杂，返回索书号，藏馆，在架情况三个信息
class Info{
    function book_info($id){
    	$text=file_get_contents('http://211.68.37.131/book/detailBook.jsp?rec_ctrl_id='.$id);
        $text = iconv('GB2312', 'UTF-8', $text);
        preg_match_all('/<table border=0 cellPadding=2 cellSpacing=1 width="97%">(.*?)<\/table>/is',$text,$book);
        $book = preg_replace('/<td><font (.*?)>\d{6}<\/font><\/td>/','',$book[0][1]);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>(\d){6}<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>[0-9]*\/[0-9]*\/[0-9]*<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>[a-z]*[A-Z]*[0-9]*<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>(\d){0}<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>(\d){9}<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td align=center><font style="color:(.*?)"[\W]*>(\d){1}<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td align=center><font >(\d){1}<\/font><\/td>/','',$book);
        $book = preg_replace('/<td><font >(\d){9}<\/font><\/td>/','',$book);
        $book = preg_replace('/<td><font >(\d){0}<\/font><\/td>/','',$book);
        $book = preg_replace('/<td><font >[a-z]*[A-Z]*[0-9]*<\/font><\/td>/','',$book);
        $book = preg_replace('/<td>&nbsp;[\W]*<\/td>/','',$book);
        $book = preg_replace('/<td>&nbsp;[\W]*<a (.*?)[\W]*<\/td>/','',$book);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>(\d){1}<[^d]*<\/td>/','',$book);
        $book = preg_replace('/<td><font >(\d){1}<\/font><\/td>/','',$book);
        $book = preg_replace('/<tr align=center[\W]*>[\W]*<\/tr>/','',$book);
        $book = str_replace('<td><font >无</font></td>','',$book);
        $book = preg_replace('/<td><font style="color:(.*?)"[\W]*>无<\/font><\/td>/','',$book);
        $book = preg_replace('/<td width="5%" class="opac_white" noWrap>(.*?)<\/td>/','',$book);
        $book = preg_replace('/<td width="10%" class="opac_white" noWrap>(.*?)<\/td>/','',$book);
        $book = preg_replace('/<td width="15%" class="opac_white" noWrap>(.*?)<\/td>/','',$book);
        $book = preg_replace('/<tr align=center valign="baseline" bgcolor="#6D849B">[\W]*<\/tr>/','',$book);
        $book = str_replace('<tr><td height="1" background="../images/doc_01.gif"></td></tr>','',$book);
        $book = str_replace('<tr><td bgcolor="#EBF0F2" class="opac_blue" height="18" align="center">:: 关联记录 ::</td></tr>','',$book);
        $book = preg_replace('/<table border=0 cellPadding=0 cellSpacing=0 width="97%">[\W]*<\/table>/','',$book);
        $book = str_replace('<table border=0 cellPadding=2 cellSpacing=1 width="97%">','',$book);  
        return $book;
    }

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bistu图书检索</title>
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
        <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
        <style type="text/css">
        	.ui-body-c, .ui-overlay-c {
                color: #333;
                font-weight:800;
                text-shadow: unset;
            }
        
        </style>
	</head>
	<body id="wrap" style="">
		<div data-role="page" id="newsdetail" data-title="Bistu News"  data-theme="c">
            <div data-role="header" data-position="fixed">
            <a data-rel="back">返回</a><h1>借阅信息</h1>
            </div><!-- /header -->
            <div data-role="content">		
            	<table>
                    <tr align=center valign="baseline" bgcolor="#6D849B">    				
                        <td width="10%" class="opac_white" noWrap>索书号</td>
                        <td width="15%" class="opac_white" noWrap>藏书部门</td>	
                        <td width="10%" class="opac_white" noWrap>流通状态</td>
                    </tr>
                    <?php echo $book;?>
                </table>
            </div><!-- /content -->
        </div>
        <script type="text/javascript">
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
            });
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideOptionMenu');
            });
        </script>
        <footer style="text-align:center; color:#ffd800;margin-right:20px;margin-top:0px;margin-bottom:20px;"><a href="./book.php"></a></footer>
	</body>
</html>