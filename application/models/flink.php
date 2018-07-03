<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/16
 * Time: 23:15
 */
class flinkModel extends baseModel{
    //获取友情链接
    public function getFlink($status=true){
        if($status){
            $sql="select * from flink where status='1' order by indexorder desc";
        }else{
            $sql="select * from flink order by indexorder desc";
        }

        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取一条或多条友情链接
    public function getPartFlink($id=0){
        if($id){
            $sql="select * from flink where id=".$id;
        }else{
            $sql="select * from flink order by indexorder desc";
        }

        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //添加一条友情链接
    public function addFlink($bind){
        $r=$this->db->insert("flink",$bind);
        return $r;
    }

    //修改一条友情链接
    public function editFlink($bind,$where){
        $r=$this->db->update("flink",$bind,$where);
        return $r;
    }

    //删除一条友情链接
    public function delFlink($id){
        $r=$this->db->delete("flink","id=".$id);
        return $r;
    }
}