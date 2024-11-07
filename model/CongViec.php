<?php
class CongViecModel
{
    public $id;
    public $name;
    public $description;
    public $start_date;
    public $due_date;
    public $category_id;
    public $status;
    public $finished_date;
    function __construct()
    {
        $this->id = "";
        $this->name = "";
        $this->description = "";
        $this->start_date = "";
        $this->due_date = "";
        $this->category_id = "";
        $this->finished_date = "";
        $this->status = "";
    }

    public static function listAll()
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        $query = "SELECT * FROM task";
        $result = $mysqli->query($query);
        $dscv = array();
        if ($result) {
            foreach ($result as $row) {
                $cv = new CongViecModel();
                $cv->id = $row["id"];
                $cv->name = $row["name"];
                $cv->description = $row["description"];
                $cv->status = $row["status"];
                $dscv[] = $cv; //add an item into array
            }
        }
        $mysqli->close();
        return $dscv;
    }

    public static function add($cv)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        // Truy vấn SQL để lấy ID lớn nhất từ bảng task
        $query_max_id = "SELECT MAX(id) AS max_id FROM task";
        $result = $mysqli->query($query_max_id);
        $row = $result->fetch_assoc();
        $max_id = $row['max_id'];

        // Tăng ID lớn nhất lên 1 để tạo ID mới
        $id = $max_id + 1;

        $name = $cv->name;
        $description = $cv->description;
        $start_date = $cv->start_date;
        $due_date = $cv->due_date;
        $category_id = $cv->category_id;

        $query = "INSERT INTO task (id, name, description, start_date, due_date, category_id) values ($id, '$name', '$description', '$start_date', '$due_date', '$category_id')";

        if ($mysqli->query($query))
            return 1;
        return 0;
    }
    public static function update($cv)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        // Lấy các giá trị được gửi từ form
        $task_id = $cv->id;

        // Chuẩn bị truy vấn cập nhật
        $sql = "UPDATE task SET ";

        // Thêm các trường cần cập nhật vào câu lệnh SQL
        $update_fields = array();

        if (!empty($cv->name)) {
            $update_fields[] = "name = '" . $cv->name . "'";
        }
        if (!empty($cv->description)) {
            $update_fields[] = "description = '" . $cv->description . "'";
        }
        if (!empty($cv->start_date)) {
            $update_fields[] = "start_date = '" . $cv->start_date . "'";
        }

        if (!empty($cv->due_date)) {
            $update_fields[] = "due_date = '" . $cv->due_date . "'";
        }
        if (!empty($cv->category_id)) {
            $update_fields[] = "category_id = '" . $cv->category_id . "'";
        }
        // Ghép các trường cập nhật vào câu lệnh SQL
        $sql .= implode(", ", $update_fields);

        // Thêm điều kiện WHERE
        $sql .= " WHERE id = " . $task_id;

        // Thực thi câu lệnh truy vấn
        $r = 0;
        if ($mysqli->query($sql))
            $r = 1;
        $mysqli->close();
        return $r;
    }
    public static function update_status($taskId, $newStatus)
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        if ($newStatus == "FINISHED") {
            $query = "UPDATE task SET status ='$newStatus' WHERE id = $taskId";
            $currentDate = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS
            // Xây dựng truy vấn UPDATE để cập nhật finished_date
            $query2 = "UPDATE task SET finished_date = '$currentDate' WHERE id = $taskId";
        } else {
            $query = "UPDATE task SET status ='$newStatus' WHERE id = $taskId";
            $query2 = "UPDATE task SET finished_date = '' WHERE id = $taskId";
        }
        $r = 0;
            if ($mysqli->query($query) && $mysqli->query($query2))
                $r = 1;
            $mysqli->close();
            return $r;
    }

    public static function get($id)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        $query = "SELECT * FROM task WHERE id=$id";
        $result = $mysqli->query($query);

        if ($row = $result->fetch_object()) {
            $cv = new CongViecModel();
            $cv->id = $row->id;
            $cv->name = $row->name;
            $cv->description = $row->description;
            $cv->start_date = $row->start_date;
            $cv->due_date = $row->due_date;
            $cv->category_id = $row->category_id;
            $cv->status = $row->status;
            $cv->finished_date = $row->finished_date;
        }
        $mysqli->close();
        return $cv;
    }

    public static function delete($id)
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        $query = "DELETE FROM task WHERE id=$id";
        $r = 0;
        if ($mysqli->query($query))
            $r = 1;
        $mysqli->close();
        return $r;
    }
    public static function delete_tasks($selectedTaskIds)
    {
        $mysqli = connect();
        $mysqli->query("SET NAMES utf8");
        // Chuyển đổi danh sách các id được chọn thành chuỗi để sử dụng trong truy vấn SQL
        $taskIdsString = implode(",", $selectedTaskIds);

        // Xây dựng truy vấn DELETE để xoá các công việc đã chọn
        $query = "DELETE FROM task WHERE id IN ($taskIdsString)";
        $r = 0;
        if ($mysqli->query($query))
            $r = 1;
        $mysqli->close();
        return $r;
    }

    public static function find($keyword)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        $query = "SELECT * FROM task WHERE name LIKE '%$keyword%' or description LIKE '%$keyword%'";
        $result = $mysqli->query($query);
        $dscv = array();
        if ($result) {
            foreach ($result as $row) {
                $cv = new CongViecModel();
                $cv->id = $row["id"];
                $cv->name = $row["name"];
                $cv->description = $row["description"];
                $cv->status = $row["status"];
                $dscv[] = $cv; //add an item into array
            }
        }
        $mysqli->close();
        return $dscv;
    }
    public static function find_status($status)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        if ($status == "All") {
            $query = "SELECT * FROM task";
        } else {
            $query = "SELECT * FROM task WHERE status ='$status'";
        }
        $result = $mysqli->query($query);
        $dscv = array();
        if ($result) {
            foreach ($result as $row) {
                $cv = new CongViecModel();
                $cv->id = $row["id"];
                $cv->name = $row["name"];
                $cv->description = $row["description"];
                $cv->status = $row["status"];
                $dscv[] = $cv; //add an item into array
            }
        }
        $mysqli->close();
        return $dscv;
    }
    public static function find_cate($cate_id)
    {
        $mysqli = connect();

        $mysqli->query("SET NAMES utf8");
        $query = "SELECT * FROM task WHERE category_id =$cate_id";
        $result = $mysqli->query($query);
        $dscv = array();
        if ($result) {
            foreach ($result as $row) {
                $cv = new CongViecModel();
                $cv->id = $row["id"];
                $cv->name = $row["name"];
                $cv->description = $row["description"];
                $cv->status = $row["status"];
                $dscv[] = $cv; //add an item into array
            }
        }
        $mysqli->close();
        return $dscv;
    }
}
