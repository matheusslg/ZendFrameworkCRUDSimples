<?php

namespace Album\Controller;

use Album\Model\AlbumTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{

    private $table;

    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'albums' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        $form = new \Album\Form\AlbumForm();

        $form->get('submit')->setAttribute('class', 'btn btn-success');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel([
                'form' => $form
            ]);
        }

        $album = new \Album\Model\Album();

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            exit('Not valid!');
        }

        $album->exchangeArray($form->getData());

        $this->table->saveAlbum($album);

        return $this->redirect()->toRoute('album', [
            'controller' => 'index'
        ]);

    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);

        if ($id == 0) {
            exit('Invalid ID');
        }

        try {
            $album = $this->table->getAlbum($id);
        } catch(\Exception $e) {
            exit('Error with Album table');
        }

        $form = new \Album\Form\AlbumForm();

        $form->bind($album);

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel([
                'form' => $form,
                'id' => $id
            ]);
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            exit('Not valid!');
        }

        $this->table->saveAlbum($album);

        return $this->redirect()->toRoute('album', [
            'controller' => 'index'
        ]);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);

        if ($id == 0) {
            exit('Invalid ID');
        }

        try {
            $album = $this->table->getAlbum($id);
        } catch(\Exception $e) {
            exit('Error with Album table');
        }

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return new ViewModel([
                'album' => $album,
                'id' => $id
            ]);
        }

        $del = $request->getPost('del', 'Não');
        if ($del == 'Sim') {
            $id = (int) $album->getId();
            $this->table->deleteAlbum($id);
        }

        $this->redirect()->toRoute('album');

        // return $this->redirect()->toRoute('album', [
        //     'controller' => 'index'
        // ]);
    }
}