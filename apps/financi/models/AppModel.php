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

}