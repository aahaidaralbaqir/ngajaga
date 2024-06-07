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
	const STORAGE_DOCUMENTATION = 'documentation';

	const ORDER_UP = 'up';
	const ORDER_DOWN = 'down';

	const CATEGORY_TAFSIR_NAME = 'Khutbah';
	const CATEGORY_KHUTBAH_NAME = 'Tafsir';
	const CATEGORY_HADIST_NAME = 'Hadist';
	const CATEGORY_TASAWUF_NAME = 'Tasawuf';
	const CATEGORY_FIQIH_NAME = 'Fikih';
	const CATEGORY_ZAKAT_NAME = 'Distribusi Zakat';
	const CATEGORY_INFAQ_NAME = 'Penyaluran Infaq';
	const CATEGORY_SEDEKAH_NAME = 'Penyaluran Sedekah';
	const CATEGORY_QURBAN_NAME = 'Pelaksanaan Qurban';

	const CATEGORY_TAFSIR = 1;
	const CATEGORY_KHUTBAH = 2;
	const CATEGORY_HADIST = 3;
	const CATEGORY_TASAWUF = 4;
	const CATEGORY_FIQIH = 5;
	const CATEGORY_ZAKAT = 6;
	const CATEGORY_INFAQ = 7;
	const CATEGORY_SEDEKAH = 8;
	const CATEGORY_QURBAN = 9;

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
	const TRANSACTION_PAID = 3;
	const TRANSACTION_EXPIRED = 4;
	const TRANSACTION_REQUESTED = 5;
	const TRANSACTION_DISTRIBUTED = 6;

	const ONE_MINUTE = 60;

	const PG_STATUS_FAILURE = 'failure';
	const PG_STATUS_EXPIRED = 'expire';
	const PG_STATUS_SETTLEMENT = 'settlement';
	const PG_STATUS_CANCEL = 'cancel';
	const PG_STATUS_PENDING = 'pending';

	const UNIT_NAME_RUPIAH	= 'Rp';

	CONST HTTP_VERB_GET = 'GET';
	CONST HTTP_VERB_POST = 'POST';
	CONST HTTP_VERB_DELETE = 'DELETE';
	CONST HTTP_VERB_PUT = 'PUT';
	CONST HTTP_VERB_PATCH = 'PATCH';
	CONST HTTP_VERB_HEAD = 'HEAD';

	const PARENT_ATTENDEE = 0;
}