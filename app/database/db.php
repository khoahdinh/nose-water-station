<?php

session_start();
require('connect.php'); // nhúng file connect.php vào

function dd($value) // to be deleted - dump and die
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

function executeQuery($sql, $data)
{
    global $conn;
    $stmt =  $conn->prepare($sql);
    $values = array_values($data);
    $types = str_repeat('s', count($values));
    $stmt->bind_param($types, ...$values);
    $stmt->execute();
    return $stmt;
}

function selectAll($table, $conditions = [])
{
    global $conn;
    $sql = "SELECT * FROM $table";
    if (empty($conditions)) {
        $stmt = $conn->prepare($sql);
        $stmt->execute(); // Thực hiện câu truy vấn trước khi lấy kết quả
        $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close(); // Giải phóng statement sau khi hoàn tất
        return $record;
    } else {
        // return records that match the condition ...
        // $sql = "SELECT * FROM $table WHERE username = 'Khoa' AND admin = 1";
        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key = ?";
            } else {
                $sql = $sql . " AND $key = ?";
            }
            $i++;
        }

        $stmt = executeQuery($sql, $conditions);
        if ($stmt) {
            $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close(); // Giải phóng statement sau khi hoàn tất
            return $record;
        } else {
            return null; // Xử lý nếu có lỗi trong executeQuery
        }
    }
}


function selectOne($table, $conditions)
{
    global $conn;
    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key = ?";
        } else {
            $sql = $sql . " AND $key = ?";
        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";
    $stmt = executeQuery($sql, $conditions);
    $record = $stmt->get_result()->fetch_assoc();
    return $record;
}


function create($table, $data)
{
    global $conn;
    // $sql ="INSERT INTO users SET username=?, admin=?, email=?, password=?"
    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql .= "$key = ?";
        } else {
            $sql .= ", $key = ?";
        }
        $i++;
    }

    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

function update($table, $id, $data)
{
    global $conn;
    // $sql ="UPDATE users SET username=?, admin=?, email=?, password=? WHERE id=?"
    $sql = "UPDATE $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql .= "$key = ?";
        } else {
            $sql .= ", $key = ?";
        }
        $i++;
    }

    $sql = $sql . " WHERE id=?";
    $data['id'] = $id;
    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}

function delete($table, $id)
{
    global $conn;
    $sql = "DELETE FROM $table WHERE id=?";
    $stmt = executeQuery($sql, ['id' => $id]);
    return $stmt->affected_rows;
}
// Hàm làm việc

function selectAllTopics($table)
{
    global $conn;

    // Câu SQL cơ bản với ORDER BY sort_order
    $sql = "SELECT * FROM $table ORDER BY sort_order ASC";

    // Chuẩn bị và thực thi câu truy vấn
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();
        $topics = $result->fetch_all(MYSQLI_ASSOC);

        // Đóng statement
        $stmt->close();
        return $topics;
    } else {
        return null; // Trả về null nếu xảy ra lỗi
    }
}


function getPublishedPosts($lang = 'vi')
// Lấy post từ database về trang index cho phần slider
{
    global $conn;

    // Lựa chọn cột dựa trên ngôn ngữ
    $title_col = $lang === 'en' ? 'title_eng' : 'title';
    $body_col = $lang === 'en' ? 'body_eng' : 'body';
    $preview_col = $lang === 'en' ? 'preview_eng' : 'preview';

    $sql = "SELECT p.id, p.image, u.username,
                   p.$title_col AS title, 
                   p.$body_col AS body, 
                   p.$preview_col AS preview,
                   p.created_at,
                   p.slug  
            FROM posts AS p 
            JOIN  users AS u ON p.user_id=u.id 
            WHERE p.published=? 
            ORDER BY p.created_at DESC";

    $stmt = executeQuery($sql, ['published' => 1]);
    if ($stmt) {
        $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $record;
    } else {
        return null;
    }
}

function formatPostFields($posts)
{
    if (empty($posts)) {
        return [];
    }
    $formattedPost = [];
    foreach ($posts as $post) {
        $currentPost = $post;
        $currentPost['body'] = html_entity_decode(substr($post['body'], 0, 150) . '...');
        $currentPost['created_at'] = date('F j, Y', strtotime($post['created_at']));
        $currentPost['image'] = BASE_URL . '/assets/images/' . $post['image'];
        array_push($formattedPost,  $currentPost);
    }
    return $formattedPost;
}

function getPaginatedPosts($currentPage = 1, $recordsPerPage = 3, $lang)
{
    global $conn;

    // Sử dụng các cột theo ngôn ngữ
    $columns = ($lang === 'en') ? "p.title_eng AS title, p.body_eng AS body, p.preview_eng AS preview"
        : "p.title, p.body, p.preview";

    $sql = "SELECT p.id, $columns, p.image, p.created_at, u.username, p.slug 
            FROM posts AS p JOIN  users AS u ON p.user_id=u.id 
            WHERE p.published=1 
            ORDER BY p.created_at DESC 
            LIMIT ?,?";
    $data = [
        'offset' => ($currentPage - 1) * $recordsPerPage,
        'numberOfRecords' => $recordsPerPage
    ];

    $stmt = executeQuery($sql, $data);

    if ($stmt) {
        $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return [
            'posts' => formatPostFields($posts),
            'nextPage' => count($posts) < $recordsPerPage ? false : $currentPage + 1,
        ];
    } else {
        return null;
    }
}


function get_posts_with_username()
{
    global $conn;
    $sql = "SELECT p.*, u.username 
            FROM posts AS p JOIN  users AS u ON p.user_id=u.id
            ORDER BY p.created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $record;
}

function get_random_post()
{
    global $conn;
    $sql = "SELECT slug FROM posts WHERE published = 1 ORDER BY RAND() LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result ? $result['slug'] : null;
}

function getPopularPosts($limit = 5, $lang = 'vi')
{
    global $conn;

    // Sử dụng các cột theo ngôn ngữ
    $columns = ($lang === 'en') ? "p.title_eng AS title"
        : "p.title";

    $sql = "SELECT p.id, $columns , p.image , p.slug
            FROM posts AS p
            WHERE p.published = 1 
            ORDER BY p.views DESC 
            LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $popularPosts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $popularPosts;
}

function getPostsWithComments()
{
    global $conn;

    // Câu SQL lấy các bài viết có ít nhất một bình luận
    $sql = "SELECT p.id AS post_id, p.title, p.image
            FROM posts p
            INNER JOIN comments c ON p.id = c.post_id
            GROUP BY p.id
            HAVING COUNT(c.id) > 0"; // Chỉ lấy bài viết có ít nhất một bình luận

    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();
        $postsWithComments = [];

        // Lưu trữ các bài viết có bình luận để xử lý sau này
        while ($row = $result->fetch_assoc()) {
            $postsWithComments[] = [
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'image' => $row['image']
            ];
        }

        // Đóng statement
        $stmt->close();
        return $postsWithComments;
    } else {
        return null; // Trả về null nếu không chuẩn bị được câu truy vấn
    }
}



function getPostsByTopicID($topic_id, $currentPage = 1, $recordsPerPage = 3, $lang)
{
    global $conn;

    // Sử dụng các cột theo ngôn ngữ
    $columns = ($lang === 'en') ? "p.title_eng AS title, p.body_eng AS body, p.preview_eng AS preview"
        : "p.title, p.body, p.preview";

    $sql = "SELECT p.id, $columns, p.image, p.created_at, u.username, p.slug
            FROM posts AS p JOIN  users AS u ON p.user_id=u.id 
            WHERE p.published=1 AND topic_id=? 
            ORDER BY p.created_at DESC 
            LIMIT ?,?";
    $data = [
        'topic_id' => $topic_id,
        'offset' => ($currentPage - 1) * $recordsPerPage,
        'numberOfRecords' => $recordsPerPage
    ];

    $stmt = executeQuery($sql, $data);

    if ($stmt) {
        $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return [
            'posts' => formatPostFields($posts),
            'nextPage' => count($posts) < $recordsPerPage ? false : $currentPage + 1,
        ];
    } else {
        return null;
    }
}




function searchPosts($term, $currentPage = 1, $recordsPerPage = 3, $lang)
{
    $match = '%' . $term . '%';
    global $conn;

    // Sử dụng các cột theo ngôn ngữ
    $lang = in_array($lang, ['en', 'vi']) ? $lang : 'vi'; // Giả sử 'vi' là ngôn ngữ mặc định
    $columns = ($lang === 'en') ? "p.title_eng AS title, p.body_eng AS body, p.preview_eng AS preview"
        : "p.title, p.body, p.preview";

    // Điều kiện tìm kiếm cho cả tiếng Việt và tiếng Anh
    $searchCondition = ($lang === 'en')
        ? "(p.body_eng LIKE ?)"
        : "(p.body LIKE ?)";

    $sql = "SELECT p.id, $columns, p.image, p.created_at, u.username, p.slug 
    FROM posts AS p 
    JOIN  users AS u ON p.user_id=u.id 
    WHERE p.published=1 AND $searchCondition
    ORDER BY p.created_at DESC 
    LIMIT ?,?";
    $data = [
        $match,
        ($currentPage - 1) * $recordsPerPage,
        $recordsPerPage
    ];

    // Debug: In ra câu lệnh SQL và dữ liệu
    // echo "lang: " . $lang;
    // echo "<pre>";
    // echo "SQL: " . $sql . "\n";
    // echo "Data: ";
    // print_r($data);
    // echo "</pre>";

    $stmt = executeQuery($sql, $data);

    if ($stmt) {
        $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return [
            'posts' => formatPostFields($posts),
            'nextPage' => count($posts) < $recordsPerPage ? false : $currentPage + 1,
        ];
    } else {
        return [
            'posts' => [],
            'nextPage' => false,
        ];
    }
}

function searchPostsInTopic($topicId, $searchTerm, $currentPage = 1, $recordsPerPage = 3, $lang)
{
    global $conn;

    // Chuyển đổi các giá trị thành số nguyên
    $currentPage = intval($currentPage);
    $recordsPerPage = intval($recordsPerPage);

    // Chọn cột theo ngôn ngữ
    $columns = ($lang === 'en') ? "p.title_eng AS title, p.body_eng AS body, p.preview_eng AS preview"
        : "p.title, p.body, p.preview";

    //Điều kiện tìm kiếm trong cả tiếng Việt và tiếng Anh
    $searchCondition = ($lang === 'en')
        ? "(p.body_eng LIKE ?)"
        : "(p.body LIKE ?)";

    // SQL tìm kiếm trong một topic
    $sql = "SELECT p.id, $columns, p.image, p.created_at, u.username, p.slug
            FROM posts AS p
            JOIN users AS u ON p.user_id = u.id
            WHERE topic_id = ? 
              AND p.published = 1
              AND $searchCondition
            ORDER BY p.created_at DESC
            LIMIT ?, ?";

    $searchPattern = "%" . $searchTerm . "%";

    $data = [
        'topic_id' => $topicId,
        $searchPattern,
        'offset' => ($currentPage - 1) * $recordsPerPage,
        'numberOfRecords' => $recordsPerPage,
    ];


    $stmt = executeQuery($sql, $data);

    if ($stmt) {
        $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return [
            'posts' => formatPostFields($posts),
            'nextPage' => count($posts) < $recordsPerPage ? false : $currentPage + 1,
        ];
    } else {
        return null;
    }
}


// Lấy ảnh image cho trang admin
function getImages($lang = 'vi')
{
    // Xác định cột caption theo ngôn ngữ
    $captionColumn = $lang === 'en' ? 'caption_eng' : 'caption';

    global $conn;
    $sql = "SELECT id, author, date, $captionColumn AS caption, image_path  
            FROM images
            ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $record;
}

// lấy comments cho admin comment
function getComments($post_id)
{
    global $conn;

    $sql = "SELECT c.*, p.title 
            FROM comments AS c 
            JOIN posts AS p ON c.post_id = p.id 
            WHERE c.post_id = ?
            ORDER BY c.id DESC";

    $data = [
        'post_id' => $post_id
    ];

    $stmt = executeQuery($sql, $data);

    if ($stmt) {
        $record = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $record;
    } else {
        return null;
    }
    // Chuẩn bị truy vấn
    // $stmt = $conn->prepare($sql);
    // if ($stmt) {
    // Liên kết tham số và thực thi
    // $stmt->bind_param('i', $post_id); // 'i' cho kiểu số nguyên
    // $stmt->execute();

    // Lấy kết quả
    // $result = $stmt->get_result();
    // $record = $result->fetch_all(MYSQLI_ASSOC);

    // Đóng statement và trả về kết quả
    //     $stmt->close();
    //     return $record;
    // } else {
    //     return null; // Trả về null nếu lỗi
    // }
}

function getParentComment($parentId)
{
    global $conn;

    $sql = "SELECT * FROM comments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $parentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $parentComment = $result->fetch_assoc();
    $stmt->close();

    return $parentComment;
}

// lấy comment cho single .php
function selectAllComment($post_id)
{
    global $conn;

    // Câu SQL cơ bản
    $sql = "SELECT * FROM comments WHERE post_id = ? AND parent_id IS NULL";

    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Liên kết tham số và thực thi truy vấn
        $stmt->bind_param('i', $post_id);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);

        // Đóng statement
        $stmt->close();
        return $comments;
    } else {
        return null; // Trả về null nếu không chuẩn bị được câu truy vấn
    }
}



function selectAllChildComments($parentId)
{
    global $conn;

    // Câu SQL lấy comment con dựa trên parent_id
    $sql = "SELECT * FROM comments WHERE parent_id = ?";

    // Chuẩn bị câu truy vấn
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Liên kết tham số và thực thi truy vấn
        $stmt->bind_param('i', $parentId);
        $stmt->execute();

        // Lấy kết quả
        $result = $stmt->get_result();
        $comments = $result->fetch_all(MYSQLI_ASSOC);

        // Đóng statement
        $stmt->close();
        return $comments;
    } else {
        return null; // Trả về null nếu không chuẩn bị được câu truy vấn
    }
}
