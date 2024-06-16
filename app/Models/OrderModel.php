<?php namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    // The name of the database table used by this model.
    protected $table = 'orders';

    // The primary key field of the table.
    protected $primaryKey = 'order_id';

    // Fields that are allowed to be inserted or updated.
    protected $allowedFields = ['table_id', 'dish_id', 'total_price', 'created_at', 'updated_at', 'status', 'merchant_id'];

    // Automatically use timestamps for created and updated fields.
    protected $useTtimestamps = true;

    // The name of the created_at field.
    protected $createdField = 'created_at';

    // The name of the updated_at field.
    protected $updatedField = 'updated_at';

    /**
     * Get total sales for today for a specific merchant.
     *
     * @param int $merchantId The ID of the merchant.
     * @return array|null The total sales amount or null if no sales found.
     */
    public function getTodaySales($merchantId)
    {
        return $this->where('merchant_id', $merchantId)
                    ->where('DATE(created_at)', date('Y-m-d'))
                    ->selectSum('total_price')
                    ->first();
    }

    /**
     * Get total sales for yesterday for a specific merchant.
     *
     * @param int $merchantId The ID of the merchant.
     * @return array|null The total sales amount or null if no sales found.
     */
    public function getYesterdaySales($merchantId)
    {
        return $this->where('merchant_id', $merchantId)
                    ->where('DATE(created_at)', date('Y-m-d', time() - 86400))
                    ->selectSum('total_price')
                    ->first();
    }

    /**
     * Get total sales for the current month for a specific merchant.
     *
     * @param int $merchantId The ID of the merchant.
     * @return array|null The total sales amount or null if no sales found.
     */
    public function getThisMonthSales($merchantId)
    {
        return $this->where('merchant_id', $merchantId)
                    ->where('MONTH(created_at)', date('m'))
                    ->where('YEAR(created_at)', date('Y'))
                    ->selectSum('total_price')
                    ->first();
    }
}
