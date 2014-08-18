<?php 

class Empreendimento extends AppModel 
{
    static $table_name = 'empreendimento';
    static $has_many = [
        ['corretores', 'class_name' => 'EmpreendimentoCorretor', 'foreign_key' => 'empreendimento_id', 'primary_key' => 'id']
    ];

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

        $doc->addField(Zend_Search_Lucene_Field::UnStored('empreendimento', $this->empreendimento, 'utf-8'));

        $index->addDocument($doc);
        $index->commit();
    }
}