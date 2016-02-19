<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use PPI\Framework\Http\Request as Request;

class Users extends SharedController
{
    public function listAction(Request $request)
    {
        $users = $this->getService('admin.user.storage')->getAll();
        return $this->render('AdminModule:users:list.html.php', compact('users'));
    }
}
