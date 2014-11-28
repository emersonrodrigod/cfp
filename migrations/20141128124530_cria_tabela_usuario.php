<?php

use Phinx\Migration\AbstractMigration;

class CriaTabelaUsuario extends AbstractMigration {
  
    public function up() {

        $sql = "create table if not exists usuario(
                    id int not null auto_increment primary key,
                    nome varchar(100) not null,
                    username varchar(100) not null,
                    senha varchar(255) not null,
                    unique key(username)
                )";

        $this->execute($sql);
    }

  
    public function down() {
        $sql = "drop table usuario";
        $this->execute($sql);
    }

}
