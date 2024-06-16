<?php namespace App\Models;

use CodeIgniter\Model;

class OrderItemsModel extends Model
{
    // The name of the database table used by this model.
    protected $table = 'order_items';

    // The primary key field of the table.
    protected $primaryKey = 'order_item_id';

    // Automatically use auto-increment for the primary key.
    protected $useAutoIncrement = true;

    // The return type of the fetched data.
    protected $returnType = 'array';

    // Disable soft deletes.
    protected $useSoftDeletes = false;

    // Fields that are allowed to be inserted or updated.
    protected $allowedFields = ['order_id', 'dish_id', 'quantity', 'price'];

    // Disable automatic timestamps.
    protected $useTimestamps = false;

    // The name of the created_at field.
    protected $createdField  = 'created_at';

    // The name of the updated_at field.
    protected $updatedField  = 'updated_at';

    // The name of the deleted_at field.
    protected $deletedField  = 'deleted_at';

    // Validation rules.
    protected $validationRules = [];

    // Custom validation messages.
    protected $validationMessages = [];

    // Whether to skip validation.
    protected $skipValidation = false;
}
