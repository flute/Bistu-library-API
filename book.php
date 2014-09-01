<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Bistu图书检索</title>
		<meta name="viewport" content="width=device-width,height=device-height,inital-scale=1.0,maximum-scale=1.0,user-scalable=no;">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
        	<link href="../public/css/cet.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="../public/js/jquery.min.js"></script>
		<script type="text/javascript" src="../public/js/main.js"></script>
	</head>

	<body id="wrap" style="">
		<style>
			.deploy_ctype_tip{z-index:1001;width:100%;text-align:center;position:fixed;top:70%;left:0;}.deploy_ctype_tip p{display:inline-block;padding:13px 24px;border:solid #d6d482 1px;background:#f5f4c5;font-size:16px;color:#8f772f;line-height:18px;border-radius:3px;}
		</style>
		<div class="banner">
			<div class="clr"></div>
		</div>
		<div class="cardexplain">
            <form method="post" action="./book_result.php" id="form" onSubmit="return tgSubmit()">
				<ul class="round">
					<li class="title mb"><span class="none">Bistu图书检索入口</span></li>
					<li class="nob">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
							<tbody>
                                <tr>
                                    <th>检索词类型</th>
                                    <td>
                                        <select name="type" id="type" class="dropdown-select">
                                            <option value='title' selected="selected">所有题名</option>
                                            <option value='author'>著/作者</option>
                                            <option value='number'>标准号(ISBN或ISSN)</option>
                                            <option value='subject_term'>主题词</option>
                                            <option value='publish_year'>出版年</option>
                                            <option value='publisher'>出版社</option>
                                            <option value='call_no'>分类号</option>
                                            <option value='title_pinyi'>题名缩拼</option>
                                            <option value='book_barcode'>图书条码</option>                                           
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
						</table>
					</li>
					<li class="nob">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
							<tbody>
								<tr>
									<th>检索词</th>
									<td><input type="text" class="px" placeholder="请输入检索词" id="word" name="word" value="">
									</td>
								</tr>
							</tbody>
						</table>
					</li>
                    <li class="nob">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
							<tbody>
                                <tr>
                                    <th>匹配方式</th>
                                    <td>
                                        <select name="match" id="match" class="dropdown-select">
                                            <option value='qx' selected="selected">前向匹配</option>
                                            <option value='mh'>模糊匹配</option>
                                            <option value='jq'>精确匹配</option>                                         
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
						</table>
					</li>
                    <li class="nob">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
							<tbody>
                                <tr>
                                    <th>资料类型</th>
                                    <td>
                                        <select name="recordtype" id="recordtype" class="dropdown-select">
                                            <option value='all' selected="selected">全部</option>
                                            <option value='01'>中文图书</option>
                                            <option value='02'>西文图书</option>
                                            <option value='03'>日文图书</option>
                                            <option value='04'>俄文图书</option>
                                            <option value='11'>中文期刊</option>
                                            <option value='12'>西文期刊</option>
                                            <option value='13'>日文期刊</option>
                                            <option value='14'>俄文期刊</option>
                                            <option value='21'>中文可视资料</option>
                                            <option value='22'>西文可视资料</option>
                                            <option value='23'>日文可视资料</option>
                                            <option value='24'>俄文可视资料</option>
                                            <option value='31'>中文古籍</option>
                                            <option value='33'>日文古籍</option>
                                            <option value='41'>中文地图</option>
                                            <option value='42'>西文地图</option>
                                            <option value='43'>日文地图</option>
                                            <option value='44'>俄文地图</option>
                                            <option value='61'>中文电子资源</option>
                                            <option value='62'>西文电子资源</option>
                                            <option value='63'>日文电子资源</option>
                                            <option value='64'>俄文电子资源</option>                                         
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
						</table>
					</li>
                    <li class="nob">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="kuang">
							<tbody>
                                <tr>
                                    <th>分馆名称</th>
                                    <td>
                                        <select name="library_id" id="library_id" class="dropdown-select">
                                            <option value='all' selected="selected">所有分馆</option>
                                            <option value='A'>A:健翔桥校区</option>
                                            <option value='B'>B:清河校区</option>
                                            <option value='C'>C:小营校区</option>                                          
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
						</table>
					</li>
				</ul>
				<div class="footReturn" style="text-align:center">
					<input type="submit" style="margin:0 auto 20px auto;width:90%" class="submit" value="提交查询">
				</div>
			</form>
			<script>				
				function tgSubmit(){                    
                    var s_word=$("#word").val();
                    var s_match=$("#match").val();
                    var len =s_word.length;
                    if(s_word=="%")
                    {
                        showTip("不支持 % 检索！请输入检索词！");
                        return false;
                    }
                	if(s_word=="")
                    {
                        showTip("请输入检索词！");
                        return false;
                    }
                    if((len<2)&&(s_match!="jq"))
                    {
                        showTip("检索词过短，请输入长检索词或精确匹配！")
                        return false;
                    }
                    if(s_word=="%")
                    {
                        showTip("不支持 % 检索！请输入检索词！");
                        return false;
                    }
                    
                    for(i=0;i<len;i++)
                    {
                        
                        s_word=s_word.replace('/\s+$|^\s+/',"");
                        s_word=s_word.replace("%","");
                        
                    }
                    
					return true;                            
                }
                function showTip(tipTxt) {
					var div = document.createElement('div');
					div.innerHTML = '<div class="deploy_ctype_tip"><p>' + tipTxt + '</p></div>';
					var tipNode = div.firstChild;
					$("#wrap").after(tipNode);
					setTimeout(function () {
						$(tipNode).remove();
					}, 1500);
				}
			</script>
		</div>
        <script type="text/javascript">
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideToolbar');
            });
            document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
                WeixinJSBridge.call('hideOptionMenu');
            });
        </script>
        <div style="display:none">
        	<script type="text/javascript">
            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F5651cb21bdb04d3467ffd48f07e5b395' type='text/javascript'%3E%3C/script%3E"));
        	</script>
        </div>       
        <footer style="text-align:center; color:#ffd800;margin-right:20px;margin-top:0px;margin-bottom:20px;font-size:13px;">©2014 By<a href="http://weibo.com/ifluter"> ludis</a></footer>
	</body>
</html>
