<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use Psr\Http\Message\RequestInterface;

class Index extends SharedController
{
    public function indexAction(RequestInterface $request)
    {
        return $this->render('AdminModule:index:index.html.php');
    }
}
