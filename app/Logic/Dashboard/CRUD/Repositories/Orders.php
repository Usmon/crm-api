<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Order;

use App\Models\Product;

use App\Models\Box;

use App\Models\BoxItem;

use Illuminate\Contracts\Pagination\Paginator;

final class Orders
{
    /**
     * @param array $filters
     *
     * @param array $sorts
     *
     * @return Paginator
     */
    public function getOrders(array $filters, array $sorts): Paginator
    {
        return Order::filter($filters)->sort($sorts)->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Order
     */
    public function storeOrder(array $credentials): Order
    {
        if(! $credentials['additional_weight'])
        {
            unset($credentials['additional_weight']);
        }

        if(! $credentials['price_additional'])
        {
            unset($credentials['price_additional']);
        }

        if(! $credentials['price_insurance'])
        {
            unset($credentials['price_insurance']);
        }

        if(! $credentials['payed_price'])
        {
            unset($credentials['payed_price']);
        }

        if(! $credentials['payment_type_id'])
        {
            unset($credentials['payment_type_id']);
        }

        $order = Order::create($credentials);

        $this->storeBoxes($order, $credentials['boxes']);

        $order->chargeBalance();

        return $order->refresh();
    }

    /**
     * @param Order $order
     *
     * @param array $boxes
     *
     * @return void
     */
    public function storeBoxes(Order $order, array $boxes): void
    {
        //Need Code optimization BEGIN
        foreach ($boxes as $box) {
            $weight = 0;
            foreach ($box['products'] as $product) {
                $weight += $product['weight'];
            }

            $box_ = new Box($box);
            $box_->weight = $weight;
            $box_->status_id = $order->status_id;
            $boxModel = $order->boxes()->save($box_);
            foreach ($box['products'] as $product) {
                $product_ = new BoxItem($product);
                $product_->box_id = $boxModel->id;
                $product_->save();
            }
        }
        //Need Code optimization END
    }

    /**
     * @param Order $order
     *
     * @param array $products
     *
     * @return void
     */
    public function storeProducts(Order $order, array $products): void
    {
        foreach ($products as $product) {
            $order->products()->save(new Product($product));
        }
    }

    /**
     * @param Order $order
     *
     * @param array $credentials
     *
     * @return Order
     */
    public function updateOrder(Order $order, array $credentials): Order
    {
        if(! $credentials['additional_weight'])
        {
            unset($credentials['additional_weight']);
        }

        if(! $credentials['price_additional'])
        {
            unset($credentials['price_additional']);
        }

        if(! $credentials['price_insurance'])
        {
            unset($credentials['price_insurance']);
        }

        if(! $credentials['payed_price'])
        {
            unset($credentials['payed_price']);
        }

        if(! $credentials['payment_type_id'])
        {
            unset($credentials['payment_type_id']);
        }

        $order->price = $order->total_price_boxes;

        $order->update($credentials);

        return $order->refresh();
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function updateOrderStatus(array $credentials): bool
    {
        return Order::find($credentials['order_id'])->update(['status_id' => $credentials['status_id']]);
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function updatePaymentStatus(array $credentials): bool
    {
        return Order::find($credentials['order_id'])->update(['payment_status_id' => $credentials['payment_status_id']]);
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteOrder($id)
    {
        return Order::destroy($id);
    }

    public function updateShow(int $id)
    {
        return Order::findOrFail($id);
    }
}
