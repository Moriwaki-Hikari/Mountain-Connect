<?php
namespace User;

use Db;

require_once(ROOT_PATH .'/Models/Db.php');

class User extends Db\Db
{
    private $table = 'users';
    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }
    /**
    *Userテーブルに登録　
    *
    * @param $data array 登録情報
    * @return $result 結果
    */

    public function register($data)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'INSERT INTO users (name, email, password, role, created_at, update_at)
        VALUES (:name, :email, :password, :role, :created_at, :update_at)';
        $this->dbh->beginTransaction();
        try {
            $sth = $this->dbh->prepare($sql);
            $hash = password_hash($data['password'], PASSWORD_DEFAULT);
            $sth->bindValue(':name', $data['name'], \PDO::PARAM_STR);
            $sth->bindValue(':email', $data['email'], \PDO::PARAM_STR);
            $sth->bindValue(':password', $hash, \PDO::PARAM_STR);
            $sth->bindValue(':role', 0, \PDO::PARAM_INT);
            $sth->bindValue(':created_at', $date, \PDO::PARAM_STR);
            $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
            $sth->execute();
            $this->dbh->commit();
            return $sth;
            echo '登録完了！'; // 登録完了のメッセージ
        } catch (PDOException $e) {
            $this->dbh->rollBack();
            exit('登録できませんでした。' . $e->getMessage());
        }
    }

    /**
    *ログイン処理
    * @param string $email
    * @param string $password
    * @return $user
    */

    public function login($email, $password)
    {
        $result = false;
        $user = self::getUserByEmail($email);


        if (!$user) {
            $_SESSION['msg'] = 'emailが一致しません。';
            return $result;
        }

        if (password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }

        $_SESSION['msg'] = 'パスワードが一致しません。';
        return $result;
    }

    /**
    *emailからユーザーを取得
    * @param string $email
    * @return array $user||false
    */

    public function getUserByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = ?';
        $arr = [];
        $arr[] = $email;
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($arr);
            //結果を返す
            $user = $sth->fetch();
            return $user;
        } catch (\Exception $e) {
            return $result;
        }
    }

    public function reset($email, $password)
    {
        $result = false;
        $user = self::getUserByEmail($email);
        if (!$user) {
            $_SESSION['msg'] = 'emailが一致しません。';
            return $result;
        }
        $sql = 'UPDATE users SET password = :password
        WHERE email = :email';
        $sth = $this->dbh->prepare($sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sth->bindvalue(':password', $hash, \PDO::PARAM_STR);
        $sth->bindvalue('email', $email, \PDO::PARAM_STR);
        $sth->execute();
        return $sth;
    }

    public function findByUser($id = 0)
    {
        $sth = $this->dbh->prepare('SELECT * FROM users Where id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function profile($id)
    {
        $sth = $this->dbh->prepare('SELECT * FROM users Where id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function profileUpdate($data, $id)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'UPDATE users SET name = :name, body = :body, update_at = :update_at
        WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':name', $data['name'], \PDO::PARAM_STR);
        $sth->bindValue(':body', $data['body'], \PDO::PARAM_STR);
        $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
        $sth->bindValue(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        return $sth;
    }

    public function diaryCreate($data)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'INSERT INTO diaries (user_id, title, body, created_at, update_at)
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

    public function myDiary($id)
    {
        $sth = $this->dbh->prepare('SELECT * FROM diaries Where user_id = :user_id');
        $sth->bindParam(':user_id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getMyDiary($id = 0)
    {
        $sth = $this->dbh->prepare('SELECT * FROM diaries Where id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function diaryUpdate($data, $id)
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $sql = 'UPDATE diaries SET title = :title, body = :body, update_at = :update_at
        WHERE id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':title', $data['title'], \PDO::PARAM_STR);
        $sth->bindValue(':body', $data['body'], \PDO::PARAM_STR);
        $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
        $sth->bindValue(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
        return $sth;
    }

    public function diaryDelete($id = 0)
    {
        $sth = $this->dbh->prepare('DELETE FROM diaries WHERE id = :id');
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
    }

    public function userList()
    {
        $id = 0;
        $sql = 'SELECT * FROM users WHERE role = :role';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':role', $id, \PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function userDelete($id = 0)
    {
        $sql = 'DELETE u, l, e, m
        FROM users u
        LEFT JOIN likes l ON u.id = l.user_id
        LEFT JOIN events e ON u.id = e.user_id
        LEFT JOIN messages m ON u.id = m.user_id
        WHERE u.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, \PDO::PARAM_INT);
        $sth->execute();
    }

    public function googleLogin($email, $user_name)
    {
        $user = self::getUserByEmail($email);
        if ($user) {
            return $user;
        } else {
            $date = new \DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $sql = 'INSERT INTO users (name, email, role, created_at, update_at)
            VALUES (:name, :email, :role, :created_at, :update_at)';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':name', $user_name, \PDO::PARAM_STR);
            $sth->bindValue(':email', $email, \PDO::PARAM_STR);
            $sth->bindValue(':role', 0, \PDO::PARAM_INT);
            $sth->bindValue(':created_at', $date, \PDO::PARAM_STR);
            $sth->bindValue(':update_at', $date, \PDO::PARAM_STR);
            $sth->execute();
            $user = self::getUserByEmail($email);
            return $user;
        }
    }
}
