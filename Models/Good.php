<?php
namespace Good;

use Db;

require_once(ROOT_PATH .'/Models/Db.php');

class Good extends Db\Db
{
    private $table = 'goods';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }

    public function dbPostGoodNum($event_id)
    {
        $sql = 'SELECT * FROM likes WHERE event_id = :event_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':event_id', $event_id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $countNum = count($result);
        return $countNum;
    }

    public function dbPostGoodUser($event_id, $user_id)
    {
        $sql = 'SELECT * FROM likes WHERE event_id = :event_id AND user_id = :user_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':event_id', $event_id, \PDO::PARAM_INT);
        $sth->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $countNum = count($result);
        return $countNum;
    }


    public function checkGood($event_id, $user_id)
    {
        $sql = 'SELECT * FROM likes WHERE event_id = :event_id AND user_id = :user_id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':event_id', $event_id, \PDO::PARAM_INT);
        $sth->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $sth->execute();
        // レコードが何件？
        $result = $sth->rowCount();
        // var_dump($result);
        // die;

        $check = self::checkCount($result, $event_id, $user_id);
        return $check;
    }

    //modelsで設定できない？
    public function checkCount($result, $event_id, $user_id)
    {
        if (empty($result)) {
            $sql = 'INSERT INTO likes (event_id, user_id)
            VALUES (:event_id, :user_id)';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':event_id', $event_id, \PDO::PARAM_INT);
            $sth->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $sth->execute();
            $result = self::dbPostGoodNum($event_id);
            return $result;
        } else {
            $sql = 'DELETE FROM likes
            WHERE event_id = :event_id AND user_id = :user_id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':event_id', $event_id, \PDO::PARAM_INT);
            $sth->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
            $sth->execute();
            $result = self::dbPostGoodNum($event_id);
            return $result;

            // $sqll = 'SELECT * FROM likes WHERE event_id = :event_id';
            // $sthh = $this->dbh->prepare($sqll);
            // $sthh->bindValue(':event_id', $event_id, \PDO::PARAM_INT);
            // $sthh->execute();
        }
    }
}
