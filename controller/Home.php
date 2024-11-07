<?php

class HomeController
{
    public function index()
    {
        $cate_data = LoaiCongViecModel::listAll();
        $VIEW = "./view/TrangChu.phtml";
        require("./template/template.phtml");
    }
}
