<?php
/**
 * 笔记信息数据库访问层
 */

class Model_Articles extends PhalApi_Model_NotORM{
	/**
	 * 获取最新的10条笔记
	 */
    public function getArticlesTen()
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' order by a.article_created desc limit 0,10";
       return $this->getORM()->queryRows($sql);
    }
    
    /**
     * 获取所有的笔记并分页
     */
    public function getAllArticles($offset,$num)
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' order by a.article_created desc limit 0,10";
       return $this->getORM()->queryRows($sql);
    }
    
    /**
     * 获取所有笔记的总数
     */
    public function getAllArticlesCount()
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' order by a.article_created desc";
       $data=$this->getORM()->queryRows($sql);
       return count($data);
    }
    
    
    
}