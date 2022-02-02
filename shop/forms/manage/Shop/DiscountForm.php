<?php

namespace shop\forms\manage\Shop;

use shop\entities\Shop\Discount;
use yii\base\Model;

class DiscountForm extends Model
{
    public $percent;
    
    public $name;
    
    public $from_date;
    
    public $to_date;
    
    public $sort;
    
    private $_discount;
    
    public function __construct(Discount $discount = null, $config = [])
    {
        if ($discount) {
            $this->percent = $discount->percent;
            $this->name = $discount->name;
            $this->from_date = $discount->from_date;
            $this->to_date = $discount->to_date;
            $this->sort = $discount->sort;
            $this->_discount = $discount;
        }
        parent::__construct($config);
    }
    
    public function rules(): array
    {
        return [
            [['name', 'percent'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['percent', 'sort'], 'integer'],
            [['from_date', 'to_date'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}