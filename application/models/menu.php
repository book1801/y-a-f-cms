<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/2
 * Time: 20:53
 */
use Common\Mdb;

class menuModel extends baseModel{
    //获取菜单
    public function getMenu(){
        $row = $this->db->fetchAll('select * from `menu` order by indexorder asc');
        return $row;
    }

    //获取一个菜单项
    public function getOneMenu($id){
        $row=$this->db->fetchAll("select * from menu where id=".$id);
        return $row[0];
    }

    //添加一个菜单
    public function addMenu($bind){
        $res=$this->db->insert('menu',$bind);
        return $res;
    }

    //修改一个菜单
    public function updateMenu($bind,$where){
        $res=$this->db->update('menu',$bind,$where);
        return $res;
    }
    
    //删除一个菜单
    public function delMenu($id){
        $r=$this->db->delete('menu','id='.$id);
        return $r;
    }
    

}