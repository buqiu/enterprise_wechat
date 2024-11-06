<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;

class Command extends \Illuminate\Console\Command
{
    /**
     * Corp Title
     */
    protected string $id = 'Id';

    /**
     * Corp Title
     */
    protected string $corp_id = 'CorpId';

    /**
     * Secret title
     */
    protected string $corp_secret = 'Secret';

    /**
     * Secret title
     */
    protected string $code = '应用标识(Code)';

    /**
     * @var string
     */
    protected string $token = 'Token';

    /**
     * @var string
     */
    protected string $encoding_aes_key = 'EncodingAESKey';

    /**
     * @var string
     */
    protected string $agent_id = 'AgentId';

    public function getCorpAsks(array $data = []): array
    {
        $corp_id          = $this->ask("请输入{$this->corp_id}", '');
        $corp_secret      = $this->ask("请输入{$this->corp_secret}", '');
        $token            = $this->ask("请输入{$this->token}", '');
        $encoding_aes_key = $this->ask("请输入{$this->encoding_aes_key}", '');
        $agent_id         = $this->ask("请输入{$this->agent_id}", '');

        return array_merge($data, [
            'corp_id'          => $corp_id,
            'corp_secret'      => $corp_secret,
            'token'            => $token,
            'encoding_aes_key' => $encoding_aes_key,
            'agent_id'         => $agent_id,
        ]);
    }

    public function view(Corp $corp): void
    {
        $this->table(
            ['ID', $this->code, $this->corp_id, $this->corp_secret,  $this->token, $this->encoding_aes_key, $this->agent_id],
            [[$corp->id, $corp->code, $corp->corp_id, $corp->corp_secret, $corp->token, $corp->encoding_aes_key, $corp->agent_id]]
        );
    }

    public function confirmUpdate(): void
    {
        if (! $this->confirm("确认更新 {$this->id} 账号吗?")) {
            $this->components->error('取消操作');
            exit;
        }
    }

    public function confirmDelete(): void
    {
        if (! $this->confirm("确认删除 {$this->id} 账号吗?")) {
            $this->components->error('取消操作');
            exit;
        }
    }

    public function clearCache($key): void
    {
        app('cache')->forget(sprintf('enterprise_wechat:access_token:%s', $key));
    }
}
