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
       return $this->getORM()
            ->select('*')
            ->where('1=1')
            ->order('article_created')
            ->limit(10)
            ->fetchAll();
    }
}