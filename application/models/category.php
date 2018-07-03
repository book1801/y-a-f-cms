<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 18:18
 */

class categoryModel extends baseModel{
    //获取一个分类
    public function getCategory($categoryid){
        $sql="select * from articlecategory where id=".intval($categoryid);
        $row=$this->db->fetchAll($sql);
        return $row[0];
    }

    //获取所有分类
    public function getAllCategory(){
        $sql="select * from articlecategory order by indexorder asc";
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //添加一个分类
    public function addCategory($bind){
        $row=$this->db->insert("articlecategory",$bind);
        return $row;
    }

    //修改一个分类
    public function editCategory($bind,$where){
        $r=$this->db->update("articlecategory",$bind,$where);
        return $r;
    }

    //删除一个分类
    public function delCategory($id){
        $r=$this->db->delete("articlecategory","id=".$id);
        return $r;
    }
}