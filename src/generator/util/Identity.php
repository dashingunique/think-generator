<?php
/**
 * | Author: dashingUnique <https://github.com/dashingunique>
 * +----------------------------------------------------------------------
 * | Description: 身份证号码生成器
 * +----------------------------------------------------------------------
 */

namespace generator\util;

use generator\BaseUtil;
use library\Collection;
use InvalidArgumentException;

class Identity extends BaseUtil
{
    /**
     * 省份集合
     * @var Collection
     */
    protected $region;

    /**
     * 城市集合
     * @var Collection
     */
    protected $cities;

    /**
     * @var mixed 性别编号
     */
    protected $sex;

    /**
     * @var string 生日编号
     */
    protected $birthday;

    /**
     * @var mixed 省份
     */
    protected $province;

    /**
     * @var mixed 市区
     */
    protected $city;

    /**
     * @var array|Collection|mixed
     */
    private $district;

    public function __construct()
    {
        parent::__construct();
        $this->loadRegion();
    }

    /**
     * 获取省份
     * @return array|bool|int|Collection|mixed
     */
    public function getProvince()
    {
        $this->setProvince();
        return $this->province;
    }

    /**
     * 获取城市
     * @return int|mixed
     * @throws \Exception
     */
    public function getCity()
    {
        $this->setCity();
        return $this->city;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getDistrict()
    {
        $this->setDistrict();
        return $this->district;
    }

    /**
     * 获取生日日期编号
     * @return string
     */
    protected function getBirthday()
    {
        $this->setBirthday();
        return $this->birthday;
    }

    /**
     * 加载省份信息
     */
    protected function loadRegion()
    {
        if (empty($this->region)) {
            $file = file_get_contents(generatorPath().'/data/region.json');
            $this->region = new Collection(json_decode($file,
                true));
        }
        return $this;
    }

    /**
     * @return $this
     */
    protected function setBirthday()
    {
        //random Datatime
        if (!isset($this->attributes['birthday'])) {
            $startDate = mktime(0, 0, 0, 1, 1, 1920);
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            $endDate = mktime(0, 0, 0, $month, $day, $year);
            $birth = mt_rand($startDate, $endDate);
            $datetime = date('Ymd', $birth);
        } else {
            list($year, $month, $day) = explode('-', $this->attributes['birthday']);
            if (!checkdate($month, $day, $year)) {
                throw new InvalidArgumentException('Invalided datetime');
            }
            $datetime = $year.$month.$day;
        }
        $this->birthday = $datetime;
        return $this;
    }

    /**
     * 设置省份信息
     * @return $this
     */
    protected function setProvince()
    {
        if (isset($this->attributes['province'])) {
            $province = $this->region->where('name', $this->attributes['province'])->where('level', 1)->first();
        } else {
            $province = $this->region->where('level', 1)->random();
        }
        $this->province = $province;
        return $this;
    }

    /**
     * 设置城市信息
     * @return $this
     */
    protected function setCity()
    {
        $province = $this->getProvince();
        try {
            $list = $this->region->where('parent_id', $province['id'])->where('level', 2);
            if (isset($this->attributes['city'])) {
                $city = $list->where('name', $this->attributes['city'])->first();
            } else {
                $city = $list->random();
            }
        } catch (\Exception $exception) {
            $city = $province;
        }
        $this->city = $city;
        return $this;
    }

    /**
     * 设置区域信息
     * @return $this
     * @throws \Exception
     */
    protected function setDistrict()
    {
        $city = $this->getCity();
        try {
            $list = $this->region->where('parent_id', $city['id'])->where('level', 3);
            if (isset($this->attributes['district'])) {
                $district = $list->where('name', $this->attributes['district'])->first();
            } else {
                $district = $list->random();
            }
        } catch (\Exception $exception) {
            $district = $city;
        }
        $this->district = $district;
        return $this;
    }

    /**
     * 计算省份证最后一位
     * @param $base
     * @return string
     */
    protected function getSuffixD($base)
    {
        if (strlen($base) <> 17) {
            die('Invalid Length');
        }
        // 权重
        $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $sums = 0;
        for ($i = 0; $i < 17; $i++) {
            $sums += substr($base, $i, 1) * $factor[$i];
        }

        $mods = $sums % 11; //10X98765432
        $return = '';
        switch ($mods) {
            case 0:
                $return = '1';
                break;
            case 1:
                $return = '0';
                break;
            case 2:
                $return = 'X';
                break;
            case 3:
                $return = '9';
                break;
            case 4:
                $return = '8';
                break;
            case 5:
                $return = '7';
                break;
            case 6:
                $return = '6';
                break;
            case 7:
                $return = '5';
                break;
            case 8:
                $return = '4';
                break;
            case 9:
                $return = '3';
                break;
            case 10:
                $return = '2';
                break;
        }
        return $return;
    }

    /**
     * 生成身份证号码
     * @return string
     */
    public function generate()
    {
        $districtCode = $this->getDistrict()['adcode'];
        $baseCode = $districtCode.$this->getBirthday().mt_rand(0, 9).mt_rand(0, 9).$this->getSex();
        return $baseCode.$this->getSuffixD($baseCode);
    }
}