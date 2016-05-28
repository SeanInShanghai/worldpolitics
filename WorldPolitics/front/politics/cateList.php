<?php
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="zh" class="zh" slick-uniqueid="3">
<head meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="description" content="Global Political Research Center">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" charset="UTF-8"/>
	<title>世界政治研究中心</title>
	<link rel="icon" href="./favicon.ico" type="/x-icon"/>
	<link rel="stylesheet" type="text/css" media="screen" href="./css/basic.css">
	<link rel="stylesheet" type="text/css" media="screen" href="./css/column2.css">	
		<link rel="stylesheet" type="text/css" media="screen" href="./css/latest-artical.css">	
</head>
<body data-mobile-url="/zh/mobile">
	<header>
		<div id="topline"></div>
		<div id="bar"></div>
		<div id="headcontent">
			<div id="logo"></div>
			<nav>
				<ul>
					<li>
						<a href="./home.php">首页</a>
					</li>
					<li>
						<a href="./intro.html">中心介绍</a>
					</li>
					<li>
						<a href="./artical_list.php">文章</a>
					</li>
					<li>
						<a href="./activity_list.html">沙龙</a>
					</li>
				</ul>
			</nav>
		</div>
		<!--headcontent-->
	</header>
	<div id="container" class="clearfix">
	    <div><?php echo $showTag;?></div>
		<div id="column1">
			<div class="column-head" style="margin-top:15px;">
			    <input style="display: none" id="type" value="<?php echo $type;?>">
				<a href="./showPaperList.php?&type=0&action=<?php echo $action;if($action == 'cate'){ echo "&cate_ID=".$cateID;}?>"><b id="newest">最新文章</b></a>
				<span style="font-size:13px;color:#b9b9b9;">｜</span>
				<a href="./showPaperList.php?&type=1&action=<?php echo $action;if($action == 'cate'){ echo "&cate_ID=".$cateID;}?>"><b id="hottest">最热文章</b></a>
			</div>
			<!--column-head-->
			<script type="text/javascript">
			var type = document.getElementById("type").value;
			if(0 == type){
				document.getElementById("hottest").style.color="#b9b9b9";
				document.getElementById("newest").style.color="#000000";
			}else{
				document.getElementById("newest").style.color="#b9b9b9";
				document.getElementById("hottest").style.color="#000000";
			}
			</script>

			<!-- paper list -->

			
		
		
<?php 
//echo "The number of articles:".count($articles);
foreach ($articles as $article)
{
// 	echo var_dump($article);
	$artID = $article->ID;
	$searhAbstract = "SELECT * FROM zbp_addtopost WHERE log_ID = '$artID'";
	$reSearchAbstract = $zbp->db->Query($searhAbstract);
	$abstract = $reSearchAbstract[0]['abstract'];
	$titleImg = $reSearchAbstract[0]['titleImage'];
	$titleImg = substr($titleImg, 18);
?>
<div class="artical-latest">
	<img class="latest-img" src="<?php echo $titleImg;?>">
	<div class="lastest-text">
		<p class="latest-head">
			<!--artial-latest-->
		<?php 
		$pos1 = stripos($article->Url,'?');
		$url = substr($article->Url,$pos1+1);
		?>
			<a href="./artical.php?<?php echo $url; ?>"><?php echo $article->Title;?></a>
		</p>
		<p class="latest-head">
			<a href="./teacher.php"><?php echo $article->Author->StaticName;?></a>
			<span style="font-size:13px;color:#b9b9b9;"> | <?php  echo $article->Time('Y年m月d日');?></span>
		</p>
		<p class="latest-abstract"><?php echo $abstract;?></p>
	</div>
	<div class="clear"></div>
</div>

	<?php 
}

?>

			<!--artial-latest-->
			 
			
			<div class="clear"></div>
			<div class="pagination">
				
	<?php 
// 			if($pagesize/5 == 0)
// 			{
// 				$allPageRange  = $pagesize / 5;
// 			}else{
//                 $allPageRange = (int)($pagesize/5) +1;
// 			}
			if($pageRange > 1 )
			{
// 				$href = "tag_ID=".$tag_ID."&&action=moduleArts";
				$href = $href."pageRange=".($pageRange-1);
			?>
			<a class="prev page-numbers" href="./artical_list.php?<?php echo $href;?>"></a>
			<?php 
			}
				$startPage = ($pageRange -1)*5 +1;
				$endPage = $startPage + 4;
				$previousPages = ($pageRange -1)*5;
				if(($pagesize - $previousPages) < 5)
				{
					$endPage = $pagesize;
				}
				
				for($i = $startPage; $i<= $endPage; $i++)
				{
// 					$href = "tag_ID=".$tag_ID."&&action=moduleArts";
					$href = "page=".$i."&&pageRange=".$pageRange;
										
					?>
					<a id="page<?php echo $i;?>" class="page-numbers" href="./artical_list.php?<?php echo $href?>"><?php echo $i?></a>
					<?php
					$href = '';
				}
				
				$temp = $pageRange*5;
				if($temp >= $pagesize)
				{
				
				}else{
//                     $href = "tag_ID=".$tag_ID."&&action=moduleArts";
                    $href = $href."&&pageRange=".($pageRange+1);
					?>
					<a class="next page-numbers" href="./artical_list.php?<?php echo $href?>"></a>
					<?php 
				}
			?>
			</div>
			<!--pagination-->
		</div>
		<!--#column1-->

	</div>
	<!--#container-->
			<div id="bottomline"></div>
	<footer>
		<div id="footercontent">
			<div id="bottomlogo">
				<img width="300px;"height="70px;" src="./images/politic_logo.png" alt="教师1">
			</div>
			<div id="link">
				<p style="color:#b9b9b9;margin-bottom:10px;">友情链接</p>
				<div style="width:80px;float:left;">
				<a href="#">链接1</a><br>
				<a href="#">链接2</a><br>
				</div>
				<div style="width:150px;float:left;">
				<a href="#">链接4</a><br>
				<a href="#">链接5</a><br>
				</div>

			</div>
		</div>
	</footer>
</body>
</html>

	</footer>