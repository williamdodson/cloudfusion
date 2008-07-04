<?php
/**
 * TARZAN CONFIGURATION
 * Set up your AWS account information.
 *
 * @category Tarzan
 * @package Config
 * @version 2008.04.12
 * @copyright 2006-2008 LifeNexus Digital, Inc. and contributors.
 * @license http://opensource.org/licenses/bsd-license.php Simplified BSD License
 * @link http://tarzan-aws.googlecode.com Tarzan
 * @see README
 */


/**
 * Define our Amazon Web Services Key
 * Found at http://aws-portal.amazon.com/gp/aws/developer/account/index.html?ie=UTF8&action=access-key
 */
define('AWS_KEY', '');

/**
 * Define our Amazon Web Services Secret Key.
 * Found at http://aws-portal.amazon.com/gp/aws/developer/account/index.html?ie=UTF8&action=access-key
 */
define('AWS_SECRET_KEY', '');

/**
 * Define our Amazon account ID without dashes. Used for Amazon EC2.
 * Found at http://aws-portal.amazon.com/gp/aws/developer/account/index.html?ie=UTF8&action=edit-aws-profile
 */
define('AWS_ACCOUNT_ID', '');

/**
 * Define our Amazon Associates ID. Used for crediting referrals via Amazon AAWS.
 * Found at http://affiliate-program.amazon.com/gp/associates/join/
 */
define('AWS_ASSOC_ID', '');

?>