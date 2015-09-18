<?php

namespace Hwl\DomainsWhois;

use Hwl\DomainsWhois\DomainTools\DomainCoreNet;
/**
 * 域名工具类
 * 可以在这个类里写一些逻辑处理方法,比如获取过期状态
 * 该工具类需要PHP5.3及以上版本,就是需要支持命名空间的版本
 * 测试环境PHP5.3
 * @package Libraries\Net
 * @author Hwl <weigewong@gmail.com>
 */
class DomainTools {

    /**
     * 域名网络查询接口
     * @var \Hwl\DomainsWhois\DomainTools\DomainCoreNet
     */
    protected $domainInterface = null;

    public function __construct(){
        $this->domainInterface = new DomainCoreNet();
    }


    /**
     * 获取域名的信息
     * @param string $dmName 域名
     * @param bool   $force  是否强制刷新
     * @return array
     */
    public function getDomainInfo($dmName,$force = false){
        return $this->domainInterface->query($dmName,$force);
    }

    /**
     * 检查域名是否过期状态
     * @param string   $dmName
     * @param int|null $time
     * @param bool     $force
     * @return int 状态码,0过期了,1正常未过期,2未查到
     */
    public function checkExpireStatus($dmName,$time = null, $force = false){
        $time = $time ? $time : time();
        $domainInfo = $this->getDomainInfo($dmName,$force);
        if($domainInfo['status']){
            if($domainInfo['expireTime'] < $time){
                return 0;
            }else{
                return 1;
            }
        }else{
            return 2;
        }
    }


}