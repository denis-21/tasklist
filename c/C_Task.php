<?php
class C_Task extends C_Controller
{
    //
    // Конструктор.
    //
    public function __construct(){
        parent::__construct();
    }

    public function action_index()
    {
        $mTask = M_Task::Instance();
        $result = $mTask->All();
        $this->render('v/v_index.php',array('projects' => $result['projects'], 'task_list' => $result['task_list']));
    }

    public function  action_addtask() {
        $projectId = $_POST['projectId'];
        $descr = $_POST['descr'];
        $mTask = M_Task::Instance();
        $result = $mTask->AddTask($projectId,$descr);
        echo json_encode($result);
    }

    public function action_addProject() {
        $mTask = M_Task::Instance();
        $id = $mTask->AddProject($_POST['name']);
        echo json_encode($id);
    }
    public function action_DeleteProject() {
        $mTask = M_Task::Instance();
        $mTask->deleteProject();
        echo json_encode(1);
    }
    public function action_DeleteTask() {
        $mTask = M_Task::Instance();
        $mTask->deleteTask();
        echo json_encode(1);
    }
    public function action_UpdateTask() {
        $mTask = M_Task::Instance();
        $mTask->updateTask();
        echo json_encode(1);
    }
    public function action_ChangeStatusTask() {
        $mTask = M_Task::Instance();
        $mTask->ChangeStatusTask();
        echo json_encode(1);
    }
    public function action_Priority() {
        $mTask = M_Task::Instance();
        $mTask->updatePriority();
        echo json_encode(1);
    }

}
