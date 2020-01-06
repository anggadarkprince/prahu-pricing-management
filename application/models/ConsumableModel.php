<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsumableModel extends App_Model
{
    protected $table = 'ref_consumables';

    const TYPE_PACKAGING = 'PACKAGING';
    const TYPE_ACTIVITY_DURATION = 'ACTIVITY DURATION';
}
