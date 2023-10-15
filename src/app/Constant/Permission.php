<?php namespace App\Constant;

class Permission {
	const CAN_VIEW_DASHBOARD 	= 'view_dashboard';
	const CAN_VIEW_BANNER 		= 'view_banner';
	const CAN_CREATE_BANNER 	= 'create_banner';
	const CAN_UPDATE_BANNER 	= 'update_banner';
	const CAN_ORDER_BANNER 		= 'order_banner';
	
	const CAN_VIEW_POST 	= 'view_post';
	const CAN_CREATE_POST 	= 'create_post';
	const CAN_UPDATE_POST 	= 'update_post';

	const CAN_VIEW_STRUCTURE 	= 'view_structure';
	const CAN_CREATE_STRUCTURE 	= 'create_structure';
	const CAN_UPDATE_STRUCTURE 	= 'update_structure';
	const CAN_DELETE_STRUCTURE = 'delete_structure';

	const CAN_VIEW_ACTIVITY 	= 'view_activity';
	const CAN_CREATE_ACTIVITY 	= 'create_activity';
	const CAN_UPDATE_ACTIVITY 	= 'update_activity';
	const CAN_MANAGE_ACTIVITY_DOCUMENTATION = 'activity_documentation';

	const CAN_MANAGE_SCHEDULE = 'manage_schedule';

	const CAN_VIEW_TRANSACTION_TYPE = 'view_transaction_type';
	const CAN_CREATE_TRANSACTION_TYPE = 'create_transaction_type';
	const CAN_UPDATE_TRANSACTION_TYPE = 'update_transaction_type';

	const CAN_VIEW_PAYMENT 		= 'view_payment';
	const CAN_CREATE_PAYMENT 	= 'create_payment';
	const CAN_UPDATE_PAYMENT 	= 'update_payment';

	const CAN_VIEW_TRANSACTION = 'view_transaction';
	const CAN_UPDATE_TRANSACTION = 'update_transaction';
	const CAN_APPROVE_TRANSACTION = 'approve_transaction';
	const CAN_CREATE_TRANSACTION = 'create_transaction';

	const CAN_VIEW_PERMISSION = 'view_permission';
	const CAN_CREATE_PERMISSION = 'create_permission';
	const CAN_UPDATE_PERMISSION = 'update_permission';
	
	const CAN_VIEW_ROLE = 'view_roles';
	const CAN_CREATE_ROLE = 'create_role';
	const CAN_UPDATE_ROLE = 'update_role';

	const CAN_VIEW_USER = 'view_user';
	const CAN_CREATE_USER = 'create_user';
	const CAN_UPDATE_USER = 'update_user';

	const CAN_VIEW_REPORT = 'view_report';

	const CAN_VIEW_DISTRIBUTION = 'view_distribution';
	const CAN_CREATE_DISTRIBUTION = 'create_distribution';
	const CAN_UPDATE_DISTRIBUTION = 'update_distribution';

	const CAN_VIEW_BENEFICIARY = 'view_beneficiary';
	const CAN_CREATE_BENEFICIARY = 'create_beneficiary';
	const CAN_UPDATE_BENEFICIARY = 'update_beneficiary';
	const CAN_DELETE_BENEFICIARY = 'delete_beneficiary';

	const CAN_MANAGE_TRANSACTION_PROOF = 'proof_transaction';
}