<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Dashboard
 */
class Dashboard extends App_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->render('dashboard/index');
    }
}
