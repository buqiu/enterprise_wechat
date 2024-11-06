<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Services;

use Buqiu\EnterpriseWechat\Models\Corp;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CorpService
{
    protected array $codes = [];

    protected array $corp_ids = [];

    protected array $ids = [];

    protected ?Corp $corp = null;

    /**
     * 基于 id|code 获取 Corp 数据
     */
    public function findCorp(?string $id = null, ?string $code = null): mixed
    {
        if (! is_null($id)) {
            return Corp::findOrFail($id);
        }

        if (! is_null($code)) {
            return Corp::whereCode($code)->firstOrFail();
        }

        throw (new ModelNotFoundException)->setModel(
            Corp::class, array_filter([$id, $code])
        );
    }

    /**
     * 绑定 Corp 数据
     */
    public function bindCorp(Corp $corp): Corp
    {
        $this->corp_ids[$corp->corp_id] = $corp->id;
        $this->codes[$corp->code]       = $corp->id;
        $this->ids[$corp->id]           = $corp;

        return $corp;
    }

    /**
     * 基于 id 获取 Corp 数据
     *
     * @return Corp|mixed
     */
    public function getCorpById(string $id): mixed
    {
        if (isset($this->ids[$id])) {
            return $this->ids[$id];
        }

        return $this->bindCorp($this->findCorp(id: $id));

    }

    /**
     * 基于 code 获取 Corp 数据
     *
     * @return Corp|mixed
     */
    public function getCorpByCode(string $code): mixed
    {
        if (isset($this->codes[$code])) {
            return $this->ids[$this->codes[$code]];
        }

        return $this->bindCorp($this->findCorp(code: $code));
    }

    /**
     * 设置 Corp 数据
     *
     * @throws Exception
     */
    public function setCorp(?string $id = null, ?string $code = null): ?Corp
    {
        $this->corp = null;

        if (! is_null($id)) {
            $this->corp = $this->getCorpById($id);
        }

        if (is_null($this->corp) && ! is_null($code)) {
            $this->corp = $this->getCorpByCode($code);
        }

        if (is_null($this->corp)) {
            throw new Exception('Cannot find corp driver');
        }

        return $this->corp;
    }

    /**
     * 获取 Corp 数据
     */
    public function getCorp(): ?Corp
    {
        return $this->corp;
    }
}
