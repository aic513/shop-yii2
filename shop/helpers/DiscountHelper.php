<?php

namespace shop\helpers;

use shop\entities\Shop\Discount;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class DiscountHelper
{
    public static function statusList(): array
    {
        return [
            Discount::STATUS_DRAFT => 'Draft',
            Discount::STATUS_ACTIVE => 'Active',
        ];
    }
    
    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }
    
    public static function statusLabel($status): string
    {
        switch ($status) {
            case Discount::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Discount::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }
        
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
