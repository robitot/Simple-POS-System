<!-- Sessions -->
<a href="{{ route('session') }}"
    class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('session') ? 'active-nav' : '' }}">
    <i class="text-hover fa-solid fa-list icon-size {{ Route::is('session') ? 'text-white' : '' }}"></i>
    <p class="text-hover {{ Route::is('session') ? 'text-white' : '' }}">POS Sessions</p>
</a>

<a href="{{ route('POS') }}"
    class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
{{ Route::is('POS') ? 'active-nav' : '' }}">
    <i class="text-hover fa-solid fa-store icon-size {{ Route::is('POS') ? 'text-white' : '' }}"></i>
    <p class="text-hover {{ Route::is('POS') ? 'text-white' : '' }}">POS</p>
</a>

 <!-- expense -->
 {{-- <a href="{{ route('expense') }}"
     class="active-hover d-flex justify-content-start gap-3 align-items-center cursor-pointer text-decoration-none text-black py-2
 {{ Route::is('expense') ? 'active-nav' : '' }}">
     <i class="text-hover fa-solid fa-money-bill icon-size {{ Route::is('expense') ? 'text-white' : '' }}"></i>
     <p class="text-hover {{ Route::is('expense') ? 'text-white' : '' }}">Expenses</p>
 </a> --}}
