<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users_and_notes extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>TRUE,'auto_increment'=>TRUE],
            'username'=>['type'=>'VARCHAR','constraint'=>'100'],
            'password'=>['type'=>'VARCHAR','constraint'=>'255'],
            'created_at'=>['type'=>'DATETIME','null'=>FALSE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('UsersTable', TRUE);

        $this->dbforge->add_field([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>TRUE,'auto_increment'=>TRUE],
            'user_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>TRUE],
            'title'=>['type'=>'VARCHAR','constraint'=>255],
            'content'=>['type'=>'TEXT','null'=>TRUE],
            'created_at'=>['type'=>'DATETIME','null'=>FALSE],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('NotesTable', TRUE);

        $this->db->insert_batch('UsersTable', [
            ['username'=>'admin', 'password'=>'admin', 'created_at'=>date('Y-m-d H:i:s')],
            ['username'=>'admin2','password'=>'admin2','created_at'=>date('Y-m-d H:i:s')],
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_table('NotesTable', TRUE);
        $this->dbforge->drop_table('UsersTable', TRUE);
    }
}
