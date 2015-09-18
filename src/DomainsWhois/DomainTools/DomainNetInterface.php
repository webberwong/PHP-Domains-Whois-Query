<?php
namespace Hwl\DomainsWhois\DomainTools;

/**
 * DomainNetInterface
 * 用来定义各个网站接口
 * @package Hwl\DomainsWhois\DomainTools
 * @author Hwl<weigewong@gmail.com>
 */
interface DomainNetInterface{
    /**
     * 查询域名信息
     * @param string $dmName 域名
     * @param bool   $force  是否返回最新数据
     * @return array
     */
    public function query($dmName,$force = false);
}