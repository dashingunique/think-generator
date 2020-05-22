<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 随机生成器
 * +----------------------------------------------------------------------
 */

namespace generator;

use think\Manager;

class Generator extends Manager
{
    protected $namespace = '\\generator\\util\\';

    /**
     * 生成器
     * @param  string  $name
     * @return mixed
     */
    public function generator(string $name)
    {
        return $this->driver(ucfirst($name));
    }

    /**
     * 默认驱动
     * @return string|null
     */
    public function getDefaultDriver()
    {
        return null;
    }
}