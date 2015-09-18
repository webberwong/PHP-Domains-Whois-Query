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
class CnnicDomainNet implements DomainNetInterface{
    private $refererUrl = 'https://whois.cnnic.net.cn/WhoisServlet';
    private $url        = 'https://whois.cnnic.net.cn/WhoisServlet';
    public function query($dmName,$force = false){
        //'https://whois.cnnic.net.cn/WhoisServlet?queryType=Domain&domain=teqhost.cn';
        $curl = new Curl();
        $curl->setReferer($this->refererUrl);
        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
        $Punycode = new Punycode();
        $page = $curl->get($this->url,array('domain' => $Punycode->encode($dmName),'queryType' => 'Domain'));
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
        $reg = "/\d{4}-\d{2}-\d{1,2}/";
        preg_match_all($reg,$html,$dates);
        //如果正确解析数据的情况
        if(isset($dates[0])){
            if(count($dates[0]) == 2){
                $return['status'] = 1;
                $return['createTime'] = strtotime($dates[0][0]);
                $return['expireTime'] = strtotime($dates[0][1]);
            }
        }
        return $return;
    }
}