<?php
namespace Hwl\DomainsWhois\DomainTools;

use Hwl\DomainsWhois\DomainTools\DomainNetInterface;
use Novutec\WhoisParser\Parser as SelfQuery;

/**
 * 自己的查询接口
 * 主要是使用各whois服务器
 * 可以根据需要来获取更多信息,比如返回raw信息
 * @package Hwl\DomainsWhois\DomainTools
 * @author Hwl<weigewong@gmail.com>
 */
class SelfDomainNet implements DomainNetInterface{


    public function query($dmName,$force = false){
        $return = array(
            'status'     => 0,
            //是否已经被注册
            'registered' => 0,
        );

        $selfQuery = new SelfQuery();
        //扩展自定义的模板路径,供下面的扩展的cn域名使用
        $selfQuery->setCustomTemplateNamespace('Hwl\\DomainsWhois\\DomainParserTemplates\\');
        //设置cn域名的解析模板,多模板可以从数组里进行添加
        $selfQuery->setSpecialWhois(array(
           'cn' => array('template' => 'cn'),
            'whois.webnic.cc' => array('template' => 'cc')
        ));

        $result = $selfQuery->lookup($dmName);
        //todo 如果有注册,但类检测不出来的时候需要通知,好后面完善一些域名解析模板
        if($result->registered){
            $return['status'] = $result->status != '' ? 1 : 0;
            $return['registered'] = $result->registered;
            if($result->created){
                $return['createTime'] = strtotime($result->created);
            }

            if($result->changed){
                $return['updateTime'] = strtotime($result->changed);
            }

            if($result->expires){
                $return['expireTime'] = strtotime($result->expires);
            }

        }

        return $return;
    }
}