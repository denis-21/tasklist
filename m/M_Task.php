<?php

class M_Task
{
    private static $instance; 	// ссылка на экземпляр класса
    private $msql; 				// драйвер БД

    //
    // Получение единственного экземпляра (одиночка)
    //
    public static function Instance()
    {
        if (self::$instance == null)
            self::$instance = new M_Task();

        return self::$instance;
    }
    private function __construct()
    {
        $this->msql = M_MSQL::Instance();
    }

    public function All()
    {
        $query = "SELECT  task_projects.id,task_projects.name,task_list.descr,task_list.projectId,task_list.id as id_task,task_list.status
                            FROM task_projects
                            LEFT JOIN task_list ON task_projects.id=task_list.projectId
                            ORDER BY id DESC";
        $res = $this->msql->Select($query);
        $i=0;
        $projects = array();
        $task_list = array();
        foreach ($res as $value) {
            $projects[$value['id']] = $value;
            $task_list[$i][$value['projectId']]['descr'] = $value['descr'];
            $task_list[$i][$value['projectId']]['id_task'] = $value['id_task'];
            $task_list[$i][$value['projectId']]['status'] = $value['status'];
            $i++;
        }
        return array('projects'=>$projects,'task_list'=>$task_list);
    }

    public function AddProject($post_name) {
        $id = $this->msql->Insert('task_projects', array('name'=>$post_name));
        return $id;
    }

    public function AddTask($projectId,$descr) {

        $obj = array();
        $obj['projectId'] = $projectId;
        $obj['descr'] = trim($descr);

         $id = $this->msql->Insert('task_list', $obj);
         if(is_numeric($id))
             return array('id'=>$id,'descr'=>trim($descr));

        return false;
    }

    public function UpdatePriority() {
        $id_first = intval($_POST['id_first']);
        $id_second = intval($_POST['id_second']);
        $temp_id = '99999';

        $where_1 = "id = '$id_first'";
        $this->msql->Update('task_list', array('id'=>$temp_id), $where_1);
        $where_2 = "id = '$id_second'";
        $this->msql->Update('task_list', array('id'=>$id_first), $where_2);
        $where_3 = "id = '$temp_id'";
        $this->msql->Update('task_list', array('id'=>$id_second), $where_3);
    }

    public function DeleteTask() {
        $id_task = $_POST['id_task'];

        $where = "id = '$id_task'";
        $this->msql->Delete('task_list', $where);

    }

    public function DeleteProject() {
        $id_project = $_POST['id_project'];
        $where = "id = '$id_project'";
        $res = $this->msql->Delete('task_projects', $where);
        if($res)
        {
            $where = "projectId = '$id_project'";
            $this->msql->Delete('task_list', $where);
        }

    }

    public function UpdateTask() {
        $id_task = $_POST['id_task'];
        $descr = $_POST['descr'];
        $type = $_POST['type'];
        if ($type == 1) {
            $where = "id = '$id_task'";
            $this->msql->Update('task_projects', array('name'=>$descr), $where);
        } else {
            $where = "id = '$id_task'";
            $this->msql->Update('task_list', array('descr'=>$descr), $where);
        }
    }

    public function ChangeStatusTask() {
        $id_task = $_POST['id_task'];
        switch($_POST['type']) {
            case 0:
                $where = "id = '$id_task'";
                $this->msql->Update('task_list', array('status'=>0), $where);
                break;
            case 1:
                $where = "id = '$id_task'";
                $this->msql->Update('task_list', array('status'=>1), $where);
                break;

        }
    }
}
