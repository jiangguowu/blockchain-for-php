<?php
/**
 * @author iSakura <i@joosie.cn>
 */
namespace Joosie\Blockchain\Services\Swoole;

use Joosie\Blockchain\Services\SocketServerAdapter;
use Joosie\Blockchain\Transaction;

/**
* 区块链通信服务 Swoole 实现
*/
class BlockchainSwooleServer extends SocketServerAdapter
{
    protected $workNum = null;

    protected $reactorNum = null;

    protected $maxRequest = null;

    protected $maxConnect = null;

    protected $backlog = 20;

    protected $data = [];

    /**
     * 事务处理实例
     * @var null
     */
    public $transaction = null;
    
    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            if (isset($this->$key)) {
                $this->$key = $value;
            }
        }
        $this->transaction = new Transaction();
    }

    /**
     * 服务启动
     * @param  Object $serv 服务实例
     */
    public function onStart($serv)
    {
        echo "Hello blockchain!\n";
    }

    /**
     * 连接进入
     * @param  Object  $serv 服务实例
     * @param  Integer $fd   连接标识
     */
    public function onConnect($serv, $fd)
    {
        echo sprintf("Client %s connect!", $fd);
    }

    /**
     * TCP 数据接收
     * @param  Object  $serv   服务实例
     * @param  Integer $fd     连接标识
     * @param  Integer $fromId 来源标识
     * @param  String  $data   数据内容
     */
    public function onReceive($serv, $fd, $fromId, $data)
    {
        echo sprintf("Receive data: %s", $data);
    }

    public function onPacket($serv, $data, $address)
    {
        // $serv->sendto('233.233.233.233', 9607, "Hello swoole");
        var_dump($address, strlen($data), $data);
    }

    /**
     * 连接关闭
     * @param  Object  $serv 服务实例
     * @param  Integer $fd   连接标识
     */
    public function onClose($serv, $fd)
    {
        echo sprintf("Client %s close!", $fd);
    }

    /**
     * 服务设置
     * @param string $name   服务名
     * @param mixed  $handle 服务处理内容
     */
    public function set(string $name, $handle)
    {
        $this->data[$name] = $handle;
    }

    function __get($name)
    {
        if (!isset($this->$name) || is_null($this->$name)) {
            if (isset($this->data[$name])) {
                return $this->$name = $this->data[$name];
            }
        }
    }
}