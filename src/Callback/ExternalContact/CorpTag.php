<?php

namespace Buqiu\EnterpriseWechat\Callback\ExternalContact;

class CorpTag
{
    // 企业客户标签创建
    public static function add($xmlArray)
    {
        if (empty($xmlArray['Event']) || empty($xmlArray['TagType']) || empty($xmlArray['ChangeType'])) {
            return false;
        }

        // 创建标签时，此项为 tag，创建标签组时，此项为 tag_group
        if ($xmlArray['TagType'] != 'tag') {
            return false;
        }

        if ($xmlArray['ChangeType'] != 'create') {
            return false;
        }

        return $xmlArray['Id'];
    }
}
