<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 手机号码生成器
 * +----------------------------------------------------------------------
 */

namespace dashing\generator\util;

use dashing\generator\BaseUtil;
use think\helper\Arr;

class Mobile extends BaseUtil
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
        $this->setPrefix();
        return $this->prefix;
    }

    /**
     * 设置手机号前缀
     * @return $this
     */
    public function setPrefix()
    {
        if (isset($this->attributes['prefix'])) {
            $this->prefix = $this->attributes['prefix'];
        } else {
            $allowPrefix = $this->getAllowPrefix();
            $this->prefix = 1 . Arr::random($allowPrefix) . mt_rand(0, 9);
        }
        return $this;
    }

    /**
     * 获取允许的号码段（手机号第二位）
     * @return array
     */
    public function getAllowPrefix(): array
    {
        $this->setAllowPrefix();
        return $this->allowPrefix;
    }

    /**
     * 设置允许的号码段（手机号第二位）
     * @param  array  $allow
     * @return $this
     */
    public function setAllowPrefix(array $allow = [])
    {
        if (isset($this->attributes['allow'])) {
            if (is_string($this->attributes['allow']) && strpos($this->attributes['allow'], ',')) {
                $this->allowPrefix = explode(',', $this->attributes['allow']);
            } elseif (is_array($this->attributes['allow'])) {
                $this->allowPrefix = $this->attributes['allow'];
            }
        } else {
            if (empty($allow)) {
                $allow = [3, 4, 5, 7, 8, 9];
            }
            $this->allowPrefix = $allow;
        }
        return $this;
    }

    /**
     * 生成手机号码
     * @return string
     */
    public function generate()
    {
        return $this->getPrefix() . str_pad(rand(0,99999999),8,0,STR_PAD_LEFT);
    }
}