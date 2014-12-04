<?php

class AppModel extends \ActiveRecord\Model {

    static $after_save = ['updateProxyLuceneIndex'];
    static $after_destroy = ['deleteLuceneIndex'];
    
    public function updateProxyLuceneIndex()
    {
        if (method_exists($this, 'updateLuceneIndex')) {
            $this->updateLuceneIndex();
        }
    }

    public function getLuceneIndex()
    {
        if (file_exists($index = $this->getLuceneIndexFile())) {
            return Zend_Search_Lucene::open($index);
        }
        return Zend_Search_Lucene::create($index);
    }

    public function getLuceneIndexFile()
    {
        return ROOT . '/data/spider/' . get_class($this) . '.index';
    }

    public function deleteLuceneIndex()
    {
        $index = $this->getLuceneIndex();

        foreach ($index->find('pk:'.$this->id) as $hit) {
            $index->delete($hit->id);
        }
    }

    public function search($query)
    {
        $hits = $this->getLuceneIndex()->find($query);

        $pks = [];
        foreach ($hits as $hit) {
            $pks[] = $hit->pk;
        }

        return $pks;
    }

    /**
     * Pecorre o attributo $has_many, a procura de registro que esteja sendo usandos
     * Pelo $object passado
     *
     * É importando agora, mapear todos os relacionamentos do Modelos ActiveRecord
     * Para que ocorra o correto funcionamento deste método
     * 
     * @param  Activerecord/Model   $object Objeto do registro que quer ser deletado
     * @param  integer              $id     ID do registro que quer ser deletado
     * @return boolean                      
     */
    static function in_used($object, $id)
    {
        
        $exceptions = [
            'telefones',
            'emails',
            'endereco'
        ];

        $has_many = isset($object::$has_many) ? $object::$has_many : array();

        foreach ($has_many as $has) {
            
            if(in_array($has[0], $exceptions, true)) {
                continue;
            }

            $nodepends = isset($has['nodepends']) ? $has['nodepends'] : false;

            if($nodepends)
                continue;

            $class = $has[0];

            $list = $object->$class;

            if ( ! $list) {
                continue;
            }

            $count = 0;

            foreach ($list as $find) {

                if ( ! isset($find->status)) {
                    $count++;
                    continue;
                }

                if (isset($find->status) and $find->status != 0) {
                    $count++;
                }
            }

            if ($count) 
                return true;
        }

        $has_one = isset($object::$has_one) ? $object::$has_one : array();

        foreach ($has_one as $has) {

            if(in_array($has[0], $exceptions, true)) {
                continue;
            }

            $nodepends = isset($has['nodepends']) ? $has['nodepends'] : false;

            if($nodepends)
                continue;

            $class = $has[0];

            $list = $object->$class;

            if ( ! $list) {
                continue;
            }


            $count = 0;

            foreach ($list as $find) {

                if ( ! isset($find->status)) {
                    $count++;
                    continue;
                }

                if (isset($find->status) and ($find->status != 0)) {
                    $count++;
                }
                
            }
            exit();

            if ($count) 
                return true;
        }

        return false;
    }

}