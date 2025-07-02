function editBlog(blog) {
    // Populate the modal with blog data
    document.getElementById('blogId').value = blog.id;
    document.getElementById('author').value = blog.author;
    document.getElementById('category').value = blog.category;
    document.getElementById('topic').value = blog.topic;
    document.getElementById('description').value = blog.description;
    document.getElementById('date').value = blog.date;

    const currentImage = document.querySelector('.img-upload-bg');
    if (blog.image_url) {
        currentImage.src = blog.image_url; // Display current image
        currentImage.style.display = 'block';
    } else {
        currentImage.src = 'img/upload.webp'; // Default placeholder
    }

    // Open the modal
    $('#blogModal').modal('show');
}

function deleteBlog(blogId) {
    if (confirm('Are you sure you want to delete this blog?')) {
        // Redirect to the delete handler
        window.location.href = `/explorer-center/adminBlogs.php?action=delete&id=${blogId}`;
    }
}
