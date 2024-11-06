<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Dto;

use Buqiu\EnterpriseWechat\Utils\ErrorHelper\ParamsError;
use Buqiu\EnterpriseWechat\Utils\Utils;
use Exception;
use ReflectionClass;

class Dto
{
    protected array $data = [];

    protected array $valid_require_property = [];

    protected array $exclude_property = [];

    /**
     * @throws Exception
     */
    public function __construct(protected array $params = [])
    {
        $this->setParams($this->params);
        $this->excludeProperty();
        $this->validParams();
    }

    /**
     * 排除的属性
     */
    public function excludeProperty(): void
    {
        foreach ($this->exclude_property as $property) {
            unset($this->$property);
        }
    }

    /**
     * 参数验证
     *
     * @throws Exception
     */
    protected function validParams(): void
    {
        foreach ($this->valid_require_property as $property) {
            if (Utils::empty($this->$property)) {
                throw new Exception($property.': '.ParamsError::ERR_MSG[ParamsError::PARAMS_EMPTY]);
            }
        }
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function issetParam($key): bool
    {
        return isset($this->params[$key]);
    }

    /**
     * 获取 Data 数据
     */
    public function getData(): array
    {
        if ($this->data) {
            return $this->data;
        }

        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            if (! $property->isPublic()) {
                continue;
            }
            $name = $property->getName();
            if (! isset($this->$name) || Utils::empty($this->$name)) {
                continue;
            }
            $this->data[$name] = $this->$name;
        }

        return $this->data;
    }

    /**
     * 重置对象属性
     */
    public function reset(): static
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            if (! $property->isPublic()) {
                continue;
            }
            $name = $property->getName();
            if (isset($this->$name)) {
                unset($this->$name);
            }
        }

        return $this;
    }

    /**
     * 对 Params 赋值
     *
     * @throws Exception
     */
    public function setParams(array $params = []): static
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * 对 Data 赋值
     *
     * @throws Exception
     */
    public function setData(array $data = []): static
    {
        $this->data = [];
        $this->setParams($data);
        $this->params = array_merge($this->params, $data);

        return $this;
    }
}
