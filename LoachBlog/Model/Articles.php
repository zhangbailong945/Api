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
     * 获取笔记分类列表
     */
    public function getCategoryNameArray()
    {
      $list=array();	
      $sql="select at.article_type_id as category_id,at.article_type_name as category_name from article_type as at where at.article_type_category='category'";
      $data=$this->getORM()->queryRows($sql);
      foreach ($data as $row)
      {
         $list[]=$row['category_name'];
      }
      return $list;
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
    
    /**
     * 根据分类名称获取笔记总数
     * @param $categoryName 笔记分类名称
     */
    public function getArticlesByCategoryCount($categoryName)
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' and at.article_type_name=:CATEGORY_NAME order by a.article_created desc";
       $params=array(':CATEGORY_NAME'=>$categoryName);
       $data=$this->getORM()->queryRows($sql,$params);
       return count($data);
    }
    
    /**
     * 
     * 根据笔记分类名称获取笔记并分页
     * @param string $categoryName 分类名称
     * @param int $offset 偏移量
     * @param int $num 每页显示数量
     */
    public function getArticlesByCategory($categoryName,$offset,$num)
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='category' and at.article_type_name=:CATEGORY_NAME order by a.article_created desc limit :OFFSET,:NUM";             
       $params=array(':CATEGORY_NAME'=>$categoryName,':OFFSET'=>$offset,':NUM'=>$num);       
       return $this->getORM()->queryRows($sql,$params);
    }
    
    /**
     * 获取不重复的tag总数
     */
    public function getArticlesTagsCount()
    {
       $sql="select distinct at.article_type_name as tag_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='tag' order by a.article_created desc";
       $data=$this->getORM()->queryRows($sql);
       return count($data);
    }
    
    /**
     * 获取所有笔记tag并分页
     * @param int $offset
     * @param int $num
     */
    public function getArticlesTags($offset,$num)
    {
       $sql="select distinct at.article_type_name as tag_name  from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='tag' order by a.article_created desc limit :OFFSET,:NUM";             
       $params=array(':OFFSET'=>$offset,':NUM'=>$num);       
       return $this->getORM()->queryRows($sql,$params);
    }
    
    /**
     * 根据标签名获取笔记总数
     * @param string $tagName 标签名
     */
    public function getArticlesByTagNameCount($tagName)
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='tag' and at.article_type_name=:TAG_NAME order by a.article_created desc";
       $params=array(':TAG_NAME'=>$tagName);
       $data=$this->getORM()->queryRows($sql,$params);
       return count($data);
    }
    
    /**
     * 根据标签名称获取笔记并分页
     * @param $tagName 标签名
     * @param $offset 偏移量
     * @param $num 每页显示数量
     */
    public function getArticlesByTagName($tagName,$offset,$num)
    {
       $sql="select a.article_id as id,article_title as title,a.article_slug as tgas,a.article_created as unix_time,a.article_text as content,at.article_type_id as type_id,at.article_type_name as type_name from articles as a inner join relationships as rs on a.article_id=rs.article_id inner join article_type as at on at.article_type_id=rs.article_type_id and at.article_type_category='tag' and at.article_type_name=:TAG_NAME order by a.article_created desc limit :OFFSET,:NUM";             
       $params=array(':TAG_NAME'=>$tagName,':OFFSET'=>$offset,':NUM'=>$num);       
       return $this->getORM()->queryRows($sql,$params);
    }
    
    
}