<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing page
$routes->get('/', 'Home::index');
$routes->get('/admin', 'Admin::index'); // Route to Admin Controller

// Admin page
$routes->get('/admin/add', 'Admin::add'); //Admin's add method
$routes->get('/admin/edit/(:num)', 'Admin::edit/$1'); // Admins edit method 
$routes->post('/admin/update', 'Admin::update');
$routes->get('/admin/delete/(:num)', 'Admin::delete/$1'); // Admin's delete method 




// Login & Logout
$routes->get('/login', 'AuthController::login');
$routes->get('/dashboard', 'MerchantDashboard::index');
$routes->post('/auth/login', 'AuthController::attemptLogin');
$routes->post('/auth/validate', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

// Register
$routes->get('/register', 'AuthController::register');
$routes->post('/auth/register', 'AuthController::attemptRegister');

// Dashboard
$routes->get('/merchant/dashboard', 'MerchantDashboard::index');
$routes->get('/merchant/orders', 'MerchantDashboard::orders');
$routes->get('/merchant/tables', 'MerchantDashboard::tables');
$routes->get('/merchant/menu', 'MerchantDashboard::menu');

//Business view orders
$routes->get('/merchant/view-orders', 'BusinessOrderController::viewOrders');
$routes->get('/business-order-controller/viewOrders', 'BusinessOrderController::viewOrders');
$routes->get('/business-order-controller/getOrderDetails/(:num)', 'BusinessOrderController::getOrderDetails/$1');
$routes->post('/business-order-controller/updateOrderStatus', 'BusinessOrderController::updateOrderStatus');
$routes->post('/business-order-controller/deleteOrder', 'BusinessOrderController::deleteOrder');


// Client Orders
$routes->get('order/menu', 'OrderController::menu');
$routes->get('/orders', 'BusinessOrderController::index');
$routes->post('order/submitOrder', 'OrderController::submitOrder');

// Manage menu
$routes->get('/menu-manage', 'MenuController::index');
$routes->post('/menu/save_dish', 'MenuController::save_dish');
$routes->get('/menu/delete_dish/(:num)', 'MenuController::delete_dish/$1');

// Manage table
$routes->get('/tables', 'TableController::index');
$routes->get('/table', 'TableController::index');
$routes->post('/table/add', 'TableController::add');
$routes->get('/table/delete/(:segment)', 'TableController::delete/$1');

// Add and save dish
$routes->get('/menu', 'MenuController::index');
$routes->post('/menu/saveDish', 'MenuController::saveDish');

// Edit dish
$routes->get('/menu/editDish/(:num)', 'MenuController::editDish/$1');
$routes->post('/menu/updateDish', 'MenuController::updateDish');

// Get crrent dish
$routes->get('/menu/getDish/(:num)', 'MenuController::getDish/$1');

// Update dish 
$routes->post('/menu/updateDish/(:num)', 'MenuController::updateDish/$1');

//Delete 
$routes->post('/menu/deleteDish/(:num)', 'MenuController::deleteDish/$1');

// Client Order
$routes->get('/order', 'MenuOrderController::index');





