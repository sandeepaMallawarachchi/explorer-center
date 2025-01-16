function editBlog(blog) {
    // Populate the modal with blog data
    document.getElementById('blogId').value = blog.id;
    document.getElementById('author').value = blog.author;
    document.getElementById('category').value = blog.category;
    document.getElementById('topic').value = blog.topic;
    document.getElementById('description').value = blog.description;
    document.getElementById('date').value = blog.date;

    // Open the modal
    $('#blogModal').modal('show');
}

function deleteBlog(blogId) {
    if (confirm('Are you sure you want to delete this blog?')) {
        // Redirect to the delete handler
        window.location.href = `php/adminBlogs.php?action=delete&id=${blogId}`;
    }
}
