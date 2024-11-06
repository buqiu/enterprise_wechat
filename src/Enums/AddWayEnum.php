<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Enums;

enum AddWayEnum: int
{
    case ADD_WAY_NONE             = 0;
    case ADD_WAY_CODE             = 1;
    case ADD_WAY_SEARCH_PHONE     = 2;
    case ADD_WAY_CARD             = 3;
    case ADD_WAY_GROUP_CHAT       = 4;
    case ADD_WAY_PHONE            = 5;
    case ADD_WAY_WECHAT           = 6;
    case ADD_WAY_CUSTOMER         = 8;
    case ADD_WAY_EMAIL            = 9;
    case ADD_WAY_VIDEO            = 10;
    case ADD_WAY_SCHEDULE         = 11;
    case ADD_WAY_MEET             = 12;
    case ADD_WAY_QY_WECHAT        = 13;
    case ADD_WAY_WISDOM_CUSTOMER  = 14;
    case ADD_WAY_DOOR_CUSTOMER    = 15;
    case ADD_WAY_HREF             = 16;
    case ADD_WAY_DEVELOP          = 17;
    case ADD_WAY_REPLY            = 18;
    case ADD_WAY_TRIPARTITE       = 21;
    case ADD_WAY_BUSINESS_PARTNER = 22;
    case ADD_WAY_FRIEND           = 24;
    case ADD_WAY_SHARE            = 201;
    case ADD_WAY_MANAGER          = 202;

    public function label(): string
    {
        return match ($this) {
            AddWayEnum::ADD_WAY_NONE             => '未知来源',
            AddWayEnum::ADD_WAY_CODE             => '扫描二维码',
            AddWayEnum::ADD_WAY_SEARCH_PHONE     => '搜索手机号',
            AddWayEnum::ADD_WAY_CARD             => '名片分享',
            AddWayEnum::ADD_WAY_GROUP_CHAT       => '群聊',
            AddWayEnum::ADD_WAY_PHONE            => '手机通讯录',
            AddWayEnum::ADD_WAY_WECHAT           => '微信联系人',
            AddWayEnum::ADD_WAY_CUSTOMER         => '安装第三方应用时自动添加的客服人员',
            AddWayEnum::ADD_WAY_EMAIL            => '搜索邮箱',
            AddWayEnum::ADD_WAY_VIDEO            => '视频号添加',
            AddWayEnum::ADD_WAY_SCHEDULE         => '通过日程参与人添加',
            AddWayEnum::ADD_WAY_MEET             => '通过会议参与人添加',
            AddWayEnum::ADD_WAY_QY_WECHAT        => '添加微信好友对应的企业微信',
            AddWayEnum::ADD_WAY_WISDOM_CUSTOMER  => '通过智慧硬件专属客服添加',
            AddWayEnum::ADD_WAY_DOOR_CUSTOMER    => '通过上门服务客服添加',
            AddWayEnum::ADD_WAY_HREF             => '通过获客链接添加',
            AddWayEnum::ADD_WAY_DEVELOP          => '通过定制开发添加',
            AddWayEnum::ADD_WAY_REPLY            => '通过需求回复添加',
            AddWayEnum::ADD_WAY_TRIPARTITE       => '通过第三方售前客服添加',
            AddWayEnum::ADD_WAY_BUSINESS_PARTNER => '通过可能的商务伙伴添加',
            AddWayEnum::ADD_WAY_FRIEND           => '通过接受微信账号收到的好友申请添加',
            AddWayEnum::ADD_WAY_SHARE            => '内部成员共享',
            AddWayEnum::ADD_WAY_MANAGER          => '管理员/负责人分配',
        };
    }
}
