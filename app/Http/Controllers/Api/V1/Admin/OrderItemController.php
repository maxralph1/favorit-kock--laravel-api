<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Http\Resources\OrderItemResource;
use App\Models\OrderItem;

/**
 * @group Admin endpoints
 */
class OrderItemController extends Controller
{
    /**
     * GET Order Items
     *
     * Returns paginated list of order items.
     * 
     * @authenticated
     *
     * @queryParam page integer Page number. Example: 1
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","meal_id":"01h3hkhxrh15atksjr11hrck0d","order_id":"01h3hkhxrh15atksjr11hrck0d","user_id":"01h3hkhxrh15atksjr11hrck0d","amount_due":55,"quantity_ordered":5}, ...}
     */
    public function index()
    {
        $orderItems = OrderItem::withTrashed()
            ->latest()
            ->paginate();

        return OrderItemResource::collection($orderItems);
    }

    /**
     * POST Order Item
     *
     * Creates a new Order Item record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","meal_id":"01h3hkhxrh15atksjr11hrck0d","order_id":"01h3hkhxrh15atksjr11hrck0d","user_id":"01h3hkhxrh15atksjr11hrck0d","amount_due":55,"quantity_ordered":5}, ...}
     */
    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = OrderItem::create($request->validated());

        return new OrderItemResource($orderItem);
    }

    /**
     * GET Order Item
     *
     * Returns an Order Item record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","meal_id":"01h3hkhxrh15atksjr11hrck0d","order_id":"01h3hkhxrh15atksjr11hrck0d","user_id":"01h3hkhxrh15atksjr11hrck0d","amount_due":55,"quantity_ordered":5}, ...}
     * @response 404 {"message":"Record not found."}
     */
    public function show(OrderItem $orderItem)
    {
        return new OrderItemResource($orderItem);
    }

    /**
     * PUT Order Item
     *
     * Updates Order Item record.
     *
     * @authenticated
     *
     * @response {"data":{"id":"01h3hkhxrh15atksjr11hrck0d","meal_id":"01h3hkhxrh15atksjr11hrck0d","order_id":"01h3hkhxrh15atksjr11hrck0d","user_id":"01h3hkhxrh15atksjr11hrck0d","amount_due":55,"quantity_ordered":5}, ...}
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->validated());

        return new OrderItemResource($orderItem);
    }

    /**
     * DELETE Order Item
     *
     * Deletes Order Item record.
     * 
     * @authenticated
     *
     * @response 204 {}
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->noContent();
    }
}
