<?php
/**
 * 域名工具测试类
 * @author Hwl<weigewong@gmail.com>
 */
include __DIR__ . '/../../bootstrap.php';

use Hwl\DomainsWhois\DomainTools;

class DomainToolsTest extends \PHPUnit_Framework_TestCase{
    /**
     * 检查获取的信息是否格式正确
     */
    public function testGetDomainInfo(){
        $domainTools = new DomainTools();
        $domainInfo  = $domainTools->getDomainInfo('baidu.com');
        $this->assertEquals(true, is_array($domainInfo));
        $this->assertEquals(true, $domainInfo['createTime'] > 0);
    }

    /**
     * 测试中文域名
     */
    public function testGetChineseDomainInfo(){
        $domainTools = new DomainTools();
        $domainInfo  = $domainTools->getDomainInfo('万网.com');
        $this->assertEquals(true, is_array($domainInfo));
        $this->assertEquals(true, $domainInfo['createTime'] > 0);
    }

    /**
     * 检查域名过期功能
     */
    public function testCheckExpireStatus(){
        $domainTools = new DomainTools();
        $someDay     = strtotime('2015-08-08');
        $result      = $domainTools->checkExpireStatus('baidu.com',$someDay);
        $this->assertEquals(true, $result);
    }

    /**
     * 测试百度域名的创建时间是否正确,以此来判断接口是否正常可用
     */
    public function testBaiduCreateTime(){
        $domainTools = new DomainTools();
        $birthDay    = strtotime('1999-10-11');
        $result      = $domainTools->getDomainInfo('baidu.com');

        $this->assertEquals($birthDay, $result['createTime']);
    }

    /**
     * 测试百度cc域名
     */
    public function testBaiduCcDomain(){
        $domainTools = new DomainTools();
        $birthDay    = strtotime('2004-03-01');
        $result      = $domainTools->getDomainInfo('baidu.cc');

        $this->assertEquals(true, $result['createTime'] > 0);
    }
}