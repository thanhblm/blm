<?php

namespace common\config\shiprush;

use common\config\BaseEnum;

abstract class ShiprushShipmentChgTypeEnum extends BaseEnum {
	const PRE = 'PRE';
	const COL = 'COL';
	const CBS = 'CBS';
	const TPB = 'TPB';
	const CNF = 'C&F';
	const DDP = 'DDP';
	const FOB = 'FOB';
	const SDT = 'SDT';
}