<?php

/**
 * 笔记信息类
 */
class Api_Articles extends PhalApi_Api{


    public function getRules()
    {
         return  array(
              //获取最新的10条笔记
             'getArticlesTen'=>array(),
             // 获取所有笔记并分页
             'getAllArticles'=>array(
                'pageNum'=>array('name'=>'pageNum','type'=>'int','min'=>1,'require'=>true),
             ),
             //获取笔记分类和相关笔记总数
             'getArticlesCategory'=>array(),
             //根据笔记分类获取笔记并分页
             'getArticlesByCategory'=>array(
                'categoryName'=>array('name'=>'categoryName','type'=>'string','require'=>true),
                'pageNum'=>array('name'=>'pageNum','type'=>'int','min'=>1,'require'=>true),
             ),
             //获取所有笔记的tag并分页
             'getArticlesTags'=>array(
               'pageNum'=>array('name'=>'pageNum','type'=>'int','min'=>1,'require'=>true),
             ),
             //根据tag获取笔记并分页
             'getArticlesByTagName'=>array(
               'tagName'=>array('name'=>'tagName','type'=>'string','require'=>true),
               'pageNum'=>array('name'=>'pageNum','type'=>'int','min'=>1,'require'=>true),
             ),
             
         );
    }
    
    /**
     * 获取10条最新的笔记
     * @desc 按时间排序获取最新的10条笔记
     */
    public function getArticlesTen()
    {
       $rs=array('code'=>0,'msg'=>'拉取到最新的10条笔记！','list'=>array());
       $domain=new Domain_Articles();
       $list=$domain->getArticlesTen();
       if(empty($list))
       {
          DI()->logger->debug('没有数据');
          $rs['code']=1;
          $rs['msg']=T('系统正在更新....');
          return $rs;
       }
       $rs['list']=$list;
       return $rs;
    }
    
    /**
     * 获取所有的笔记并分页
     * @desc 获取所有的笔记并分页
     */
    public function getAllArticles()
    {
       $offset=0; //偏移量
       $num=10; //每页显示10条数据
       $rs=array('code'=>0,'msg'=>'已经为您拉取到第'.$this->pageNum.'页的所有笔记。','list'=>array());
       $domain=new Domain_Articles();
       //获取笔记总数
       $count=$domain->getAllArticlesCount();
       if($count==0)
       {
          DI()->logger->debug('没有获取到笔记总数。');
          $rs['code']=1;
          $rs['msg']=T('系统正在更新....');
          return $rs;
       }
       
       //根据笔记总数和每页显示数，得出分页总数（笔记总数/每页显示条数,有余数就进一）
       $allPageNum=ceil($count/$num);
       //客户的提供的页码数
       $clientPageNum=$this->pageNum;
  
       if($clientPageNum>$allPageNum||$clientPageNum<=0)
       {
          DI()->logger->debug('客户的页码数过大或者小于0。');
          $rs['code']=1;
          $rs['msg']=T('pageNum必须在1-'.$allPageNum.'之间!');
          return $rs;
       }
       //求出页码的偏移量
       $offset=($clientPageNum-1)*$num;
       $rs['list']=$domain->getAllArticles($offset,$num);
       return $rs;
    }
    
    /**
     * 获取笔记的分类
     * @desc 获取笔记的分类和相关分类的笔记总数
     */
    public function getArticlesCategory()
    {

       $rs=array('code'=>0,'msg'=>'','list'=>array());
       $domain=new Domain_Articles();
       $list=$domain->getArticlesCategory();
       if(empty($list))
       {
          $rs['code']=1;
          $rs['msg']='暂时没有数据！';
       }
       $rs['list']=$list;
       return $rs;
       
    }
    /**
     * 根据分类获取笔记
     * @desc 根据分类获取笔记并分页
     */
    public function getArticlesByCategory()
    {
       $offset=0; //偏移量
       $num=10; //每页显示10条数据
       $categoryName=trim($this->categoryName);
       $rs=array('code'=>0,'msg'=>'已经为您拉取到第'.$this->pageNum.'页的所有笔记。','list'=>array());
       $domain=new Domain_Articles(); 
       //获取分类名称列表
       $categoryNameArray=$domain->getCategoryNameArray();
       if(!in_array($categoryName,$categoryNameArray))
       {
          DI()->logger->debug('笔记分类名称不存在！');
          $rs['code']=1;
          $rs['msg']=T('笔记分类名称参考列表：'.implode(',',$categoryNameArray));
          return $rs;
       }     
       //获取笔记总数
       $count=$domain->getArticlesByCategoryCount($categoryName);
       if($count==0)
       {
          DI()->logger->debug('没有获取到笔记总数。');
          $rs['code']=1;
          $rs['msg']=T('系统正在更新....');
          return $rs;
       }       
       //根据笔记总数和每页显示数，得出分页总数（笔记总数/每页显示条数,有余数就进一）
       $allPageNum=ceil($count/$num);
       //客户的提供的页码数
       $clientPageNum=$this->pageNum;
  
       if($clientPageNum>$allPageNum||$clientPageNum<=0)
       {
          DI()->logger->debug('客户的页码数过大或者小于0。');
          $rs['code']=1;
          $rs['msg']=T('pageNum必须在1-'.$allPageNum.'之间!');
          return $rs;
       }
       //求出页码的偏移量
       $offset=($clientPageNum-1)*$num;
       $rs['list']=$domain->getArticlesByCategory($categoryName,$offset,$num);
       return $rs;
      
    }
    
    /**
     * 获取所有笔记不重复的tag并分页
     * @desc 获取不重复的tag并分页
     */
    public function getArticlesTags()
    {
       $offset=0; //偏移量
       $num=10; //每页显示10条数据
       $rs=array('code'=>0,'msg'=>'已经为您拉取到第'.$this->pageNum.'页的所有笔记。','list'=>array());
       $domain=new Domain_Articles();
       //获取笔记总数
       $count=$domain->getArticlesTagsCount();
       if($count==0)
       {
          DI()->logger->debug('没有获取到笔记tag的总数。');
          $rs['code']=1;
          $rs['msg']=T('系统正在更新....');
          return $rs;
       }
       
       //根据笔记总数和每页显示数，得出分页总数（笔记总数/每页显示条数,有余数就进一）
       $allPageNum=ceil($count/$num);
       //客户的提供的页码数
       $clientPageNum=$this->pageNum;
  
       if($clientPageNum>$allPageNum||$clientPageNum<=0)
       {
          DI()->logger->debug('客户的页码数过大或者小于0。');
          $rs['code']=1;
          $rs['msg']=T('pageNum必须在1-'.$allPageNum.'之间!');
          return $rs;
       }
       //求出页码的偏移量
       $offset=($clientPageNum-1)*$num;
       $rs['list']=$domain->getArticlesTags($offset,$num);
       return $rs;
    }
    
    /**
     * 根据标签名获取笔记
     * @desc 根据标签名获取笔记并分页
     */
    public function getArticlesByTagName()
    {
       $offset=0; //偏移量
       $num=10; //每页显示10条数据
       $tagName=trim($this->tagName);
       $rs=array('code'=>0,'msg'=>'已经为您拉取到第'.$this->pageNum.'页的所有笔记。','list'=>array());
       $domain=new Domain_Articles();     
       //获取笔记总数
       $count=$domain->getArticlesByTagNameCount($tagName);
       if($count==0)
       {
          DI()->logger->debug('没有知道'.$tagName.'的笔记总数。');
          $rs['code']=1;
          $rs['msg']=T('没有找到['.$tagName.']相关的笔记。');
          return $rs;
       }       
       //根据笔记总数和每页显示数，得出分页总数（笔记总数/每页显示条数,有余数就进一）
       $allPageNum=ceil($count/$num);
       //客户的提供的页码数
       $clientPageNum=$this->pageNum;
  
       if($clientPageNum>$allPageNum||$clientPageNum<=0)
       {
          DI()->logger->debug('客户的页码数过大或者小于0。');
          $rs['code']=1;
          $rs['msg']=T('pageNum必须在1-'.$allPageNum.'之间!');
          return $rs;
       }
       //求出页码的偏移量
       $offset=($clientPageNum-1)*$num;
       $rs['list']=$domain->getArticlesByTagName($tagName,$offset,$num);
       return $rs;
    }
    
    
    

}