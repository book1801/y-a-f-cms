<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/1
 * Time: 23:14
 */

class appModel extends baseModel{
    //获取指定Id的app
    public function getApp($id,$allInfo=false){
        if($allInfo){
            $sql="select a.*,ac.category as appcategory,c.category as articlecategory from app as a,appcategory as ac ,articlecategory as c where a.appcategoryid=ac.id and a.categoryid=c.id and a.id=".$id;
        }else{
            $sql="select * from app where id=".$id;
        }
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取文章右侧栏文章列表（内链优化)
    public function getAppBar($id,$listcount){
        $startid=$id - 5 > 0 ? $id -5:0;
        $sql="select * from app where id<>".$id." and id>".$startid." order by id asc limit ".$listcount;
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取APP列表
    public function getAppList($where="status=1",$orderby="pubdate",$desc="desc",$start=0,$limit=10){
        $sql="select * from app ";
        if($where)  $sql=$sql." where ".$where;
        if($orderby) $sql=$sql." order by ".$orderby." ".$desc;
        $sql=$sql." limit ".$start." , ".$limit;

        $row=$this->db->fetchAll($sql);
        //print_r($sql);
        return $row;
    }

    //获取指定条件的App总数
    public function getAppCount($where="status=1"){
        $sql="select count(*) from app";
        if($where){
            $sql=$sql." where ".$where;
        }

        $count=$this->db->fetchOne($sql);
        return $count;
    }

    //获取多条件查询总数
    public function getAppFilterCount($status,$appcategoryid,$categoryid){
        $sql="select count(*) as mycount from app ";
        if(($status <>2) || ($appcategoryid >0) || ($categoryid>0)){
            $q_str="";
            if($status <> 2){
                $q_str=$q_str." status=".$status;
            }

            if($appcategoryid > 0){
                if($q_str<>""){
                    $q_str=$q_str." and appcategoryid=".$appcategoryid;
                }else{
                    $q_str=$q_str." appcategoryid=".$appcategoryid;
                }
            }

            if($categoryid > 0){
                if($q_str<>""){
                    $q_str=$q_str." and categoryid=".$categoryid;
                }else{
                    $q_str=$q_str." categoryid=".$categoryid;
                }
            }
            $sql=$sql." where ".$q_str;
        }

        $row=$this->db->fetchOne($sql);
        return $row;
    }
    
    //获取APP的详细列表包括关联表
    public function getAppInfoList($status=1,$appcategoryid=0,$categoryid=0,$orderby="updated",$desc="desc",$start=0,$limit=10){
        $sql="select a.*,ac.category as appcategory,c.category as articlecategory from app as a,appcategory as ac ,articlecategory as c where a.appcategoryid=ac.id and a.categoryid=c.id ";
        if ($status){
            $sql=$sql." and ".$status;
        }

        if($appcategoryid>0){
            $sql=$sql." and a.appcategoryid=".$appcategoryid;
        }

        if($categoryid > 0){
            $sql=$sql." and a.categoryid=".$categoryid;
        }

        if (empty($orderby)==false){
            $sql=$sql." order by ".$orderby." ".$desc;
        }

        if($start >= 0){
            $sql=$sql." limit ".$start.",".$limit;
        }

        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //保存一个应用
    public function addApp($bind){
        $row=$this->db->insert("app",$bind);
        return $row;
    }

    //修改一个应用
    public function editApp($bind,$where){
        $r=$this->db->update("app",$bind,$where);
        return $r;
    }

    //删除一个应用
    public function delApp($id){
        $r=$this->db->delete("app","id=".$id);
        return $r;
    }

}