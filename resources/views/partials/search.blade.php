<form action="{{ route('products.search') }}" class="d-flex align-items-center" id="searchForm">
    <div class="input-group">
        <input type="text" name="q" id="searchInput" class="form-control" placeholder="Search for products" aria-label="Search for products" value="{{ request()->q ?? '' }}">
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchInput').on('input', function() {
        $('#searchForm').submit();
    });
});
</script>
