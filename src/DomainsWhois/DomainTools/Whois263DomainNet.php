<?php
namespace Hwl\DomainsWhois\DomainTools;

use Curl\Curl;
use Curl\MultiCurl;
use Hwl\DomainsWhois\DomainTools\DomainNetInterface;

/**
 * Whois263DomainNet
 * 从网络上找到的一个开放接口
 * 该类未完成
 * @package Hwl\DomainsWhois\DomainTools
 * @author Hwl<weigewong@gmai.com>
 */
class Whois263DomainNet implements DomainNetInterface{
    private $url = 'http://whois.263.tw';

    public function query($dmName,$force = false){

        $curl = new Curl();
        $curl->setReferer($this->url);
        $page = $curl->get($this->url,array('domain' => $dmName));

    }
}