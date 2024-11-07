<?php
require_once("./controller/Home.php");
require_once("./controller/Task.php");
require_once("./controller/Category.php");
require_once("./model/CongViec.php");
require_once("./model/LoaiCongViec.php");
require_once("./config/dbconnect.php");

$action = "";
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
}

switch ($action) {
    case "task_list":
        $controller = new TaskController();
        $controller->listAll();
        break;
    case "search":
        $controller = new TaskController();
        $controller->search();
        break;
    case "status_search":
        $controller = new TaskController();
        $controller->status_search();
        break;
    case "add_task":
        $controller = new TaskController();
        $controller->add();
        break;
    case "update_task":
        $controller = new TaskController();
        $controller->update();
        break;
    case "update_status":
        $controller = new TaskController();
        $controller->update_status();
        break;
    case "show_task":
        $controller = new TaskController();
        $controller->show();
        break;
    case "delete_task":
        $controller = new TaskController();
        $controller->delete();
        break;
    case "cate_list":
        $controller = new CategoryController();
        $controller->listAll();
        break;
    case "cate_search":
        $controller = new TaskController();
        $controller->cate_search();
        break;
    case "add_cate":
        $controller = new CategoryController();
        $controller->add();
        break;
    case "delete_cate":
        $controller = new CategoryController();
        $controller->delete();
        break;
    default:
        $controller = new HomeController();
        $controller->index();
        break;
}
