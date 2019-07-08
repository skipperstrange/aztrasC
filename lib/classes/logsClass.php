<?php
//include 'fileSystemClass.php';
class logs extends MYSQL_AD
{
    var $time;
    var $logsMode;
    var $logFile;

    function __construct($logsMode = null, $logFile = null)
    {
        # code...
        $this->time = strftime("%Y-%m-%d %H:%M", time());
        // $this->auto_connect();
        if (trim($logsMode) == 'file') {
            $this->logsMode = 'file';
            $this->logFile = 'logs/logs.txt';
        }
        if (isset($logFile)) {
            $this->logFile = rtrim($logFile, '.txt') . '.txt';
        }
    }


    function createLog($event)
    {
        global $SESSION;
        $log['time'] = $this->time;
        $log['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $log['user_id'] = $SESSION->user_id;
        $log['event'] = trim($event);
        if (trim($log['event']) != '') {
            return $this->completeAutoInsertSelf($log);
        }
    }


    function getLogs()
    {

        $query = $this->selectQuery('logs');
        $total = $this->count($query);
        global $per_page;

        $pagination = new Pagination($_GET['page'], $per_page, $total);
        $p['results'] = $pagination->selectPagination(array('logs' => array(
                'log_id',
                'event',
                'time',
                'user_id'), 'users' => array('username')), 'users.user_id | logs.user_id |',
            array('order by' => 'logs.log_id DESC'));
        $p['per_page'] = $per_page;
        $p['total'] = $total;

        return $p;

    }

    function getUserLogs($user_id)
    {

        $query = $this->selectQuery('logs', 'user_id | ' . $user_id);
        $total = $this->count($query);
        global $per_page;

        $pagination = new Pagination($_GET['page'], $per_page, $total);
        $p['results'] = $pagination->selectPagination(array('logs' => array(
                'log_id',
                'ip_address',
                'event',
                'time',
                'user_id'), 'users' => array('username')),
            'users.user_id | logs.user_id , logs.user_id | ' . $user_id, array('order by' =>
                'logs.log_id DESC'));
        $p['per_page'] = $per_page;
        $p['total'] = $total;

        return $p;

    }

    function clearLogs()
    {

        $query = "TRUNCATE TABLE `logs`";

        if ($this->query($query)) {
            return true;
        } else {
            return false;
        }
    }

}
