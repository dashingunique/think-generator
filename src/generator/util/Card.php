<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 身份证号码生成器
 * +----------------------------------------------------------------------
 */

namespace generator\util;

use library\Collection;

class Card
{
    /**
     * 省份集合
     * @var Collection
     */
    protected Collection $provinces;

    /**
     * 城市集合
     * @var Collection
     */
    protected Collection $cities;

    protected $padding;

    protected array $attributes;

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (!is_null($arguments) && isset($arguments[0])) {
            $this->setAttributes($name, $arguments[0]);
        }
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    protected function setAttributes($key, $value)
    {
        if ($this->isPadding($key)) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    public function isPadding($value): bool
    {
        if (!in_array($value, $this->getPadding())) {
            return false;
        }
        return true;
    }

    public function getPadding(): array
    {
        return $this->padding;
    }

    /**
     * 获取省份集合
     * @return Collection
     */
    public function getProvinces()
    {
        if (empty($this->provinces)) {
            $this->loadProvinces();
        }
        return $this->provinces;
    }

    /**
     * 获取城市集合
     * @return Collection
     */
    public function getCities()
    {
        if (empty($this->cities)) {
            $this->loadCity();
        }
        return $this->cities;
    }

    /**
     * 加载省份信息
     * @return $this
     */
    protected function loadProvinces()
    {
        if (empty($this->provinces)) {
            $this->provinces = uniqueCollection(json_decode(file_get_contents(generatorPath().'/data/provinces.json'),
                true));
        }
        return $this;
    }

    /**
     * 加载城市信息
     * @return $this
     */
    protected function loadCity()
    {
        if (empty($this->cities)) {
            $this->cities = uniqueCollection(json_decode(file_get_contents(generatorPath().'/data/cities.json'), true));
        }
        return $this;
    }

    public function make()
    {

    }
}