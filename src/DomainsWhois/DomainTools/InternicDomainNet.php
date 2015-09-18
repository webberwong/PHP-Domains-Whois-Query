<?php
namespace Hwl\DomainsWhois\DomainTools;

use Curl\Curl;
use Curl\MultiCurl;
use TrueBV\Punycode;
use Hwl\DomainsWhois\DomainTools\DomainNetInterface;

/**
 * Internic域名接口
 * http://www.internic.net/index.html
 * 可以根据需要来获取更多信息,比如返回raw信息
 * @package Hwl\DomainsWhois\DomainTools
 * @author Hwl<weigewong@gmail.com>
 */
class InternicDomainNet implements DomainNetInterface{
    private $refererUrl = 'http://www.internic.net/whois.html';
    private $url        = 'http://reports.internic.net/cgi/whois';
    public function query($dmName,$force = false){
        //'http://reports.internic.net/cgi/whois?whois_nic=baidu.com&type=domain';
        $curl = new Curl();
        $curl->setReferer($this->refererUrl);
        $Punycode = new Punycode();
        $page = $curl->get($this->url,array('whois_nic' => $Punycode->encode($dmName),'type' => 'domain'));
        return $this->parse($page);
    }

    /**
     * 解析,返回需要的值
     * @param string $html
     * @return array
     */
    protected function parse($html){
        $return = array(
            'status' => 0,
        );
        $reg = "/\d{1,2}-\w+-\d{4}/";
        preg_match_all($reg,$html,$dates);
        //如果正确解析数据的情况
        if(isset($dates[0])){
            if(count($dates[0]) == 3){
                $return['status'] = 1;
                $return['updateTime'] = strtotime($dates[0][0]);
                $return['createTime'] = strtotime($dates[0][1]);
                $return['expireTime'] = strtotime($dates[0][2]);
            }
        }
        return $return;
    }
}