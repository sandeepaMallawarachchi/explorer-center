$(document).ready(function() {
    $('#searchBtn').click(function() {
        var keyword = $('#searchInput').val().trim();
        window.location.href = "/explorer-center//explorer-center/allBlogs.php?search=" + encodeURIComponent(keyword);
    });
});
