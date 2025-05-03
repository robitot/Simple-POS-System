

<div class="rounded p-4 mb-5 border" style="background-color:white;border:2px solid black!important">

    <style>
        .pagination-wrapper nav {
            padding: 10px;
            border-radius: 5px;
        }

        .pagination .page-link {
            background-color: #000;
            /* black buttons */
            color: white;
            /* white text */
            border-color: #444;
            /* optional */
        }

        .pagination .page-item.active .page-link {
            background-color: #222;
            /* darker for active */
        }
    </style>

    <table class="table table-hover table-striped" style="border-radius: 10px!important" id="myTable">

        <div class="mb-3 d-flex gap-4">
            <input wire:model.live='pagination.search' placeholder="Search" class="p-2 rounded form-control"
                style="max-width:300px" />

            <div class="d-flex gap-3 rounded-md">

                {{-- <button class="btn btn-primary" id="exportButton"
                    style="white-space:nowrap;background:#9fa1ca!important" data-bs-toggle="tooltip"
                    data-bs-placement="top" data-bs-title="export to excel">
                    <i class="fa-solid fa-file-export text-white"></i>
                </button> --}}

                <select wire:model.live='pagination.paginate' class="form-select" style="max-width:70px">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="">All</option>
                </select>
            </div>
        </div>

        <thead>
            <tr>
                @yield('head')
            </tr>
        </thead>

        <tbody>
            @yield('body')
        </tbody>

    </table>

    <div class="pagination-wrapper">
        {{ $data->links() }}
    </div>

</div>

<script>
    document.getElementById("exportButton").addEventListener("click", function() {
        const fileName = @json($fileName) + "_" + new Date().toISOString().split('T')[0] + ".xlsx";
        var wb = XLSX.utils.table_to_book(document.getElementById('myTable'), {
            sheet: "Sheet 1"
        });
        XLSX.writeFile(wb, fileName);
    });
</script>
