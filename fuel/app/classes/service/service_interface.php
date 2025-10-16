<?php

/**
 * Interface cho Service Layer
 */
interface Service_Interface
{

    /**
     * @param $filters
     * @param $page
     * @param $per_page
     * @return mixed
     */
    public function get_list($filters = array(), $page = 1, $per_page = 20);

    /**
     * @param $id
     * @return mixed
     */
    public function get_by_id($id);

    /**
     * @param $data
     * @return mixed
     */
    public function create($data);

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function toggle_status($id);

    /**
     * @param $data
     * @param $is_update
     * @return mixed
     */
    public function validate($data, $is_update = false);
}
