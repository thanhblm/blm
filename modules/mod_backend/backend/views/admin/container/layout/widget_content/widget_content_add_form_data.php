<?php
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use common\utils\FileUtil;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\RouteUtil;

// get data
$ajaxData = RequestUtil::get ( "ajaxData" );
$widgetGroup = $ajaxData ['widgetGroup'];
$widgetContentGroup = $ajaxData ['widgetContentGroup'];
$widgetContentDefault = $ajaxData ['widgetContentDefault'];
$containerId = RequestUtil::get ( "containerId" );
$widgetContentLangs = RequestUtil::get ( "widgetContentLanguages" )->getArray();
$widgetContentVo = RequestUtil::get ( "widgetContentVo" );
?>
<div class="form-group">
	<!-- widgets list -->
	<?php
	if (empty ( $widgetGroup )) {
		echo "<div class='data_empty'>";
		echo Lang::get ( 'Widgets list is empty' );
		echo "</div>";
	} else {
		?>
	<!-- left -->
	<div class="col-md-4">
		<div id="accordion-resizer" class="ui-widget-content widget_list">
			<?php foreach($widgetGroup as $group){?>
			  <h4><?php echo $group['name']?></h4>
			<ul>
				<?php foreach($group['data'] as $widgetInfo){?>
                <li class="widget_list_select <?php echo($widgetInfo->id == $widgetContentDefault->widgetId)? 'active' : ''; ?>" data-widgetid="<?=$widgetInfo->id?>">
                    <a href="javascript:widgetListSelect<?=$containerId?>('<?=$containerId?>', '<?=$widgetInfo->id?>')">
                        <div class="widget_name">
                            <?php echo (!empty($widgetInfo->icon)) ? "<i class='{$widgetInfo->icon}'></i>" : "<i class='fa fa-bars'></i>";?>
                            <?php echo $widgetInfo->name?>
                        </div>
                        <div class='widget_description'><?php echo $widgetInfo->description?></div>
                    </a>
				</li>
				<?php }?>
			  </ul>
			<?php }?>	
		</div>
	</div>
	<!-- right -->
	<div class="col-md-8">
		<?php
		// default data
		echo "<input type='hidden' name='widgetContentVo[widgetId]' value='{$widgetContentDefault->widgetId}'>";
		echo "<input type='hidden' name='widgetContentVo[status]' value='active'>";
		
		$text = new TextInput ();
		$text->label = Lang::get ( "Widget name" );
		$text->required = true;
		$text->name = "widgetContentVo[name]";
		$text->value = '';
		$text->render ();
		
		$text = new TextInput ();
		$text->label = Lang::get ( "Widget description" );
		$text->name = "widgetContentVo[description]";
		$text->value = '';
		$text->render ();
		
		$text = new TextInput ();
		$text->label = Lang::get ( "Custom class" );
		$text->name = "widgetContentVo[class]";
		$text->value = '';
		$text->render ();
		
		$text = new TextInput ();
		$text->label = Lang::get ( "Custom style" );
		$text->name = "widgetContentVo[style]";
		$text->value = '';
		$text->render ();

        $select = new SelectInput();
        $select->value = 1;
        $select->name = "widgetContentVo[public]";
        $select->collections = ApplicationConfig::get("layout.yn.list");
        $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
        $select->label = Lang::get("Public");
        $select->render();
		
		// line
		echo '<hr class="hr-mini">';
		
		// load controller
		FileUtil::loadWidgetController ( $widgetContentDefault );
		
		// run form method
        $mod = RouteUtil::getRoute()->getModule();
		$widgetController = str_replace ( 'mod_', '', $mod) . '\widgets\\' . $widgetContentDefault->widgetController;
		$control = new $widgetController ( $widgetContentDefault, $widgetContentLangs );
		$control->form ();
		?>
	</div>
	<?php }?>
</div>