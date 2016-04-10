<?php
namespace common\z;
/**
*@version: 1.0
*@author simle
*@email  1060656096@qq.com
*星座constellation
*------------------------
水瓶座	(1.20~2.18)	Aquarius--[ə'kweriəs]
 双鱼座	(2.10~3.20)	Pisces--['pisi:z]
 白羊座	(3.21~4.19)	Aries--['ɛəri:z]
 金牛座	(4.20~5.20)	Taurus--['tɔ:rəs]
 双子座	(5.21~6.21)	Gemini--['dʒeminaɪ]
 巨蟹座	(6.22~7.22)	Cancer--['kænsə]
 狮子座	(7.23~8.22)	Leo--['li:əu]
 处女座	(8.23~9.22)	Virgo--['və:gəu]
 天秤座	(9.23~10.23)	Libra--['laibrə]
 天蝎座	(10.24~11.22)	Scorpio--['skɔ:piəu]
 射手座	(11.23~12.21)	Sagittarius--[,sædʒi'tɛəriəs]
 魔羯座	(12.22~1.19)	Capricorn--['kæprikɔ:n]
 */
class Constellation
{

    /**
     * get constellation list data
     *
     * @return array
     */
    public static function getConstellationList()
    {
        static $data = null;
        if (isset($data)) {
            return $data;
        }
        $data = array(
            '1' => array(
                'key'       => 1,
                'id'        => 'Aquarius',
                'name'      => '水瓶座',
                'start_date'=> '01-20',
                'end_date'  => '02-18'
            ),
            '2' => array(
                'key'       => 2,
                'id'        => 'Pisces',
                'name'      => '双鱼座',
                'start_date'=> '02-10',
                'end_date'  => '03-20'
            ),
            '3' => array(
                'key'       => 3,
                'id'        => 'Aries',
                'name'      => '白羊座',
                'start_date'=> '03-21',
                'end_date'  => '04-19'
            ),
            '4' => array(
                'key'       => 4,
                'id'        => 'Taurus',
                'name'      => '金牛座',
                'start_date'=> '04-20',
                'end_date'  => '05-20'
            ),
            '5' => array(
                'key'       => 5,
                'id'        => 'Gemini',
                'name'      => '双子座',
                'start_date'=> '05-21',
                'end_date'  => '06-21'
            ),
            '6' => array(
                'key'       => 6,
                'id'        => 'Cancer',
                'name'      => '巨蟹座',
                'start_date'=> '06-22',
                'end_date'  => '07-22'
            ),
            '7' => array(
                'key'       => 7,
                'id'        => 'Leo',
                'name'      => '狮子座',
                'start_date'=> '07-23',
                'end_date'  => '08-22'
            ),
            '8' => array(
                'key'       => 8,
                'id'        => 'Virgo',
                'name'      => '处女座',
                'start_date'=> '08-23',
                'end_date'  => '09-22'
            ),
            '9' => array(
                'key'       => 9,
                'id'        => 'Libra',
                'name'      => '天秤座',
                'start_date'=> '09-23',
                'end_date'  => '10-23'
            ),
            '10' => array(
                'key'       => 10,
                'id'        => 'Scorpio',
                'name'      => '天蝎座',
                'start_date'=> '10-24',
                'end_date'  => '11-22'
            ),
            '11' => array(
                'key'       => 11,
                'id'        => 'Sagittarius',
                'name'      => '射手座',
                'start_date'=> '11-23',
                'end_date'  => '12-21'
            ),
            '12' => array(
                'key'       => 12,
                'id'        => 'Capricorn',
                'name'      => '水瓶座',
                'start_date'=> '12-22',
                'end_date'  => '01-19'
            )
        );

        return $data;
    }

    /**
     *According to the date for the constellation
     *根据日期获取星座
     *@param string $date 日期Y-m-d(demo: 2016-08-06)
     *@return array
     */
    public static function getDateToConstellation($date)
    {
        $time   = strtotime($date);
        $year   = date('Y', $time);
        $month  = date('m', $time);
        $month  = intval($month);
        $day    = date('d', $time);
        $day    = intval($day);

        // get constellation list
        $date_constellation_list = self::getConstellationList();
        if( !isset( $date_constellation_list[$month] ) ){
            return null;
        }
        // 水瓶座 Capricorn
        if( ( $month == 1 && $day < 20 ) || ( $month == 12 && $day > 21 ) ){
            return $date_constellation_list[12];

        }else if( $month == 1 ){
            return $date_constellation_list[1];

        }else if( $month == 12 ){
            return $date_constellation_list[12];
        }
        //get process constellation list data
        $return = null;
        $start_date = $year.'-'.$date_constellation_list[$month]['start_date'];
        $end_date   = $year.'-'.$date_constellation_list[$month]['end_date'];

        if( strtotime( $start_date ) <=$time  && strtotime( $end_date ) >= $time ){
            $return = $date_constellation_list[$month];
        }

        $start_date = $year.'-'.$date_constellation_list[$month-1]['start_date'];
        $end_date   = $year.'-'.$date_constellation_list[$month-1]['end_date'];

        if( strtotime( $start_date ) <= $time  && strtotime( $end_date ) >= $time ){
            $return = $date_constellation_list[$month-1];
        }
        return $return;
    }
}
