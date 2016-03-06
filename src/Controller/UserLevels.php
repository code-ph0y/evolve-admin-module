<?php
namespace AdminModule\Controller;

use AdminModule\Controller\Shared as SharedController;
use PPI\Framework\Http\Request as Request;

class UserLevels extends SharedController
{
    public function listAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        // Get user levels entities
        $user_levels = $this->getService('admin.userlevels.storage')->getAll();

        return $this->render('AdminModule:userlevels:list.html.php', compact('user_levels'));
    }

    public function editAction(Request $request)
    {
        // Check user is logged in
        $this->loggedInCheck();

        // Get post variables
        $user_level_id = $request->get('user_level_id');

        // Get user level entity
        if ($user_level_id == 0) {
            $user_level = $this->getService('admin.userlevels.storage')->getBlankEntity();
        } else {
            $user_level = $this->getService('admin.userlevels.storage')->getById($user_level_id);
        }

        return $this->render('AdminModule:userlevels:edit.html.php', compact('user_level'));
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
            'userlevelId',
            'userlevelTitle'
        );

        $userlevelStorage = $this->getService('admin.userlevels.storage');

        // Check for missing fields, or fields being empty.
        foreach ($requiredKeys as $field) {
            if (!isset($post[$field]) || $post[$field] == '') {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the user
        if (!empty($missingFields)) {
            $user_level = $userlevelStorage->makeEntity($post);
            $this->setFlash('danger', 'Some requred fields are empty. Please check your input and try again!');

            return $this->render('AdminModule:userlevels:edit.html.php', compact('user_level'));
        }

        // Create user level array

        $user_level = array(
            'id'    => $post['userlevelId'],
            'title' => $post['userlevelTitle']
        );

        if ($post['userlevelId'] == 0) {
            // Create User Level
            $userlevelStorage->create($user_level);
            $this->setFlash('success', 'User Level Created.');
        } else {
            // Update User Level
            $id = $user_level['id'];
            $userlevelStorage->update($id, $user_level);
            $this->setFlash('success', 'User Level Updated.');
        }

        $this->setFlash('success', 'User Level saved successfully');
        return $this->redirectToRoute('AdminModule_User_Levels');
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
            $this->getService('admin.userlevels.storage')->deleteById($item);
        }

        // Inform the user
        $this->setFlash('success', 'Selected items have been deleted successfully');
        return $this->redirectToRoute('AdminModule_User_Levels');
    }
}
