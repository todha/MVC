<?php
class CategoryController
{
    public function listAll()
    {
        $data = LoaiCongViecModel::listAll();
        $VIEW = "./view/DanhSachLoaiCV.phtml";
        require("./template/template.phtml");
    }

    public function add()
    {
        $data = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $lcv = new LoaiCongViecModel();
            $lcv->name = $_REQUEST["name"];
            $result = LoaiCongViecModel::add($lcv);
            if ($result == 1)
                $data = "Thêm thành công";
            else
                $data = "Thêm bị lỗi";
        }

        $VIEW = "./view/ThemLoaiCongViec.phtml";
        require("./template/template.phtml");
    }
    public function delete()
    {
        $id = $_REQUEST["id"];
        $result = LoaiCongViecModel::delete($id);
        if ($result == 1)
            $res = "Xóa loại công việc thành công";
        else
            $res = "Không thể xóa loại công việc này vì có công việc đang tham chiếu đến.";
        $data = LoaiCongViecModel::listAll();
        $VIEW = "./view/DanhSachLoaiCV.phtml";
        require("./template/template.phtml");
    }
}
