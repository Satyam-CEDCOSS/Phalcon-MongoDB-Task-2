<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        // Redirect to view
    }
    public function addAction()
    {
        // print_r($_POST);die;
        $data = $this->mongo->value;
        $data->insertOne($_POST);
        $this->response->redirect("/index");
    }
    public function displayAction()
    {
        if ($_POST['search']) {
            $this->view->search = $_POST['search'];
        } else {
            $this->view->search = "";
        }
        $data = $this->mongo->value;
        $this->view->data = $data->find();
    }
    public function editAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->value;
        $this->view->data = $data->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)));

    }
    public function updateAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->value;
        $data->updateOne(array("_id" => new MongoDB\BSON\ObjectId($id)), array('$set' => $_POST));
        $this->response->redirect("/index/display");
    }
    public function deleteAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->value;
        $data->deleteOne(array("_id" => new MongoDB\BSON\ObjectId($id)));
        $this->response->redirect("/index/display");
    }
    public function metaAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->value;
        print_r($data->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)))->m_field);
        print_r($data->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)))->m_value);die;
    }
    public function variationAction()
    {
        $id = $_GET['id'];
        $data = $this->mongo->value;
        print_r($data->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)))->v_field);
        print_r($data->findOne(array("_id" => new MongoDB\BSON\ObjectId($id)))->v_value);die;
    }
}
