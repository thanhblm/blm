<?php
use common\helper\DatoImageHelper;
use common\rule\url\friendly\BlogUrlFriendly;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\rule\url\friendly\CategoryUrlFriendly;

$blog = RequestUtil::get ( 'blog' );
$blogRelated = RequestUtil::get ( 'blogRelated' );
$categoryParent = RequestUtil::get ( 'categoryParent' );
?>

<div id="LeftMainContent">
	<div class="container-default">
		<div id="ctl23_BodyContainer">
			<div id="ctl23_ctl00_panelNewsDetails" class="contentDetail">
				<h1 id="ctl23_ctl00_divArticleTitle" class="detailsView-title-style"><?= $blog->name ?></h1>
				<div id="ctl23_ctl00_divDate" class="date-first"><?= $blog->crDate ?></div>
				
				<div class="detailsView-contents-style">
					<h2 id="ctl23_ctl00_divSummary" class="summary"><?= $blog->description ?></h2>
				</div>
				<div id="divContents" class="detailsView-contents-style detail-article-content">
					<div>
					<?= $blog->composition ?>
				</div>
				<div id="ctl23_ctl00_divSourceNews" class="detailsView-contents-style soucenews" style="padding: 10px"></div>
				<div style="clear: both; height: 20px;"></div>
				
			</div>
			<div class="clear" style="margin-bottom: 10px;"></div>
			
		</div>
	</div>
	<div class="othernews">
		<h2 class="normalblue" style="white-space: nowrap;">Tin cũ hơn</h2>
		<div class="otherline">&nbsp;</div>
		<?php 
		foreach ($blogRelated as $item){
		?>
		<h3 class="normal">
			<a class="font-link-box-item iconlist" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?= $item->name ?>"> <?= $item->name ?> <i>(<?= $item->crDate ?>)</i>
			</a>
		</h3>
	
		<?php 
		}
		?>
	</div>
	<div class="othernews">
		<a id="lnkNewOther" href="<?= ActionUtil::getFullPathAlias("home/blog/list?id=$categoryParent->id" , new CategoryUrlFriendly($categoryParent->languageCode, $categoryParent->id, $categoryParent->seoUrl, $categoryParent->name)) ?>" style="cursor: pointer; text-decoration: underline; font-style: italic; color: #055699 !important;">Xem tiếp</a>
		<div class="otherline" style="width: 91%;">&nbsp;</div>
	</div>
	<div style="clear: both;"></div>
</div>