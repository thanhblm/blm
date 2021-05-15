<?php

namespace common\config\shiprush;

use common\config\BaseEnum;

abstract class ShiprushShippingTypeEnum extends BaseEnum {
	const UNKNOWN = 'Unknown';
	const PENDING = 'Pending';
	const HISTORY = 'History';
	const FAVORITES = 'Favorites';
	const SEARCH = 'Search';
	const DRAFT = 'Draft';
}