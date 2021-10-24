<?php
namespace Mountain;

use Db;

require_once(ROOT_PATH .'/Models/Db.php');

class Mountain extends Db\Db
{
    private $table = 'mountains';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function index()
    {
        $sql = 'SELECT e.id, e.title, e.body, e.user_id, u.name FROM events e
        JOIN users u ON u.id = e.user_id
        ORDER BY e.id DESC';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function eventsCreate($data)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'INSERT INTO events (user_id, title, body, created_at, update_at)
        VALUES (:user_id, :title, :body, :created_at, :update_at)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $sth->bindValue(':title', $data['title'], \PDO::PARAM_STR);
        $sth->bindValue(':body', $data['body'], \PDO::PARAM_STR);
        $sth->bindValue(':created_at', $date, \PDO::PARAM_STR);
        $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
        $sth->execute();
        return $sth;
    }

    public function myEvents($id)
    {
        $sth = $this->dbh->prepare('SELECT * FROM events Where user_id = :user_id');
        $sth->bindParam(':user_id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMyEvent($id = 0)
    {
        $sth = $this->dbh->prepare('SELECT * FROM events Where id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function eventsUpdate($data, $id)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'UPDATE events SET title = :title, body = :body, update_at = :update_at
        WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':title', $data['title'], \PDO::PARAM_STR);
        $sth->bindValue(':body', $data['body'], \PDO::PARAM_STR);
        $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
        $sth->bindValue(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        return $sth;
    }

    public function eventsDelete($id = 0)
    {
        $sth = $this->dbh->prepare('DELETE FROM events WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
    }

    public function getEvent($id = 0)
    {
        $sth = $this->dbh->prepare('SELECT * FROM events Where id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function messageCreate($data)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'INSERT INTO messages (user_id, event_id, body, created_at, update_at)
        VALUES (:user_id, :event_id, :body, :created_at, :update_at)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':user_id', $data['user_id'], \PDO::PARAM_INT);
        $sth->bindValue(':event_id', $data['event_id'], \PDO::PARAM_INT);
        $sth->bindValue(':body', $data['body'], \PDO::PARAM_STR);
        $sth->bindValue(':created_at', $date, \PDO::PARAM_STR);
        $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
        $sth->execute();
        return $sth;
    }

    public function getMessages($event_id)
    {
        $sql = 'SELECT m.id, u.id AS user_id, u.name, m.body, m.event_id FROM messages m
        JOIN users u ON u.id = m.user_id
        Where event_id = :event_id
        ORDER BY m.id DESC';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':event_id', $event_id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function messageDelete($id = 0)
    {
        $event_id = self::getEventId($id);
        $sth = $this->dbh->prepare('DELETE FROM messages WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        return $event_id;
    }

    public function getEventId($id)
    {
        $sth = $this->dbh->prepare('SELECT event_id FROM messages WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function search($search)
    {
        $data = "%{$search}%";
        $sql = 'SELECT e.id, e.title, e.body, e.user_id, u.name FROM events e
        JOIN users u ON u.id = e.user_id
        WHERE e.title LIKE :search
        ORDER BY e.id DESC';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':search', $data, \PDO::PARAM_STR);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
