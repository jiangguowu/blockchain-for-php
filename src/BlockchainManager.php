<?php
/**
 * @author iSakura <i@joosie.cn>
 */
namespace Joosie\Blockchain;

use Joosie\Blockchain\Stores\StoreManager;
use Joosie\Blockchain\Exceptions\BlockchainException;
use Joosie\Blockchain\Exceptions\BlockchainAccountException;

/**
* 区块链主类
*/
class BlockchainManager extends BlockchainBase
{
    /**
     * 创建一个对象实例
     * @param ConfigManager|null $config 配置类
     */
    public function __construct(ConfigManager $config = null)
    {
        parent::__construct($config);
        static::setInstance($this);
    }

    /**
     * 获取服务容器
     * @return Joosie\Blockchain\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * 创建一个新的钱包账号
     * @param  Boolean $force true|false 是否强制生成新的账号
     * @return array
     */
    public function createAccount($force = false)
    {
        if (!$force && $this->account->hasAccount()) {
            throw new BlockchainAccountException('Create a new account is faild! Account has exist.');
        }

        // 创建并返回一个新的钱包数据
        return $this->account->create()->getMyAccountInfo();
    }

    /**
     * 查询账户详情
     * @param  string $account 账户地址
     * @return Array
     */
    public function findAccountInfo(string $account = null)
    {
        if (is_null($account)) {
            $account = $this->account->getMyAccountAddress();
        }
        return $this->store->findResourcesInfoByAccount($account);
    }

    /**
     * 生成资产并奖励给用户
     * @param  string $account      账户地址
     * @param  mixed  $resourceData 资产数据
     * @return boolean
     */
    public function generateResourceToAccount($account, $resourceData)
    {
        # TODO 生成资产并奖励给用户
    }

    /**
     * 魔术方法
     * @param  String $name 属性名
     */
    public function __get($name)
    {
        if (isset($this->$name)) {
            return $this->$name;
        } elseif (isset($this->container->$name)) {
            return $this->container->$name;
        } else {
            throw new BlockchainException("Invalid property of {$name}");
        }
    }
}