<?php
include 'function/getSalons.php';
include 'function/action.php';
?>
<?php 
// $count = 6;
// $totalCount = count($allSalons);
// $pagesize = 0;
// if($totalCount % $count == 0)
// {
// 	$pagesize = $totalCount/$count;
// }else{
// 	$pagesize = $totalCount/$count + 1;
// }
// $page = 1;
// $page = $_GET['page'];
// if(empty($page))
// {
// 	$page = 1;
// }
?>
<?php 
// $pageInfo = array($page,$count);

// $salons = getSalons($pageInfo);
// getSalons($pageInfo);
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
		<link rel="stylesheet" type="text/css" media="screen" href="./css/activity.css">	
</head>
<body data-mobile-url="/zh/mobile">
<?php 
include 'header.html';
?>
	<div id="container" class="clearfix">
		<div class="column-head" style="margin-top:100px;">
			<b>沙龙活动</b>
			<span style="font-size:13px;color:#b9b9b9;">｜</span>
			<a href="#"><span style="font-size:13px;color:#b9b9b9;">已结束活动 »</span></a>
		</div>
		
		<?php 
		foreach ($salons as $salon)
		{
			include 'function/getSalonInfo.php';
// 			echo $salon['log_ID'];
// 			echo "My id:". $salonInfo['log_ID'];
			?>
		<div class="activity-brief">
			<img class="activity-img" src="<?php echo substr($mysalon['titleImage'],18);?>">
				<div class="activity-text">
					<p class="activity-head">
						<a href="./activity.php?<?php echo "id=".$salon['log_ID'];?>"><?php echo $salon['log_Title'];?></a>
					</p>
					<p class="activity-time">
						<span style="font-size:13px;color:#b9b9b9;"><?php echo date('Y年m月d日 H:i ',$salon['log_PostTime']); ?></span>
					</p>
					<p class="activity-abstract"><?php echo $salon['abstract'];?></p>
				</div>
		</div>
			
			<?php 
		}
		?>
		
	
	</div>
	<!--#container-->
	
	<!-- pagination -->
	<div class="pagination">
	<?php
			
			for($i = 1; $i <= $pagesize; $i++)
			{
				?>
				<a class="page-numbers" href="./artical_list.php?<?php echo "page=".$i;?>"><?php echo $i;?></a>
				<?php 
			}
	?>
	</div>
	<!-- #pagination -->
	
			<div id="bottomline"></div>
		<?php 
		include 'footer.html';
		?>
</body>
</html>
