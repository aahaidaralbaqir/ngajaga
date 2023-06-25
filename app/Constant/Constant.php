<?php

namespace App\Constant;

class Constant {

	const MAX_PAGINATION = 10;

	const ROLE_HOKAGE = 1;
	const ROLE_RAIKAGE = 2;

	const STORAGE_AVATAR = 'avatars';
	const STORAGE_BANNER = 'banners';
	const STORAGE_POST = 'posts';
	const STORAGE_ACTIVITY = 'activity';
	const STORAGE_TRANSACTION = 'transaction';
	const STORAGE_PAYMENT = 'payment_logo';

	const ORDER_UP = 'up';
	const ORDER_DOWN = 'down';

	const CATEGORY_KAJIAN_NAME = 'Kajian';
	const CATEGORY_KHUTBAH_NAME = 'Khutbah';
	const CATEGORY_BULETIN_NAME = 'Buletin';

	const CATEGORY_KAJIAN = 1;
	const CATEGORY_KHUTBAH = 2;
	const CATEGORY_BULETIN = 3;

	const STATUS_PUBLISHED = 1;
	const STATUS_DRAFT = 2;
	const STATUS_ACTIVE = 3;
	const STATUS_INACTIVE = 4;
	const STATUS_PUBLISHED_NAME = 'Published';
	const STATUS_DRAFT_NAME = 'Draft';
	const STATUS_ACTIVE_NAME = 'Active';
	const STATUS_INACTIVE_NAME = 'Inactive';

	const TRANSACTION_PENDING = 1;
	const TRANSACTION_FAILED = 2;
	const TRANSACTION_SUCCESS = 3;
	const TRANSACTION_EXPIRED = 4;
	const TRANSACTION_PAID = 5;
	const TRANSACTION_REQUESTED = 6;

	const ONE_MINUTE = 60;

	const PG_STATUS_FAILURE = 'failure';
	const PG_STATUS_EXPIRED = 'expired';
	const PG_STATUS_SETTLEMENT = 'settlement';
	const PG_STATUS_CANCEL = 'cancel';
	const PG_STATUS_PENDING = 'pending';

	const UNIT_NAME_RUPIAH	= 'Rp';
}