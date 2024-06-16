<?php namespace App\Models;

use CodeIgniter\Model;

class DishModel extends Model
{
    // The name of the database table used by this model.
    protected $table = 'dishes';

    // The primary key field of the table.
    protected $primaryKey = 'id';

    // Fields that are allowed to be inserted or updated.
    protected $allowedFields = ['name', 'category', 'price', 'description', 'image', 'merchant_id'];

    // The return type of the fetched data.
    protected $returnType = 'array';

    // Disabling automatic timestamp fields (created_at, updated_at).
    protected $useTimestamps = false;
}
