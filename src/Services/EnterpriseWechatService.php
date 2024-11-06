<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Models\Corp;
use Exception;
use Illuminate\Contracts\Foundation\Application;

class EnterpriseWechatService
{
    protected ?CorpService $corpService = null;

    public array $services = [];

    public ?string $corp_id = null;

    public ?string $code = null;

    public function __construct(protected Application $app) {}

    /**
     * @throws Exception
     */
    public function connect(?string $id = null, ?string $code = null): static
    {
        if (! $this->corpService) {
            $this->corpService = new CorpService;
        }
        $this->corpService->setCorp(id: $id, code: $code);
        $corp = $this->corpService->getCorp();

        $this->corp_id = $corp->corp_id;
        $this->code    = $corp->code;

        return $this;
    }

    public function getCorp(): ?Corp
    {
        return $this->corpService?->getCorp();
    }

    public function setCorpId(?string $corp_id): void
    {
        $this->corp_id = $corp_id;
    }

    public function getCorpId(): ?string
    {
        return $this->corp_id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @throws Exception
     */
    public function __call($method, $parameters)
    {
        if (! $this->getCorp()) {
            throw new Exception('cannot find corp driver');
        }

        $class = '\\Buqiu\\EnterpriseWechat\\Libs\\'.ucfirst($method);

        if (isset($this->services[$class])) {
            return $this->services[$class];
        }
        $instance = '\\Buqiu\\EnterpriseWechat\\Api\\'.ucfirst($method);

        $this->services[$class] = new $class(new $instance);

        return $this->services[$class];
    }
}
