<?php
namespace common\z;

use yii;
use yii\web\Session;

class ZSession extends Session
{

    /**
     * 自定义session id
     * 
     * @var string
     */
    public static $php_session_id = '';

    /**
     * 自定义session debug
     * 
     * @var string
     */
    public static $php_session_debug = '';

    private $session_prefix = 'ssid_';

    public function init()
    {
        parent::init();
        // Yii::$app->cache->useMemcached=true;
        register_shutdown_function([
            $this,
            'close'
        ]);
    }

    public function getUseCustomStorage()
    {
        return true;
    }

    /**
     * 打开
     * 
     * @see \yii\web\Session::openSession($savePath, $sessionName)
     */
    public function openSession($savePath, $sessionName)
    {
        
        // 启用缓存
        if (CACHE_ENABLE) {
            // 如果还没设置session id
            if (empty($_COOKIE[session_name()])) {
                // 生成session
                $id = $this->session_generate_id();
                $this->setId($id);
                $_COOKIE[session_name()] = $id;
                $session = Yii::$app->cache->get($this->session_prefix . $id);
                // 缓存过期重新设置
                if (! $session) {
                    Yii::$app->cache->set($this->session_prefix . $id, 'default', $this->getTimeout());
                    
                    echo 'openvaue=' . Yii::$app->cache->get($this->session_prefix . $id) . '=timeout=' . $this->getTimeout();
                }
            } else {
                echo 'open2';
                // $this->setId($_COOKIE[session_name()]);
            }
            echo 'open=key==' . Yii::$app->cache->buildKey($this->session_prefix . $id) . '<br/>';
        }
        
        // print_r($_COOKIE);
        // exit;
        return (true);
    }

    /**
     * 关闭
     * 
     * @see \yii\web\Session::closeSession()
     */
    public function closeSession()
    {
        // $this->debug(__METHOD__, null, $this->getSessionValues());
        
        // 启用缓存
        if (CACHE_ENABLE) {
            @session_write_close();
        }
    }

    /**
     * 读取
     * 
     * @see \yii\web\Session::readSession($id)
     */
    public function readSession($id)
    {
        // echo $id;
        $session_data = '';
        // 启用缓存
        if (CACHE_ENABLE) {
            $session_data = Yii::$app->cache->get($this->session_prefix . $id);
            echo $session_data;
        }
        echo '<br/>read=' . $id . '=session=' . print_r($session_data, true) . '=read<br/>';
        echo '<br/>read=' . $this->session_prefix . $id . '==key==' . Yii::$app->cache->buildkey($this->session_prefix . $id) . '=read<br/>';
        // exit;
        return $session_data;
    }

    /**
     * 写入
     * 
     * @see \yii\web\Session::writeSession($id, $data)
     */
    public function writeSession($id, $data)
    {
        $a_data = self::unserialize($data);
        // $a_data = $data;
        // 启用缓存
        if (CACHE_ENABLE) {
            $session = Yii::$app->cache->get($this->session_prefix . $id);
            echo '<h1>$this->session_prefix.$id=' . $this->session_prefix . $id . '=session_value=' . print_r($session, true) . '</h1><br/>';
            if (! $session) {
                // echo $this->getTimeout();
                $save = Yii::$app->cache->set($this->session_prefix . $id, $data, 100);
                $session_data = Yii::$app->cache->get($this->session_prefix . $id);
                $session = Yii::$app->cache->set($this->session_prefix, $data, 6000);
                
                $session = Yii::$app->cache->get($this->session_prefix);
                echo 'write222==' . Yii::$app->cache->useMemcached . ')' . '$session_data=' . print_r($session_data, true) . '<br/>';
                echo 'write222======' . print_r($session, true) . '===key===' . Yii::$app->cache->buildKey($this->session_prefix) . '==ppppp==' . print_r($a_data, true) . '<br/>';
                exit();
            } else {
                $save = Yii::$app->cache->set($this->session_prefix . $id, $data);
                $session = Yii::$app->cache->set($this->session_prefix, $data, $this->getTimeout());
                $session = Yii::$app->cache->get($this->session_prefix);
                echo 'write3333======' . print_r($session, true) . '<br/>';
            }
            echo 'session_prefix=' . Yii::$app->cache->get($this->session_prefix);
            echo '-' . Yii::$app->cache->buildKey($this->session_prefix);
            $session = Yii::$app->cache->get($this->session_prefix . $id);
            echo '<br/>write=' . $id . '=' . print_r($a_data, true) . '=save' . $save . '=write<br/>';
            echo '<br/>write2=key2=' . Yii::$app->cache->buildKey($this->session_prefix . $id) . '==save==' . $save . '=write2<br/>';
            echo '<br/>', $this->session_prefix . $id, '<br/>';
            echo Yii::$app->cache->buildKey($this->session_prefix . $id), '<br/>';
            echo 'write3=' . print_r($session, true);
            //
            echo $save;
            
            return true;
            // exit;
            return $save ? true : false;
        }
        return true;
    }

    /**
     * 销毁
     * 
     * @see \yii\web\Session::destroySession($id)
     */
    public function destroySession($id)
    {
        // $this->debug(__METHOD__, $id, $this->getSessionValues());
        // 启用缓存
        if (CACHE_ENABLE) {
            // Yii::$app->cache->delete($this->session_prefix.$id);
        }
        @session_unset();
        @session_destroy();
    }

    /**
     * 回收
     * 
     * @see \yii\web\Session::gcSession($maxLifetime)
     *
     */
    /*
     * public function gcSession($maxLifetime){
     *
     * }
     */
    
    /**
     * 生成session id
     * 
     * @return string
     *
     */
    public static function session_generate_id()
    {
        $php_session_id = session_regenerate_id();
        // 客户端请求时间
        $request_time_float = isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : microtime(true);
        // 客户端请求时间后缀
        $request_time_float_suffix = substr($request_time_float, strripos($request_time_float, '.') + 1, strlen($request_time_float));
        // 客户端ip
        $client_ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        // 客户端端口
        $client_port = isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : '';
        
        // 服务器物理地址
        $o_GetMacAddr = new GetMacAddr(PHP_OS);
        $server_mac_add = isset($o_GetMacAddr->mac_addr) ? $o_GetMacAddr->mac_addr : '';
        // 服务器ip
        $server_ip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
        // 服务器端口
        $server_port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : '';
        // session操作时间
        $server_last_time = microtime(true);
        // 服务器物理地址 + 服务器ip + $server_port +php session id +客户端请求时间前缀 +客户端端口 + 客户端ip+$server_last_time
        $session_id = $server_mac_add . $server_ip . $server_port . $php_session_id . $request_time_float_suffix . $client_port . $client_ip . $server_last_time;
        $session_id = sha1($session_id);
        self::$php_session_debug = <<<str
        \$server_mac_add=$server_mac_add
        \$server_ip=$server_ip.
        \$server_port=$server_port.
        \$php_session_id=$php_session_id.
        \$request_time_float_suffix=$request_time_float_suffix.
        \$client_port=$client_port.
        \$client_ip=$client_ip
        \$server_last_time=$server_last_time
        \$session_id=$session_id
str;
        self::$php_session_id = $session_id;
        return $session_id;
    }

    /**
     * 获取cache id
     * 
     * @return string
     */
    public function getCacheId()
    {
        return Yii::$app->cache->buildKey($this->session_prefix . $this->getId());
    }

    public function debug($method, $session_id, $data, $return = false)
    {
        if (! SESSION_DEBUG_CUSTOM)
            return null;
        
        $str_data = print_r($data, true);
        $temp = <<<str
		method: $method
		ssid  : $session_id
		data  : $str_data
str;
        if ($return)
            return $temp;
        echo $temp;
    }

    public function getSessionValues()
    {
        $session = [];
        foreach (Yii::$app->session as $name => $value) {
            // $session[$name] = $value;
            $this->set($name, $value);
        }
        return $session;
    }

    /**
     * 设置yii session
     * 
     * @param array $cache_session_data
     *            缓存中的session
     */
    public function setSession($cache_session_data)
    {
        if (is_array($cache_session_data)) {
            foreach ($cache_session_data as $key => $value) {
                // Yii::$app->session[$key]=$value;
                $this->set($key, $value);
            }
        }
    }

    /**
     * 序列化session
     * 
     * @param unknown $session_data            
     * @throws Exception
     * @return multitype:unknown
     */
    public static function unserialize($session_data)
    {
        $method = ini_get("session.serialize_handler");
        switch ($method) {
            case "php":
                return self::unserialize_php($session_data);
                break;
            case "php_binary":
                return self::unserialize_phpbinary($session_data);
                break;
            default:
                throw new Exception("Unsupported session.serialize_handler: " . $method . ". Supported: php, php_binary");
        }
    }

    private static function unserialize_php($session_data)
    {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            if (! strstr(substr($session_data, $offset), "|")) {
                throw new Exception("invalid data, remaining: " . substr($session_data, $offset));
            }
            $pos = strpos($session_data, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session_data, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }

    private static function unserialize_phpbinary($session_data)
    {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            $num = ord($session_data[$offset]);
            $offset += 1;
            $varname = substr($session_data, $offset, $num);
            $offset += $num;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }
}