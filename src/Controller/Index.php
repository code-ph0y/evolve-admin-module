<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use PPI\Framework\Http\Request as Request;

class Index extends SharedController
{
    public function indexAction(Request $request)
    {
        return $this->render('AdminModule:index:index.html.php');
    }
}
