<?php
namespace Mountain;

use User;
use Mountain;
use Good;

require_once(ROOT_PATH .'/Models/User.php');
require_once(ROOT_PATH .'/Models/Mountain.php');
require_once(ROOT_PATH .'/Models/Good.php');


class MountainController
{
    private $request; //リクエストパラメータ(GET,POST)
    private $User;
    private $Mountain;
    private $Good;

    public function __construct()
    {
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

    //モデルオブジェクトの生成
        $this->User = new User\User();
    //別モデルと連携
        $dbh = $this->User->getDbHandler();
        $this->Mountain = new Mountain\Mountain($dbh);
        $this->Good = new Good\Good($dbh);
    }

    public function register($data)
    {
        if (isset($this->request['get']['id'])) {
        }

        $register = $this->User->register($data);
        $params = [
          'register' => $register
        ];
        return $params;
    }

    public function login($email, $password)
    {
        $login = $this->User->login($email, $password);
        $params = $login;
        return $params;
    }

    public function reset($email, $password)
    {
        $reset = $this->User->reset($email, $password);
        $params = $reset;
        return $params;
    }


    public function index()
    {
        if (isset($this->request['get']['page'])) {
        }
        $events = $this->Mountain->index();
        $params = [
          'events' => $events,
        ];
        return $params;
    }

    public function findByUser()
    {
        $findByUser = $this->User->findByUser($this->request['get']['id']);
        $params = [
          'findByUser' => $findByUser,
        ];
        return $params;
    }

    public function eventsCreate($data)
    {
        $create = $this->Mountain->eventsCreate($data);
        $params = [
          'eventsCreate' => $create,
        ];
        return $params;
    }

    public function myEvents($id)
    {
        $myEvent = $this->Mountain->myEvents($id);
        $params = [
          'myEvent' => $myEvent,
        ];
        return $params;
    }

    public function getMyEvent()
    {
        $getMyEvent = $this->Mountain->getMyEvent($this->request['get']['id']);
        $params = [
          'getMyEvent' => $getMyEvent,
        ];
        return $params;
    }

    public function eventsUpdate($data, $id)
    {
        $update = $this->Mountain->eventsUpdate($data, $id);
        $params = [
          'eventsUpdate' => $update,
        ];
        return $params;
    }

    public function eventsDelete()
    {
        $delete = $this->Mountain->eventsDelete($this->request['get']['id']);
        $params = [
          'eventsDelete' => $delete,
        ];
        return $params;
    }

    public function profile($id)
    {
        $profile = $this->User->profile($id);
        $params = [
          'profile' => $profile,
        ];
        return $params;
    }

    public function profileUpdate($data, $id)
    {
        $update = $this->User->profileUpdate($data, $id);
        $params = [
          'profileUpdate' => $update
        ];
        return $params;
    }

    public function diaryCreate($data)
    {
        $create = $this->User->diaryCreate($data);
        $params = [
          'diaryCreate' => $create
        ];
        return $params;
    }

    public function myDiary($id)
    {
        $myDiary = $this->User->myDiary($id);
        $params = [
          'myDiary' => $myDiary,
        ];
        return $params;
    }

    public function getMyDiary()
    {
        $getMyDiary = $this->User->getMyDiary($this->request['get']['id']);
        $params = [
          'getMyDiary' => $getMyDiary,
        ];
        return $params;
    }

    public function diaryUpdate($data, $id)
    {
        $update = $this->User->diaryUpdate($data, $id);
        $params = [
          'diaryUpdate' => $update,
        ];
        return $params;
    }

    public function diaryDelete()
    {
        $delete = $this->User->diaryDelete($this->request['get']['id']);
        $params = [
          'diaryDelete' => $delete,
        ];
        return $params;
    }

    public function getEvent()
    {
        $getEvent= $this->Mountain->getEvent($this->request['get']['id']);
        $params = [
        'getEvent' => $getEvent,
        ];
        return $params;
    }

    public function messageCreate($data)
    {
        $create = $this->Mountain->messageCreate($data);
        $params = [
          'messageCreate' => $create,
        ];
        return $params;
    }

    public function getMessages($event_id)
    {
        $getMessages= $this->Mountain->getMessages($event_id);
        $params = [
          'getMessages' => $getMessages,
        ];
        return $params;
    }

    public function messageDelete()
    {
        $delete = $this->Mountain->messageDelete($this->request['get']['id']);
        $params = [
          'messageDelete' => $delete,
        ];
        return $params;
    }

    public function userList()
    {
        $user = $this->User->userList();
        $params = [
          'userList' => $user,
        ];
        return $params;
    }

    public function userDelete()
    {
        $delete = $this->User->userDelete($this->request['get']['id']);
        $params = [
          'userDelete' => $delete,
        ];
        return $params;
    }

    public function search($search)
    {
        $search = $this->Mountain->search($search);
        $params = [
          'events' => $search,
        ];
        return $params;
    }

    public function dbPostGoodNum($event_id)
    {
        $dbPostGoodNum = $this->Good->dbPostGoodNum($event_id);
        $params = [
          'dbPostGoodNum' => $dbPostGoodNum,
        ];
        return $params;
    }

    public function dbPostGoodUser($event_id, $user_id)
    {
        $dbPostGoodUser = $this->Good->dbPostGoodUser($event_id, $user_id);
        $params = [
          'dbPostGoodUser' => $dbPostGoodUser,
        ];
        return $params;
    }

    // public function dbPostGoodUserNum($event_id)
    // {
    //     $dbPostGoodUserNum = $this->Good->dbPostGoodUserNum($event_id);
    //     $params = [
    //       'dbPostGoodUserNum' => $dbPostGoodUserNum,
    //     ];
    //     return $params;
    // }
}
