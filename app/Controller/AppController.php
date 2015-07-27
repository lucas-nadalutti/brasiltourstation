<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'Session',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login'
			),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
			'unauthorizedRedirect' => array(
				'controller' => 'users',
				'action' => 'login'
			),
            'authorize' => 'Controller',
			'authenticate' => 'Form'
		)
	);

	public function beforeFilter() {
		$this->_setLanguage();
		$locale = Configure::read('Config.language');
		$path = APP . 'View' . DS . $locale . DS . $this->viewPath;
		if ($locale && file_exists($path)) {
			$this->viewPath = $locale . DS . $this->viewPath;
		}
		$this->Auth->flash['params']['class'] = 'post-error message';
        $this->Auth->authError = __('Você não tem permissão para visualizar isso');
        $this->Auth->unauthorizedRequest = '/';
        $this->Auth->allow();
	}
	
	public function isAuthorized($user) {
		if (isset($user['role']) && $user['role'] === 'Administrador') {
			return true;
		}
		return false;
	}
	
	protected function _setLanguage() {
        if (!$this->Session->check('Config.language')) {
        	$langLetters = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : 'pt';
            $browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            switch ($browserLanguage) {
                case "en":
                    $this->Session->write('Config.language', 'en');
                    break;
                case "pt":
                    $this->Session->write('Config.language', 'pt');
                    break;
                default:
                    $this->Session->write('Config.language', 'pt');
            }
        }
        // TEMP: While there are no translations, always show pages in Portuguese
        $this->Session->write('Config.language', 'pt');

    	Configure::write('Config.language', $this->Session->read('Config.language'));
    }

}
