<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/2
 * Time: 20:56
 */

use Common\Mdb;

class baseModel{
    protected $db;
    public function __construct(){
        $config = Yaf\Application::app()->getConfig()->db;
        $this->db = Mdb::getInstance($config);
    }

    public function __destruct(){
        $row=$this->db->close();
    }
}