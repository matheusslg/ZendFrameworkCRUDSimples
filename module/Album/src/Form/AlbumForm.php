<?php
namespace Album\Form;

use Zend\Form\Form;

class AlbumForm extends Form 
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct('album');

        $this->setAttribute('method', 'POST');

        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);

        $this->add([
            'name' => 'artist',
            'type' => 'text',
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'title',
            'type' => 'text',
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id' => 'buttonSave',
                'class' => 'btn btn-success'
            ]
        ]);
    }
}