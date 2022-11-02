install package via composer
```bash
composer require jensramakers/laravel-make-crud
```


publish the stubs, add "--force" after the command below to overwrite existing stub files. Usefull when updating this package for example.
```bash
php artisan custom-stub:publish
```


Install dataTable with npm and jquery if you dont have it already

```bash
npm i datatables.net
```
```bash
npm i datatables.net-dt
```
```bash
npm i jquery
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
