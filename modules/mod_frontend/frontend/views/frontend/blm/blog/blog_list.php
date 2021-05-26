<?php

use common\template\extend\Text;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get("blogList");
$blogList = $paging->records;

$categoryBlog = RequestUtil::get("categoryBlog");
$filter = RequestUtil::get("filter");

$text = new Text ();
$text->type = 'hidden';
$text->value = AppUtil::defaultIfEmpty(RequestUtil::get("page"), 1);
$text->name = "page";
$text->id = "page";
$text->render();
?>


<div class="col-md-12" style="padding: 0;">
	<div class="parent-main-left">
		<?php
		if ($categoryBlog != null && $categoryBlog->parentId == 0) {
			include "blog_list_multi_category_data.php";
		} else {
			include "blog_list_single_category_data.php";
		}
		?>
		<!-- main-inner-wrap -->
	</div>
	<!-- /main-wrapper -->


	<div id="RightMainContent" class="col_right parent-main-right">
		<div style="clear: both;"></div>
		<div class="adPosition" positioncode="BANNER_POSITION_RIGHT_MAIN_CONTENT" style="margin-bottom: 10px;">
			<div class="adshared">
				<div class="aditem" time="15" style="display: block;" src="https://file4.batdongsan.com.vn/2016/06/13/V5fQl2m0/20160613154250-76ef.jpg" altsrc="https://file4.batdongsan.com.vn/2016/06/13/V5fQl2m0/20160613154250-76ef.jpg" link="https://alokiddy.com.vn/" bid="3850" tip="" tp="7" w="240" h="150"
				     k="">
					<a href="/click.aspx?bannerid=3850" target="_blank" title="" rel="nofollow"><img src="https://file4.batdongsan.com.vn/2016/06/13/V5fQl2m0/20160613154250-76ef.jpg" style="max-width: 100%; height: 150px;"></a>
				</div>
			</div>
			<div class="adshared">
				<div class="aditem" time="6" style="display: block;" src="https://file4.batdongsan.com.vn/2017/11/30/RUFz0fap/20171130091123-635e.jpg" altsrc="https://file4.batdongsan.com.vn/2017/11/30/RUFz0fap/20171130091123-635e.jpg" link="https://batdongsan.com.vn/phong-thuy" bid="664"
				     tip="http://batdongsan.com.vn/ban-can-ho-chung-cu-tp-hcm" tp="7" w="240" h="150" k="">
					<a href="/click.aspx?bannerid=664" target="_blank" title="http://batdongsan.com.vn/ban-can-ho-chung-cu-tp-hcm" rel="nofollow"><img src="https://file4.batdongsan.com.vn/2017/11/30/RUFz0fap/20171130091123-635e.jpg" style="max-width: 100%; height: 150px;"></a>
				</div>
			</div>
			<div class="adshared">
				<div class="aditem" time="10" style="display: block;" src="https://file4.batdongsan.com.vn/2017/11/01/RUFz0fap/20171101081951-d5f8.jpg" altsrc="https://file4.batdongsan.com.vn/2017/11/01/RUFz0fap/20171101081951-d5f8.jpg" link="https://batdongsan.com.vn/nha-dep" bid="1788" tip="" tp="7" w="240"
				     h="150" k="">
					<a href="/click.aspx?bannerid=1788" target="_blank" title="" rel="nofollow"><img src="https://file4.batdongsan.com.vn/2017/11/01/RUFz0fap/20171101081951-d5f8.jpg" style="max-width: 100%; height: 150px;"></a>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div class="fb-fanpage">
			<div id="fb-root" class=" fb_reset">
				<div style="position: absolute; top: -10000px; height: 0px; width: 0px;">
					<div></div>
				</div>
				<div style="position: absolute; top: -10000px; height: 0px; width: 0px;">
					<div>
						<iframe name="fb_xdm_frame_https" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" id="fb_xdm_frame_https" aria-hidden="true" title="Facebook Cross Domain Communication Frame" tabindex="-1"
						        src="https://staticxx.facebook.com/connect/xd_arbiter/r/RQ7NiRXMcYA.js?version=42#channel=f31869cc1917194&amp;origin=https%3A%2F%2Fbatdongsan.com.vn" style="border: none;"></iframe>
					</div>
				</div>
			</div>
			<div class="fb-page fb_iframe_widget" data-href="https://www.facebook.com/Batdongsandv/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" fb-xfbml-state="rendered"
			     fb-iframe-plugin-query="adapt_container_width=true&amp;app_id=302507473246792&amp;container_width=240&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FBatdongsandv%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=false">
				<span style="vertical-align: bottom; width: 240px; height: 214px;"><iframe name="f962ff915494c" width="1000px" height="1000px" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" title="fb:page Facebook Social Plugin"
				                                                                           src="https://www.facebook.com/v2.10/plugins/page.php?adapt_container_width=true&amp;app_id=302507473246792&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter%2Fr%2FRQ7NiRXMcYA.js%3Fversion%3D42%23cb%3Df1c8fd53ba17738%26domain%3Dbatdongsan.com.vn%26origin%3Dhttps%253A%252F%252Fbatdongsan.com.vn%252Ff31869cc1917194%26relation%3Dparent.parent&amp;container_width=240&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FBatdongsandv%2F&amp;locale=vi_VN&amp;sdk=joey&amp;show_facepile=true&amp;small_header=false"
				                                                                           style="border: none; visibility: visible; width: 240px; height: 214px;" class=""></iframe></span>
			</div>
		</div>
		<div style="clear: both;"></div>
	</div>
	<!-- sidebar-wrapper -->
	<div class="clear"></div>
</div>

<script type="text/javascript">
    var gUrlBlogList = "<?=ActionUtil::getFullPathAlias("home/blog/list/search") ?>" + "?rtype=json";

    function changePageBlogs(page) {
        simpleAjaxPost(
            guid(),
            gUrlBlogList + "&page=" + page,
            "",
            loadBlogSuccess
        );
    }

    function loadBlogSuccess(res) {
        $("#Blog1").html(res.content);
    }
</script>