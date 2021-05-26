<?php

use common\template\extend\PagingTemplate;
use core\utils\RequestUtil;
use common\helper\DatoImageHelper;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\Lang;
use common\rule\url\friendly\BlogUrlFriendly;

$paging = RequestUtil::get("blogList");
$blogList = $paging->records;
$filter = RequestUtil::get("filter");
?>











<div class="blog-posts hfeed">
	<!--Can't find substitution for tag [defaultAdStart]-->

	<div class="date-outer">
		<div class="date-posts">
			<?php
			foreach ($blogList as $blog) {
				$imageMo = DatoImageHelper::getImageInfoById(json_decode($blog->images)[0]);
				?>
				<div class="post-outer">
					<div class="post hentry uncustomized-post-template" itemscope="itemscope">
						<div class="post-body entry-content">
							<h2 class="post-title entry-title col-md-8" itemprop="name headline">
								<a title="<?= $blog->name ?>" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$blog->id", new BlogUrlFriendly($blog->languageCode, $blog->id, $blog->url, $blog->name)) ?>"><?= $blog->name ?></a>
							</h2>
							<div class="col-md-2">
								<span itemprop="dateModified"><?= $blog->crBy ?>
								</span>
							</div>
							<div class="col-md-2">
								<span itemprop="dateModified"><?= $blog->crDate ?>
								</span>
							</div>
							<div style="clear: both;"></div>
						</div>

					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>

	<!--Can't find substitution for tag [adEnd]-->
</div>
<div class="blog-pager" id="blog-pager">
	<?php
	$pagingTemplate = new PagingTemplate();
	$pagingTemplate->paging = $paging;
	$pagingTemplate->changePageJs = "changePageBlogs";
	$pagingTemplate->render();
	?>
</div>
<div class="clear"></div>
