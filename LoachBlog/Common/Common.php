<?php


class Common {
	

	/**
	* 词义化时间
	* 
	* @access public
	* @param string $from 起始时间
	* @param string $now 终止时间
	* @return string
	*/
	public static function dateWord($from, $now)
	{
		//fix issue 3#6 by saturn, solution by zycbob		
		/** 如果不是同一年 */
        if (idate('Y', $now) != idate('Y', $from)) 
        {
            return date('Y年m月d日', $from);
        }
		
		/** 以下操作同一年的日期 */
		$seconds = $now - $from;
        $days = idate('z', $now) - idate('z', $from);
        
        /** 如果是同一天 */
        if ($days == 0) 
        {
        	/** 如果是一小时内 */
            if ($seconds < 3600) 
            {
            	/** 如果是一分钟内 */
                if ($seconds < 60)
                {
                    if (3 > $seconds) 
                    {
                        return '刚刚';
                    } 
                    else 
                    {
                        return sprintf('%d秒前', $seconds);
                    }
                }

                return sprintf('%d分钟前', intval($seconds / 60));
            }

            return sprintf('%d小时前', idate('H', $now) - idate('H', $from));
        }

		/** 如果是昨天 */
        if ($days == 1) 
        {
            return sprintf('昨天 %s', date('H:i', $from));
        }
        
        /** 如果是前天 */
        if ($days == 2) 
        {
        	return sprintf('前天 %s', date('H:i', $from));
        }

        /** 如果是7天内 */
        if ($days < 7) 
        {
            return sprintf('%d天前', $days);
        }

        /** 超过一周 */
        return date('n月j日', $from);
	}
	
	
	/**
	 * 
	 * @param $id 文章编号
	 */
	public static function encryptUrl($id)
	{
	   $key="zhangbailongloachblog";
	   return rawurlencode(base64_encode(trim($id))).md5(trim($key));	    
	}
	
	/**
	 * 
	 * @param $id 文章编号
	 */
	public static function decryptUrl($id)
	{
		$key="zhangbailongloachblog";
		$md5Str=md5(trim($key));
		$jiemiStr=str_replace($md5Str,'',trim($id));
	    return base64_decode(rawurldecode($jiemiStr));
	}
	
	/**
	 * 解密 中文乱码（UTF-8）
	 * @param $str
	 */
	public static function unescape($str) 
	{  
	    $str = rawurldecode ( $str );  
	    preg_match_all ( "/%u.{4}|&#x.{4};|&#\d+;|.+/U", $str, $r );  
	    $ar = $r [0];  
	    foreach ( $ar as $k => $v ) {  
	        if (substr ( $v, 0, 2 ) == "%u")  
	            $ar [$k] = iconv ( "UCS-2", "GBK", pack ( "H4", substr ( $v, - 4 ) ) );  
	        elseif (substr ( $v, 0, 3 ) == "&#x")  
	            $ar [$k] = iconv ( "UCS-2", "GBK", pack ( "H4", substr ( $v, 3, - 1 ) ) );  
	        elseif (substr ( $v, 0, 2 ) == "&#") {  
	            $ar [$k] = iconv ( "UCS-2", "GBK", pack ( "n", substr ( $v, 2, - 1 ) ) );  
	        }  
	    }  
	    return join ( "", $ar );  
    }  
    
    /**
     * 加密（将中文编码）
     * @param $str
     */
    public static function escape($str) 
    {  
	    $sublen = strlen ( $str );  
	    $retrunString = "";  
	    for($i = 0; $i < $sublen; $i ++) {  
	        if (ord ( $str [$i] ) >= 127) {  
	            $tmpString = bin2hex ( iconv ( "gb2312", "ucs-2", substr ( $str, $i, 2 ) ) );  
	            $retrunString .= "%u" . $tmpString;  
	            $i ++;  
	        } else {  
	            $retrunString .= "%" . dechex ( ord ( $str [$i] ) );  
	        }  
	    }  
	    return $retrunString;  
     }


     /**
      * base64加密
      * Enter description here ...
      * @param $word
      */
     public static function base_Jia($word)
     {
         return base64_encode($word);
     }
     
     /**
      * base64解密
      * Enter description here ...
      * @param unknown_type $word
      */
     public static function base_Jie($word)
     {
        return base64_decode($word);
     }

     /**
      * 获取客户端真实IP地址
      */
     public static function get_ip()
     {
        $CI =& get_instance();
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
            $ip=$_SERVER['HTTP_CLIENT_IP']; 
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR']; 
         }else { 
            $ip=$_SERVER['REMOTE_ADDR']; 
         } 
        return $ip;
     }

	

}