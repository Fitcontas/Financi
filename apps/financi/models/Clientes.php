<?php

class Clientes extends AppModel {
    static $table_name = 'cliente';
    static $has_many = [
        ['telefones', 'class_name' => 'ClienteTelefone', 'foreign_key' => 'cliente_id', 'primary_key' => 'id'],
        ['emails', 'class_name' => 'ClienteEmail', 'foreign_key' => 'cliente_id', 'primary_key' => 'id']
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

        $doc->addField(Zend_Search_Lucene_Field::UnStored('status', $this->get_status(), 'utf-8'));

        $index->addDocument($doc);
        $index->commit();
    }

    
}