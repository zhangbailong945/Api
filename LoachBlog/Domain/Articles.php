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
}