<?php
class TaskController
{
    public function listAll()
    {
        $data = CongViecModel::listAll();
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }

    public function add()
    {
        $cate_data = LoaiCongViecModel::listAll();
        $date = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cv = new CongViecModel();
            $cv->name = $_REQUEST["name"];
            $cv->description = $_REQUEST["description"];
            $cv->start_date = $_REQUEST["start_date"];
            $cv->due_date = $_REQUEST["due_date"];
            $cv->category_id = $_REQUEST["category_id"];

            $result = CongViecModel::add($cv);
            if ($result == 1)
                $data = "Thêm thành công";
            else
                $data = "Thêm bị lỗi";
        }

        $VIEW = "./view/ThemCongViec.phtml";
        require("./template/template.phtml");
    }

    public function update()
    {
        $data_update = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['due_date']) || !empty($_POST['start_date']) || !empty($_POST['name']) || !empty($_POST['description']) || !empty($_POST['category_id'])) {
                $cv = new CongViecModel();
                $cv->id = $_REQUEST['id'];
                $cv->name = $_REQUEST["name"];
                $cv->description = $_REQUEST["description"];
                $cv->start_date = $_REQUEST["start_date"];
                $cv->due_date = $_REQUEST["due_date"];
                $cv->category_id = $_REQUEST["category_id"];

                $result = CongViecModel::update($cv);
                if ($result == 1)
                    $data_update = "Thêm thành công";
                else
                    $data_update = "Thêm bị lỗi";
            }
        }
        $data = CongViecModel::listAll();
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }

    public function update_status()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $taskId = (int) $_POST["taskId"];
            $newStatus = $_POST["newStatus"];
            // Update task status in the database using your model
            $result = CongViecModel::update_status($taskId, $newStatus);
        }
    }

    public function show()
    {
        $id = $_REQUEST["id"];
        $data = CongViecModel::get($id);
        $cate_id = $data->category_id;
        $cate_name_by_id = LoaiCongViecModel::get_name_by_id($cate_id);
        $cate_data = LoaiCongViecModel::listAll();
        $VIEW = "./view/ChiTietCV.phtml";
        require("./template/template.phtml");
    }

    public function delete()
    {
        $id = $_REQUEST["id"];
        $result = CongViecModel::delete($id);
        $data = CongViecModel::listAll();
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }

    public function delete_tasks()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kiểm tra xem dữ liệu đã được gửi từ form và không rỗng
            if (isset($_POST["selected_tasks"]) && !empty($_POST["selected_tasks"])) {
                // Lấy danh sách các id của các công việc được chọn để xoá
                $selectedTaskIds = $_POST["selected_tasks"];

                // Gọi phương thức trong CongViecModel để xoá các công việc đã chọn
                $result = CongViecModel::delete_tasks($selectedTaskIds);

                // Kiểm tra kết quả của việc xoá và thực hiện hành động tương ứng
                if ($result) {
                    // Xoá thành công
                    // Redirect hoặc hiển thị thông báo thành công
                    // Ví dụ: header("Location: task_list.php");
                } else {
                    // Xoá thất bại
                    // Redirect hoặc hiển thị thông báo lỗi
                }
            } 
        }
        $data = CongViecModel::listAll();
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }


    public function search()
    {
        $keyword = $_REQUEST["keyword"];
        $data = CongViecModel::find($keyword);
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }
    public function status_search()
    {
        $status = $_REQUEST["status"];
        $data = CongViecModel::find_status($status);
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }

    public function cate_search()
    {
        $cate_id=$_REQUEST["cate_id"];
        $data = CongViecModel::find_cate($cate_id);
        $VIEW = "./view/DanhSachCongViec.phtml";
        require("./template/template.phtml");
    }
}
