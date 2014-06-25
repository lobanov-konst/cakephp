<?php

    /**
     * Created by PhpStorm.
     * User: kostia
     * Date: 25.06.14
     * Time: 12:03
     */

    App::uses('ConnectionManager', 'Model');

    class InitDBShell extends AppShell {

        public function main() {


            $db = ConnectionManager::getDataSource('default');
            if (!$db->isConnected()) {
                $this->out('Connection failed!');
                return;
            }


            $table_name = 'posts';
            $db->execute("DROP TABLE IF EXISTS $table_name");
            $table_name = 'users';
            $db->execute("DROP TABLE IF EXISTS $table_name");


            $table_name = 'users';
            $db->execute("CREATE TABLE IF NOT EXISTS
                                $table_name (
                                i_id                INT AUTO_INCREMENT,
                                str_name            VARCHAR(100),
                                dt_datetime_created DATETIME,
                                PRIMARY KEY (i_id))
                                COMMENT='Пользователи'");

            $table_name = 'posts';
            $db->execute("CREATE TABLE IF NOT EXISTS
                                $table_name (
                                i_id                INT AUTO_INCREMENT,
                                i_post_id           INT NOT NULL,
                                i_user_id           INT NOT NULL,
                                str_post            VARCHAR(255),
                                dt_datetime_created DATETIME,
                                PRIMARY KEY (i_id),
                                FOREIGN KEY (i_user_id) REFERENCES users (i_id)
                                ON DELETE CASCADE
                                )
                                COMMENT='Посты'");

            // Add user
            $db->execute("INSERT INTO users SET str_name='user_name'");
            $user_id = $db->lastInsertId();

            // Add posts
            for ($i = 1; $i < 10; $i++) {
                $db->execute("INSERT INTO posts SET i_user_id=$user_id, i_post_id=$i, str_post='post_$i'");
            }
        }
    }
