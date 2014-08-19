<?php 

class Lote extends AppModel 
{
    static $table_name = 'lote';
    static $belongs_to = [
        ['empreendimento', 'class_name' => 'Empreendimento', 'foreign_key' => 'empreendimento_id', 'primary_key' => 'id']
    ];

    public function get_status() 
    {
        $tipos = [
            '1'=> 'Disponível',
            '2'=> 'Reservado',
            '3'=> 'Vendido'
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

        $doc->addField(Zend_Search_Lucene_Field::UnStored('numero', $this->numero, 'utf-8'));

        $doc->addField(Zend_Search_Lucene_Field::UnStored('quadra', $this->quadra, 'utf-8'));

        $doc->addField(Zend_Search_Lucene_Field::UnStored('empreendimento', $this->empreendimento->empreendimento, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::UnStored('valor', $this->valor, 'utf-8'));

        $index->addDocument($doc);
        $index->commit();
    }
}