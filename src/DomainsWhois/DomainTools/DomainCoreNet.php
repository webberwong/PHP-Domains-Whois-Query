<?php

namespace Hwl\DomainsWhois\DomainTools;


/**
 * 域名核心网络类
 * @package Hwl\DomainsWhois\DomainTools
 * @author Hwl<weigewong@gmail.com>
 */
class DomainCoreNet{

    /**
     * 优先域名接口
     * 某些特定的域名后辍走优先接口
     * @var array
     */
    protected $priorInterfaces = array(
        'Internic' => array('aero','arpa','asia','biz','cat', 'com', 'coop', 'edu', 'info', 'int', 'jobs', 'mobi', 'museum', 'name', 'net', 'org', 'pro', 'travel'),
        'Cnnic'    => array('cn','中国'),
    );
    /**
     * 请求的网站接口列表
     * 呵呵,这些类都没完成,现在的需求,基本上面的优先接口都处理完了
     * @var array
     */
    protected $queryInterface = array(
        'Whois263','Chinaz'
    );

    /**
     * 查询数据
     * @param string $dmName 域名
     * @param bool   $force  是否获取最新的数据
     * @return array
     */
    public function query($dmName,$force = false){
        /**
         * 返回的值
         * 该处只返回这点信息,想要其他信息,需要扩展接口
         */
        $return = array(
            'status'     => 0,
            'expireTime' => 0,
            'createTime' => 0
        );
        //最先使用自己的接口
        if(true){
            $interfaceName = 'Hwl\\DomainsWhois\\DomainTools\\SelfDomainNet';
            $interface     = new $interfaceName;
            $queryResult   = $interface->query($dmName,$force);
            if($queryResult['status']){
                return array_merge($return,$queryResult);
            }
        }

        //使用优先的接口
        $priorInterfaceName = $this->getPriorityInterface($dmName);
        if($priorInterfaceName){
            $interfaceName = 'Hwl\\DomainsWhois\\DomainTools\\' . $priorInterfaceName . 'DomainNet';
            $interface     = new $interfaceName;
            $queryResult   = $interface->query($dmName,$force);
            if($queryResult['status']){
                return array_merge($return,$queryResult);
            }
        }

        //使用其他的接口
        foreach($queryResult as $key => $interface){
            $interfaceName = 'Hwl\\DomainsWhois\\DomainTools\\' . $priorInterfaceName . 'DomainNet';
            $interface     = new $interfaceName;
            $queryResult   = $interface->query($dmName,$force);
            if($queryResult['status']){
                return array_merge($return,$queryResult);
            }
        }

        return $return;
    }

    /**
     * 获取优先接口
     * @param string $dmName
     * @return bool|int|string
     */
    public function getPriorityInterface($dmName){
        //获取域名的类型
        $domainExt = explode('.',$dmName);
        $domainExt = end($domainExt);
        foreach($this->priorInterfaces as $key => $interface){
            if(in_array($domainExt,$interface)){
                return $key;
            }
        }
        return false;
    }

}