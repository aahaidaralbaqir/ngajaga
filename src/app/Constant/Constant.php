<?php

namespace App\Constant;

class Constant {

	const MAX_PAGINATION = 10;

	const STORAGE_PRODUCT = 'products';

	const STATUS_ACTIVE = 3;
	const STATUS_INACTIVE = 4;
	const STATUS_ACTIVE_NAME = 'Aktif';
	const STATUS_INACTIVE_NAME = 'Tidak Aktif';

	const ONE_MINUTE = 60;


	const UNIT_NAME_RUPIAH	= 'Rp';

	CONST HTTP_VERB_GET = 'GET';
	CONST HTTP_VERB_POST = 'POST';
	CONST HTTP_VERB_DELETE = 'DELETE';
	CONST HTTP_VERB_PUT = 'PUT';
	CONST HTTP_VERB_PATCH = 'PATCH';
	CONST HTTP_VERB_HEAD = 'HEAD';

	const UNIT_KG = 1;
	const UNIT_LUSIN = 2;
	const UNIT_PCS = 3;
	const UNIT_BKS = 4;

	const OPTION_ENABLE = 1;
	const OPTION_DISABLE = 2;

	const PURCHASE_ORDER_VOID = 0;
	const PURCHASE_ORDER_DRAFT = 1;
	const PURCHASE_ORDER_WAITING = 2;
	const PURCHASE_ORDER_COMPLETED = 3;
}