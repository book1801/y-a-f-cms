<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/12
 * Time: 19:20
 */
class appcategoryModel extends baseModel{
    //获取一个或全部app分类
    public function getCategory($id=0){
        $sql="";
        if($id==0){
            $sql="select * from appcategory order by indexorder desc";
        }else{
            $sql='select * from appcategory where id='.$id.' order by indexorder desc';
        }

        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //添加一个新分类
    public function addCategory($bind){
        $r=$this->db->insert("appcategory",$bind);
        return $r;
    }

    //修改一个分类
    public function editCategory($bind,$where){
        $r=$this->db->update('appcategory',$bind,$where);
        return $r;
    }

    //删除一个分类
    public function delCategory($id){
        $r=$this->db->delete('appcategory',"id=".$id);
        return $r;
    }
}