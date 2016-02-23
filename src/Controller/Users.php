<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use PPI\Framework\Http\Request as Request;

class Users extends SharedController
{
    public function listAction(Request $request)
    {
        // Get user entities
        $users = $this->getService('admin.users.storage')->getAll();

        return $this->render('AdminModule:users:list.html.php', compact('users'));
    }

    public function editAction(Request $request)
    {
        $user_id = $request->get('user_id');

        if ($user_id == 0) {
            $user = $this->getService('admin.users.storage')->getBlankEntity();
        } else {
            $user = $this->getService('admin.users.storage')->getById($user_id);
        }

        $user_levels = $this->getService('admin.userlevels.storage')->getAll();

        return $this->render('AdminModule:users:edit.html.php', compact('user', 'user_levels'));
    }

    public function saveAction(Request $request)
    {
        $config        = $this->getConfig()
        $missingFields = array();
        $post          = $request->request->all();
        // List of required array keys
        $requiredKeys  = array(
            'id',
            'first_name',
            'last_name',
            'email',
            'user_level_id'
        );

        $userStorage = $this->getService('admin.users.storage');

        // Check for missing fields, or fields being empty.
        foreach ($requiredKeys as $field) {
            if (!isset($post[$field]) || empty($post[$field])) {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the user
        if (!empty($missingFields)) {
            $this->setFlash('error', 'Some requred fields are empty. Please check your input and try again!');
            return $this->render('AdminModule:users:edit.html.php');
        }

        // Check if the email address already exists
        if ($userStorage->existsByEmail($post['email'])) {
            $this->setFlash(
                'error',
                'Email already exists at this moment. Please change your email address and try again!'
            );
            return $this->render('AdminModule:users:edit.html.php');
        }

        if ($post['id'] == 0) {
            // Generate random password
            $password         = $this->getService('auth.security')->generateStrongPassword();
            // Generate random salt
            $userSalt         = $this->getService('auth.security')->generateSalt();
            // Get authSalt from Application Config
            $appAuthSalt      = $config['authSalt'];
            // Generate encrypted password
            $post['password'] = $this->getService('auth.security')->saltPass($password, $appAuthSalt, $userSalt);
            // Set blocked value to not blocked
            $post['blocked']  = 0;
            // Create User
            $newUserID = $userStorage->create($post);

            // @todo : create a entry in the user_activation_token table

        } else {
            $userStorage->update($post, $post['id']);
        }

        $this->setFlash('success', 'User Created. Password is ' . $password);
        return $this->redirectToRoute('AdminModule_Users');
    }

    public function blockuserAction(Request $request)
    {
        $this->getService('admin.users.storage')->blockUser(
            (int)$request->get('user_id'),
            (int)$request->get('block_value')
        );
        $this->setFlash('success', 'User has been blocked');
        return $this->redirectToRoute('AdminModule_Users');
    }
}
