function editNews(news) {
    // Populate the modal with news data
    document.getElementById('newsId').value = news.id;
    document.getElementById('topic').value = news.topic;
    document.getElementById('category').value = news.category;
    document.getElementById('content').value = news.content;
    document.getElementById('date').value = news.date;

    const currentImage = document.querySelector('.img-upload-bg');
    if (news.image_url) {
        currentImage.src = news.image_url; // Display current image
        currentImage.style.display = 'block';
    } else {
        currentImage.src = 'img/upload.webp'; // Default placeholder
    }

    // Open the modal
    $('#newsModal').modal('show');
}

function deleteNews(newsId) {
    if (confirm('Are you sure you want to delete this news?')) {
        // Redirect to the delete handler
        window.location.href = `/explorer-center/adminNews.php?action=delete&id=${newsId}`;
    }
}
