<?php


namespace generator;

use generator\util\Identity;

abstract class BaseUtil
{
    const MAX = 100;        //最大生成条数

    const MALE = 1;         //性别：1男
    const FEMALE = 2;       //性别：2女


    /**
     * @var int 限制条数
     */
    protected $limit = 1;

    /**
     * @var array 最近参数
     */
    protected $padding = [];

    /**
     * @var array 属性信息
     */
    protected $attributes;

    /**
     * @var mixed 性别编号
     */
    protected $sex;

    /**
     * 生成条数
     * @param $limit
     * @return $this
     */
    public function limit($limit)
    {
        $limit = (int)$limit ?: 1;
        $limit = ($limit >= self::MAX) ? self::MAX : $limit;
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * 获取生成的省份证号码
     * @return array|string
     */
    public function get()
    {
        $limit = $this->getLimit();
        if ($limit > 1) {
            $data = [];
            for ($i = 0; $i < $this->getLimit(); $i++) {
                $data[] = $this->generate();
            }
            return $data;
        } else {
            return $this->generate();
        }
    }

    /**
     * @return mixed 生成信息
     */
    public abstract function generate();

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

    /**
     * 是否是额外参数
     * @param $value
     * @return bool
     */
    public function isPadding($value): bool
    {
        if (in_array($value, $this->getPadding())) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getPadding(): array
    {
        return $this->padding;
    }

    /**
     * 获取性别信息
     * @return float|int
     */
    public function getSex()
    {
        $this->setSex();
        return $this->sex;
    }

    /**
     * 设置性别
     * @return $this
     */
    protected function setSex()
    {
        // sex is null , random 1 - 8
        if (!isset($this->attributes['sex'])) {
            $sex = random_int(1, 8);
        } elseif ($this->attributes['sex'] == self::MALE) {
            // sex is male
            $sex = 2 * random_int(1, 4) - 1;
        } else {
            // sex is female
            $sex = 2 * random_int(1, 4);
        }
        $this->sex = $sex;
        return $this;
    }
}
