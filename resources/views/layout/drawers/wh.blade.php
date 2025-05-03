 <!-- Supply Chain Link -->
 <a href="{{ route('supplyChain') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('supplyChain') ? 'active-nav' : '' }}">
     <i class="text-hover fa-solid fa-truck-ramp-box icon-size {{ Route::is('supplyChain') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('supplyChain') ? 'text-white' : '' }}">Supply Chain</p>
 </a>
 
 <!-- expense -->
 <a href="{{ route('expense') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
 {{ Route::is('expense') ? 'active-nav' : '' }}">
     <i class="text-hover fa-solid fa-money-bill icon-size {{ Route::is('expense') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('expense') ? 'text-white' : '' }}">Expenses</p>
 </a>