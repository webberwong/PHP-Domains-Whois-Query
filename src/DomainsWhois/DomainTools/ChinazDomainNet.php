<?php
namespace Hwl\DomainsWhois\DomainTools;

use Curl\Curl;
use Curl\MultiCurl;
use Hwl\DomainsWhois\DomainTools\DomainNetInterface;

/**
 * Class ChinazDomainNet
 * 站长工具的whois查询类
 * 该类未完成
 * @package Hwl\DomainsWhois\DomainTools
 */
class ChinazDomainNet implements DomainNetInterface{
    private $url = 'http://whois.chinaz.com/';

    public function query($dmName,$force = false){
        'http://whois.chinaz.com/?DomainName=teqhost.cn';
        $curl = new Curl();
        $curl->setReferer($this->url);
        $page = $curl->get($this->url,array('DomainName' => $dmName));
        //有时间完善
    }
}