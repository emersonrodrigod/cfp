<?php

use Phinx\Migration\AbstractMigration;

class AdicionaAdministrador extends AbstractMigration {

    public function up() {
        $sql = "insert into usuario values(null,'Administrador', 'administrador', sha1('admin'))";
        $this->execute($sql);
    }

    public function down() {
        $sql = "delete from usuario where username = 'administrador'";
        $this->execute($sql);
    }

}
