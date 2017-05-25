<?php


/**
 * 笔记的业务逻辑
 */

class Domain_Articles{
	
	   /**
	    * 获取最新的10条笔记
	    */
       public function getArticlesTen()
       {

       	  $list=array();
          $model=new Model_Articles();
          $list=$model->getArticlesTen();
          return $list;
       }
       
       /**
        * 获取所有笔记并分页
        * @param $offset
        * @param $num
        */
       public function getAllArticles($offset,$num)
       {
          $list=array();
          $model=new Model_Articles();
          $list=$model->getAllArticles($offset,$num);
          return $list;
       }
       
       /**
        * 获取所有笔记的总数
        */
       public function getAllArticlesCount()
       {
         $model=new Model_Articles();
         $count=$model->getAllArticlesCount();
         return $count;
       }
       
       /**
        * 获取笔记分类和分类的总数
        */
       public function getArticlesCategory()
       {
         $model=new Model_Articles();
         $list=$model->getArticlesCategory();
         return $list;
       }
       
       /**
        * 获取笔记分类名称列表
        */
       public function getCategoryNameArray()
       {
         $model=new Model_Articles();
         return $model->getCategoryNameArray();
       }
       
       /**
        * 根绝笔记分类名称获取笔记总数
        * @param $categoryName 分类名称
        */
       public function getArticlesByCategoryCount($categoryName)
       {
         $model=new Model_Articles();
         $count=$model->getArticlesByCategoryCount($categoryName);
         return $count;
       }
       
       /**
        * 根据笔记分类名称获取笔记并分页
        * @param $categoryName 分类名称
        * @param $offset 偏移量
        * @param $num 每页显示数量
        */
       public function getArticlesByCategory($categoryName,$offset,$num)
       {
          $list=array();
          $model=new Model_Articles();
          $list=$model->getArticlesByCategory($categoryName,$offset,$num);
          return $list;
       }
       
       /**
        * 获取所有笔记的tags
        */
       public function getArticlesTagsCount()
       {
         $model=new Model_Articles();
         $count=$model->getArticlesTagsCount();
         return $count;
       }
       /**
        * 获取笔记tags并分页
        * @param int $offset
        * @param int $num
        */    
       public function getArticlesTags($offset,$num)
       {
          $list=array();
          $model=new Model_Articles();
          $list=$model->getArticlesTags($offset,$num);
          return $list;
       }
       
       /**
        *根据标签名获取相关笔记总数
        * @param $tagName 标签名
        */
       public function getArticlesByTagNameCount($tagName)
       {
         $model=new Model_Articles();
         $count=$model->getArticlesByTagNameCount($tagName);
         return $count;
       }
       
       /**
        * 根据标签名获取相关笔记并分页
        * @param string $tagName 标签名
        * @param int $offset 偏移量
        * @param int $num 每页显示数量
        */
       public function getArticlesByTagName($tagName,$offset,$num)
       {
          $list=array();
          $model=new Model_Articles();
          $list=$model->getArticlesByTagName($tagName,$offset,$num);
          return $list;
       }
}