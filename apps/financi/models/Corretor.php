<?php 

class Corretor extends AppModel 
{
    static $table_name = 'corretor';

    static $has_many = [
        ['telefones', 'class_name' => 'CorretorTelefone', 'foreign_key' => 'corretor_id', 'primary_key' => 'id'],
        ['emails', 'class_name' => 'CorretorEmail', 'foreign_key' => 'corretor_id', 'primary_key' => 'id'],
        ['contrato_corretor', 'ContratoCorretor'],
        ['empreendimento_corretor', 'EmpreendimentoCorretor']
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

        $doc->addField(Zend_Search_Lucene_Field::UnStored('cpf', $this->cpf, 'utf-8'));

        $doc->addField(Zend_Search_Lucene_Field::UnStored('status', $this->get_status(), 'utf-8'));

        $index->addDocument($doc);
        $index->commit();
    }
}