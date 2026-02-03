 <div class="d-flex justify-content-between mb-3">
    <div>
        <form method="GET" action="{{ route($route) }}" id="perPageForm">
            Show
            <select name="per_page" onchange="document.getElementById('perPageForm').submit()" class="form-select d-inline-block w-auto">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $perPage == 100 ? 'seleced' : '' }}>100</option>
            </select>
            entries
        </form>
    </div>
</div>