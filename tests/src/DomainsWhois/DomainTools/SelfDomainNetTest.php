<?php
/**
 * 自定义查询接口工具测试类
 * @author Hwl<weigewong@gmail.com>
 */
include __DIR__ . '/../../../bootstrap.php';

use Hwl\DomainsWhois\DomainTools\SelfDomainNet;
class DomainToolsTest extends \PHPUnit_Framework_TestCase{
    public function testQuery(){
        $selfQuery = new SelfDomainNet();

        $result = $selfQuery->query('baidu.com');
        $this->assertEquals(939571200,$result['createTime']);
    }

    public function testQueryCn(){
        $selfQuery = new SelfDomainNet();
        $result = $selfQuery->query('baidu.cn');
        $this->assertEquals(1047874805,$result['createTime']);
    }

    public function testQueryHk(){
        $selfQuery = new SelfDomainNet();
        $result = $selfQuery->query('google.com.hk');
        $this->assertEquals(true,$result['createTime'] > 0);
    }

    public function testQueryCc(){
        $selfQuery = new SelfDomainNet();
        $result = $selfQuery->query('baidu.cc');
        $this->assertEquals(true,$result['createTime'] > 0);
    }
}