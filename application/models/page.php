<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/16
 * Time: 21:42
 */
class pageModel extends baseModel{
    //获取一个page的所有内容
    public function getPage($name,$thisone=true){
        if($thisone){
            $sql="select * from page where name='".$name."'";
        }else{
            $sql="select * from page where name<>'".$name."'";
        }

        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取所有的Page
    public function getAllPage($start,$limit){
        $sql="select * from page limit ".$start.",".$limit;
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取Page总数
    public function getPageCount(){
        $sql="select count(*) from page";
        $r=$this->db->fetchOne($sql);
        return $r;
    }

    //基于ID获取一个PAGE
    public function getPageById($id){
        $sql="select * from page where id=".$id;
        $row=$this->db->fetchAll($sql);
        return $row[0];
    }

    //添加一个page
    public function addPage($bind){
        $r=$this->db->insert("page",$bind);
        return $r;
    }

    //修改一个page
    public function editPage($bind,$where){
        $r=$this->db->update("page",$bind,$where);
        return $r;
    }

    //删除一个page
    public function delPage($id){
        $r=$this->db->delete("page","id=".$id);
        return $r;
    }
}