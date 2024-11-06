<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Commands;

use Buqiu\EnterpriseWechat\Models\Corp;

class ListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise-wechat:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '展示企微账号';


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->table(
            ['ID', $this->code, $this->corp_id, $this->corp_secret,  $this->token, $this->encoding_aes_key, $this->agent_id],
            Corp::all(['id', 'code', 'corp_id', 'corp_secret', 'token', 'encoding_aes_key', 'agent_id'])->toArray()
        );
    }
}
