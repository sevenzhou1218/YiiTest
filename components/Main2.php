<?php
namespace app\components;


class Main2
{
    /* *
     * 找回密码的过期时间
     * 24小时
     * */
    const EXPIRED_TIME = 86400;

	/*
	 * 用户活跃状态
	 */
	const USER_ACTIVE_0 = 0 ;
	const USER_ACTIVE_1 = 1 ;
	/*
	 * 笑话显示状态
	 */
	const STORY_DISPLAY_YES = 0 ;
	const STORY_DISPLAY_NO = 1 ;
	/*
	 * 翻页每页数量
	 */
	const STORY_PER_PAGE = 50 ;

	public static function getIP()
	{
		if(getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else 
			$ip = '0.0.0.0';
		return $ip ;
		//return ip2long($ip) ;
	}

	/*
	 *  返回是否有更改个人信息
	 */
	public static function compareProfile($arr1,$arr2)
	{
		$key1 = array_diff($arr1,$arr2);
        $key2 = array_diff($arr2,$arr1);
        if(empty($key1) && empty($key2)){
            return true;
        }else{
            return false;
        }
	}

	/*
	 *
	 */
	public static function inputPost($arr)
	{
		$newArr = array();
		foreach ($arr as $key=>$val){
			$newArr[$key] = addslashes(trim($val));
		}
		return $newArr ;
	}



//END
}
