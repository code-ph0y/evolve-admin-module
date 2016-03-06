<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use PPI\Framework\Http\Request as Request;

class Users extends SharedController
{
    public function listAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        // Get user entities
        $users = $this->getService('admin.users.storage')->getAll();

        return $this->render('AdminModule:users:list.html.php', compact('users'));
    }

    public function editAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

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
        // Check user is logged in
        $this->loggedInCheck();

        $config        = $this->getConfig();
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
            if (!isset($post[$field]) || $post[$field] == '') {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the user
        if (!empty($missingFields)) {
            $user = $userStorage->makeEntity($post);
            $this->setFlash('danger', 'Some requred fields are empty. Please check your input and try again!');

            $user_levels = $this->getService('admin.userlevels.storage')->getAll();
            return $this->render('AdminModule:users:edit.html.php', compact('user', 'user_levels'));
        }

        if ($post['id'] == 0) {
            // Check if the email address already exists
            if ($userStorage->existsByEmail($post['email'])) {
                $user = $userStorage->makeEntity($post);
                $this->setFlash(
                    'danger',
                    'Email already exists at this moment. Please change your email address and try again!'
                );

                $user_levels = $this->getService('admin.userlevels.storage')->getAll();
                return $this->render('AdminModule:users:edit.html.php', compact('user', 'user_levels'));
            }

            // Generate random password for user
            $password         = $this->getService('auth.security')->generateStrongPassword();
            // Generate random salt for user
            $post['salt']     = $this->getService('auth.security')->generateSalt();
            // Get authSalt from Application Config
            $appAuthSalt      = $config['authSalt'];
            // Generate encrypted password
            $post['password'] = $this->getService('auth.security')->saltPass($password, $appAuthSalt, $post['salt']);
            // Set blocked value to not blocked
            $post['blocked']  = 0;
            // Create User
            $newUserID = $userStorage->create($post);

            // Generate sha1() based activation code
            $activationCode = sha1(openssl_random_pseudo_bytes(16));

            // Insert an activation token for this user
            $this->getService('auth.user.activation.storage')->create(array(
                'user_id'   => $newUserID,
                'token'     => $activationCode,
                'used'      => '1',
                'date_used' => date('Y-m-d H:i:s', strtotime('now'))
            ));
            $this->setFlash('success', 'User Created. Password is: ' . $password);
        } else {
            // Update User
            $id = $post['id'];
            $userStorage->update($id, $post);
            $this->setFlash('success', 'User Updated.');
        }


        return $this->redirectToRoute('AdminModule_Users');
    }

    public function deleteAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        // Get post delete items
        $deleteItems = $request->get('deleteItems');
        $items = explode(',', $deleteItems);

        // Delete required items
        foreach ($items as $item) {
            $this->getService('admin.users.storage')->deleteById($item);
            $this->getService('admin.user.activation.storage')->deleteByUserId($item);
            $this->getService('admin.user.forgot.storage')->deleteByUserId($item);
        }

        // Inform the user
        $this->setFlash('success', 'Selected items have been deleted successfully');
        return $this->redirectToRoute('AdminModule_Users');
    }

    public function blockuserAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        $this->getService('admin.users.storage')->blockUser(
            (int)$request->get('user_id'),
            (int)$request->get('block_value')
        );
        $this->setFlash('success', 'User has been blocked');
        return $this->redirectToRoute('AdminModule_Users');
    }

    public function changepasswordAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        $user_id = $request->get('user_id');
        $user = $this->getService('admin.users.storage')->getById($user_id);
        $rand_password = $this->getService('auth.security')->generateStrongPassword();

        if ($user === false) {
            throw new \Exception('No user found using user id: ' . $user_id);
        }

        return $this->render('AdminModule:users:changepassword.html.php', compact('user', 'rand_password'));
    }

    public function changepasswordsaveAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        // Get post variables
        $password = $request->get('userPassword');
        $user_id  = $request->get('userId');

        // Get config
        $config = $this->getConfig();

        // Get user storage from AuthModule
        $userStorage = $this->getService('auth.user.storage');

        // Get security helper
        $security = $this->getService('auth.security');

        // Get user with user id
        $user = $userStorage->getById($user_id);

        // Validate user id
        if ($user === false) {
            throw new \Exception('No user found using user id: ' . $user_id);
        }

        // Validate password
        if ($password == '') {
            $rand_password = $security->generateStrongPassword();
            $this->setFlash('danger', 'Password field was blank please re-evaluate your input and try again!');
            return $this->render('AdminModule:users:changepassword.html.php', compact('user', 'rand_password'));
        }

        // Get new encrypted password
        $encPassword = $security->saltPass(
            $user->getSalt(),
            $config['authSalt'],
            $password
        );

        // Update user password
        $userStorage->updatePassword(
            $user->getId(),
            $encPassword
        );

        $this->setFlash('success', 'Password changed successfully');
        return $this->redirectToRoute('AdminModule_Users');
    }
}
