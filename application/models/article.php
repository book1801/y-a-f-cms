<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/10
 * Time: 18:57
 */

class articleModel extends baseModel{
    //获取置顶文章列表
    public function getRecommendArticle($categoryid=0,$listcount){
        $sql="";
        if($categoryid==0){
            $sql="select * from article order by recommend desc limit 0,".intval($listcount);
        }else{
            $sql="select * from article where catid=".intval($categoryid)." ordr by recommend desc limit 0,".intval($listcount);
        }
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取文章列表，翻页
    public function getArticleList($categoryid,$page,$pagecount){
        $page=$page > 0?$page:1;
        $start=($page - 1) * $pagecount;
        $sql="";
        if($categoryid==0){
            $sql="select * from article  order by updated desc limit ".$start.",".$pagecount;
        }else{
            $sql="select * from article where catid=".$categoryid." order by updated desc limit ".$start.",".$pagecount;
        }
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取某个文章
    public function getArticle($id){
        $sql="select * from article where id=".$id;
        $row=$this->db->fetchAll($sql);
        return $row[0];
    }

    //获取文章右侧栏文章列表（内链优化)
    public function getArticleBar($id,$listcount){
        $startid=$id - 5 > 0 ? $id -5:0;
        $sql="select * from article where id<>".$id." and id>".$startid." order by id asc limit ".$listcount;
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取文章总数  翻页用
    public function getArticleListCount($categoryid){
        $sql="select count(*) as mycount from article ";
        if($categoryid > 0){
            $sql=$sql." where catid=".$categoryid;
        }


        $row=$this->db->fetchOne($sql);
        return $row;
    }

    //获取文章全部信息，包括跨表关联
    public function getArticleInfoAllList($categoryid,$start,$limit){
        $sql="select a.*,c.category from article as a,articlecategory as c where a.catid=c.id ";
        if($categoryid > 0){
            $sql=$sql." and a.catid=".$categoryid;
        }
        $sql=$sql." limit ".$start.",".$limit;


        $row=$this->db->fetchAll($sql);
        return $row;
    }


    //翻页
    public function getArticlePlayPage($categoryid,$pagecount){
        $sql="select count(*) as mycount from article where catid=".$categoryid;
        $r=$this->db->fetchOne($sql);
        $count=$r[0];
        $pages=ceil($count/$pagecount);
        $arr=array();
        for($i=1;$i<=$pages;$i++){
            $arr[]=array("page"=>$i,"link"=>\Until\Url::createurl("article","list",["categoryid"=>$categoryid,"page"=>$i]));
        }

        return $arr;
    }

    //搜索一个文章或分类文章
    public function searchArticle($categoryid,$searchword){
        $sql="select a.*,c.category from article as a,articlecategory as c where a.catid=c.id ";
        if($categoryid >0){
            $sql=$sql." and a.catid=".$categoryid;
        }

        if($searchword<>""){
            $sql=$sql." and a.title like '%".$searchword."%'";
        }
        //print_r($sql);die();
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取搜索结果总数
    public function searchArticleCount($categoryid,$searchword){
        $sql="select count(*) from article ";
        if($categoryid >0){
            if($searchword<>""){
                $sql=$sql." where catid=".$categoryid;
            }else{
                $sql=$sql." where catid=".$categoryid ." and title like '%".$searchword."%'";
            }
        }else{
            if($searchword<>""){
                $sql=$sql." where catid=".$categoryid;
            }
        }

        $row=$this->db->fetchOne($sql);
        return $row;
    }

    //添加一篇文章
    public function addArticle($bind){
        $r=$this->db->insert("article",$bind);
        return $r;
    }

    //修改一篇文章
    public function editArticle($bind,$where){
        $r=$this->db->update("article",$bind,$where);
        return $r;
    }

    //删除一篇文章
    public function delArticle($id){
        $r=$this->db->delete("article","id=".$id);
        return $r;
    }
}