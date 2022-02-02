<?php

namespace shop\entities\Shop;

use shop\entities\Shop\queries\DiscountQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $percent
 * @property string  $name
 * @property string  $from_date
 * @property string  $to_date
 * @property bool    $status
 * @property integer $sort
 */
class Discount extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;
    
    public static function create($percent, $name, $fromDate, $toDate, $sort): self
    {
        $discount = new static();
        $discount->percent = $percent;
        $discount->name = $name;
        $discount->from_date = $fromDate;
        $discount->to_date = $toDate;
        $discount->sort = $sort;
        $discount->status = self::STATUS_ACTIVE;
        
        return $discount;
    }
    
    public function edit($percent, $name, $fromDate, $toDate, $sort): void
    {
        $this->percent = $percent;
        $this->name = $name;
        $this->from_date = $fromDate;
        $this->to_date = $toDate;
        $this->sort = $sort;
    }
    
    public function activate(): void
    {
        $this->status = true;
    }
    
    public function draft(): void
    {
        $this->status = false;
    }
    
    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }
    
    public function isEnabled(): bool
    {
        return true;
    }
    
    public static function tableName(): string
    {
        return '{{%shop_discounts}}';
    }
    
    public static function find(): DiscountQuery
    {
        return new DiscountQuery(static::class);
    }
}