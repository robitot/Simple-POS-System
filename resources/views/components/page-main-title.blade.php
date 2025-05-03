<div class="mb-4 d-flex gap-4">

    <div>
        <h3 style="margin:0" class="fw-bold" >
            {{ $title }}</h3>
        <p style="color:gray" >{{ $subTitle }}</p>
    </div>

    @if ($isWithBtn)
        <div >
            <a href="{{ route($link) }}" class="btn btn-primary" >
                {{ $btnName }}
            </a>
        </div>
    @endif
</div>
