<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 名称生成器
 * +----------------------------------------------------------------------
 */

namespace dashing\generator\util;

use dashing\generator\BaseUtil;
use library\Collection;

class Nickname extends BaseUtil
{
    /**
     * @var string 姓氏
     */
    protected $surname;

    /**
     * @var string 名字
     */
    protected $lastName;

    /**
     * @var int 姓氏类型：1单姓 2复姓
     */
    protected $compound;

    /**
     * @var int 名长
     */
    protected $nameLength;

    /**
     * 获取复姓长度
     * @return int
     */
    public function getCompound()
    {
        if (isset($this->attributes['compound']) && $this->attributes['compound'] <= 2) {
            $this->compound = $this->attributes['compound'];
        } else {
            $this->compound = mt_rand(1, 2);
        }
        return $this->compound;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        $this->setSurname();
        return $this->surname;
    }

    /**
     * @return $this
     */
    public function setSurname()
    {
        if (isset($this->attributes['surname'])) {
            $this->surname = $this->attributes['surname'];
        } else {
            $file = file_get_contents(generatorPath().'/data/surname.json');
            $surnameData = new Collection(json_decode($file, true));
            $surname = $surnameData->where('length', $this->getCompound())->random();
            $this->surname = $surname['surname'];
        }
        return $this;
    }

    /**
     * 获取名字
     * @return string
     */
    public function getName()
    {
        $this->setName();
        return $this->lastName;
    }

    /**
     * @return Nickname
     */
    protected function setSex(): Nickname
    {
        if (isset($this->attributes['sex'])) {
            $this->sex = $this->attributes['sex'];
        } else {
            $this->sex = mt_rand(self::MALE, self::FEMALE);
        }
        return $this;
    }

    /**
     * 设置名字信息
     * @return $this
     */
    public function setName()
    {
        $file = file_get_contents(generatorPath().'/data/name.json');
        $nameData = new Collection(json_decode($file, true));
        $nameCollect = $nameData->where('sex', $this->getSex());
        $name = '';
        for ($i = 0; $i < $this->getLength(); $i++) {
            $nameItem = $nameCollect->random();
            $name .= $nameItem['name'];
        }
        $this->lastName = $name;
        return $this;
    }

    /**
     * 获取名字长度
     * @return $this
     */
    public function getLength()
    {
        if (isset($this->attributes['length'])) {
            $this->nameLength = $this->attributes['length'];
        } else {
            $this->nameLength = mt_rand(1, 2);
        }
        return $this->nameLength;
    }

    /**
     * @return mixed 生成信息
     */
    public function generate()
    {
        return $this->getSurname().$this->getName();
    }
}