<?php namespace App\Models;

use CodeIgniter\Model;

class TableModel extends Model
{
    // The name of the database table used by this model.
    protected $table = 'tables';

    // The primary key field of the table.
    protected $primaryKey = 'id';

    // The return type of the fetched data.
    protected $returnType = 'array';

    // Disable soft deletes.
    protected $useSoftDeletes = false;

    // Fields that are allowed to be inserted or updated.
    protected $allowedFields = ['capacity', 'qr_code', 'merchant_id'];

    // Disable automatic timestamps.
    protected $useTimestamps = false;
}
