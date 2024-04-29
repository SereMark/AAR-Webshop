document.addEventListener('DOMContentLoaded', function() {
    var searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            var searchQuery = document.querySelector('.search-input').value;
            window.location.href = '/?q=' + encodeURIComponent(searchQuery);
        });
    } else {
        console.log('Search form not found');
    }
});