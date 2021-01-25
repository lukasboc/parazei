<?php
/**
 * Created by PhpStorm.
 * User: lukasbock
 * Date: 25.08.20
 * Time: 18:12
 */

interface iDBConnections
{
    public function getAllConnectionsByUid($userid);

    public function getConnectionById($id, $uid);

    public function deleteConnection($id, $userid);

    public function getAllConnectionNamesAndIdsByUid($userid);
}