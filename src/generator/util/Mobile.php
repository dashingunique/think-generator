<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 手机号码生成器
 * +----------------------------------------------------------------------
 */

namespace generator\util;

use think\helper\Arr;

class Mobile
{
    /**
     * @var string 手机号前缀：例如136
     */
    protected $prefix = '';

    /**
     * @var array 允许的号码段
     */
    protected $allowPrefix = [];

    /**
     * 获取手机号前缀
     * @return string
     */
    public function getPrefix()
    {
        if (empty($this->prefix)) {
            $this->setPrefix();
        }
        return $this->prefix;
    }

    /**
     * 设置手机号前缀
     * @param  string  $prefix
     * @return $this
     */
    public function setPrefix(string $prefix = '')
    {
        $allowPrefix = $this->getAllowPrefix();
        if (empty($prefix)) {
            $prefix .= 1;
            $prefix .= $allowPrefix[Arr::random($allowPrefix)];
            $prefix .= rand(0, 9);
        }
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * 获取允许的号码段（手机号第二位）
     * @return array
     */
    public function getAllowPrefix(): array
    {
        if (empty($this->allowPrefix)) {
            $this->setAllowPrefix();
        }
        return $this->allowPrefix;
    }

    /**
     * 设置允许的号码段（手机号第二位）
     * @param  array  $allow
     * @return $this
     */
    public function setAllowPrefix(array $allow = [])
    {
        if (empty($allow)) {
            $allow = [3, 4, 5, 7, 8, 9];
        }
        $this->allowPrefix = $allow;
        return $this;
    }

    /**
     * 获取手机号码
     * @return string
     */
    public function make()
    {
        return $this->getPrefix() . str_pad(rand(00000000,99999999),8,0,STR_PAD_LEFT);
    }
}