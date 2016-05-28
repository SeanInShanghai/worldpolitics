<?php
include_once 'prefix.php';
$action = $_GET['action'];

$showTag = "";//在标题页写入是类别还是教师的文章

$type = 0;//0表示最新，1表示最热
if(empty($_GET['type'])){
	$type = 0;
}else{
	$type = $_GET['type'];
}
// echo $type;
// echo $action;
switch($action)
{
	case 'cate':
		
		
		
		
		//找到这个分类的文章，并且根据时间的倒序来进行更新
		$cateID = $_GET['cate_ID'];
		$w = array();
		$w[] = array('=', 'log_CateID', $cateID);
		$allArticles = $zbp->GetArticleList(
				'*',
				$w,
				array('log_PostTime' => 'DESC'),
				null,
				null,
				true
		);
		
		$searchCateName = "SELECT * FROM zbp_category WHERE cate_ID = '$cateID'";
		$reCateName = $zbp->db->Query($searchCateName);
		$cateName = $reCateName[0]['cate_Name'];
		$showTag = "标签：".$cateName;

		$count = 3; //每页显示3篇论丛文章
		$totalCount = count($allArticles);//论丛文章全部数量
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
		// $articles = ViewList($pageInfo, null, null, null, null);
		$arr = array('log_PostTime' => 'DESC');
		if(0 == $type){
			$arr = array('log_PostTime' => 'DESC');
		}else{
			$arr = array('log_ViewNums' => 'DESC');
		}
		$articles = $zbp->GetArticleList(
				'*',
				$w,
				$arr,
				array(($page-1)*$count,$count),
				null,
				true
		);
		
		$sql = "SELECT * FROM zbp_member WHERE mem_Level = 3 LIMIT 6";
		$members = $zbp->db->Query($sql);
		
		//热门标签
		$tagSQL = "SELECT * FROM zbp_category LIMIT 6";
		$tags = $zbp->db->Query($tagSQL);
		
		include 'cateList.php';
		break;
	case 'author':
		$memID = $_GET['mem_ID'];
		break;
		
	default:
		break;
}
?>