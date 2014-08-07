<?php
$type = $_POST['type'];
$word = iconv( 'UTF-8', 'GB2312',$_POST['word']);
$word = str_replace(' ','',$word);
$word = str_replace('%','',$word);
$cmmatch = $_POST['match'];
$recordtype = $_POST['recordtype'];
$library_id = $_POST['library_id'];

$ludis = new Book;
$text = $ludis -> search_book($type,$word,$cmmatch,$recordtype,$library_id);
$text = iconv('GB2312', 'UTF-8', $text);

//提交搜索词，抓取网页信息，正则出所需内容
class Book{
	function search_book($type,$word,$cmmatch,$recordtype,$library_id){
		//传入参数，"size"为返回结果条数
		$url = 'http://211.68.37.131/book/search.jsp?recordtype='.$recordtype.'&library_id='.$library_id.'&kind=simple&word='.$word.'&cmatch='.$cmmatch.'&searchtimes=1&type='.$type.'&size=30';
		$text = file_get_contents($url);
        preg_match_all('/<table Width=97% border=0 cellpadding=2 cellspacing=1>(.*?)<\/table>/is',$text,$book);
        $book = str_replace('bgcolor=#EBF0F2','',$book[1][0]);
        preg_match_all('/<tr align=center valign="baseline" bgcolor="#6D849B">(.*?)<\/tr>/is',$book,$books);
        $book = str_replace($books[0][0],'',$book);
        $book = preg_replace('/<!--(.*?)-->/','',$book);
        $book = str_replace("javascript:popup('detailBook.jsp','","",$book);
        $book = str_replace("')","",$book);
		//匹配出图书详情链接，传递给book_info页面
        $book = str_replace('<td><a href="','<span><a href="./books.php?id=',$book);
        $book = str_replace('</a></td>','</a></span></p>',$book);
        $book = str_replace('<td align=center>','<p style="float:left;height:100px"><span>',$book);
        $book = str_replace('<td>','<p style="margin-left:40px">',$book);
        $book = str_replace('</td>','</p>',$book);
        $book = str_replace('<tr>','',$book);
        $book = str_replace('</tr>','<hr>',$book);
		//判断正则结果，返回结果
        if ($book == ""){
            $error = "<a href='./book.php'><img src='./public/img/sorry.gif'></a><p style='text-align:center'>(点击返回查询页面)</p>";
            $book = "<p>对不起~图书馆暂时没有相关书籍，您可以输入其他搜索词尝试O(∩_∩)O~</p>".$error;
			//转码
            $book = iconv( 'UTF-8', 'GB2312',$book);
        }
        return $book;

	}

}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bistu图书检索结果</title>
		<meta name="author" content="ludis">
		<meta name="reply-to" content="552452006@qq.com">
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link href="./public/css/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="./public/js/jquery.min.js"></script>
		<script type="text/javascript" src="./public/js/main.js"></script>
        
	</head>
	<body id="wrap" style="">
		<div class="cardexplain">
            <ul class="round">
                <li>
					<h2>查询结果(点击图书名称查看详细情况)</h2>
					<div class="text">
						<font size="3">
						<table>
						<?php                         	
							echo $text;                      
						?>
						</table>
					</div>
                </li>
            </ul>
		</div>
        <script type="text/javascript">
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
            });
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideOptionMenu');
            });
        </script>
        <footer style="text-align:center; color:#ffd800;margin-right:20px;margin-top:0px;margin-bottom:20px;"><a href="./book.php">Bistu图书查询</a></footer>
	</body>
</html>