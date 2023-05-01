<?php

namespace App\Constant;

class Constant {

	const MAX_PAGINATION = 10;

	const ROLE_HOKAGE = 1;
	const ROLE_RAIKAGE = 2;

	const STORAGE_AVATAR = 'avatars';
	const STORAGE_BANNER = 'banners';
	const STORAGE_POST = 'posts';

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
	const STATUS_PUBLISHED_NAME = 'Published';
	const STATUS_DRAFT_NAME = 'Draft';
}