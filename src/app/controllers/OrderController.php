<?php

use Phalcon\Mvc\Controller;

session_start();
class OrderController extends Controller
{
    public function indexAction()
    {
        // Redirect to View
    }
    public function selectAction()
    {
        $_SESSION['sub'] = $_POST['val'];
    }
    public function addAction()
    {
        $arr = [
            "product" => "$_SESSION[sub]",
            "category" => "$_POST[category]",
            "name" => "$_POST[name]",
            "quantity" => $_POST['quantity'],
            "status" => "Paid",
            "date" => Date("Y-m-d")
        ];
        $data = $this->mongo->order;
        $data->insertOne($arr);
        $this->response->redirect("/order");
    }
    public function displayAction()
    {
        $data = $this->mongo->order;
        if ($_POST['status'] && $_POST['date']) {
            if ($_POST['date'] == 'Custom') {
                $sdate = "$_POST[s_date]";
                $edate = "$_POST[e_date]";
            } elseif ($_POST['date'] == 'This week') {
                $sdate = Date("Y-m-d", strtotime("-7 days"));
                $edate = Date("Y-m-d");
            } elseif ($_POST['date'] == 'This month') {
                $sdate = Date("Y-m-d", strtotime("-30 days"));
                $edate = Date("Y-m-d");
            } else {
                $sdate = Date("Y-m-d");
                $edate = Date("Y-m-d");
            }
            print_r($sdate);
            print_r($edate);
            $val = $data->find(["status" => $_POST['status'], '$and' => [["date" =>
             ['$gte' => $sdate]], ["date" => ['$lte' => $edate]]]]);
        } else {
            $val = $data->find();
        }
        $this->view->data = $val;
    }
    public function editAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->order;
        $this->view->data = $data->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
    }
    public function updateAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->order;
        $data->updateOne(array("_id" => new MongoDB\BSON\ObjectId($id)), array('$set' => $_POST));
        $this->response->redirect("/order/display");
    }
    public function deleteAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->order;
        $data->deleteOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
        $this->response->redirect("/order/display");
    }
}
