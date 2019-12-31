<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RoleModel extends App_Model
{
    protected $table = 'prv_roles';

    const ROLE_ADMINISTRATOR = 'Administrator';

    const RESERVED_ROLES = [
        self::ROLE_ADMINISTRATOR
    ];

    /**
     * Get base query.
     *
     * @return CI_DB_query_builder
     */
    protected function getBaseQuery()
    {
		return parent::getBaseQuery()
			->select('COUNT(DISTINCT prv_role_permissions.id_permission) AS total_permission')
			->join('prv_role_permissions', 'prv_role_permissions.id_role = prv_roles.id', 'left')
			->group_by('prv_roles.id');
    }

}
