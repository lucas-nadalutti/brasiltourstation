<?php

// Create email settings if in local environment

if (is_file(dirname(__FILE__) . '/email-dev.php')) {
	include 'email-dev.php';
}


/**
 *
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * This is email configuration file.
 *
 * Use it to configure email transports of CakePHP.
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *  Mail - Send using PHP mail function
 *  Smtp - Send using SMTP
 *  Debug - Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */

if (!defined('EMAIL_TRANSPORT')) {
	define('EMAIL_TRANSPORT', getenv('EMAIL_TRANSPORT'));
	define('EMAIL_HOST', getenv('EMAIL_HOST'));
	define('EMAIL_PORT', getenv('EMAIL_PORT'));
	define('EMAIL_USERNAME', getenv('EMAIL_USERNAME'));
	define('EMAIL_PASSWORD', getenv('EMAIL_PASSWORD'));
}

class EmailConfig {

	/**
	*
	* -------------------------- TODO REMINDER -----------------------------
	*
	* MUST CHANGE THESE VALUES IN STAGING AND PRODUCTION ENVIRONMENTS WHEN THERE
	* IS AN OFFICIAL EMAIL
	*
	*/

	public $default = array(
		'transport' => EMAIL_TRANSPORT,
	    'host' => EMAIL_HOST,
	    'port' => EMAIL_PORT,
	    'username' => EMAIL_USERNAME,
	    'password' => EMAIL_PASSWORD,
	);

}
