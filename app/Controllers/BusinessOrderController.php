<?php namespace App\Controllers;

use App\Models\OrderModel;

class BusinessOrderController extends BaseController
{
    /**
     * Display all orders related to a specific merchant.
     *
     * @return string View with orders data
     */
    public function viewOrders()
    {
        $orderModel = new OrderModel();
        $merchantId = session()->get('merchant_id'); // Get the merchant ID from the session

        // Get the current page number, default to 1 if not provided
        $page = $this->request->getVar('page') ?: 1;

        // Set the number of orders per page
        $perPage = 10;

        // Fetch orders for the specified merchant with pagination
        $orders = $orderModel->where('merchant_id', $merchantId)
                             ->paginate($perPage, 'orders');

        // Get pagination links
        $pager = $orderModel->pager;

        // Pass orders and pagination links to the view
        return view('view_orders', [
            'orders' => $orders,
            'pager' => $pager,
            'currentPage' => $page,
        ]);
    }

    /**
     * Fetch and return detailed information about a specific order.
     *
     * @param int $orderId The ID of the order
     * @return \CodeIgniter\HTTP\Response JSON response with order details
     */
    public function getOrderDetails($orderId)
    {
        $db = \Config\Database::connect(); // Connect to the database

        // Use Query Builder to join order_items and dishes tables for detailed information
        $builder = $db->table('order_items');
        $builder->select('order_items.quantity, order_items.price, dishes.name as dish_name, dishes.description');
        $builder->join('dishes', 'dishes.id = order_items.dish_id');
        $builder->where('order_items.order_id', $orderId);
        $orderDetails = $builder->get()->getResult();

        // Check if any details were found for the order
        if (empty($orderDetails)) {
            // Respond with failure if no details are found
            return $this->response->setJSON(['success' => false, 'message' => 'No details found for this order']);
        }

        // Respond with success and the order details
        return $this->response->setJSON(['success' => true, 'orderDetails' => $orderDetails]);
    }

    /**
     * Update the status of an order.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the viewOrders page
     */
    public function updateOrderStatus()
    {
        $orderModel = new OrderModel();
        $orderId = $this->request->getPost('order_id'); // Get the order ID from the request
        $status = $this->request->getPost('status'); // Get the new status from the request

        $data = [
            'status' => $status,
        ];

        // Update the order status
        if ($orderModel->update($orderId, $data)) {
            return redirect()->to('/business-order-controller/viewOrders');
        } else {
            // Handle update failure
            // You can set flash messages or return an error view
        }
    }

    /**
     * Delete an order.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the viewOrders page
     */
    public function deleteOrder()
    {
        $orderModel = new OrderModel();
        $orderId = $this->request->getPost('order_id'); // Get the order ID from the request

        // Delete the order
        if ($orderModel->delete($orderId)) {
            return redirect()->to('/business-order-controller/viewOrders');
        } else {
            // Handle delete failure
            // You can set flash messages or return an error view
        }
    }
}
