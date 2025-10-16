<?php

class Controller_Admin_Availability extends Controller_Admin_Base
{
    /**
     * Danh sách tình trạng phòng
     */
    public function action_index()
    {
        $data = array();

        // Get filter parameters
        $hotel_id = \Input::get('hotel_id');
        $room_id = \Input::get('room_id');
        $date_from = \Input::get('date_from', date('Y-m-d'));
        $date_to = \Input::get('date_to', date('Y-m-d', strtotime('+7 days')));

        // Build query
        $where_conditions = array();
        $params = array();

        if ($hotel_id) {
            $where_conditions[] = 'r.hotel_id = :hotel_id';
            $params[':hotel_id'] = $hotel_id;
        }

        if ($room_id) {
            $where_conditions[] = 'ra.room_id = :room_id';
            $params[':room_id'] = $room_id;
        }

        $where_conditions[] = 'ra.date BETWEEN :date_from AND :date_to';
        $params[':date_from'] = $date_from;
        $params[':date_to'] = $date_to;

        $where_clause = !empty($where_conditions) ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

        $sql = "SELECT ra.*, r.name as room_name, h.name as hotel_name
			FROM room_availability ra
			LEFT JOIN rooms r ON r.id = ra.room_id
			LEFT JOIN hotels h ON h.id = r.hotel_id
			{$where_clause}
			ORDER BY ra.date DESC, h.name, r.name";

        $data['availabilities'] = \DB::query($sql)->parameters($params)->execute()->as_array();

        // Get hotels and rooms for filters
        $data['hotels'] = \DB::query('SELECT id, name FROM hotels WHERE status = :status ORDER BY name')
            ->parameters(array(':status' => 'active'))
            ->execute()->as_array();

        $data['rooms'] = \DB::query('SELECT r.id, r.name, h.name as hotel_name 
			FROM rooms r 
			LEFT JOIN hotels h ON h.id = r.hotel_id 
			WHERE r.status = :status 
			ORDER BY h.name, r.name')
            ->parameters(array(':status' => 'active'))
            ->execute()->as_array();
        $this->template->title = 'Quản lý tình trạng phòng';
        $this->template->content = \View::forge('admin/room_availability/index', $data);
    }

    /**
     * Tạo tình trạng phòng mới
     */
    public function action_create()
    {
        if (\Input::method() === 'POST') {
            $room_id = \Input::post('room_id');
            $date = \Input::post('date');
            $available_rooms = \Input::post('available_rooms', 1);
            $price_override = \Input::post('price_override');
            $status = \Input::post('status', 'available');
            $block_reason = \Input::post('block_reason');

            try {
                // Check if already exists
                $existing = \DB::query('SELECT id FROM room_availability WHERE room_id = :room_id AND date = :date')
                    ->parameters(array(':room_id' => $room_id, ':date' => $date))
                    ->execute()->as_array();

                if (!empty($existing)) {
                    \Session::set_flash('error', 'Tình trạng phòng cho ngày này đã tồn tại!');
                    \Response::redirect(\Uri::create('admin/room-availability'));
                }

                // Insert new availability
                $sql = 'INSERT INTO room_availability (room_id, date, available_rooms, price_override, status, block_reason, created_at, updated_at) 
					VALUES (:room_id, :date, :available_rooms, :price_override, :status, :block_reason, NOW(), NOW())';

                \DB::query($sql)->parameters(array(
                    ':room_id' => $room_id,
                    ':date' => $date,
                    ':available_rooms' => $available_rooms,
                    ':price_override' => $price_override ?: null,
                    ':status' => $status,
                    ':block_reason' => $block_reason
                ))->execute();

                \Session::set_flash('success', 'Tạo tình trạng phòng thành công!');
                \Response::redirect(\Uri::create('admin/room-availability'));

            } catch (\Exception $e) {
                \Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
                \Response::redirect(\Uri::create('admin/room-availability'));
            }
        }

        \Response::redirect(\Uri::create('admin/room-availability'));
    }

    /**
     * Cập nhật tình trạng phòng
     */
    public function action_update($id = null)
    {
        if (!$id || \Input::method() !== 'POST') {
            \Response::redirect(\Uri::create('admin/room-availability'));
        }

        $available_rooms = \Input::post('available_rooms', 1);
        $price_override = \Input::post('price_override');
        $status = \Input::post('status', 'available');
        $block_reason = \Input::post('block_reason');

        try {
            $sql = 'UPDATE room_availability 
				SET available_rooms = :available_rooms, 
					price_override = :price_override, 
					status = :status, 
					block_reason = :block_reason, 
					updated_at = NOW()
				WHERE id = :id';

            \DB::query($sql)->parameters(array(
                ':id' => $id,
                ':available_rooms' => $available_rooms,
                ':price_override' => $price_override ?: null,
                ':status' => $status,
                ':block_reason' => $block_reason
            ))->execute();

            \Session::set_flash('success', 'Cập nhật tình trạng phòng thành công!');

        } catch (\Exception $e) {
            \Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
        }

        \Response::redirect(\Uri::create('admin/room-availability'));
    }

    /**
     * Lấy thông tin tình trạng phòng (AJAX)
     */
    public function action_get($id = null)
    {
        if (!$id) {
            \Response::redirect(\Uri::create('admin/room-availability'));
        }

        try {
            $sql = 'SELECT ra.*, r.name as room_name, h.name as hotel_name
				FROM room_availability ra
				LEFT JOIN rooms r ON r.id = ra.room_id
				LEFT JOIN hotels h ON h.id = r.hotel_id
				WHERE ra.id = :id';

            $result = \DB::query($sql)->parameters(array(':id' => $id))->execute()->as_array();

            if (!empty($result)) {
                \Response::redirect(\Uri::create('admin/room-availability'));
            }

            \Response::redirect(\Uri::create('admin/room-availability'));

        } catch (\Exception $e) {
            \Response::redirect(\Uri::create('admin/room-availability'));
        }
    }

    /**
     * Xóa tình trạng phòng
     */
    public function action_delete($id = null)
    {
        if (!$id) {
            \Response::redirect(\Uri::create('admin/room-availability'));
        }

        try {
            \DB::query('DELETE FROM room_availability WHERE id = :id')
                ->parameters(array(':id' => $id))
                ->execute();

            \Session::set_flash('success', 'Xóa tình trạng phòng thành công!');

        } catch (\Exception $e) {
            \Session::set_flash('error', 'Lỗi: ' . $e->getMessage());
        }

        \Response::redirect(\Uri::create('admin/room-availability'));
    }
}
