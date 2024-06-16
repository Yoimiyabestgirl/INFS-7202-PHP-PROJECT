<?php namespace App\Controllers;

use App\Models\TableModel; 
use App\Models\DishModel;  
use App\Models\OrderItemsModel;

use CodeIgniter\RESTful\ResourceController;

class OrderController extends BaseController
{
    /**
     * Displays the menu for a specific table and merchant.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Redirects to error page if table or merchant ID is missing, otherwise displays the client order view
     */
    public function menu()
    {
        // Retrieve table and merchant ID from the request
        $tableId = $this->request->getVar('table_id');
        $merchantId = $this->request->getVar('merchant_id');  

        // If either table ID or merchant ID is missing, redirect to the error page
        if (!$tableId || !$merchantId) {
            return redirect()->to('/error')->with('message', 'Table ID and Merchant ID are required.');
        }

        // Initialize the table and dish model
        $tableModel = new TableModel();
        $dishModel = new DishModel();

        // Check if the specified table exists for the given merchant
        $tableExists = $tableModel->where('id', $tableId)->where('merchant_id', $merchantId)->first();

        // If the table doesn't exist or doesn't belong to the merchant, throw a page not found exception
        if (!$tableExists) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Table not found or does not belong to this merchant.');
        }

        // Retrieve all dishes available for the merchant and pass them to the view along with table and merchant ID
        $data['dishes'] = $dishModel->where('merchant_id', $merchantId)->findAll();
        $data['table_id'] = $tableId;
        $data['merchant_id'] = $merchantId;

        return view('client_order', $data);
    }

    /**
     * Handles the submission of an order.
     *
     * @return \CodeIgniter\HTTP\Response JSON response indicating the result of the order submission
     */
    public function submitOrder()
    {
        // Retrieve JSON data from the request
        $jsonData = $this->request->getJSON(true);

        // Validate received JSON data
        if (!$jsonData) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'No data provided']);
        }

        // Extract necessary information from JSON data
        $tableId = $jsonData['table_id'] ?? null;
        $merchantId = $jsonData['merchant_id'] ?? null;
        $items = $jsonData['items'] ?? [];

        // Validate required information
        if (!$tableId || !$merchantId || empty($items)) {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Incomplete data']);
        }

        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        $ordersModel = new \App\Models\OrderModel();
        $orderItemsModel = new \App\Models\OrderItemsModel();

        $totalPrice = 0;

        // Create initial order data
        $orderData = [
            'table_id' => $tableId,
            'merchant_id' => $merchantId,  
            'status' => 'Ready to Start',
        ];

        // Insert the order and get its ID
        $ordersModel->insert($orderData);
        $orderId = $ordersModel->getInsertID();

        // Process each item in the order
        foreach ($items as $item) {
            $itemPrice = $item['price'];
            $itemQuantity = $item['quantity'];
            $itemTotal = $itemPrice * $itemQuantity;
            $totalPrice += $itemTotal;

            // Insert each item into the order items table
            $orderItemsModel->insert([
                'order_id' => $orderId,
                'dish_id' => $item['id'],
                'quantity' => $itemQuantity,
                'price' => $itemPrice,
            ]);
        }

        // Update the total price of the order
        $ordersModel->update($orderId, ['total_price' => $totalPrice]);

        // Check the transaction status and complete the transaction or rollback if failed
        if ($db->transStatus() === false) {
            $db->transRollback();
            return $this->response->setStatusCode(500)->setJSON(['success' => false, 'message' => 'Could not place the order']);
        }

        $db->transComplete();

        // Return success response
        return $this->response->setStatusCode(201)->setJSON(['success' => true, 'message' => 'Order placed successfully', 'order_id' => $orderId]);
    }
}
?>
