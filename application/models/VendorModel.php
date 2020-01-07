<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VendorModel extends App_Model
{
    protected $table = 'ref_vendors';

    const TYPE_SHIPPING_LINE = 'SHIPPING LINE';
    const TYPE_TRUCKING = 'TRUCKING';
}
