# Installation
install package via composer
```bash
composer require jensramakers/laravel-make-crud
```
publish the stubs, add "--force" after the command below to overwrite existing stub files. Usefull when updating this package for example.
```bash
php artisan custom-stub:publish
```
Install datatables, jquery and fontawesome with npm package manager
```bash
npm i datatables.net
```
```bash
npm i datatables.net-dt
```
```bash
npm i jquery
```
```bash
npm install --save @fortawesome/fontawesome-free
```
load the packages and define the tables
```js
window.$ = window.jQuery = require('jquery');
require('datatables.net');

$('.datatable').DataTable({
    stateSave: true,
    pageLength: 25,
    lengthMenu: [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, 'All']],
});
```
load styling package and some extra optional css
```scss
@import '~@fortawesome/fontawesome-free/css/all';
@import "~datatables.net-dt";

.admin-summary-table > td {
    border: 1px solid black;
    border-bottom: none;
    border-top: none;
}

.admin-summary-table tr:nth-child(odd) {
    background-color: white;
}

.admin-summary-table tr:nth-child(even) {
    background-color: lightgrey;
}

table.dataTable tbody th, table.dataTable tbody td {
    padding: 0;
}

#DataTables_Table_0_length > label > select {
    padding-right: 2.5rem;
}

table.dataTable tbody th, table.dataTable tbody td {
    padding: 0;
}
```
add this to web.php and dont forget to protect this route with proper middleware
```php
Route::get('/admin/modal/deletion/{route}', function ($route) { 
  return view('vendor.jensramakers.modal_delete', ['route' => str_replace('\\', '/', $route)])->render();
})->name('admin.deletion.async.modal');
```
Install tailwind elements for modal functionality  
https://tailwind-elements.com/quick-start/  
# Usage
To create a CRUD page
```bash
php artisan make:crud
```
Choose a model name, use singular noun. E.g. "Product".  
This creates a model, migration, formrequests, route and resource controller.  
The route is created in "routes/crud.php", you need to manually add this to your RouteServiceProvider.php.
```php
Route::middleware('web')
    ->group(base_path('routes/crud.php'));
```
You can navigate to the page the generated URL will look something like this
```url
http://localhost:8000/admin/products
```
You will get errors when you dont have the RouteAsync and/or FlashMessage package  
https://github.com/PS222407/laravel-async-route  
https://github.com/PS222407/laravel-flashmessage  

Alternatively you can edit the stub files and remove the code and add your own
