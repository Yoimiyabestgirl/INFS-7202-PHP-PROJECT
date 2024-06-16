<?php namespace App\Models;

use CodeIgniter\Model;

class MerchantModel extends Model
{
    // The name of the database table used by this model.
    protected $table = 'merchants';

    // The primary key field of the table.
    protected $primaryKey = 'id'; 

    // Fields that are allowed to be inserted or updated.
    protected $allowedFields = ['restaurant_name', 'email', 'password'];
    
    /**
     * Save a new merchant with hashed password.
     *
     * @param array $data The merchant data to save.
     * @return bool True if the merchant was saved successfully, false otherwise.
     */
    public function saveMerchant($data)
    {
        // Hash the password before saving the merchant data.
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->save($data);
    }

    /**
     * Update an existing merchant's information.
     *
     * @param int $id The ID of the merchant to update.
     * @param array $data The merchant data to update.
     * @return bool True if the merchant was updated successfully, false otherwise.
     */
    public function updateMerchant($id, $data)
    {
        // Hash the password if it is being updated.
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // If password is not provided, do not update the password field.
            unset($data['password']);
        }

        // Attempt to update the merchant data.
        if ($this->update($id, $data)) {
            log_message('info', 'Successfully updated merchant with ID: ' . $id);
            return true;
        } else {
            // Log error messages if update fails.
            log_message('error', 'Failed to update merchant with ID: ' . $id);
            log_message('error', 'DB Error: ' . print_r($this->errors(), true));
            return false;
        }
    }
}
