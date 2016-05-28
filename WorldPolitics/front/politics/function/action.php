<?php 
include 'myprefix.php';
include "function.php";

$url = $_SERVER['REQUEST_URI'];
// echo $url;

if($url)
{
	$urlArr = explode('/',$url);
	if($urlArr[count($urlArr)-1] == "")
	{
		$action = "home";
	}else{
		$action = getActionFromUrl($url);
	}
}

if(isset($_GET['action']))
{
	$action = $_GET['action'];
}

switch ($action)
{
	case "home":
		$count = 4;
		$page = 1;
		$page = $_GET['page'];
		if(empty($page))
		{
			$page = 1;
		}
		$pageInfo = array($page,$count);
		$articles = ViewList($pageInfo, null, null, null, null);
		
		/*
		 * 右侧显示信息
		 */
		
		//热门文章
		$popArt = "SELECT * FROM zbp_post order by log_ViewNums desc LIMIT 6";
		$rePopArt = $zbp->db->Query($popArt);
		
		//热门标签
		$tagSQL = "SELECT * FROM zbp_category LIMIT 6";
		$tags = $zbp->db->Query($tagSQL);
	
		//热门教师
		$sql = "SELECT * FROM zbp_member WHERE mem_Level = 3 LIMIT 6";
		$members = $zbp->db->Query($sql);
		
		foreach($members as $member){
			$memID = $member['mem_ID'];
			$addTeaSQL = "SELECT * FROM zbp_memaddition WHERE mem_ID = $memID";
			$reAddTeaSQL = $zbp->db->Query($addTeaSQL);
			$member['mem_headPortrait'] = $reAddTeaSQL[0]['mem_headPortrait'];
		}
		
		
		
		break;
		
	case 'teacher_list':
// 				echo "OK";
		$sqlAllTeachs = "SELECT * FROM zbp_member WHERE mem_Level = 3 order by mem_ID";
		$reAllTeachs = $zbp->db->Query($sqlAllTeachs);
		$countNum = 0;
		foreach($reAllTeachs as $reAllTeach ){
			$memID = $reAllTeach['mem_ID'];
			$addTeaSQL = "SELECT * FROM zbp_memaddition WHERE mem_ID = $memID";
			$reAddTeaSQL = $zbp->db->Query($addTeaSQL);
			$reAllTeachs[$countNum]['mem_headPortrait'] = $reAddTeaSQL[0]['mem_headPortrait'];
			$countNum += 1;
		}
		
		$sqlLCArts = "SELECT * FROM zbp_post";
		$reLCArts = $zbp->db->Query($sqlLCArts);
// 		echo count($reLCArts);
// 		echo "OK";
		break;
	case 'artical_list':
//         echo "asdas";
        $type = 0;//0表示最新，1表示最热
        if(empty($_GET['type'])){
        	$type = 0;
        }else{
        	$type = $_GET['type'];
        }
        
        if(0 == $type){
        	$sqlALLCArts = "SELECT * FROM zbp_post WHERE log_Type = 0 order by log_PostTime desc";
        }else{
        	$sqlALLCArts = "SELECT * FROM zbp_post WHERE log_Type = 0 order by log_ViewNums desc";
        }
		
		$reALLCArts = $zbp->db->Query($sqlALLCArts);
	
		$count = 3; //每页显示3篇论丛文章
		$totalCount = count($reALLCArts);//论丛文章全部数量
		$pagesize = 0; //一共需要展示的页数
		
		if($totalCount % $count == 0)
		{
			$pagesize = $totalCount/$count;
		}else{
			$pagesize = (int)($totalCount/$count) + 1;
		}
		
		$page = 1; //当前页码，默认为1
		
		
		 
		$pageRange = 1; //页码段，没五页为一个页码段，默认为1
		 
		if(empty($_GET['pageRange']))
		{
			$pageRange = 1;
		}else{
			$pageRange = $_GET['pageRange'];
			
			//判断pageRange是否存在sql注入危险
			$is_number = ctype_digit($pageRange);
			if($is_number != 1)
				$pageRange = 1;
			$page = ($pageRange-1) * 5 + 1;
		}
		
		
		
		if(!empty($_GET['page']))
		{
			$page = $_GET['page'];
			//判断page是否存在sql注入危险
			$is_number = ctype_digit($page);
			if($is_number != 1)
				$page = 1;
		}
		
// 		echo $page;
		
		$offset = ($page - 1) * $count;
		
        if(0 == $type){
        	$sqlLCArts = "SELECT * FROM zbp_post WHERE log_Type = 0 order by log_PostTime desc LIMIT $count OFFSET $offset";
        }else{
        	$sqlLCArts = "SELECT * FROM zbp_post WHERE log_Type = 0 order by log_ViewNums desc LIMIT $count OFFSET $offset";
        }
// 		echo $sqlLCArts;
// 		$sqlLCArts = "SELECT * FROM zbp_post WHERE log_Type = 0 order by log_PostTime desc LIMIT $count OFFSET $offset";
		$reLCArts = $zbp->db->Query($sqlLCArts);

		$lccount = 0;
		foreach ($reLCArts as $reLCArt)
		{
			$log_ID = $reLCArt['log_ID'];

			$sqlPostAddition = "SELECT * FROM zbp_addtopost WHERE log_ID = '$log_ID'";
			$rePostAddition = $zbp->db->Query($sqlPostAddition);

			$imgArr = explode('/', $rePostAddition[0]['titleImage']);
			$reLCArts[$lccount]['log_abstract'] = $rePostAddition[0]['abstract'];
			$reLCArts[$lccount]['log_pic'] = $imgArr[3]."/".$imgArr[4];
			
			$lccount += 1;

		}
		
		$sql = "SELECT * FROM zbp_member WHERE mem_Level = 3 LIMIT 6";
		$members = $zbp->db->Query($sql);
		
		//热门标签
		$tagSQL = "SELECT * FROM zbp_category LIMIT 6";
		$tags = $zbp->db->Query($tagSQL);

		break;
	case 'activity_list':
		
		$times = array('starting','ended');
		$timeValue = 0;
		if(empty($_GET['timetype'])){
			$timeValue = 0;
		}else{
			$timeValue = $_GET['timetype'];
		}
// 		echo $timeValue;
		$time = $times[$timeValue];//0表示正还没有开始，1表示已经结束
		
// 		$allSearSalonsSQL = "SELECT * FROM zbp_post WHERE log_Type = 1 order by log_PostTime desc";
// 		$reSear = $zbp->db->Query($allSearSalonsSQL);
// 		echo count($reSear);
		
		$curTime = time();
		if(0 == $timeValue){
			$allSearSalonsSQL = "SELECT * FROM zbp_post WHERE log_Type = 1 and log_PostTime <= '$curTime' order by log_PostTime desc";
		}else{
			$allSearSalonsSQL = "SELECT * FROM zbp_post WHERE log_Type = 1 and log_PostTime > '$curTime' order by log_PostTime desc";
		}
// 		echo $allSearSalonsSQL;
		$reAllsalons = $zbp->db->Query($allSearSalonsSQL);
		
		$count = 6; //每页显示6个活动
		$totalCount = count($reAllsalons);//全部的沙龙的个数
// 		echo $totalCount;
		$pagesize = 0; //一共需要展示的页数
		
		if($totalCount % $count == 0)
		{
			$pagesize = $totalCount/$count;
		}else{
			$pagesize = (int)($totalCount/$count) + 1;
		}
// 		echo $totalCount." Totalcount";
// 		echo $pagesize." pagesize";
		$page = 1; //当前页码，默认为1
		$pageRange = 1; //页码段，没五页为一个页码段，默认为1
			
		if(empty($_GET['pageRange']))
		{
			$pageRange = 1;
		}else{
			$pageRange = $_GET['pageRange'];
				
			//判断pageRange是否存在sql注入危险
			$is_number = ctype_digit($pageRange);
			if($is_number != 1)
				$pageRange = 1;
			$page = ($pageRange-1) * 5 + 1;
		}
		
		
		
		if(!empty($_GET['page']))
		{
			$page = $_GET['page'];
			//判断page是否存在sql注入危险
			$is_number = ctype_digit($page);
			if($is_number != 1)
				$page = 1;
		}
		$offset = ($page - 1) * $count;
		
		if(0 == $timeValue){
			$allSalonsSQL = "SELECT * FROM zbp_post WHERE log_Type = 1 and log_PostTime <= '$curTime' order by log_PostTime desc LIMIT $count OFFSET $offset";
		}else{
			$allSalonsSQL = "SELECT * FROM zbp_post WHERE log_Type = 1 and log_PostTime >= '$curTime' order by log_PostTime desc LIMIT $count OFFSET $offset";
		}
		
		$salons = $zbp->db->Query($allSalonsSQL);
		break;
	case 'teacher':
// 		echo "ok";
		$teacherID = $_GET["id"];
		
		$teacherSQL = "SELECT * FROM zbp_member WHERE mem_ID = $teacherID";
// 		echo $teacherSQL;
		$teacher = $zbp->db->Query($teacherSQL);
		$teacher = $teacher[0];
		
		$addTeaSQL = "SELECT * FROM zbp_memaddition WHERE mem_ID = $teacherID";
		$reAddTeaSQL = $zbp->db->Query($addTeaSQL);
		$teacher['mem_headPortrait'] = $reAddTeaSQL[0]['mem_headPortrait'];
		
		$teacherPapers = "SELECT * FROM zbp_post WHERE log_AuthorID = $teacherID ORDER BY log_PostTime desc LIMIT 4";
		$reTeaPapers = $zbp->db->Query($teacherPapers);
// 		echo count($reteacherPapers);
// 		echo $teacherPapers;
// 		var_dump($teacher[0]);
		break;
	case 'artical':
		$id = $_GET['id'];
		$article = ViewPost($id, null, null, null, null);
		
		//获取教师信息
		$teacherSQL = "SELECT * FROM zbp_post,zbp_member WHERE zbp_post.log_ID = $id and zbp_post.log_AuthorID = zbp_member.mem_ID";
		$reTeaSQL = $zbp->db->Query($teacherSQL);
// 		var_dump($reTeaSQL);
// 		echo $teacherSQL;
		$teaInfo = $reTeaSQL[0];
// 		var_dump($teaInfo);
// 		echo $teaInfo['log_AuthorID'];
// 		echo $teaInfo['mem_ID'];
		$teacherID = $teaInfo['mem_ID'];
		
// 		var_dump($reTeaSQL[0]);
		$addTeaSQL = "SELECT * FROM zbp_memaddition WHERE mem_ID = $teacherID";
		$reAddTeaSQL = $zbp->db->Query($addTeaSQL);
		$teaInfo['mem_headPortrait'] = $reAddTeaSQL[0]['mem_headPortrait'];
// 		echo $teaInfo['mem_ID'];
// 		echo var_dump($teaInfo);

		//当前教师的最多五篇文章
		$teaArtSQL = "SELECT * FROM zbp_post WHERE log_AuthorID = $teacherID order by log_ViewNums desc LIMIT 6";
// 		echo $teaArtSQL;
		$reTeaArts = $zbp->db->Query($teaArtSQL);
// 		echo $teacherID;
		break;
}

/**
 * 根据URL地址得到Action， 比如home.php，那么action= 'home';
 * */
function getActionFromUrl($url)
{
	$arr1 = explode('/',$url);
	$len = count($arr1);
	$url2 = $arr1[$len - 1];
	$arr2 = explode('.',$url2);
	return $arr2[count($arr2) - 2];
}


?>