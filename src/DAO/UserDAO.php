<?php

namespace App\src\DAO;

use App\src\model\User;

use App\config\Parameter;

class UserDAO extends DAO
{

    private function buildObject($row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);
        $user->setCreatedAt($row['createdAt']);
        $user->setRoles($row['roles']);
        return $user;
    }

    public function getUsers()
    {
        $sql = 'SELECT id, pseudo, roles, createdAt FROM users ORDER BY id DESC';
        $result = $this->createQuery($sql);
        $users = [];
        foreach ($result as $row){
            $userId = $row['id'];
            $users[$userId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $users;
    }
    

    public function register(Parameter $post)
    {
        $this->checkUser($post);

        $sql = 'INSERT INTO users (pseudo, email, password, roles, createdAt) VALUES (?, ?, ?, "user", NOW())';

        $this->createQuery($sql, [$post->get('pseudo'), $post->get('email'), password_hash($post->get('password'), PASSWORD_BCRYPT)]);
    }

    public function checkUser(Parameter $post)
    {
        $sql = 'SELECT COUNT(pseudo), COUNT(email) FROM users WHERE pseudo = ? OR email = ?';

        $result = $this->createQuery($sql, [$post->get('pseudo'), $post->get('email')]);

        $isUnique = $result->fetchColumn();

        if($isUnique) 
        {
            return '<p>Le pseudo ou l\'email existe déjà</p>';
        }
    }

    public function login(Parameter $post)
    {
        $sql = 'SELECT id, password, roles FROM users WHERE pseudo = ?';

        $data = $this->createQuery($sql, [$post->get('pseudo')]);

        $result = $data->fetch();

        $isPasswordValid = password_verify($post->get('password'), $result['password']);

        return [
            'result' => $result,

            'isPasswordValid' => $isPasswordValid
        ];
    }

    public function updatePassword(Parameter $post, $pseudo)
    {
        $sql = 'UPDATE users SET password = ? WHERE pseudo = ?';

        $this->createQuery($sql, [password_hash($post->get('password'), PASSWORD_BCRYPT), $pseudo]);
        
    }

    public function deleteAccount($pseudo)
    {
        $sql = 'DELETE FROM users WHERE pseudo = ?';
        $this->createQuery($sql, [$pseudo]);
    }

    public function deleteUser($id)
    {
        $sql = 'DELETE FROM users WHERE id = ?';
        $this->createQuery($sql, [$id]);
    }

    

}