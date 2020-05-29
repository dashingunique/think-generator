<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 邮箱地址生成器
 * +----------------------------------------------------------------------
 */

namespace dashing\generator\util;

use dashing\generator\BaseUtil;
use library\Collection;

class Email extends BaseUtil
{
    /**
     * @var string 邮箱前缀
     */
    protected $prefix;

    // 字符集合
    protected $codeSet = '0123456789abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';

    // 位数
    protected $length = 8;

    /**
     * @var string[] 常用邮箱后缀
     */
    protected $mailboxSuffix = [
        '@qq.com',
        '@163.com',
        '@sina.com',
        '@sohu.com',
        '@gmail.com',
        '@yahoo.com',
        '@msn.com',
        '@hotmail.com',
        '@aol.com',
        '@ask.com',
        '@live.com',
        '@0355.net',
        '@163.net',
        '@263.net',
        '@3721.net',
        '@yeah.net',
        '@googlemail.com',
        '@mail.com',
        '@sina.com',
        '@21cn.com',
        '@yahoo.com.cn',
        '@etang.com',
        '@eyou.com',
        '@56.com',
        '@x.cn',
        '@chinaren.com',
        '@sogou.com',
        '@citiz.com'
    ];

    /**
     * @var string 邮箱后缀
     */
    protected $suffix;

    /**
     * 获取邮箱前缀
     * @return string
     */
    public function getPrefix()
    {
        $this->setPrefix();
        return $this->prefix;
    }

    /**
     * 设置邮箱前缀
     * @return $this
     */
    public function setPrefix()
    {
        $regexp = "/^[a-zA-Z0-9]*$/";
        if (isset($this->attributes['prefix']) && preg_match($regexp, $this->attributes['prefix'])) {
            $this->prefix = $this->attributes['prefix'];
        } else {
            $characters = str_split($this->codeSet);
            $prefix = '';
            for ($i = 0; $i < $this->getLength(); $i++) {
                $value = $characters[rand(0, count($characters) - 1)];
                if (empty($i) && empty($value)) {
                    $prefix .= rand(1,9);
                } else {
                    $prefix .= $value;
                }
            }
            $this->prefix = $prefix;
        }
        return $this;
    }

    /**
     * 获取邮箱前缀长度
     * @return mixed
     */
    public function getLength()
    {
        if (isset($this->attributes['length'])) {
            $this->length = $this->attributes['length'];
        }
        return $this->length;
    }

    /**
     * 获取邮箱后缀
     * @return string
     */
    public function getSuffix()
    {
        $this->setSuffix();
        return $this->suffix;
    }

    /**
     * 设置邮箱后缀
     * @return $this
     */
    public function setSuffix()
    {
        $mailboxSuffix = new Collection($this->mailboxSuffix);
        if (isset($this->attributes['suffix']) && in_array($this->attributes['suffix'], $mailboxSuffix->all())) {
            $this->suffix = $this->attributes['suffix'];
        } else {
            $this->suffix = $mailboxSuffix->random();
        }
        return $this;
    }

    /**
     * @return mixed 生成信息
     */
    public function generate()
    {
        return $this->getPrefix() . $this->getSuffix();
    }
}