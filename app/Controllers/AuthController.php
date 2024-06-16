<?php namespace App\Controllers;

use App\Models\MerchantModel;
use CodeIgniter\Controller;

class AuthController extends BaseController
{
    /**
     * Displays the login view.
     *
     * @return string The login view
     */
    public function login()
    {
        helper('cookie'); // Load the cookie helper
        $data['remembered_email'] = get_cookie('rememberMe', true); // Retrieve the email from the "Remember Me" cookie if it exists
        return view('login', $data); // Load the login view with the remembered email
    }

    /**
     * Displays the registration view.
     *
     * @return string The registration view
     */
    public function register()
    {
        return view('register'); // Load the registration view
    }

    /**
     * Handles the registration of a new merchant.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to login page on success, back to registration on failure
     */
    public function attemptRegister()
    {
        // Validation rules for registering a new merchant
        $validationRules = [
            'merchantName' => 'required|min_length[3]|max_length[100]',
            'email'        => 'required|valid_email|is_unique[merchants.email]',
            'password'     => 'required|min_length[8]',
            'confirmPassword' => 'matches[password]'
        ];

        // Validate user input against the rules
        if (!$this->validate($validationRules)) {
            // If validation fails, redirect back with input and errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $merchantModel = new MerchantModel();
        $newData = [
            'restaurant_name' => $this->request->getPost('merchantName'),
            'email'           => $this->request->getPost('email'),
            'password'        => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) // Hash the password
        ];

        // Attempt to save the new merchant
        if ($merchantModel->save($newData)) {
            // If successful, redirect to login with a success message
            return redirect()->to('/login')->with('success', 'Registration successful');
        } else {
            // If not successful, redirect back with an error message
            return redirect()->back()->with('error', 'Registration failed');
        }
    }

    /**
     * Handles login attempts.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to dashboard on success, back to login on failure
     */
    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $rememberMe = $this->request->getPost('rememberMe') === 'on'; // Check if "Remember Me" is selected

        $merchantModel = new MerchantModel();
        $merchant = $merchantModel->where('email', $email)->first(); // Find the merchant by email

        // Check if merchant exists and password is correct
        if ($merchant && password_verify($password, $merchant['password'])) {
            // Set session data upon successful login
            $sessionData = [
                'merchant_id' => $merchant['id'],
                'merchant_email' => $merchant['email'],
                'merchant_name' => $merchant['restaurant_name'],
                'is_logged_in' => true
            ];

            session()->set($sessionData);

            if ($rememberMe) {
                helper('cookie');
                // Set a cookie that expires in 30 days
                set_cookie('rememberMe', $email, 30 * 86400); // Store only the email for security reasons
            }

            return redirect()->to('/dashboard'); // Redirect to the dashboard
        } else {
            // Set error message and redirect back to login if login fails
            session()->setFlashdata('error', 'Invalid email or password');
            return redirect()->back();
        }
    }

    /**
     * Handles merchant logout.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirect to the login page
     */
    public function logout()
    {
        // Destroy all session data but preserve the "Remember Me" cookie if it exists
        session()->destroy();

        // Optionally, to clear the "Remember Me" cookie upon logout, uncomment the following line:
        // delete_cookie('rememberMe');

        return redirect()->to('/login'); // Redirect to the login page
    }
}
