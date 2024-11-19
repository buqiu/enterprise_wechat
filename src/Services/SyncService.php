<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Dto\CorpTag\CorpTagGroupDto;
use Buqiu\EnterpriseWechat\Dto\CorpTag\CorpTagMarkDto;
use Buqiu\EnterpriseWechat\Dto\CorpTagDto;
use Buqiu\EnterpriseWechat\Dto\Customer\ExternalContactDto;
use Buqiu\EnterpriseWechat\Dto\Customer\FollowUserDto;
use Buqiu\EnterpriseWechat\Dto\Customer\RemarkDto;
use Buqiu\EnterpriseWechat\Dto\DepartmentDto;
use Buqiu\EnterpriseWechat\Dto\GroupChatDto;
use Buqiu\EnterpriseWechat\Dto\GroupChatDto\GroupChatMemberDto;
use Buqiu\EnterpriseWechat\Dto\GroupChatDto\GroupChatTransferDto;
use Buqiu\EnterpriseWechat\Dto\Media\MediaUrlDto;
use Buqiu\EnterpriseWechat\Dto\MediaDto;
use Buqiu\EnterpriseWechat\Dto\Message\BotDto;
use Buqiu\EnterpriseWechat\Dto\Message\GroupMessageDto;
use Buqiu\EnterpriseWechat\Dto\Message\WelcomeMessageDto;
use Buqiu\EnterpriseWechat\Dto\MessageDto;
use Buqiu\EnterpriseWechat\Dto\Moment\MomentResultDto;
use Buqiu\EnterpriseWechat\Dto\MomentDto;
use Buqiu\EnterpriseWechat\Dto\Strategy\UpdateDto;
use Buqiu\EnterpriseWechat\Dto\StrategyDto;
use Buqiu\EnterpriseWechat\Dto\StrategyTag\StrategyTagGroupDto;
use Buqiu\EnterpriseWechat\Dto\StrategyTagDto;
use Buqiu\EnterpriseWechat\Dto\TagDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferCustomerDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferResultDto;
use Buqiu\EnterpriseWechat\Dto\TransferCustomer\TransferUserDto;
use Buqiu\EnterpriseWechat\Dto\UserDto;
use Buqiu\EnterpriseWechat\Dto\WelcomeTemplateDto;
use Buqiu\EnterpriseWechat\Enums\TransferCustomer\TransferStatusEnum;
use Buqiu\EnterpriseWechat\Enums\User\UserStatusEnum;
use Buqiu\EnterpriseWechat\Facades\EnterpriseWechatFacade;
use Buqiu\EnterpriseWechat\Models\CorpTag;
use Buqiu\EnterpriseWechat\Models\Customer;
use Buqiu\EnterpriseWechat\Models\Department;
use Buqiu\EnterpriseWechat\Models\GroupChat;
use Buqiu\EnterpriseWechat\Models\GroupChatMember;
use Buqiu\EnterpriseWechat\Models\Media;
use Buqiu\EnterpriseWechat\Models\Message;
use Buqiu\EnterpriseWechat\Models\Moment;
use Buqiu\EnterpriseWechat\Models\Strategy;
use Buqiu\EnterpriseWechat\Models\StrategyTag;
use Buqiu\EnterpriseWechat\Models\Tag;
use Buqiu\EnterpriseWechat\Models\TransferCustomer;
use Buqiu\EnterpriseWechat\Models\TransferGroupChat;
use Buqiu\EnterpriseWechat\Models\User;
use Buqiu\EnterpriseWechat\Models\WelcomeTemplate;
use Buqiu\EnterpriseWechat\Utils\ArrHelper;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Illuminate\Support\Facades\DB;

class SyncService
{
    /**
     * 同步客户
     */
    public static function customer(ExternalContactDto $externalContactDto, FollowUserDto $followUserDto, array $data = []): Customer
    {
        $customer = Customer::withCorpId()->whereUserId($followUserDto->getUserKey())->whereExternalUserId($externalContactDto->getExternalUserId())->withTrashed()->first();
        if (empty($customer)) {
            $customer = new Customer(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $customer->reset();
        $externalContactDto->fill($customer);
        $followUserDto->fill($customer);

        if (ArrHelper::notEmpty($data, 'welcome_code')) {
            $customer->welcome_code = $data['welcome_code'];
        }

        if (ArrHelper::notEmpty($data, 'state')) {
            $customer->state = $data['state'];
        }

        $customer->saveRestore();

        return $customer;
    }

    /**
     * 修改客户备注信息
     */
    public static function remarkCustomer(RemarkDto $remarkDto): void
    {
        $customer = Customer::withCorpId()->whereUserId($remarkDto->getUserKey())->whereExternalUserId($remarkDto->getExternalUserId())->firstOrFail();
        $remarkDto->fill($customer);
        $customer->save();
    }

    /**
     * 添加客户标签
     */
    public static function addCustomerCorpTag(Customer $customer, string $tag_id): void
    {
        if (in_array($tag_id, $customer->tag_ids)) {
            return;
        }
        $customer->tag_ids = array_merge($customer->tag_ids, [$tag_id]);
        $customer->save();
    }

    /**
     * 添加客户标签
     */
    public static function delCustomerCorpTag(Customer $customer, string|array $tag_id): void
    {
        $customer->tag_ids = array_values(Utils::arrayFilter($customer->tag_ids, $tag_id));
        $customer->save();
    }

    /**
     * 删除客户
     */
    public static function deleteCustomer(User $user, string $external_user_id, ?array $data = []): void
    {
        $customer = Customer::withCorpId()->whereUserId($user->getKey())->whereExternalUserId($external_user_id)->withTrashed()->first();
        if (! $customer) {
            return;
        }
        if (ArrHelper::notEmpty($data, 'delete_source')) {
            $customer->extra = array_merge($customer->extra, ['delete_source' => $data['delete_source']]);
        }
        if (ArrHelper::notEmpty($data, 'delete_type')) {
            $customer->delete_type = $data['delete_type'];
        }
        $customer->delete();
    }

    /**
     * 同步迁移客户
     */
    public static function transferCustomer(TransferUserDto $transferUserDto, TransferCustomerDto $transferCustomerDto): TransferCustomer
    {
        $transferCustomer = new TransferCustomer(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $transferUserDto->fill($transferCustomer);
        $transferCustomerDto->fill($transferCustomer);
        $transferCustomer->save();

        return $transferCustomer;
    }

    /**
     * 同步客户接替状态
     */
    public static function transferCustomerResult(TransferResultDto $transferResultDto): void
    {
        $transfer_customer = TransferCustomer::withCorpId()
            ->whereHandoverUserId($transferResultDto->getHandoverUserId())
            ->whereTakeoverUserId($transferResultDto->getTakeoverUserId())
            ->whereExternalUserId($transferResultDto->getExternalUserId())
            ->whereTransferErrCode(TransferCustomer::TRANSFER_ERR_CODE_SUCCESS)
            ->orderByDesc('id')
            ->first();

        if (! $transfer_customer) {
            return;
        }

        if (! in_array($transfer_customer->transfer_status, [TransferStatusEnum::TRANSFER_STATUS_START->value, TransferStatusEnum::TRANSFER_STATUS_READY->value])) {
            return;
        }

        $transferResultDto->fill($transfer_customer);
        $transfer_customer->save();
    }

    /**
     * 同步回调客户接替失败状态
     */
    public static function transferCustomerFail(TransferResultDto $transferResultDto): void
    {
        $transfer_customer = TransferCustomer::withCorpId()
            ->whereTakeoverUserId($transferResultDto->getTakeoverUserId())
            ->whereExternalUserId($transferResultDto->getExternalUserId())
            ->whereTransferErrCode(TransferCustomer::TRANSFER_ERR_CODE_SUCCESS)
            ->orderBy('id')
            ->first();

        if (! $transfer_customer) {
            return;
        }

        if (! in_array($transfer_customer->transfer_status, [TransferStatusEnum::TRANSFER_STATUS_START->value, TransferStatusEnum::TRANSFER_STATUS_READY->value])) {
            return;
        }

        $transferResultDto->fill($transfer_customer);
        $transfer_customer->save();
    }

    /**
     * 同步部门数据
     */
    public static function department(DepartmentDto $departmentDto): Department
    {
        $department = Department::withCorpId()->whereDepartmentId($departmentDto->getId())->withTrashed()->first();
        if (! $department) {
            $department = new Department(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $departmentDto->fill($department->reset());
        $department->saveRestore();

        return $department;
    }

    /**
     * 同步部门路径
     */
    public static function departmentPath(Department $department): Department
    {
        if ($department->parent_id) {
            $parentDepartment = Department::withCorpId()->whereDepartmentId($department->parent_id)->firstOrFail();
        }
        $department->path = isset($parentDepartment) ? array_merge($parentDepartment->path, [$department->department_id]) : [$department->department_id];
        $department->save();

        return $department;
    }

    /**
     * 同步子部门路径
     */
    public static function departmentChildrenPath(Department $department): void
    {
        $children = Department::withCorpId()->whereParentId($department->department_id)->get();
        foreach ($children as $child) {
            $child->path = array_merge($department->path, [$child->department_id]);
            $child->save();
            self::departmentCallPath($child);
        }
    }

    /**
     * 同步部门和子部门路径
     */
    public static function departmentCallPath(Department $department): void
    {
        self::departmentPath($department);
        self::departmentChildrenPath($department);
    }

    /**
     * 删除部门
     */
    public static function deleteDepartment(int $department_id): void
    {
        Department::withCorpId()->whereDepartmentId($department_id)->delete();
    }

    /**
     * 同步标签
     */
    public static function tag(TagDto $tagDto): Tag
    {
        $tag = Tag::withCorpId()->whereTagId($tagDto->getTagId())->withTrashed()->first();
        if (! $tag) {
            $tag = new Tag(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $tagDto->fill($tag->reset());
        $tag->saveRestore();

        return $tag;
    }

    /**
     * 删除标签
     */
    public static function deleteTag(int $tag_id): void
    {
        Tag::withCorpId()->whereTagId($tag_id)->delete();
    }

    /**
     * 同步成员
     */
    public static function user(UserDto $userDto, ?string $new_user_id = null): User
    {
        $user = User::withCorpId()->whereAccountId($userDto->getUserId())->withTrashed()->first();
        if ($new_user_id) {
            $userDto->setUserId($new_user_id);
        }
        if (! $user) {
            $user = new User(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $userDto->fill($user->reset());
        $user->saveRestore();

        return $user;
    }

    /*
    * 删除部门成员
    */
    public static function deleteDepartmentUser(string $department_id): void
    {
        User::withCorpId()->whereDepartmentId($department_id)->delete();
    }

    /*
    * 离职部门成员
    */
    public static function resignDepartmentUser(string $department_id): void
    {
        User::withCorpId()->whereDepartmentId($department_id)->update(['status' => UserStatusEnum::STATUS_RESIGN->value]);
    }

    /**
     * 删除成员
     */
    public static function deleteUser(array|string $user_id_list): void
    {
        $user_id_list = is_array($user_id_list) ? $user_id_list : [$user_id_list];

        User::withCorpId()->whereIn('account_id', $user_id_list)->delete();
    }

    /**
     * 同步配置客户联系功能成员
     */
    public static function enableCustomerUser(array $follow_users): void
    {
        User::withCorpId()->update(['customer_enabled' => User::CUSTOMER_DISABLE]);
        User::withCorpId()->whereIn('account_id', $follow_users)->update(['customer_enabled' => User::CUSTOMER_ENABLED]);
    }

    /**
     * 同步添加成员标签
     */
    public static function addUserTagId(User $user, int $tag_id): void
    {
        if (in_array($tag_id, $user->tag_ids)) {
            return;
        }
        $user->tag_ids = array_merge($user->tag_ids, [$tag_id]);
        $user->save();
    }

    /**
     * 同步删除成员标签
     */
    public static function deleteUserTagId(User $user, int $tag_id): void
    {
        $user->tag_ids = array_values(Utils::arrayFilter($user->tag_ids, $tag_id));
        $user->save();
    }

    /**
     * 同步企业标签
     */
    public static function corpTag(CorpTagGroupDto $corpTagGroupDto, CorpTagDto $corpTagDto): ?CorpTag
    {
        $corpTag = CorpTag::withCorpId()->whereGroupId($corpTagGroupDto->getGroupId())->whereTagId($corpTagDto->getId())->withTrashed()->first();
        if ($corpTagDto->getDeleted()) {
            if (! $corpTag) {
                return null;
            }
            if ($corpTag->trashed()) {
                return $corpTag;
            }
            $corpTag->delete();

            return $corpTag;
        }

        if (! $corpTag) {
            $corpTag = new CorpTag(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $corpTag->reset();
        $corpTagGroupDto->fill($corpTag);
        $corpTagDto->fill($corpTag);
        $corpTag->saveRestore();

        return $corpTag;
    }

    /**
     * 删除企业标签
     */
    public static function deleteCorpTag(array $tag_id = [], array $group_id = []): void
    {
        //        $corpTags = CorpTag::withCorpId()->whereIn('tag_id', $tag_id)->get();
        //        foreach ($corpTags as $corpTag) {
        //            Customer::withCorpId()->whereJsonContains('tag_ids', $corpTag->tag_id)->update([
        //                'tag_ids' => DB::raw("JSON_REMOVE(tag_ids, JSON_UNQUOTE(JSON_SEARCH(tag_ids, 'one', '".$corpTag->tag_id."')))"),
        //            ]);
        //        }
        CorpTag::withCorpId()->whereIn('tag_id', $tag_id)->delete();

        //        $corpTags = CorpTag::withCorpId()->whereIn('group_id', $group_id)->get();
        //        foreach ($corpTags as $corpTag) {
        //            Customer::withCorpId()->whereJsonContains('tag_ids', $corpTag->tag_id)->update([
        //                'tag_ids' => DB::raw("JSON_REMOVE(tag_ids, JSON_UNQUOTE(JSON_SEARCH(tag_ids, 'one', '".$corpTag->tag_id."')))"),
        //            ]);
        //        }

        CorpTag::withCorpId()->whereIn('group_id', $group_id)->delete();
    }

    /**
     * 编辑客户标签
     */
    public static function remarkCustomerTag(CorpTagMarkDto $corpTagMarkDto): void
    {
        $user     = User::withCorpId()->whereAccountId($corpTagMarkDto->getUserId())->firstOrFail();
        $customer = Customer::withCorpId()->whereUserId($user->id)->whereExternalUserId($corpTagMarkDto->getExternalUserId())->firstOrFail();

        $addTagIds    = array_values(Utils::arrayFilter($corpTagMarkDto->getAddTag(), $corpTagMarkDto->getRemoveTag()));
        $removeTagIds = array_values(Utils::arrayFilter($corpTagMarkDto->getRemoveTag(), $corpTagMarkDto->getAddTag()));
        $addTagIds    = array_unique(array_merge($customer->tag_ids, $addTagIds));

        $customer->tag_ids = array_unique(array_values(Utils::arrayFilter($addTagIds, $removeTagIds)));
        $customer->save();
    }

    /**
     * 发送应用消息
     */
    public static function appMessage(MessageDto $messageDto): Message
    {
        $message = new Message(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $messageDto->fill($message);
        $message->msg_type = Message::MSG_TYPE_APP;
        $message->save();

        return $message;
    }

    /**
     * 发送机器人
     */
    public static function botMessage(BotDto $botDto): Message
    {
        $message = new Message(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $botDto->fill($message);
        $message->msg_type = Message::MSG_TYPE_BOT;
        $message->save();

        return $message;
    }

    /**
     * 发送欢迎语
     */
    public static function welcomeMessage(WelcomeMessageDto $welcomeMessageDto): Message
    {
        $message = new Message(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $welcomeMessageDto->fill($message);
        $message->msg_type = Message::MSG_TYPE_WELCOME;
        $message->save();

        return $message;
    }

    /**
     * 发送群聊
     */
    public static function groupMessage(GroupMessageDto $messageDto): Message
    {
        $message = new Message(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $messageDto->fill($message);
        $message->msg_type = Message::MSG_TYPE_GROUP;
        $message->save();

        return $message;
    }

    /**
     * 添加素材
     */
    public static function media(MediaDto $mediaDto): void
    {
        $media = new Media(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $mediaDto->fill($media);
        $media->upload_mode = Media::UPLOAD_MODE_SYNC;
        $media->save();
    }

    /**
     * 添加异步素材
     */
    public static function mediaUrl(MediaUrlDto $mediaUrlDto): void
    {
        $media = new Media(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $mediaUrlDto->fill($media);
        $media->upload_mode = Media::UPLOAD_MODE_ASYNC;
        $media->save();
    }

    /**
     * 添加异步素材
     */
    public static function mediaUrlResult(MediaUrlDto $mediaUrlDto): void
    {
        $media = Media::withCorpId()->whereJobId($mediaUrlDto->getJobId())->first();
        if (! $media) {
            return;
        }
        $mediaUrlDto->fill($media);
        $media->save();
    }

    public static function strategy(StrategyDto $strategyDto): Strategy
    {
        $strategy = Strategy::withCorpId()->whereStrategyId($strategyDto->getStrategyId())->first();
        if (! $strategy) {
            $strategy = new Strategy(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $strategyDto->fill($strategy);
        $strategy->save();

        return $strategy;
    }

    /**
     * 同步部门路径
     */
    public static function strategyPath(Strategy $strategy): Strategy
    {
        if ($strategy->parent_id) {
            $parentStrategy = Strategy::withCorpId()->whereStrategyId($strategy->parent_id)->firstOrFail();
        }
        $strategy->path = isset($parentStrategy) ? array_merge($parentStrategy->path, [$strategy->strategy_id]) : [$strategy->strategy_id];
        $strategy->save();

        return $strategy;
    }

    /**
     * 同步子部门路径
     */
    public static function strategyChildrenPath(Strategy $strategy): void
    {
        $children = Strategy::withCorpId()->whereParentId($strategy->strategy_id)->get();
        foreach ($children as $child) {
            $child->path = array_merge($strategy->path, [$child->strategy_id]);
            $child->save();
            self::strategyChildrenPath($child);
        }
    }

    /**
     * 同步部门和子部门路径
     */
    public static function strategyCallPath(Strategy $strategy): void
    {
        self::strategyPath($strategy);
        self::strategyChildrenPath($strategy);
    }

    /**
     * 编辑规则组范围
     */
    public static function modifyStrategy(UpdateDto $strategyDto): void
    {
        $strategy = Strategy::withCorpId()->whereStrategyId($strategyDto->getStrategyId())->firstOrFail();

        $strategyDto->fill($strategy);

        [$add_range_user, $add_range_party] = StrategyService::parseRange($strategyDto->getRangeAdd());
        [$del_range_user, $del_range_party] = StrategyService::parseRange($strategyDto->getRangeDel());

        $addRangeUser         = array_values(Utils::arrayFilter($add_range_user, $del_range_user));
        $removeRangeUser      = array_values(Utils::arrayFilter($del_range_user, $add_range_user));
        $addRangeUser         = array_unique(array_merge($strategy->range_user, $addRangeUser));
        $strategy->range_user = array_unique(array_values(Utils::arrayFilter($addRangeUser, $removeRangeUser)));

        $addRangeParty         = array_values(Utils::arrayFilter($add_range_party, $del_range_party));
        $removeRangeParty      = array_values(Utils::arrayFilter($del_range_party, $add_range_party));
        $addRangeParty         = array_unique(array_merge($strategy->range_party, $addRangeParty));
        $strategy->range_party = array_unique(array_values(Utils::arrayFilter($addRangeParty, $removeRangeParty)));

        $strategy->save();
    }

    /**
     * 删除规则
     */
    public static function deleteStrategy(int $strategy_id): void
    {
        Strategy::withCorpId()->whereStrategyId($strategy_id)->delete();
    }

    /**
     * 同步欢迎语素材
     */
    public static function welcomeTemplate(WelcomeTemplateDto $welcomeTemplateDto): WelcomeTemplate
    {
        $welcomeTemplate = WelcomeTemplate::withCorpId()->whereTemplateId($welcomeTemplateDto->getTemplateId())->withTrashed()->first();
        if (! $welcomeTemplate) {
            $welcomeTemplate = new WelcomeTemplate(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $welcomeTemplateDto->fill($welcomeTemplate);
        $welcomeTemplate->save();

        return $welcomeTemplate;
    }

    /**
     * 删除欢迎语素材
     */
    public static function deleteWelcomeTemplate(string $templateId): void
    {
        WelcomeTemplate::withCorpId()->whereTemplateId($templateId)->delete();
    }

    /**
     * 同步客户群
     */
    public static function groupChat(GroupChatDto $groupChatDto): GroupChat
    {
        $groupChat = GroupChat::withCorpId()->whereChatId($groupChatDto->getChatId())->withTrashed()->first();
        if (! $groupChat) {
            $groupChat = new GroupChat(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $groupChat->reset();
        $groupChatDto->fill($groupChat);
        $groupChat->saveRestore();

        return $groupChat;
    }

    /**
     * 同步群成员
     */
    public static function groupChatMember(GroupChatDto $groupChatDto, GroupChatMemberDto $groupChatMemberDto): GroupChatMember
    {
        $groupChatMember = GroupChatMember::withCorpId()->whereChatId($groupChatDto->getChatId())->whereType($groupChatMemberDto->getType())->whereUserId($groupChatMemberDto->getUserId())->withTrashed()->first();
        if (! $groupChatMember) {
            $groupChatMember = new GroupChatMember(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $groupChatMember->reset();
        $groupChatMember->chat_id = $groupChatDto->getChatId();
        $groupChatMemberDto->fill($groupChatMember, $groupChatDto->getAdminList());
        $groupChatMember->saveRestore();

        return $groupChatMember;
    }

    /**
     * 同步企业标签
     */
    public static function strategyTag(StrategyTagGroupDto $strategyTagGroupDto, StrategyTagDto $strategyTagDto): StrategyTag
    {
        $strategyTag = StrategyTag::withCorpId()->whereGroupId($strategyTagGroupDto->getGroupId())->whereTagId($strategyTagDto->getId())->withTrashed()->first();
        if (! $strategyTag) {
            $strategyTag = new StrategyTag(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        }
        $strategyTag->reset();
        $strategyTagGroupDto->fill($strategyTag);
        $strategyTagDto->fill($strategyTag);
        $strategyTag->saveRestore();

        return $strategyTag;
    }

    /**
     * 删除企业标签
     */
    public static function deleteStrategyTag(array $tag_id = [], array $group_id = []): void
    {
        $strategyTags = StrategyTag::withCorpId()->whereIn('tag_id', $tag_id)->get();
        foreach ($strategyTags as $strategyTag) {
            Strategy::withCorpId()->whereJsonContains('tag_ids', $strategyTag->tag_id)->update([
                'tag_ids' => DB::raw("JSON_REMOVE(tag_ids, JSON_UNQUOTE(JSON_SEARCH(tag_ids, 'one', '".$strategyTag->tag_id."')))"),
            ]);
        }
        StrategyTag::withCorpId()->whereIn('tag_id', $tag_id)->delete();

        $strategyTags = StrategyTag::withCorpId()->whereIn('group_id', $group_id)->get();
        foreach ($strategyTags as $strategyTag) {
            Strategy::withCorpId()->whereJsonContains('tag_ids', $strategyTag->tag_id)->update([
                'tag_ids' => DB::raw("JSON_REMOVE(tag_ids, JSON_UNQUOTE(JSON_SEARCH(tag_ids, 'one', '".$strategyTag->tag_id."')))"),
            ]);
        }
        StrategyTag::withCorpId()->whereIn('group_id', $group_id)->delete();
    }

    /**
     * 修改群主
     */
    public static function modifyGroupChatOwner(string $owner_id, string $chat_id): void
    {
        $user      = User::withCorpId()->whereAccountId($owner_id)->firstOrFail();
        $groupChat = GroupChat::withCorpId()->whereChatId($chat_id)->withTrashed()->firstOrFail();

        $groupChat->owner_id = $user->id;
        $groupChat->save();
    }

    /**
     * 分配客户群
     */
    public static function groupChatTransfer(GroupChatTransferDto $groupChatTransferDto): TransferGroupChat
    {
        $transferGroupChat = new TransferGroupChat(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $groupChatTransferDto->fill($transferGroupChat);
        $transferGroupChat->save();

        return $transferGroupChat;
    }

    /**
     * 朋友圈
     */
    public static function moment(MomentDto $momentDto): Moment
    {
        $moment = new Moment(['corp_id' => EnterpriseWechatFacade::getCorpId()]);
        $momentDto->fill($moment);
        $moment->save();

        return $moment;
    }

    /**
     * 朋友圈结果
     */
    public static function momentResult(string $job_id, MomentResultDto $momentResultDto): Moment
    {
        $moment = Moment::withCorpId()->whereJobId($job_id)->firstOrFail();
        $momentResultDto->fill($moment);
        $moment->save();

        return $moment;
    }

    /**
     * 取消朋友圈
     */
    public static function cancelMoment(string $moment_id): void
    {
        Moment::withCorpId()->whereMomentId($moment_id)->delete();
    }
}
