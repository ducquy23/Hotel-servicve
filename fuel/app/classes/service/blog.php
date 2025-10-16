<?php

use Fuel\Core\DB;

/**
 * Service cho quản lý Blogs
 */
class Service_Blog extends Service_Base
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct('blogs');

		$this->required_fields = array('title', 'content', 'category', 'status');

		$this->updateable_fields = array(
			'title', 'content', 'excerpt', 'featured_image', 'category', 'status', 'published_at'
		);
	}

    /**
     * @param $data
     * @param $is_update
     * @return array
     */
    public function validate($data, $is_update = false)
	{
		$errors = parent::validate($data, $is_update);

		// Validate tiêu đề
		if (isset($data['title'])) {
			if (strlen($data['title']) > 255) {
				$errors[] = 'Tiêu đề không được vượt quá 255 ký tự';
			}
		}

		// Validate nội dung
		if (isset($data['content'])) {
			if (strlen($data['content']) < 10) {
				$errors[] = 'Nội dung phải có ít nhất 10 ký tự';
			}
		}

		// Validate excerpt
		if (isset($data['excerpt']) && $data['excerpt']) {
			if (strlen($data['excerpt']) > 500) {
				$errors[] = 'Tóm tắt không được vượt quá 500 ký tự';
			}
		}

		// Validate category
		if (isset($data['category'])) {
			if (strlen($data['category']) > 100) {
				$errors[] = 'Danh mục không được vượt quá 100 ký tự';
			}
		}

		// Validate status
		if (isset($data['status'])) {
			$valid_statuses = array('published', 'draft');
			if (!in_array($data['status'], $valid_statuses)) {
				$errors[] = 'Trạng thái không hợp lệ';
			}
		}

		// Validate featured_image
		if (isset($data['featured_image']) && $data['featured_image']) {
			if (strlen($data['featured_image']) > 255) {
				$errors[] = 'Đường dẫn ảnh không được vượt quá 255 ký tự';
			}
		}

		return $errors;
	}

    /**
     * @return string[]
     */
    protected function get_searchable_fields()
	{
		return array('title', 'content');
	}

    /**
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function create($data)
	{
		$published_at = null;
		if (isset($data['status']) && $data['status'] === 'published') {
			$published_at = date('Y-m-d H:i:s');
		}

		$data['published_at'] = $published_at;

		// Handle featured image upload
		if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
			$data['featured_image'] = $this->upload_featured_image($_FILES['featured_image']);
		}

		return parent::create($data);
	}

    /**
     * @param $id
     * @param $data
     * @return true
     * @throws Exception
     */
    public function update($id, $data)
	{
		$current_blog = $this->get_by_id($id);
		if (!$current_blog) {
			throw new Exception('Không tìm thấy blog');
		}

		if (isset($data['status'])) {
			if ($data['status'] === 'published' && !$current_blog['published_at']) {
				$data['published_at'] = date('Y-m-d H:i:s');
			} elseif ($data['status'] === 'draft') {
				$data['published_at'] = null;
			} else {
				$data['published_at'] = $current_blog['published_at'];
			}
		}

		// Handle featured image upload
		if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
			// Delete old image if exists
			if (!empty($current_blog['featured_image'])) {
				$old_file_path = DOCROOT . $current_blog['featured_image'];
				if (file_exists($old_file_path)) {
					unlink($old_file_path);
				}
			}
			$data['featured_image'] = $this->upload_featured_image($_FILES['featured_image']);
		}

		return parent::update($id, $data);
	}

    /**
     * @param $id
     * @return true
     * @throws Exception
     */
    public function toggle_status($id)
	{
		$blog = $this->get_by_id($id);
		if (!$blog) {
			throw new Exception('Không tìm thấy blog');
		}

		$new_status = ($blog['status'] === 'published') ? 'draft' : 'published';
		$published_at = null;

		if ($new_status === 'published') {
			$published_at = date('Y-m-d H:i:s');
		}

		$data = array(
			'status' => $new_status,
			'published_at' => $published_at
		);

		return parent::update($id, $data);
	}

    /**
     * @param $filters
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_published_blogs($filters = array(), $page = 1, $per_page = 20)
	{
		$filters['status'] = 'published';
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $category
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_by_category($category, $page = 1, $per_page = 20)
	{
		$filters = array('category' => $category);
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $limit
     * @return mixed
     */
    public function get_latest_blogs($limit = 10)
	{
		$query = "SELECT * FROM blogs 
				  WHERE status = 'published' 
				  ORDER BY published_at DESC 
				  LIMIT :limit";
		
		return DB::query($query)
			->parameters(array(':limit' => $limit))
			->execute();
	}

    /**
     * @param $limit
     * @return mixed
     */
    public function get_popular_blogs($limit = 10)
	{
		$query = "SELECT * FROM blogs 
				  WHERE status = 'published' 
				  ORDER BY created_at DESC 
				  LIMIT :limit";
		
		return DB::query($query)
			->parameters(array(':limit' => $limit))
			->execute();
	}

	/**
	 * Lấy thống kê blogs
	 */
	public function get_statistics()
	{
		$stats = DB::query('SELECT 
			COUNT(*) as total,
			SUM(CASE WHEN status = "published" THEN 1 ELSE 0 END) as published_count,
			SUM(CASE WHEN status = "draft" THEN 1 ELSE 0 END) as draft_count,
			COUNT(DISTINCT category) as categories_count
			FROM blogs')
			->execute();

		return $stats[0];
	}

    /**
     * @param $keyword
     * @param $page
     * @param $per_page
     * @return array
     */
    public function search($keyword, $page = 1, $per_page = 20)
	{
		$filters = array();
		if ($keyword) {
			$filters['title'] = $keyword;
		}
		
		return $this->get_list($filters, $page, $per_page);
	}

    /**
     * @param $year
     * @param $month
     * @param $page
     * @param $per_page
     * @return array
     */
    public function get_by_date($year, $month = null, $page = 1, $per_page = 20)
	{
		$where_conditions = array("YEAR(published_at) = :year");
		$params = array(':year' => $year);

		if ($month) {
			$where_conditions[] = "MONTH(published_at) = :month";
			$params[':month'] = $month;
		}

		$where_clause = 'WHERE ' . implode(' AND ', $where_conditions) . ' AND status = "published"';

		// Đếm tổng số records
		$count_query = "SELECT COUNT(*) as total FROM blogs " . $where_clause;
		$count_result = DB::query($count_query)->parameters($params)->execute();
		$total_records = $count_result[0]['total'];

		// Tính pagination
		$total_pages = ceil($total_records / $per_page);
		$offset = ($page - 1) * $per_page;

		// Lấy dữ liệu
		$query = "SELECT * FROM blogs 
				  " . $where_clause . " 
				  ORDER BY published_at DESC LIMIT :limit OFFSET :offset";
		$params[':limit'] = $per_page;
		$params[':offset'] = $offset;

		$rows = DB::query($query)->parameters($params)->execute();

		return array(
			'rows' => $rows,
			'pagination' => array(
				'current_page' => $page,
				'total_pages' => $total_pages,
				'total_records' => $total_records,
				'per_page' => $per_page,
				'start' => $offset + 1,
				'end' => min($offset + $per_page, $total_records),
			),
		);
	}

    /**
     * @return mixed
     */
    public function get_categories_with_count()
	{
		$query = "SELECT category, COUNT(*) as count 
				  FROM blogs 
				  WHERE status = 'published' 
				  GROUP BY category 
				  ORDER BY count DESC, category ASC";
		
		return DB::query($query)->execute();
	}

    /**
     * @param $blog_id
     * @param $limit
     * @return object
     */
    public function get_related_blogs($blog_id, $limit = 5)
	{
		$current_blog = $this->get_by_id($blog_id);
		if (!$current_blog) {
			return array();
		}

		$query = "SELECT * FROM blogs 
				  WHERE id != :id 
				  AND category = :category 
				  AND status = 'published' 
				  ORDER BY published_at DESC 
				  LIMIT :limit";
		
		return DB::query($query)
			->parameters(array(
				':id' => $blog_id,
				':category' => $current_blog['category'],
				':limit' => $limit
			))
			->execute();
	}

	/**
	 * Upload featured image for blog
	 * @param array $file
	 * @return string
	 * @throws Exception
	 */
	private function upload_featured_image($file)
	{
		// Validate file
		if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
			throw new Exception('File upload không hợp lệ');
		}

		// Check file type
		$allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'webp');
		$file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
		
		if (!in_array($file_extension, $allowed_types)) {
			throw new Exception('Chỉ cho phép upload file ảnh: JPG, PNG, GIF, WEBP');
		}

		// Check file size (max 5MB)
		if ($file['size'] > 5 * 1024 * 1024) {
			throw new Exception('Kích thước file không được vượt quá 5MB');
		}

		// Create upload directory
		$upload_dir = DOCROOT . 'uploads/blogs/';
		if (!is_dir($upload_dir)) {
			if (!mkdir($upload_dir, 0755, true)) {
				throw new Exception('Không thể tạo thư mục upload');
			}
		}

		// Generate unique filename
		$filename = uniqid('blog_') . '_' . time() . '.' . $file_extension;
		$file_path = $upload_dir . $filename;

		// Move uploaded file
		if (!move_uploaded_file($file['tmp_name'], $file_path)) {
			throw new Exception('Không thể lưu file');
		}

		return 'uploads/blogs/' . $filename;
	}
}
