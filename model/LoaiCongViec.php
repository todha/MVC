<?php
class LoaiCongViecModel
{
    public $id;
    public $name;
    public $date_created;
    public function __construct()
    {
        $this->id = "";
        $this->name = "";
        $this->date_created = "";
    }
    public static function listAll()
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        $query = "SELECT * FROM category";
        $result = $mysqli->query($query);
        $dslcv = array();
        if ($result) {
            foreach ($result as $row) {
                $lcv = new LoaiCongViecModel();
                $lcv->id = $row["id"];
                $lcv->name = $row["name"];
                $lcv->date_created = $row["date_created"];
                $dslcv[] = $lcv; //add an item into array
            }
        }
        $mysqli->close();
        return $dslcv;
    }

    public static function count_task($cate_id)
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        $query = "SELECT COUNT(*) AS total FROM task WHERE category_id = $cate_id";
        $result = $mysqli->query($query);
        // Lấy kết quả
        $row = $result->fetch_assoc();
        $total_tasks = $row['total'];

        // Đóng kết nối và trả về số lượng task
        $result->close();
        $mysqli->close();
        return $total_tasks;
    }

    public static function get_name_by_id($cate_id)
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        $query = "SELECT name FROM CATEGORY WHERE id = $cate_id";
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        $cate_name = $row['name'];
        $mysqli->close();
        return $cate_name;
    }

    public static function add($lcv)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        // Truy vấn SQL để lấy ID lớn nhất từ bảng task
        $query_max_id = "SELECT MAX(id) AS max_id FROM category";
        $result = $mysqli->query($query_max_id);
        $row = $result->fetch_assoc();
        $max_id = $row['max_id'];

        // Tăng ID lớn nhất lên 1 để tạo ID mới
        $id = $max_id + 1;
        $currentDate = date("Y-m-d H:i:s");
        $name = $lcv->name;
        $query = "INSERT INTO category (id, name, date_created) values ($id, '$name', '$currentDate')";

        if ($mysqli->query($query))
            return 1;
        return 0;
    }

    public static function delete($id)
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        $query_check_tasks = "SELECT COUNT(*) as total_task FROM task WHERE category_id=$id";
        $result = $mysqli->query($query_check_tasks);
        $row = $result->fetch_assoc();
        $total_tasks = $row['total_task'];
        $r = 0;
        if ($total_tasks > 0) {
            return $r;    
        } else {
            $query = "DELETE FROM category WHERE id=$id";
            if ($mysqli->query($query))
                $r = 1;
            $mysqli->close();
            return $r;
        }
    }
}
