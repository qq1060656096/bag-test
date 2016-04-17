<?php
namespace common\z;
/**
 * cache name
 *
 *
 */
class ZCache{
    /**
     * 首页缓存变量
     * @var string
     */
    const HOME_PAGE_HOT = 'home_page_hot';
    const HOME_PAGE_NEW = 'home_page_new';
    /**
     * 缓存时间
     * @var integer
     */
    const HOME_PAGE_TIMEOUT = 30;

    /**
     * 回答页面缓存
     * @var string
     */
    const ANSWER_PAGE = 'anser_page';
    /**
     * 缓存时间
     * @var integer
     */
    const ANSWER_PAGE_TIMEOUT = 30;

    /**
     * 数组转key
     * @param array $array
     * @return string
     */
    static function array_to_key($array){
        $key = md5(serialize( $array ));
        return $key;
    }


}