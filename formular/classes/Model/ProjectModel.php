<?php

namespace Model;

use DataObject\ProjectData;

class ProjectModel extends AbstractModel
{
    public function getProjects()
    {
        $sql = '
            SELECT id, name FROM project ORDER BY id DESC;
        ';
        $result = $this->query($sql, array());
        $projects = array();
        foreach ($result as $row) {
            $project = new ProjectData();
            $project->setId(intval($row['id']));
            $project->setName($row['name']);
            $projects[] = $project;
        }
        return $projects;
    }

    /**
     * @param $data []
     * @return int
     */
    public function saveProject($data)
    {
        $id = $this->query('SELECT max(id) FROM project', array())[0]['max'] + 1;
        $from = $data['dateFrom'];
        $to = $data['dateTo'];
        $sql = '
            INSERT INTO project(id, name, fk_client, fk_user_owner, valid_from, valid_until, time_created, description)
            VALUES (:id, :name, :client, :owner, :from, :to, now(), :description)
        ';
        $this->query($sql, array(
                ':id' => $id,
                ':name' => $data['name'],
                ':client' => $data['client'],
                ':owner' => $data['owner'],
                ':from' => $from,
                ':to' => $to,
                ':description' => $data['description']
            )
        );
        return $id;
    }

    /**
     * @param $id
     * @return ProjectData
     */
    public function getProjectName($id)
    {
        $sql = '
            SELECT id, name FROM project WHERE id = :id;
        ';
        $result = $this->query($sql, array(':id' => $id));
        $project = new ProjectData();
        $project->setName($result[0]['name']);
        return $project;
    }
}