<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_Seed_initial_role_permission
 * @property CI_DB_query_builder $db
 */
class Migration_Seed_initial_role_permission extends CI_Migration
{
    public function up()
    {
        $this->db->insert_batch('prv_permissions', [
            [
                'module' => 'setting', 'submodule' => 'account', 'permission' => PERMISSION_ACCOUNT_EDIT,
                'description' => 'Setting account profile'
            ],
            [
                'module' => 'setting', 'submodule' => 'application', 'permission' => PERMISSION_SETTING_EDIT,
                'description' => 'Setting application preference'
            ],

            [
                'module' => 'privilege', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_VIEW,
                'description' => 'View role data'
            ],
            [
                'module' => 'privilege', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_CREATE,
                'description' => 'Create new role'
            ],
            [
                'module' => 'privilege', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_EDIT,
                'description' => 'Edit role'
            ],
            [
                'module' => 'privilege', 'submodule' => 'role', 'permission' => PERMISSION_ROLE_DELETE,
                'description' => 'Delete role'
            ],


            [
                'module' => 'privilege', 'submodule' => 'user', 'permission' => PERMISSION_USER_VIEW,
                'description' => 'View user data'
            ],
            [
                'module' => 'privilege', 'submodule' => 'user', 'permission' => PERMISSION_USER_CREATE,
                'description' => 'Create new user'
            ],
            [
                'module' => 'privilege', 'submodule' => 'user', 'permission' => PERMISSION_USER_EDIT,
                'description' => 'Edit user'
            ],
            [
                'module' => 'privilege', 'submodule' => 'user', 'permission' => PERMISSION_USER_DELETE,
                'description' => 'Delete user'
            ],

            [
                'module' => 'master', 'submodule' => 'component', 'permission' => PERMISSION_COMPONENT_VIEW,
                'description' => 'View component'
            ],
            [
                'module' => 'master', 'submodule' => 'component', 'permission' => PERMISSION_COMPONENT_CREATE,
                'description' => 'Create new component'
            ],
            [
                'module' => 'master', 'submodule' => 'component', 'permission' => PERMISSION_COMPONENT_EDIT,
                'description' => 'Edit component'
            ],
            [
                'module' => 'master', 'submodule' => 'component', 'permission' => PERMISSION_COMPONENT_DELETE,
                'description' => 'Delete component'
            ],

            [
                'module' => 'master', 'submodule' => 'sub-component', 'permission' => PERMISSION_SUB_COMPONENT_VIEW,
                'description' => 'View customer data'
            ],
            [
                'module' => 'master', 'submodule' => 'sub-component', 'permission' => PERMISSION_SUB_COMPONENT_CREATE,
                'description' => 'Create new component'
            ],
            [
                'module' => 'master', 'submodule' => 'sub-component', 'permission' => PERMISSION_SUB_COMPONENT_EDIT,
                'description' => 'Edit component'
            ],
            [
                'module' => 'master', 'submodule' => 'sub-component', 'permission' => PERMISSION_SUB_COMPONENT_DELETE,
                'description' => 'Delete sub component'
            ],

            [
                'module' => 'master', 'submodule' => 'package', 'permission' => PERMISSION_PACKAGE_VIEW,
                'description' => 'View package'
            ],
            [
                'module' => 'master', 'submodule' => 'package', 'permission' => PERMISSION_PACKAGE_CREATE,
                'description' => 'Create new package'
            ],
            [
                'module' => 'master', 'submodule' => 'package', 'permission' => PERMISSION_PACKAGE_EDIT,
                'description' => 'Edit package'
            ],
			[
				'module' => 'master', 'submodule' => 'package', 'permission' => PERMISSION_PACKAGE_DELETE,
				'description' => 'Delete package'
			],

            [
                'module' => 'master', 'submodule' => 'service', 'permission' => PERMISSION_SERVICE_VIEW,
                'description' => 'View service'
            ],
            [
                'module' => 'master', 'submodule' => 'service', 'permission' => PERMISSION_SERVICE_CREATE,
                'description' => 'Create new service'
            ],
            [
                'module' => 'master', 'submodule' => 'service', 'permission' => PERMISSION_SERVICE_EDIT,
                'description' => 'Edit service'
            ],
			[
				'module' => 'master', 'submodule' => 'service', 'permission' => PERMISSION_SERVICE_DELETE,
				'description' => 'Delete service'
			],

            [
                'module' => 'master', 'submodule' => 'port', 'permission' => PERMISSION_PORT_VIEW,
                'description' => 'View port'
            ],
            [
                'module' => 'master', 'submodule' => 'port', 'permission' => PERMISSION_PORT_CREATE,
                'description' => 'Create new port'
            ],
            [
                'module' => 'master', 'submodule' => 'port', 'permission' => PERMISSION_PORT_EDIT,
                'description' => 'Edit port'
            ],
			[
				'module' => 'master', 'submodule' => 'port', 'permission' => PERMISSION_PORT_DELETE,
				'description' => 'Delete port'
			],

            [
                'module' => 'master', 'submodule' => 'location', 'permission' => PERMISSION_LOCATION_VIEW,
                'description' => 'View location'
            ],
            [
                'module' => 'master', 'submodule' => 'location', 'permission' => PERMISSION_LOCATION_CREATE,
                'description' => 'Create new location'
            ],
            [
                'module' => 'master', 'submodule' => 'location', 'permission' => PERMISSION_LOCATION_EDIT,
                'description' => 'Edit location'
            ],
			[
				'module' => 'master', 'submodule' => 'location', 'permission' => PERMISSION_LOCATION_DELETE,
				'description' => 'Delete location'
			],

            [
                'module' => 'master', 'submodule' => 'vendor', 'permission' => PERMISSION_VENDOR_VIEW,
                'description' => 'View vendor'
            ],
            [
                'module' => 'master', 'submodule' => 'vendor', 'permission' => PERMISSION_VENDOR_CREATE,
                'description' => 'Create new vendor'
            ],
            [
                'module' => 'master', 'submodule' => 'vendor', 'permission' => PERMISSION_VENDOR_EDIT,
                'description' => 'Edit vendor'
            ],
			[
				'module' => 'master', 'submodule' => 'vendor', 'permission' => PERMISSION_VENDOR_DELETE,
				'description' => 'Delete vendor'
			],

            [
                'module' => 'master', 'submodule' => 'container-size', 'permission' => PERMISSION_CONTAINER_SIZE_VIEW,
                'description' => 'View container size'
            ],
            [
                'module' => 'master', 'submodule' => 'container-size', 'permission' => PERMISSION_CONTAINER_SIZE_CREATE,
                'description' => 'Create new container size'
            ],
            [
                'module' => 'master', 'submodule' => 'container-size', 'permission' => PERMISSION_CONTAINER_SIZE_EDIT,
                'description' => 'Edit container size'
            ],
			[
				'module' => 'master', 'submodule' => 'container-size', 'permission' => PERMISSION_CONTAINER_SIZE_DELETE,
				'description' => 'Delete container size'
			],

            [
                'module' => 'master', 'submodule' => 'container-type', 'permission' => PERMISSION_CONTAINER_TYPE_VIEW,
                'description' => 'View container type'
            ],
            [
                'module' => 'master', 'submodule' => 'container-type', 'permission' => PERMISSION_CONTAINER_TYPE_CREATE,
                'description' => 'Create new container type'
            ],
            [
                'module' => 'master', 'submodule' => 'container-type', 'permission' => PERMISSION_CONTAINER_TYPE_EDIT,
                'description' => 'Edit container type'
            ],
			[
				'module' => 'master', 'submodule' => 'container-type', 'permission' => PERMISSION_CONTAINER_TYPE_DELETE,
				'description' => 'Delete container type'
			],

            [
                'module' => 'master', 'submodule' => 'loading-category', 'permission' => PERMISSION_LOADING_CATEGORY_VIEW,
                'description' => 'View loading category'
            ],
            [
                'module' => 'master', 'submodule' => 'loading-category', 'permission' => PERMISSION_LOADING_CATEGORY_CREATE,
                'description' => 'Create new loading category'
            ],
            [
                'module' => 'master', 'submodule' => 'loading-category', 'permission' => PERMISSION_LOADING_CATEGORY_EDIT,
                'description' => 'Edit loading category'
            ],
			[
				'module' => 'master', 'submodule' => 'loading-category', 'permission' => PERMISSION_LOADING_CATEGORY_DELETE,
				'description' => 'Delete loading category'
			],

            [
                'module' => 'master', 'submodule' => 'marketing', 'permission' => PERMISSION_MARKETING_VIEW,
                'description' => 'View marketing'
            ],
            [
                'module' => 'master', 'submodule' => 'marketing', 'permission' => PERMISSION_MARKETING_CREATE,
                'description' => 'Create new marketing'
            ],
            [
                'module' => 'master', 'submodule' => 'marketing', 'permission' => PERMISSION_MARKETING_EDIT,
                'description' => 'Edit marketing'
            ],
			[
				'module' => 'master', 'submodule' => 'marketing', 'permission' => PERMISSION_MARKETING_DELETE,
				'description' => 'Delete marketing'
			],

            [
                'module' => 'master', 'submodule' => 'payment-type', 'permission' => PERMISSION_PAYMENT_TYPE_VIEW,
                'description' => 'View payment type'
            ],
            [
                'module' => 'master', 'submodule' => 'payment-type', 'permission' => PERMISSION_PAYMENT_TYPE_CREATE,
                'description' => 'Create new payment type'
            ],
            [
                'module' => 'master', 'submodule' => 'payment-type', 'permission' => PERMISSION_PAYMENT_TYPE_EDIT,
                'description' => 'Edit payment type'
            ],
			[
				'module' => 'master', 'submodule' => 'payment-type', 'permission' => PERMISSION_PAYMENT_TYPE_DELETE,
				'description' => 'Delete payment type'
			],

            [
                'module' => 'master', 'submodule' => 'consumable', 'permission' => PERMISSION_CONSUMABLE_VIEW,
                'description' => 'View consumable'
            ],
            [
                'module' => 'master', 'submodule' => 'consumable', 'permission' => PERMISSION_CONSUMABLE_CREATE,
                'description' => 'Create new consumable'
            ],
            [
                'module' => 'master', 'submodule' => 'consumable', 'permission' => PERMISSION_CONSUMABLE_EDIT,
                'description' => 'Edit consumable'
            ],
			[
				'module' => 'master', 'submodule' => 'consumable', 'permission' => PERMISSION_CONSUMABLE_DELETE,
				'description' => 'Delete consumable'
			],

            [
                'module' => 'master', 'submodule' => 'component-price', 'permission' => PERMISSION_COMPONENT_PRICE_VIEW,
                'description' => 'View component price'
            ],
            [
                'module' => 'master', 'submodule' => 'component-price', 'permission' => PERMISSION_COMPONENT_PRICE_CREATE,
                'description' => 'Create new component price'
            ],
            [
                'module' => 'master', 'submodule' => 'component-price', 'permission' => PERMISSION_COMPONENT_PRICE_EDIT,
                'description' => 'Edit component price'
            ],
			[
				'module' => 'master', 'submodule' => 'component-price', 'permission' => PERMISSION_COMPONENT_PRICE_DELETE,
				'description' => 'Delete component price'
			],


            [
                'module' => 'pricing', 'submodule' => 'calculator', 'permission' => PERMISSION_PRICING_CALCULATE,
                'description' => 'Calculate service price'
            ],
            [
                'module' => 'pricing', 'submodule' => 'quotation', 'permission' => PERMISSION_QUOTATION_VIEW,
                'description' => 'Create new quotation'
            ],
            [
                'module' => 'pricing', 'submodule' => 'quotation', 'permission' => PERMISSION_QUOTATION_CREATE,
                'description' => 'Create new quotation'
            ],
            [
                'module' => 'pricing', 'submodule' => 'quotation', 'permission' => PERMISSION_QUOTATION_EDIT,
                'description' => 'Edit quotation data'
            ],
            [
                'module' => 'pricing', 'submodule' => 'quotation', 'permission' => PERMISSION_QUOTATION_DELETE,
                'description' => 'Delete quotation data'
            ],

            [
                'module' => 'report', 'submodule' => 'service', 'permission' => PERMISSION_REPORT_SERVICE_COMBINATION_VIEW,
                'description' => 'Report service combination'
            ],
            [
                'module' => 'report', 'submodule' => 'service', 'permission' => PERMISSION_REPORT_PACKAGE_COMBINATION_VIEW,
                'description' => 'Report package combination'
            ],
            [
                'module' => 'report', 'submodule' => 'pricing', 'permission' => PERMISSION_REPORT_PAYMENT_MARGIN_VIEW,
                'description' => 'Report payment margin'
            ],
            [
                'module' => 'report', 'submodule' => 'pricing', 'permission' => PERMISSION_REPORT_CONSUMABLE_PRICING_VIEW,
                'description' => 'Report consumable pricing'
            ],
            [
                'module' => 'report', 'submodule' => 'pricing', 'permission' => PERMISSION_REPORT_COMPONENT_PRICING_VIEW,
                'description' => 'Report component price'
            ],

        ]);

        echo '--Seeding Migration_Seed_initial_role_permission' . PHP_EOL;
    }

    public function down()
    {
        $this->db->delete('prv_permissions', ['module' => 'setting']);
        $this->db->delete('prv_permissions', ['module' => 'privilege']);
        $this->db->delete('prv_permissions', ['module' => 'master']);
        $this->db->delete('prv_permissions', ['module' => 'pricing']);
        $this->db->delete('prv_permissions', ['module' => 'report']);
        echo 'Rollback Migration_Seed_initial_role_permission' . PHP_EOL;
    }
}
