<?php

class Usuario extends AppModel {
	static $table_name = 'usuario';
    static $belongs_to = [
        ['grupo_usuario', 'class_name' => 'GrupoUsuario', 'foreign_key' => 'grupo_id', 'primary_key' => 'id'],
        ['instituicao', 'class_name' => 'Instituicao', 'foreign_key' => 'instituicao_id', 'primary_key' => 'id']
    ];

    public function get_status() 
    {
        $tipos = [
            '1'=> 'Ativo',
            '2'=> 'Desabilitado'
        ];

        return $tipos[$this->read_attribute('status')];
    }

    public function updateLuceneIndex()
    {
        $index = $this->getLuceneIndex();

        // remove existing entries
        foreach ($index->find('pk:'.$this->id) as $hit)
        {
            $index->delete($hit->id);
        }

        $doc = new Zend_Search_Lucene_Document();

        $doc->addField(Zend_Search_Lucene_Field::Keyword('pk', $this->id));

        $doc->addField(Zend_Search_Lucene_Field::UnStored('nome', $this->nome, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::UnStored('usuario', $this->usuario, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::UnStored('email', $this->email, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::UnStored('status', $this->get_status(), 'utf-8'));

        $index->addDocument($doc);
        $index->commit();
    }
}