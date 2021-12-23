<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developer extends Onhacker_controller {
	function __construct(){
		parent::__construct();
	}

	function index(){
        echo "
        * @Engine   CodeIgniter<br>
        * @Database Mysqli<br>
        * @author   Baso Irwan Sakti<br>
        * @license  Onhacker<br>
        * @link     https://siimut-lutim.com<br>
        * @since    Version 1.0.0<br>
        * @filesource<br>
        ";
    }

	
}
