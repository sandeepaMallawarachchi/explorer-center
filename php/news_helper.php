<?php
include('db.php');

// Fetch search term and category filter with pagination
function getNews($conn, $searchKeyword = '', $categoryFilter = '', $page = 1, $newsPerPage = 6)
{
    // Calculate the offset for pagination
    $offset = ($page - 1) * $newsPerPage;

    // Build the SQL query with filters, pagination, and descending order
    if ($searchKeyword && $categoryFilter) {
        $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);
        $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
        $sql = "SELECT * FROM news 
            WHERE (LOWER(`News Title`) LIKE '%$searchKeyword%' OR LOWER(category) LIKE '%$searchKeyword%' 
                   OR LOWER(content) LIKE '%$searchKeyword%') 
                  AND category = '$categoryFilter' 
            ORDER BY date DESC 
            LIMIT $offset, $newsPerPage";
    } elseif ($searchKeyword) {
        $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);
        $sql = "SELECT * FROM news 
            WHERE LOWER(`News Title`) LIKE '%$searchKeyword%' OR LOWER(category) LIKE '%$searchKeyword%' 
                  OR LOWER(content) LIKE '%$searchKeyword%' 
            ORDER BY date DESC 
            LIMIT $offset, $newsPerPage";
    } elseif ($categoryFilter) {
        $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
        $sql = "SELECT * FROM news 
            WHERE category = '$categoryFilter' 
            ORDER BY date DESC 
            LIMIT $offset, $newsPerPage";
    } else {
        $sql = "SELECT * FROM news 
            ORDER BY date DESC 
            LIMIT $offset, $newsPerPage";
    }

    // Execute and return the query result
    return mysqli_query($conn, $sql);
}

// Fetch categories and blog counts
function getNewsCategories($conn)
{
    $sql = "SELECT category, COUNT(*) as count FROM news GROUP BY category";
    return mysqli_query($conn, $sql);
}

// Fetch recent news posts
function getRecentNews($conn)
{
    $sql = "SELECT * FROM news ORDER BY date DESC LIMIT 3";
    return mysqli_query($conn, $sql);
}

// Fetch tags from content (if applicable)
function getNewsTags($conn)
{
    $sqlTags = "SELECT content FROM news";
    $tagsResult = mysqli_query($conn, $sqlTags);

    $tags = [];
    if ($tagsResult && mysqli_num_rows($tagsResult) > 0) {
        while ($row = mysqli_fetch_assoc($tagsResult)) {
            $content = strtolower($row['content']);
            preg_match_all('/\b(design|consulting|travel|culture|adventure|wildlife|beaches)\b/i', $content, $matches);
            $tags = array_merge($tags, $matches[0]);
        }
        $tags = array_unique($tags);
    }
    return $tags;
}

// Pagination logic
function getPaginatedNews($conn, $page = 1, $newsPerPage = 6)
{
    $offset = ($page - 1) * $newsPerPage;
    $sql = "SELECT * FROM news ORDER BY date DESC LIMIT $offset, $newsPerPage";
    return mysqli_query($conn, $sql);
}

function getTotalNewsCount($conn)
{
    $sql = "SELECT COUNT(*) AS total FROM news";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result)['total'];
}

function getTotalPages($totalNews, $newsPerPage)
{
    return ceil($totalNews / $newsPerPage);
}
?>
