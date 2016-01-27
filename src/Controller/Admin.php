<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use PPI\Framework\Http\Request as Request;

class Admin extends SharedController
{
    public function dashboardAction(Request $request)
    {
        return $this->render('AdminModule:index:dashboard.html.php');
    }
}
