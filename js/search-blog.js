$(document).ready(function() {
    $('#searchBtn').click(function() {
        var keyword = $('#searchInput').val().trim();
        window.location.href = "//allBlogs.php?search=" + encodeURIComponent(keyword);
    });
});
