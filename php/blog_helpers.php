<?php
include('db.php');

// Fetch search term and category filter with pagination
function getBlogs($conn, $searchKeyword = '', $categoryFilter = '', $page = 1, $blogsPerPage = 6)
{
    // Calculate the offset for pagination
    $offset = ($page - 1) * $blogsPerPage;

    // Build the SQL query with filters, pagination, and descending order
    if ($searchKeyword && $categoryFilter) {
        $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);
        $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
        $sql = "SELECT * FROM blogs 
            WHERE (LOWER(topic) LIKE '%$searchKeyword%' OR LOWER(author) LIKE '%$searchKeyword%' 
                   OR LOWER(category) LIKE '%$searchKeyword%' OR LOWER(description) LIKE '%$searchKeyword%') 
                  AND category = '$categoryFilter' 
            ORDER BY date DESC 
            LIMIT $offset, $blogsPerPage";
    } elseif ($searchKeyword) {
        $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);
        $sql = "SELECT * FROM blogs 
            WHERE LOWER(topic) LIKE '%$searchKeyword%' OR LOWER(author) LIKE '%$searchKeyword%' 
                  OR LOWER(category) LIKE '%$searchKeyword%' OR LOWER(description) LIKE '%$searchKeyword%' 
            ORDER BY date DESC 
            LIMIT $offset, $blogsPerPage";
    } elseif ($categoryFilter) {
        $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
        $sql = "SELECT * FROM blogs 
            WHERE category = '$categoryFilter' 
            ORDER BY date DESC 
            LIMIT $offset, $blogsPerPage";
    } else {
        $sql = "SELECT * FROM blogs 
            ORDER BY date DESC 
            LIMIT $offset, $blogsPerPage";
    }

    // Execute and return the query result
    return mysqli_query($conn, $sql);
}

// Fetch categories and blog counts
function getBlogCategories($conn)
{
    $sql = "SELECT category, COUNT(*) as count FROM blogs GROUP BY category";
    return mysqli_query($conn, $sql);
}

// Fetch recent blog posts
function getRecentPosts($conn)
{
    $sql = "SELECT * FROM blogs ORDER BY date DESC LIMIT 3";
    return mysqli_query($conn, $sql);
}

// Fetch tags
function getBlogTags($conn)
{
    $sqlTags = "SELECT description FROM blogs";
    $tagsResult = mysqli_query($conn, $sqlTags);

    $tags = [];
    if ($tagsResult && mysqli_num_rows($tagsResult) > 0) {
        while ($row = mysqli_fetch_assoc($tagsResult)) {
            $description = strtolower($row['description']);
            preg_match_all('/\b(design|consulting|travel|culture|adventure|wildlife|beaches)\b/i', $description, $matches);
            $tags = array_merge($tags, $matches[0]);
        }
        $tags = array_unique($tags);
    }
    return $tags;
}

// Pagination logic
function getPaginatedBlogs($conn, $page = 1, $blogsPerPage = 6)
{
    $offset = ($page - 1) * $blogsPerPage;
    $sql = "SELECT * FROM blogs ORDER BY date DESC LIMIT $offset, $blogsPerPage";
    return mysqli_query($conn, $sql);
}

function getTotalBlogsCount($conn)
{
    $sql = "SELECT COUNT(*) AS total FROM blogs";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function getTotalPages($totalBlogs, $blogsPerPage)
{
    return ceil($totalBlogs / $blogsPerPage);
}
