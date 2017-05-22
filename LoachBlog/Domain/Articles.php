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
}