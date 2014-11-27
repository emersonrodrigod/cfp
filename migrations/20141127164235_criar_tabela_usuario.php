<?php

use Phinx\Migration\AbstractMigration;

class CriarTabelaUsuario extends AbstractMigration {

    public function up() {
        $this->execute(
                "create table usuario (
                    id int not null auto_increment primary key,
                    nome varchar(255) not null,
                    email varchar(255) not null,
                    senha varchar(255) not null,
                    unique key(email)
                )"
        );
    }

    public function down() {
        $this->execute("drop table usuario");
    }

}
