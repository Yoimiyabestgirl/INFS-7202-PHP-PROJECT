<?php namespace App\Controllers;

use App\Models\TableModel;
// Importing necessary classes for QR code generation.
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TableController extends BaseController
{
    /**
     * Display all tables associated with the logged-in merchant.
     *
     * @return string The tables view with the list of tables
     */
    public function index()
    {
        $model = new TableModel();
        $merchantId = session()->get('merchant_id'); // Get the merchant ID from session

        // Retrieve all tables for the logged-in merchant
        $data['tables'] = $model->where('merchant_id', $merchantId)->findAll();
        
        // Load the tables view with the data
        return view('tables', $data);
    }

    /**
     * Add a new table with QR code for menu access.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the tables page
     */
    public function add()
    {
        helper(['form', 'url']); // Load form and URL helpers
        $model = new TableModel();
        $capacity = $this->request->getVar('capacity'); // Get the table capacity from the request

        // Save table information in the database
        $data = [
            'capacity' => $capacity,
            'merchant_id' => session()->get('merchant_id'),
        ];
        $tableId = $model->insert($data);

        // Generate QR code content linking to the menu with the table and merchant IDs
        $qrContent = base_url("order/menu?table_id={$tableId}&merchant_id={$data['merchant_id']}");
        $qrCode = new QrCode($qrContent);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        $writer = new PngWriter();

        // Generate the QR code image and save it to a file
        $qrCodeImage = $writer->write($qrCode);
        $qrCodeImageName = uniqid() . '.png';
        $qrCodeImagePath = WRITEPATH . 'uploads/' . $qrCodeImageName;
        $qrCodeImage->saveToFile($qrCodeImagePath);

        // Move the QR code image to a public directory
        $publicPath = FCPATH . 'uploads/qr_codes/' . $qrCodeImageName;
        $publicDir = dirname($publicPath);
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0777, true);
        }
        copy($qrCodeImagePath, $publicPath);

        // Update the table record to include the QR code path
        $updateData = ['qr_code' => 'uploads/qr_codes/' . $qrCodeImageName];
        $model->update($tableId, $updateData);

        // Redirect to the tables page
        return redirect()->to('/table');
    }

    /**
     * Delete a table and its associated QR code.
     *
     * @param int $id The ID of the table to delete
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the tables page with a success or error message
     */
    public function delete($id)
    {
        $model = new TableModel();
        // Find the table by ID
        $table = $model->find($id);

        if (!$table) {
            // Redirect to the tables page with an error message if the table is not found
            return redirect()->to('/table')->with('error', 'Table not found.');
        }

        // Delete the QR code file if it exists
        $qrCodePath = FCPATH . $table['qr_code'];
        if (file_exists($qrCodePath)) {
            unlink($qrCodePath);
        }

        // Delete the table record from the database
        $model->delete($id);

        // Redirect to the tables page with a success message
        return redirect()->to('/table')->with('message', 'Table deleted successfully.');
    }
}
