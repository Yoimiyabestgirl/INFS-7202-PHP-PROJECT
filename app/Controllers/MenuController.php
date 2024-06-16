<?php namespace App\Controllers;

use App\Models\DishModel;

class MenuController extends BaseController
{
    /**
     * Display the menu management page with all dishes for the current merchant.
     *
     * @return string The menu management view with dishes data
     */
    public function index()
    {
        $model = new DishModel();
        // Retrieve the merchant ID from session data
        $merchantId = session()->get('merchant_id');

        // Fetch all dishes that belong to the logged-in merchant
        $data['dishes'] = $model->where('merchant_id', $merchantId)->findAll();

        // Load the menu management view with dishes data
        return view('menu_manage', $data);
    }

    /**
     * Get a specific dish by ID and return it as JSON.
     *
     * @param int $id The ID of the dish to retrieve
     * @return \CodeIgniter\HTTP\Response JSON response with dish data
     */
    public function getDish($id)
    {
        $model = new DishModel();
        // Find the dish by ID
        $dish = $model->find($id);
        // Return the dish data as JSON
        return $this->response->setJSON($dish);
    }

    /**
     * Save a new dish or update an existing one.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the menu page on success, back to form on failure
     */
    public function saveDish()
    {
        $model = new DishModel();
        // Handle file upload
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate a new random name for the uploaded image
            $newImageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newImageName);

            // Collect dish data from the form
            $data = [
                'name' => $this->request->getVar('name'),
                'category' => $this->request->getVar('category'),
                'price' => $this->request->getVar('price'),
                'description' => $this->request->getVar('description'),
                'image' => $newImageName,
                'merchant_id' => session()->get('merchant_id')
            ];

            // Attempt to save the dish data
            if ($model->save($data)) {
                // Redirect to the menu page on success
                return redirect()->to('/menu');
            } else {
                // Redirect back to the form with validation errors
                return redirect()->back()->with('errors', $model->errors());
            }
        } else {
            // Redirect back with an error message if file upload fails
            return redirect()->back()->with('error', 'Invalid file upload');
        }
    }

    /**
     * Delete a dish by ID.
     *
     * @param int $id The ID of the dish to delete
     * @return \CodeIgniter\HTTP\Response JSON response with status message
     */
    public function deleteDish($id)
    {
        $model = new DishModel();
        // Find the dish by ID
        $dish = $model->find($id);

        if ($dish) {
            // Delete the image associated with the dish if it exists
            $imagePath = FCPATH . 'uploads/' . $dish['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the dish record
            $model->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Dish and image deleted successfully.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Dish not found.']);
        }
    }

    /**
     * Update dish details.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the menu page on success, back to form on failure
     */
    public function updateDish()
    {
        $model = new DishModel();
        // Get the ID from the form submission
        $id = $this->request->getPost('id');

        // Find the existing dish by ID
        $existingDish = $model->find($id);
        if (!$existingDish) {
            // Redirect back with an error message if the dish is not found
            return redirect()->back()->with('error', 'Dish not found.');
        }

        // Prepare new data for the dish
        $data = [
            'name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'merchant_id' => session()->get('merchant_id')
        ];

        // Handle new image upload if provided
        $file = $this->request->getFile('image');
        if ($file->isValid() && !$file->hasMoved()) {
            // Generate a new random name for the uploaded image
            $newImageName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newImageName);
            // Delete the old image file if it exists
            if (file_exists(FCPATH . 'uploads/' . $existingDish['image'])) {
                unlink(FCPATH . 'uploads/' . $existingDish['image']);
            }
            // Update the image path in the data array
            $data['image'] = $newImageName;
        }

        // Update the dish information in the database
        if ($model->update($id, $data)) {
            // Redirect to the menu page with a success message
            return redirect()->to('/menu')->with('message', 'Dish updated successfully.');
        } else {
            // Redirect back to the form with validation errors
            return redirect()->back()->with('errors', $model->errors());
        }
    }
}
?>
