<?php

class m120925_085554_create_user_table extends CDbMigration
{
    
    public function up()
    {
        $this->createTable('users', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'login' => 'varchar(255) CHARACTER SET utf8 NOT NULL',
            'password' => 'varchar(32) CHARACTER SET utf8 NOT NULL',
            'role' => 'int(2) NOT NULL',
            'email' => 'varchar(255) CHARACTER SET utf8 NOT NULL',
            'status' => 'int(1) NOT NULL',
            'date_add' => 'int(11) NOT NULL',
            'date_edit' => 'int(11) NOT NULL',
        ));
        $this->createTable('profile', array(
            'user_id' => 'int(11) PRIMARY KEY',
            'full_name' => 'varchar(255) NOT NULL',
            'avatar' => 'varchar(255) NOT NULL',
            'city_id' => 'int(11) NOT NULL',
            'sex' => 'int(1) NOT NULL',
            'birthday' => 'int(11) NOT NULL',
        ));
        $this->createTable('user_providers', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'int(11) NOT NULL',
            'provider_id' => 'int(11) NOT NULL',
            'soc_id' => 'varchar(32) CHARACTER SET utf8 NOT NULL',
        ));
    }
 
    public function down()
    {
        $this->dropTable('profile');
        $this->dropTable('users');
        $this->dropTable('user_providers');
    }
    
}