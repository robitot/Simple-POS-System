 <style>
     i {
         color: white !important
     }
 </style>

 <a href="{{ route('dashboard') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('dashboard') ? 'active-nav' : '' }}">
     <i class="text-hover fa-solid fa-chart-line icon-size {{ Route::is('dashboard') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('dashboard') ? 'text-white' : '' }}">Home</p>
 </a>

 <a href="{{ route('user') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('user') ? 'active-nav' : '' }}">
     <i class="fa-solid fa-person text-hover icon-size {{ Route::is('user') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('user') ? 'text-white' : '' }}">Users</p>
 </a>

 <a href="{{ route('products') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('products') ? 'active-nav' : '' }}">
     <i class="fa-brands fa-product-hunt text-hover icon-size {{ Route::is('products') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('products') ? 'text-white' : '' }}">Products</p>
 </a>

 <a href="{{ route('category') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
 {{ Route::is('category') ? 'active-nav' : '' }}">
     <i class="fa-solid fa-list text-hover icon-size {{ Route::is('category') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('category') ? 'text-white' : '' }}">Categories</p>
 </a>

 {{-- <a href="{{ route('inventory') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('inventory') ? 'active-nav' : '' }}">
     <i class="fa-solid fa-box text-hover icon-size {{ Route::is('inventory') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('inventory') ? 'text-white' : '' }}">Inventory</p>
 </a> --}}

 <a href="{{ route('POS') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('POS') ? 'active-nav' : '' }}">
     <i class="fa-solid fa-shop text-hover icon-size {{ Route::is('POS') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('POS') ? 'text-white' : '' }}">POS</p>
 </a>

 <a href="{{ route('session') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
 {{ Route::is('session') ? 'active-nav' : '' }}">
     <i class="fa-solid fa-list-check text-hover icon-size {{ Route::is('session') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('session') ? 'text-white' : '' }}">Cashier Shift</p>
 </a>