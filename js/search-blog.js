$(document).ready(function() {
    $('#searchBtn').click(function() {
        var keyword = $('#searchInput').val().trim();
        window.location.href = "/explorer-center/php/allBlogs.php?search=" + encodeURIComponent(keyword);
    });
});
