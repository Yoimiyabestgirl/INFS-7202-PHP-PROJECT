<?php

namespace App\Controllers;

use App\Models\MerchantModel;

class Admin extends BaseController
{
    /**
     * Display all merchants.
     *
     * @return string View with merchants data
     */
    public function index()
    {
        $model = new MerchantModel();
        // Retrieve all merchants from the database
        $data['merchants'] = $model->findAll();
        // Pass the merchants data to the view
        return view('admin', $data);
    }

    /**
     * Show the edit form for a specific merchant.
     *
     * @param int $id The ID of the merchant to edit
     * @return string View with merchant data
     */
    public function edit($id)
    {
        $model = new MerchantModel();
        // Find the merchant by ID
        $data['merchant'] = $model->find($id);
        // Pass the merchant data to the edit view
        return view('edit_merchant', $data);
    }

    /**
     * Update a merchant's information.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the admin index page
     */
    public function update()
    {
        $model = new MerchantModel();
        // Get the merchant ID from the request
        $id = $this->request->getPost('id');
        // Collect the data to be updated
        $data = [
            'restaurant_name' => $this->request->getPost('restaurant_name'),
            'email' => $this->request->getPost('email'),
        ];

        // Get the new password from the request, if provided
        $password = $this->request->getPost('password');
        if ($password) {
            // Hash the new password and include it in the data array
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update the merchant data in the database
        if ($model->update($id, $data)) {
            // Redirect to the admin index page on success
            return redirect()->to('/admin');
        } else {
            // Handle update failure (e.g., set flash messages or return an error view)
        }
    }

    /**
     * Delete a merchant.
     *
     * @param int $id The ID of the merchant to delete
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the admin index page
     */
    public function delete($id)
    {
        $model = new MerchantModel();
        // Delete the merchant by ID
        if ($model->delete($id)) {
            // Redirect to the admin index page on success
            return redirect()->to('/admin');
        } else {
            // Handle delete failure (e.g., set flash messages or return an error view)
        }
    }
}
