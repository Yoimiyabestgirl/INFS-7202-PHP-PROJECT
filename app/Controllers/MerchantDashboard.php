<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\OrderModel;

class MerchantDashboard extends Controller
{
    /**
     * Main function to display the dashboard.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Redirect to login page if not logged in, otherwise display dashboard
     */
    public function index()
    {
        // Check if the merchant is logged in, redirect to login if not
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/login');
        }

        // Get the merchant ID from session data
        $merchantId = session()->get('merchant_id'); 
        $orderModel = new OrderModel();

        // Retrieve sales data for today, yesterday, and this month using a private method
        $todaySales = $this->getSales($orderModel, $merchantId, 'today');
        $yesterdaySales = $this->getSales($orderModel, $merchantId, 'yesterday');
        $thisMonthSales = $this->getSales($orderModel, $merchantId, 'this month');

        // Log sales information for monitoring or debugging
        log_message('info', 'Today Sales: ' . $todaySales);
        log_message('info', 'Yesterday Sales: ' . $yesterdaySales);
        log_message('info', 'This Month Sales: ' . $thisMonthSales);

        // Data array to pass to the view
        $data = [
            'todaySales' => $todaySales,
            'yesterdaySales' => $yesterdaySales,
            'thisMonthSales' => $thisMonthSales
        ];

        // Load the dashboard view with the sales data
        return view('dashboard', $data);
    }

    /**
     * Helper function to retrieve sales data based on the specified time period.
     *
     * @param OrderModel $orderModel The model used to interact with the orders table
     * @param int $merchantId The ID of the merchant
     * @param string $timePeriod The time period for which to retrieve sales data ('today', 'yesterday', 'this month')
     * @return float The total sales for the specified time period
     */
    private function getSales(OrderModel $orderModel, $merchantId, $timePeriod)
    {
        // Create a query builder instance for the orders table
        $builder = $orderModel->builder();

        // Determine the time period for the query
        switch ($timePeriod) {
            case 'today':
                $builder->where('DATE(created_at)', date('Y-m-d'));
                break;
            case 'yesterday':
                $builder->where('DATE(created_at)', date('Y-m-d', strtotime('-1 day')));
                break;
            case 'this month':
                $builder->where('MONTH(created_at)', date('m'));
                $builder->where('YEAR(created_at)', date('Y'));
                break;
        }

        // Configure the query to sum the total sales price
        $builder->selectSum('total_price');
        $builder->where('merchant_id', $merchantId);
        $query = $builder->get();
        $result = $query->getRow();

        // Return the sum or zero if null
        return $result->total_price ?? 0;
    }
}
?>
