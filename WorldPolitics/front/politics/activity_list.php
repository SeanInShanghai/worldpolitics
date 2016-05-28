<?php
include 'function/getSalons.php';
include 'function/action.php';
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
			<link rel="stylesheet" type="text/css" media="screen" href="./css/latest-artical.css">	
</head>
<body data-mobile-url="/zh/mobile">
<?php 
include 'header.html';
?>
	<div id="container" class="clearfix">
		<div class="column-head" style="margin-top:100px;">
		    <input style="display: none" id="timeValue" value="<?php echo $timeValue;?>"/>
			<a href="./activity_list.php?timetype=0"><b id="start">沙龙活动</b></a>
			<span style="font-size:13px;color:#b9b9b9;">｜</span>
			<a href="./activity_list.php?timetype=1"><b id="end" style="color:#b9b9b9;">已结束活动 »</b></a>
		</div>
		
		<script type="text/javascript">
		var time = document.getElementById("timeValue").value;
		if(time == 1){
			document.getElementById("start").style.color="#b9b9b9";
			document.getElementById("end").style.color="#000000";
		}else{
			document.getElementById("start").style.color="#000000";
			document.getElementById("end").style.color="#b9b9b9";
		}
		</script>
		
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
		
	
	
	<!--#container-->
	<div class="clear"></div>
	<!-- pagination -->
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
					<a id="page<?php echo $i;?>" class="page-numbers" href="./activity_list.php?<?php echo $href?>&&timetype=<?php echo $timeValue; ?>"><?php echo $i?></a>
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
					<a class="next page-numbers" href="./activity_list.php?<?php echo $href?>"></a>
					<?php 
				}
			?>
	</div>
	</div>
	<!-- #pagination -->
	
			<div id="bottomline"></div>
		<?php 
		include 'footer.html';
		?>
</body>
</html>
