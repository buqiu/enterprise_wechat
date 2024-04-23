<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Api;

use Buqiu\EnterpriseWechat\Api\DataStructure\AddressBook;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\ExternalContact;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\MessagePush\AddMsgTemplate;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Remark;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Tag\CorpTag;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Transfer\TransferCustomer;
use Buqiu\EnterpriseWechat\Api\DataStructure\ExternalContact\Transfer\TransferResult;
use Buqiu\EnterpriseWechat\Api\DataStructure\SendMessage;
use Buqiu\EnterpriseWechat\Constants\Transfer;
use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ApiError;
use Buqiu\EnterpriseWechat\Utils\HttpUtils;
use Buqiu\EnterpriseWechat\Utils\Utils;

class CorpApi extends Api
{
    protected $accessToken;
    private $corpId;
    private $secret;

    /**
     * 企业进行自定义开发调用, 无需关注 accessToken, 会自动获取并刷新.
     *
     * @param  string     $corpId : 企业 ID
     * @param  string     $secret : 应用的凭证密钥
     * @throws \Exception
     */
    public function __construct(string $corpId, string $secret)
    {
        Utils::checkNotEmptyStr($corpId, 'corpid');
        Utils::checkNotEmptyStr($secret, 'secret');
        $this->corpId = $corpId;
        $this->secret = $secret;
    }

    // ------------------------- access token ---------------------------------

    /**
     * 获取 accessToken.
     * @return null|void
     * @throws \Exception
     */
    public function getAccessToken()
    {
        if (!Utils::notEmptyStr($this->accessToken)) {
            $this->refreshAccessToken();
        }

        return $this->accessToken;
    }

    // ------------------------- 【客户联系】客户管理 ---------------------------------

    // 获取配置了客户联系功能的成员列表
    public function getFollowUserList(): ExternalContact
    {
        self::_httpCall(self::GET_FOLLOW_USER_LIST, 'GET', []);

        return ExternalContact::handleGetFollowUserRsp($this->rspJson);
    }

    // 获取客户列表
    public function getExternalContactList(ExternalContact $externalContact): ExternalContact
    {
        ExternalContact::checkGetListArgs($externalContact);
        $args = ExternalContact::handleGetListArgs($externalContact);
        self::_httpCall(self::GET_EXTERNAL_CONTACT_LIST, 'GET', $args);

        return ExternalContact::handleGetListRsp($this->rspJson);
    }

    // 获取客户详情
    public function getExternalContact(ExternalContact $externalContact): array
    {
        ExternalContact::checkGetArgs($externalContact);

        $r = ['externalUserId' => '', 'unionId' => '', 'name' => '', 'avatar' => '', 'type' => '', 'gender' => '', 'corp_name' => '', 'corp_full_name' => '', 'followUserInfo' => [], 'tags' => [], 'followUserIds' => []];

        do {
            $args = ExternalContact::handleGetArgs($externalContact);
            self::_httpCall(self::GET_EXTERNAL_CONTACT_INFO, 'GET', $args);

            $externalRow = ExternalContact::handleGetRsp($this->rspJson);
            if (empty($r['externalUserId']) && !empty($externalRow->externalUserId)) {
                $r['externalUserId'] = $externalRow->externalUserId;
            }
            if (empty($r['unionId']) && !empty($externalRow->unionId)) {
                $r['unionId'] = $externalRow->unionId;
            }
            if (empty($r['name']) && !empty($externalRow->name)) {
                $r['name'] = $externalRow->name;
            }
            if (empty($r['avatar']) && !empty($externalRow->avatar)) {
                $r['avatar'] = $externalRow->avatar;
            }
            if (empty($r['type']) && !empty($externalRow->type)) {
                $r['type'] = $externalRow->type;
            }
            if (empty($r['gender']) && isset($externalRow->gender)) {
                $r['gender'] = $externalRow->gender;
            }
            if (empty($r['corp_name']) && isset($externalRow->corpName)) {
                $r['corp_name'] = $externalRow->corpName;
            }
            if (empty($r['corp_full_name']) && isset($externalRow->corpFullName)) {
                $r['corp_full_name'] = $externalRow->corpFullName;
            }

            if (!empty($externalRow->followUserInfo)) {
                foreach ($externalRow->followUserInfo as $userId => $item) {
                    if (empty($r['followUserInfo'][$userId])) {
                        $r['followUserInfo'][$userId]['own_tags']   = $item['tags'];
                        $r['followUserInfo'][$userId]['remark']     = $item['remark'];
                        $r['followUserInfo'][$userId]['createtime'] = $item['createtime'];
                        $r['followUserInfo'][$userId]['add_way']    = $item['add_way'];
                    } else {
                        $r['followUserInfo'][$userId]['own_tags'] = array_merge(
                            $r['followUserInfo'][$userId]['own_tags'],
                            $item
                        );
                    }
                }

                $r['tags']          = array_merge($r['tags'], $externalRow->tags);
                $r['followUserIds'] = array_merge($r['followUserIds'], $externalRow->followUserIds);
            }
            $nextCursor     = $externalRow->cursor;
            $args['cursor'] = $nextCursor;
        } while (!empty($nextCursor));

        return $r;
    }

    // 批量获取客户信息
    public function batchGetExternalContacts(ExternalContact $externalContact): ?array
    {
        ExternalContact::checkBatchGetArgs($externalContact);

        $r          = [];
        $userChunks = array_chunk($externalContact->userIds, ExternalContact::$batchProcessUserLimit);
        $external   = new ExternalContact();
        foreach ($userChunks as $userChunk) {
            $external->userIds = $userChunk;
            $args              = ExternalContact::handleBatchGetArgs($external);
            do {
                self::_httpCall(self::BATCH_GET_EXTERNAL_CONTACTS, 'POST', $args);
                $tmp = ExternalContact::handleBatchGetRsp($this->rspJson ?: []);
                if (!is_null($tmp->externalUserList)) {
                    $r = array_merge($r, $tmp->externalUserList);
                }

                $nextCursor     = $tmp->cursor;
                $args['cursor'] = $nextCursor;
            } while (!empty($nextCursor));
        }

        return $r;
    }

    /**
     * @note 修改客户备注信息
     * @author eva
     *
     * @param  Remark     $remark
     * @return array
     * @throws \Exception
     */
    public function remark(Remark $remark): array
    {
        Remark::checkRemarkArgs($remark);
        $args = Remark::handleRemarkArgs($remark);
        self::_httpCall(self::REMARK, 'POST', $args);

        return $this->rspJson;
    }

    // ------------------------- 【客户联系】客户标签管理 ---------------------------------

    // 获取企业标签库
    public function getCorpTagList(CorpTag $corpTag): CorpTag
    {
        $filter = CorpTag::handleListArgs($corpTag);
        self::_httpCall(self::GET_CORP_TAG_LIST, 'POST', $filter);

        return CorpTag::handleListRsp($this->rspJson);
    }

    // 添加企业客户标签
    public function addCorpTag(CorpTag $tags): CorpTag
    {
        CorpTag::checkAddArgs($tags);
        $args = CorpTag::handleAddArgs($tags);
        self::_httpCall(self::ADD_CORP_TAG, 'POST', $args);

        return CorpTag::handleAddRsp($this->rspJson);
    }

    // 编辑企业客户标签
    public function editCorpTag(CorpTag $tags)
    {
        CorpTag::checkEditArgs($tags);
        $args = CorpTag::handleEditArgs($tags);
        self::_httpCall(self::EDIT_CORP_TAG, 'POST', $args);
    }

    // 删除企业客户标签
    public function delCorpTag(CorpTag $tags)
    {
        CorpTag::checkDelArgs($tags);
        $args = CorpTag::handleDelArgs($tags);
        self::_httpCall(self::DEL_CORP_TAG, 'POST', $args);
    }

    // 编辑客户企业标签
    public function markCorpTag(CorpTag $tags)
    {
        CorpTag::checkMarkArgs($tags);
        $args = CorpTag::handleMarkArgs($tags);
        self::_httpCall(self::MARK_CORP_TAG, 'POST', $args);
    }

    // ------------------------- 【客户联系】消息推送 ---------------------------------

    // 创建企业群发
    public function addMsgTemplate(AddMsgTemplate $msgTemplate): AddMsgTemplate
    {
        AddMsgTemplate::checkArgs($msgTemplate);
        $args = AddMsgTemplate::handleArgs($msgTemplate);
        self::_httpCall(self::ADD_MSG_TEMPLATE, 'POST', $args);

        return AddMsgTemplate::handleRsp($this->rspJson);
    }

    // ------------------------- 【企业内部】消息推送 ---------------------------------

    // 应用内部参数
    public function sendMessage(SendMessage $sendMessage): SendMessage
    {
        SendMessage::checkSendMsgArgs($sendMessage);
        $args = SendMessage::sendMessage2Array($sendMessage);
        self::_httpCall(self::MESSAGE_SEND, 'POST', $args);

        return SendMessage::responseArray2SendMessage($this->rspJson);
    }

    // ------------------------- 【企业内部】部门信息 ---------------------------------

    /**
     * @note   getDepartment 获取部门列表
     * @author Lu
     *
     * @param  mixed      $departmentId
     * @return mixed
     * @throws \Exception
     */
    public function getDepartment($departmentId = 0)
    {
        return AddressBook::getDepartmentList($this->getAccessToken(), $departmentId);
    }

    /**
     * @note getDepartmentShow  获取部门详情
     * @author Zyy
     * @param  null|int   $departmentId
     * @return mixed
     * @throws \Exception
     */
    public function getDepartmentShow(?int $departmentId = 0): mixed
    {
        return AddressBook::getDepartmentShow($this->getAccessToken(), $departmentId);
    }

    /**
     * @note   getUserSimpleList 获取成员列表
     * @author Lu
     *
     * @param  mixed      $departmentId
     * @return mixed
     * @throws \Exception
     */
    public function getUserSimpleList($departmentId)
    {
        return AddressBook::getUserSimpleList($this->getAccessToken(), $departmentId);
    }

    /**
     * @note   getUserSimpleDetailList 获取成员详情
     * @author Lu
     *
     * @param             $departmentId
     * @return mixed
     * @throws \Exception
     */
    public function getUserSimpleDetailList($departmentId)
    {
        return AddressBook::getUserSimpleDetailList($this->getAccessToken(), $departmentId);
    }

    /**
     * @note   getUserOpenid 获取用户openid
     * @author Lu
     *
     * @param             $code
     * @return mixed
     * @throws \Exception
     */
    public function getUserOpenid($code)
    {
        return AddressBook::getUserAuth($this->getAccessToken(), $code);
    }

    /**
     * @note   getUserDetail web端，扫码获取用户信息
     * @author Lu
     *
     * @param             $code
     * @return mixed
     * @throws \Exception
     */
    public function getUserDetail($code)
    {
        return AddressBook::getUserAuth($this->getAccessToken(), $code);
    }

    /**
     * @note   h5AuthUserInfo h5 授权获取用户信息
     * @author Lu
     *
     * @param             $code
     * @return mixed
     * @throws \Exception
     */
    public function h5AuthUserInfo($code)
    {
        return AddressBook::h5AuthUserDetail($this->getAccessToken(), $code);
    }

    /**
     * @note   h5AuthUserDetail h5 授权获取用户敏感信息
     * @author Lu
     *
     * @param             $userTicket
     * @return mixed
     * @throws \Exception
     */
    public function h5AuthUserDetail($userTicket)
    {
        return AddressBook::h5AuthUserDetail($this->getAccessToken(), $userTicket);
    }

    /**
     * @note   getUserInfoById 通过用户id，读取用户信息
     * @author Lu
     *
     * @param             $userId
     * @return mixed
     * @throws \Exception
     */
    public function getUserInfoById($userId): mixed
    {
        return AddressBook::getUserInfoById($this->getAccessToken(), $userId);
    }

    /**
     * @note   setUserDepartment 更新用户部门
     * @author Lu
     *
     * @param             $userId
     * @param             $departmentArr
     * @return mixed
     * @throws \Exception
     */
    public function setUserDepartment($userId, $departmentArr)
    {
        return AddressBook::setUserDepartment($this->getAccessToken(), $userId, $departmentArr);
    }

    /**
     * @note   getUnassignedList 获取待分配的离职成员列表
     * @author Lu
     *
     * @return mixed
     * @throws \Exception
     */
    public function getUnassignedList()
    {
        return AddressBook::getUnassignedList($this->getAccessToken());
    }

    /**
     * @note 分配成员客户
     * @author eva
     *
     * @param  TransferCustomer $transferCustomer
     * @param  string           $type
     * @return TransferCustomer
     * @throws \Exception
     */
    public function transferCustomer(TransferCustomer $transferCustomer, string $type): TransferCustomer
    {
        TransferCustomer::checkArgs($transferCustomer);
        $args = TransferCustomer::handleArgs($transferCustomer);
        self::_httpCall(Transfer::TRANSFER_TYPE_NORMAL == $type ? self::EXTERNALCONTACT_TRANSFER_CUSTOMER : self::RESIGNED_TRANSFER_CUSTOMER, 'POST', $args);

        return TransferCustomer::handleRsp($this->rspJson);
    }

    /**
     * @note 查询客户接替状态
     * @author eva
     *
     * @param  TransferResult $transferResult
     * @param  string         $type
     * @return array
     * @throws \Exception
     */
    public function externalcontactTransferResult(TransferResult $transferResult, string $type): array
    {
        TransferResult::checkArgs($transferResult);
        $r = [];

        do {
            $args = TransferResult::handleArgs($transferResult);
            self::_httpCall(Transfer::TRANSFER_TYPE_NORMAL == $type ? self::EXTERNALCONTACT_TRANSFER_RESULT : self::RESIGNED_TRANSFER_RESULT, 'POST', $args);

            $row = TransferResult::handleRsp($this->rspJson);
            $r   = array_merge($r, $row->customers);

            $nextCursor     = $row->cursor;
            $args['cursor'] = $nextCursor;
        } while (!empty($nextCursor));

        return $r;
    }

    /**
     * 刷新 accessToken.
     * @throws \Exception
     */
    protected function refreshAccessToken()
    {
        if (!Utils::notEmptyStr($this->corpId) || !Utils::notEmptyStr($this->secret)) {
            throw new \Exception(ApiError::ERR_MSG[ApiError::ILLEGAL_CORP_ID_OR_SECRET]);
        }

        $url = HttpUtils::makeUrl(self::GET_TOKEN);
        $url = str_replace('CORP_ID', $this->corpId, $url);
        $url = str_replace('SECRET', $this->secret, $url);

        $this->_httpGetParseToJson($url);
        $this->_checkErrCode();

        $this->accessToken = $this->rspJson['access_token'];
    }
}
