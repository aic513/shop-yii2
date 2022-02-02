<?php

namespace shop\useCases\manage\Shop;

use shop\entities\Shop\Discount;
use shop\forms\manage\Shop\DiscountForm;
use shop\repositories\Shop\DiscountRepository;

class DiscountManageService
{
    private $discounts;
    
    public function __construct(DiscountRepository $discounts)
    {
        $this->discounts = $discounts;
    }
    
    public function create(DiscountForm $form): Discount
    {
        $discount = Discount::create(
            $form->percent,
            $form->name,
            $form->from_date,
            $form->to_date,
            $form->sort,
        );
        $this->discounts->save($discount);
        
        return $discount;
    }
    
    public function edit($id, DiscountForm $form): void
    {
        $discount = $this->discounts->get($id);
        $discount->edit(
            $form->percent,
            $form->name,
            $form->from_date,
            $form->to_date,
            $form->sort,
        );
        $this->discounts->save($discount);
    }
    
    public function activate($id): void
    {
        $discount = $this->discounts->get($id);
        $discount->activate();
        $this->discounts->save($discount);
    }
    
    public function draft($id): void
    {
        $discount = $this->discounts->get($id);
        $discount->draft();
        $this->discounts->save($discount);
    }
    
    public function remove($id): void
    {
        $discount = $this->discounts->get($id);
        $this->discounts->remove($discount);
    }
}