<?php
/**
 * Created by PhpStorm.
 * User: mybook
 * Date: 2018/6/14
 * Time: 19:19
 */
class commentModel extends baseModel{
    //获取文章评论
    public function getArticleComment($articlid,$page,$limit){
        $start=($page -1) * $limit;
        $sql="select * from comment where type='ARTICLE' and typeid=".$articlid." and status='1' order by pubdate desc limit ".$start.",".$limit;
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取app评论
    public function getAppComment($appid,$page,$limit){
        $start=($page -1) * $limit;
        $sql="select * from comment where type='APP' and typeid=".$appid." and status='1' order by pubdate desc limit ".$start.",".$limit;
        $row=$this->db->fetchAll($sql);
        return $row;
    }

    //获取文章评论总数 翻页用
    public function getArticleCommentCount($articleid){
        $sql="select count(*) as mycount from comment where status='1' and type='ARTICLE' and typeid=".$articleid;
        $row=$this->db->fetchOne($sql);
        return $row;
    }

    //获取APP评论总数 翻页用
    public function getAppCommentCount($appid){
        $sql="select count(*) as mycount from comment where status='1' and type='APP' and typeid=".$appid;
        $row=$this->db->fetchOne($sql);
        return $row;
    }
}