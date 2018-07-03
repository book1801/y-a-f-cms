<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 23:50
 */
class conversionModel extends baseModel{
    public  function getConversion($controller,$action,$paraid=0){
        if($paraid==0){
            $sql="select * from conversion where controller='".$controller."' and action='".$action."' order by indexorder desc";
        }else{
            $sql="select * from conversion where controller='".$controller."' and action='".$action."' and paraid='".$paraid."' order by indexorder desc";
        }
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取转化记录
    public function getPartConversion($id=0){
        if($id==0){
            $sql="select * from conversion";
        }else{
            $sql="select * from conversion where id=".$id;
        }

        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //添加一条转化记录
    public function addConversion($bind){
        $r=$this->db->insert("conversion",$bind);
        return $r;
    }

    //修改转化记录
    public function editConversion($bind,$where){
        $r=$this->db->update("conversion",$bind,$where);
        return $r;
    }

    //删除一条转化记录
    public function delConversion($id){
        $r=$this->db->delete("conversion","id=".$id);
        return $r;
    }
}