<?php
namespace Ignite\Inpatient\Library\Evaluation;

use Ignite\Evaluation\Entities\Visit;

use Ignite\Inpatient\Entities\InpatientConsumable;

use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryStock;

use Ignite\Inpatient\Library\Interfaces\EvaluationInterface;

class ConsumablesEvaluation implements EvaluationInterface
{
    protected $visit;
    
    /*
    * Initialise the general charges 
    */
    public function __construct($visit)
    {
        $this->visit = $visit;
    }

    /*
    * Return the data that will be presented to the view on the charge sheet
    */
    public function data()
    {
        return [
            'consumables' => $this->getConsumables()
        ];
    }

    /*
    * These will go in a repository later
    **/
    public function getConsumables()
    {
        return InventoryProducts::with('stocks')->where('consumable', '1')->get();
    }

    /*
    * Makes the data more friendly to a datatable
    */
    public function table()
    {
        $consumables = InpatientConsumable::with(['product'])->where('visit', $this->visit->id)->get();

        $data = $consumables->map(function($consumable){

            return [
                $consumable->product->name,
                $consumable->type,
                $consumable->price,
                $consumable->quantity,
                $consumable->discount,
                $consumable->amount,
                // $consumable->created_at
            ];

        })->toArray();

        return compact('data');
    }

    /*
    * Save the consumable into the database
    */
    public function persist()
    {
        foreach ($this->_get_selected_stack() as $consumable) {
            InpatientConsumable::create([
                'type' => request()->get("type$consumable"),
                'visit' => request()->get("visit"),
                'product_id' => $consumable,
                'quantity' => request()->get("quantity$consumable"),
                'price' => request()->get("price$consumable"),
                'discount' => request()->get("discount$consumable"),
                'amount' => request()->get("amount$consumable"),
                'user' => request()->get("user"),
                'ordered' => true
            ]);

            $this->adjustStock($consumable, request()->get("quantity$consumable"));
        }

        return true;
    }
    /*
    * Remove the items from the store
    */
    public function adjustStock($productId, $quantity)
    {
        $stock = InventoryStock::where('product', $productId)->first();

        $stock->quantity = $stock->quantity - $quantity;

        $stock->save();

        $adjustment = InventoryStockAdjustment::where('product', $productId)->latest()->first();

        InventoryStockAdjustment::create([
            'product' => $productId,
            'opening_qty' => $adjustment->quantity,
            'quantity' => $adjustment->quantity - $quantity,
            'new_stock' => $quantity,
            'method' => '-',
            'type' => 'consumable',
            'user' => \Auth::user()->id,
        ]);
    }

    private function _get_selected_stack()
    {
        $stack = [];
        foreach (request()->all() as $key => $one) {
            if (starts_with($key, 'item')) {
                $stack[] = substr($key, 4);
            }
        }
        return $stack;
    }
}