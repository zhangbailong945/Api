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

       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' order by a.article_created desc limit :OFFSET,:NUM";
       $params=array(':OFFSET'=>$offset,':NUM'=>$num);
       return $this->getORM()->queryRows($sql,$params);
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
    
    /**
     * 获取笔记分类和分类总数
     */
    public function getArticlesCategory()
    {
      $list=array();	
      $sql="select at.article_type_id as category_id,at.article_type_name as category_name from article_type as at where at.article_type_category='category'";
      $data=$this->getORM()->queryRows($sql);
      foreach ($data as $row)
      {
         $list[]=array(
          'category_id'=>$row['category_id'],
          'category_name'=>$row['category_name'],
          'categroy_count'=>$this->getArticlesCountByCategory($row['category_id'])
         );
      }
      return $list;
    }
    
    /**
     * 根据笔记的类型ID获取笔记总数
     * @param $category_id 笔记分类ID
     */
    public function getArticlesCountByCategory($category_id)
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' and at.article_type_id=:CATEGORY_ID order by a.article_created desc";
       $params=array(':CATEGORY_ID'=>$category_id);
       $data=$this->getORM()->queryRows($sql,$params);
       return count($data);
    }
    
    
    
    
    
}