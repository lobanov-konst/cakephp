<?php
    /**
     * Static content controller.
     *
     * This file will render views from views/pages/
     *
     * @link          http://cakephp.org CakePHP(tm) Project
     * @package       app.Controller
     * @since         CakePHP(tm) v 0.2.9
     */

    App::uses('AppController', 'Controller');

    /**
     * Static content controller
     *
     * Override this controller by placing a copy in controllers directory of an application
     *
     * @package       app.Controller
     * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
     */
    /** @var UserModel User */

    class PagesController extends AppController {


        // Add model to controller
        public $uses = array('Posts','UserModel');

        public function display() {
            $path = func_get_args();

            $count = count($path);
            if (!$count) {
                return $this->redirect('/');
            }

            $page = $subpage = $title_for_layout = null;

            if (!empty($path[0])) {
                $page = $path[0];
            }
            if (!empty($path[1])) {
                $subpage = $path[1];
            }
            if (!empty($path[$count - 1])) {
                $title_for_layout = Inflector::humanize($path[$count - 1]);
            }
            $this->set(compact('page', 'subpage', 'title_for_layout'));
            try {
                $this->render(implode('/', $path));
            } catch (MissingViewException $e) {
                if (Configure::read('debug')) {
                    throw $e;
                }
                throw new NotFoundException();
            }
        }

        public function test() {
            //            $this->ext = '.php';
            $this->layout = 'default';

            $this->set(array('text_users' => $this->UserModel->find('all')));
            $this->set(array('text_posts' => $this->Posts->find('all')));
        }

        public function index() {
            //            $this->ext = '.php';
            $this->set(array('text' => 'test_view_index_'));
        }
    }
