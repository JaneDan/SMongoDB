<?php

namespace SMongoDB\Options\Crud;

final class DeletesOptions
{
    private $_deletes = array();

    public function addDelete(DeletesOption $delete)
    {
        $this->_deletes[] = $delete;
    }

    public function getOptions()
    {
        return array('deletes' => $this->_deletes);
    }
}