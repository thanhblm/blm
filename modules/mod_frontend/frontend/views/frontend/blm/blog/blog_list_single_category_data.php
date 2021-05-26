<?php
use common\helper\DatoImageHelper;
use common\rule\url\friendly\BlogUrlFriendly;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
use core\utils\AppUtil;

$lstBlogFearured = RequestUtil::get ( "blogFearured" );
$paging = RequestUtil::get ( "blogList" );
$blogList = $paging->records;
$categoryBlog = RequestUtil::get ( "categoryBlog" );
$filter = RequestUtil::get ( "filter" );

?>

<div class="div_2col1">
	<div class="clear"></div>
	<div id="LeftMainContent">
		<div class="container-default">
			<div id="ctl23_BodyContainer">
				<div class="body-left">
					<div id="ctl23_ctl00_panelCate" class="detailsView-title-style">
						<div class="font-title-list-news"><?php if(!AppUtil::isEmptyString($categoryBlog->name)){ echo $categoryBlog->name; }else { echo "Kết quả tìm kiếm";}?></div>
					</div>
					<?php
					$i = 0;
					foreach ( $blogList as $item ) {
						$imageMo = DatoImageHelper::getImageInfoById ( json_decode ( $item->images ) [0] );
						$i ++;
						if ($i == 1) {
						?>
					<div class="tt-thumb-img">
						<a href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"> <img style="width: 216px; height: 152px" src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="<?=$item->name?>"
							class="bor_img">
						</a>&nbsp;&nbsp;
					</div>
					<div class="tt-thumb-cnt">
						<h2>
							<a class="link_blue" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?=$item->name?>"> <?=$item->name?></a>
						</h2>
						<div class="datetime">10:23 21/07/2018</div>
						<p style="text-rendering: geometricPrecision;"><?= $item->composition ?></p>
					</div>
					<div class="clear line"></div>
					<?php }else{?>
					<div class="tintuc-row1 tintuc-list tc-tit">
						<div class="tc-img list-news-image-title">
							<a href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"> <img class="bor_img" style="width: 132px; height: 100px;" alt="<?=$item->name?>"
								src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>">
							</a>&nbsp;&nbsp;
						</div>
						<h3>
							<a class="link_blue" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?=$item->name?>"> <?=$item->name?> </a>
						</h3>
						<div class="datetime">08:07 21/07/2018</div>
						<p style="text-rendering: geometricPrecision;"><?= $item->composition ?></p>
					</div>
					<div class="clear"></div>
					<?php }}?>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>




