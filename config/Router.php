<?php

namespace App\config;

use App\src\controller\BackController;

use App\src\controller\ErrorController;

use App\src\controller\FrontController;

use Exception;

class Router
{

    private $frontController;

    private $backController;

    private $errorController;

    private $request;


    public function __construct()
    {
        $this->frontController = new FrontController();

        $this->backController = new BackController();

        $this->errorController = new ErrorController();

        $this->request = new Request();

    }

    public function run()
    {

        $p = $this->request->getGet()->get('p');

        try
        {
            if(isset($p))
            {
                if($p === 'post')
                {
                   $this->frontController->single($this->request->getGet()->get('id'));

                }
                else if($p === 'addPost')
                {

                    $this->backController->addPost($this->request->getPost());

                }
                else if ($p === 'editPost')
                {
                    $this->backController->editPost($this->request->getPost(), $this->request->getGet()->get('id'));
                }
                else if ($p === 'deletePost')
                {
                    $this->backController->deletePost($this->request->getGet()->get('id'));
                }
                else if ($p === 'addCategory')
                {
                    $this->backController->addCategory($this->request->getPost());
                }
                else if ($p === 'deleteCategory')
                {
                    $this->backController->deleteCategory($this->request->getGet()->get('id'));
                }
                else if($p === 'addComment')
                {
                    $this->frontController->addComment($this->request->getPost(), $this->request->getGet()->get('id'));
                }
                else if($p === 'flagComment')
                {
                    $this->frontController->flagComment($this->request->getGet()->get('id'));
                }
                else if($p === 'unflagComment'){
                    $this->backController->unflagComment($this->request->getGet()->get('id'));
                }
                
                else if($p === 'deleteComment')
                {
                    $this->backController->deleteComment($this->request->getGet()->get('id'));
                }
                else if($p === 'register')
                {

                    $this->frontController->register($this->request->getPost());
                }
                else if($p === 'login')
                {

                    $this->frontController->login($this->request->getPost());
                }
                else if($p === 'profile')
                {

                    $this->backController->profile();

                }
                else if($p === 'updatePassword')
                {

                    $this->backController->updatePassword($this->request->getPost());

                }else if($p === 'logout')
                {
                    $this->backController->logout();
                }
                else if($p === 'deleteAccount')
                {

                    $this->backController->deleteAccount();
                }
                else if($p === 'deleteUser')
                {
                    $this->backController->deleteUser($this->request->getGet()->get('id'));
                }
                else if($p === 'adminPost')
                {

                    $this->backController->adminPost();
                }
                else if($p === 'adminCate')
                {

                    $this->backController->adminCate();
                }
                else if($p === 'adminUser')
                {

                    $this->backController->adminUser();
                }
                else if($p === 'adminComment')
                {

                    $this->backController->adminComment();
                }
                else
                {
                    $this->errorController->errorNotFound();
                }
            }
            else
            {
                $this->frontController->home();
            }
        }
        catch(Exception $e)
        {
            $this->errorController->errorServer();
        }
    }

}
