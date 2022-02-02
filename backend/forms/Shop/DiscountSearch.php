<?php

namespace backend\forms\Shop;

use shop\entities\Shop\Discount;
use shop\helpers\DiscountHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DiscountSearch extends Model
{
    public $id;
    
    public $percent;
    
    public $name;
    
    public $from_date;
    
    public $to_date;
    
    public $status;
    
    public $sort;
    
    public function rules(): array
    {
        return [
            [['id', 'percent', 'status', 'sort'], 'integer'],
            [['from_date', 'to_date'], 'date'],
            ['name', 'safe'],
        ];
    }
    
    /**
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Discount::find();
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);
        
        $this->load($params);
        
        if (!$this->validate()) {
            $query->where('0=1');
            
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        
        $query->andFilterWhere([
            'id' => $this->id,
            'percent' => $this->percent,
            'status' => $this->status,
        ]);
        
        $query
            ->andFilterWhere(['like', 'name', $this->name]);
        
        return $dataProvider;
    }
    
    public function statusList(): array
    {
        return DiscountHelper::statusList();
    }
}