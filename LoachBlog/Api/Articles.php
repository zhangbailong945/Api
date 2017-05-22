<?php

/**
 * 笔记信息类
 */
class Api_Articles extends PhalApi_Api{

	/**
	 * 编写规则
	 * @see PhalApi/PhalApi_Api::getRules()
	 */
    public function getRules()
    {
         return  array(
             /**
              * 获取最新的10条笔记
              */
             'getArticlesTen'=>array(
         
             ),
         );
    }
    
    /**
     * 获取10条最新的笔记
     */
    public function getArticlesTen()
    {
       $rs=array('code'=>0,'msg'=>'拉取到最新的10条笔记！','list'=>array());
       $domain=new Domain_Articles();
       $list=$domain->getArticlesTen();
       if(empty($list))
       {
          DI()->logger->debug('user not found');
          $rs['code']=1;
          $rs['msg']=T('系统正在更新....');
          return $rs;
       }
       $rs['list']=$list;
       return $rs;
    }

}