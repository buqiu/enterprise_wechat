<?php
/**
 * @note   ${NAME}${CARET}
 * @author Lu
 */
namespace Buqiu\EnterpriseWechat\Examples;

use Buqiu\EnterpriseWechat\Api\CorpApi;
use Exception;

require dirname(__DIR__) . "/../vendor/autoload.php";


$config = require('./config.php');
$api    = new CorpApi('ww53a5a250d606fc37', 'hEj95-XuoftjtoHlb2dtr4DPDtQgUL878ATtXWqIKk0');


try {
    // 获取部门
//    $d = $api->getDepartment(53);
//    print_r($d);
//
    // 获取成员
//    $d = $api->getUserInfoById('lujing');
    print_r($d);
} catch (Exception $e) {
    echo "{$e->getMessage()}\n";
}