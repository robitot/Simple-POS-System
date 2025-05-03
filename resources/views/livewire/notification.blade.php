<div>
    @if (Auth()->user()->user_role == 'admin')
        <div class="d-flex gap-3">
            <a href="{{ route('expense') }}" style="background: #7d4000!important"
                class="btn btn-primary position-relative" wire:click="viewNotifications">
                <i class="fa-solid fa-money-bill text-white"></i>
                @if ($expensePending > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $expensePending > 99 ? '99+' : $expensePending }}
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                @endif
            </a>

            <a href="{{ route('supplyChain') }}" type="button" style="background: #7d4000!important"
                class="btn btn-primary position-relative" wire:click="viewNotifications">
                <i class="fa-solid fa-truck text-white"></i>
                @if ($supplyPending > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $supplyPending > 99 ? '99+' : $supplyPending }}
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                @endif
            </a>
        </div>
    @endif
</div>
