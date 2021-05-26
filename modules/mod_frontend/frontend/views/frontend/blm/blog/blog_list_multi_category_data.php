<?php
use common\helper\DatoImageHelper;
use common\rule\url\friendly\BlogUrlFriendly;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\rule\url\friendly\CategoryBlogUrlFriendly;

$lstBlogFearured = RequestUtil::get ( "blogFearured" );
$blogFearured = $lstBlogFearured->records;
$filter = RequestUtil::get ( "filter" );
$categoryBlog = RequestUtil::get ( "categoryBlog" );
$categoryParent = RequestUtil::get ( "categoryParent" );
?>

<div class="div_2col1">
	<div class="clear"></div>
		<div id="LeftMainContent" class="t_left1">
		<div>
			<div id="ctl24_HeaderContainer" class="box-header">
				<div class="name_tit" align="left" style="padding-left: 10px;">
					<h1 style="color: White;line-height: 26px;"><?=$categoryBlog->name?></h1>
				</div>
			</div>
			<div id="ctl24_BodyContainer" class="tc-tin-3cot-tit1">
				<div class="parent-cate-news">
					<?php
		
					$i = 0;
					foreach ( $blogFearured as $item ) {
						$imageMo = DatoImageHelper::getImageInfoById ( json_decode ( $item->images ) [0] );
						$i ++;
						if ($i == 1) {
							?>
					<div class="tc-tin-3cot-tit1-left">
						<a title="<?=$item->name?>" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"> <img class="bor_img" src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>">
						</a>
						<h3>
							<a class="font-link-box-item" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?= $item->name ?>"> <?= $item->name ?> </a>
						</h3>
						<div class="description-news"><?= $item->composition ?></div>
					</div>
					<?php
						} else if ($i != 1 && $i <= 4) {
					?>
					<div class="tc-tin-3cot-tit1-right">
						<img class="bor_img" src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="">
						<h3 class="normal">
							<a class="tc-tin-3cot-tit1-right-link font-link-box-item" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a>
						</h3>
						<div class="clear"></div>
					</div>
								
					<?php
				}
			}
			?>				
				
					<div class="tc-tin-3cot-tit1-right-link2">
					<?php
		
					$i = 0;
					foreach ( $blogFearured as $item ) {
						$i ++;
						if ($i > 4 && $i <= 8) {
							?>
									<ul>
										<li><h3 class="normal">
												<a href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?= $item->name ?>"><?= $item->name ?></a>
											</h3></li>
									</ul>
								<?php
						}
					}
					?>
			</div>
				</div>
				<div class="clear"></div>
				<div class="lblnewscateby">
					<strong>Tin tức bất động sản</strong>&nbsp;theo chuyên mục:
				</div>
			</div>
		</div>
		<div style="clear: both; margin-bottom: 5px;"></div>
		<div class="container-default">
			<div id="ctl25_BodyContainer">
				<?php 
				foreach ( $categoryParent as $item ) {
					if (count ( $item->lstBlog ) > 0) {
				?>
					<div class="tc-duan-tin parent-cate-news">
					<h2 class="tit_l borderbold">
						<a class="news-category-root-box-title-link" href="<?= ActionUtil::getFullPathAlias("home/blog/list?id=$item->id", new CategoryBlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" title="<?= $item->name ?>"><span style="white-space: nowrap;"><?= $item->name ?></span></a>
					</h2>
					<?php
					$i = 0;
					foreach ( $item->lstBlog as $subItem ) {
						$imageMo = DatoImageHelper::getImageInfoById ( json_decode ( $subItem->images ) [0] );
						$i ++;
						if ($i == 1) {
						?>
						<div class="tintuc-row1 tc-tit">
						<a class="avatar" title="<?= $subItem->name ?>" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$subItem->id", new BlogUrlFriendly($subItem->languageCode, $subItem->id, $subItem->seoUrl, $subItem->name)) ?>"> <img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>"
							alt="<?= $subItem->name ?>">
						</a>
						<h3>
							<a class="font-link-news-parent" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$subItem->id", new BlogUrlFriendly($subItem->languageCode, $subItem->id, $subItem->seoUrl, $subItem->name)) ?>" title="<?= $subItem->name ?>"> <span style="font-weight: bold; color: #055699"><?= $subItem->name ?></span>
							</a>
						</h3>
						<br>
						<p><?= $subItem->composition ?></p>
					</div>
						
						<?php }else{?>
							<div class="tc-duan-tin-thumnai">
							<?php if($i==2){?>
								<div class="tc-duan-tin-thumnai-row1">
							<a class="tc-duan-tin-thumnai-img" title="<?= $subItem->name ?>" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$subItem->id", new BlogUrlFriendly($subItem->languageCode, $subItem->id, $subItem->seoUrl, $subItem->name)) ?>"> <img alt="<?= $subItem->name ?>"
								src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>">
							</a>
							<h3>
								<a class="tc-duan-tin-thumnai-link" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$subItem->id", new BlogUrlFriendly($subItem->languageCode, $subItem->id, $subItem->seoUrl, $subItem->name)) ?>" title="<?= $subItem->name ?>"> <?= $subItem->name ?></a>
							</h3>
						</div>
								<?php }else{?>
								<div class="tc-tin-3cot-tit1-right-link2">
							<ul>
								<li><h3 class="normal">
										<a class="font-link-box-item" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$subItem->id", new BlogUrlFriendly($subItem->languageCode, $subItem->id, $subItem->seoUrl, $subItem->name)) ?>" title="<?= $subItem->name ?>"> <?= $subItem->name ?></a>
									</h3> <a class="font-link-box-item" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$subItem->id", new BlogUrlFriendly($subItem->languageCode, $subItem->id, $subItem->seoUrl, $subItem->name)) ?>" title="<?= $subItem->name ?>"> </a></li>
							</ul>
						</div>
								<?php }?>
							</div>
						<?php }}?>
						
						<div class="clear"></div>
				</div>
					<?php
			}
		}
		?>
				<div style="clear: both">&nbsp;</div>
			</div>
		</div>
	</div>
	<?php include "blog_list_sidebar_data.php" ?>
	<div class="clear"></div>
</div>




