<?php
/**
 * This file is part of CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

namespace cmsgears\community\common\components;

// Yii Imports
use Yii;

/**
 * Mailer triggers the mails provided by Community Module.
 *
 * @since 1.0.0
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	// Global -----------------

	const MAIL_GROUP_CREATE		= 'group/create';
	const MAIL_GROUP_REGISTER	= 'group/register';

	const MAIL_GROUP_MEMBER_CREATE		= 'member/create';
	const MAIL_GROUP_MEMBER_REGISTER	= 'member/register';
	const MAIL_GROUP_MEMBER_JOIN		= 'member/join';
	const MAIL_GROUP_MEMBER_INVITE		= 'member/invite';

	// Public -----------------

    public $htmlLayout 	= '@cmsgears/module-core/common/mails/layouts/html';
    public $textLayout 	= '@cmsgears/module-core/common/mails/layouts/text';
    public $viewPath 	= '@cmsgears/module-community/common/mails/views';

	// Protected --------------

	// Private ----------------

	// Constructor and Initialisation ------------------------------

	// Instance methods --------------------------------------------

	// Yii parent classes --------------------

	// CMG parent classes --------------------

	// Mailer --------------------------------

	// Group Mails --------------

	public function sendCreateGroupMail( $group ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$email = Yii::$app->factory->get( 'groupService' )->getEmail( $group );

		if( !empty( $email ) ) {

			// Send Mail
			$this->getMailer()->compose( self::MAIL_GROUP_CREATE, [ 'coreProperties' => $this->coreProperties, 'group' => $group, 'email' => $email ] )
				->setTo( $email )
				->setFrom( [ $fromEmail => $fromName ] )
				->setSubject( "Group Registration | " . $this->coreProperties->getSiteName() )
				//->setTextBody( "text" )
				->send();
		}
	}

	public function sendRegisterGroupMail( $group, $admin ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$email = Yii::$app->factory->get( 'groupService' )->getEmail( $group );

		if( !empty( $email ) ) {

			// Send Mail
			$this->getMailer()->compose( self::MAIL_GROUP_REGISTER, [ 'coreProperties' => $this->coreProperties, 'group' => $group, 'email' => $email, 'admin' => $admin ] )
				->setTo( $group->email )
				->setFrom( [ $fromEmail => $fromName ] )
				->setSubject( "Group Registration | " . $this->coreProperties->getSiteName() )
				//->setTextBody( "text" )
				->send();
		}
	}

	// Group Member Mails -------

	public function sendCreateGroupMemberMail( $member, $group, $user ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$label = 'Member';

		// Send Mail
		$this->getMailer()->compose( self::MAIL_GROUP_MEMBER_CREATE, [ 'coreProperties' => $this->coreProperties, 'member' => $member, 'group' => $group, 'user' => $user ] )
			->setTo( $user->email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "$label Registration | " . $this->coreProperties->getSiteName() )
			//->setTextBody( "text" )
			->send();
	}

	public function sendRegisterGroupMemberMail( $member, $group, $user ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		$label = 'Member';

		// Send Mail
		$this->getMailer()->compose( self::MAIL_GROUP_MEMBER_REGISTER, [ 'coreProperties' => $this->coreProperties, 'member' => $member, 'group' => $group, 'user' => $user ] )
			->setTo( $user->email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "$label Registration | " . $this->coreProperties->getSiteName() )
			//->setTextBody( "text" )
			->send();
	}

	public function sendJoinGroupMemberMail( $member, $group, $user ) {

		$fromEmail	= $this->mailProperties->getSenderEmail();
		$fromName	= $this->mailProperties->getSenderName();

		// Send Mail
		$this->getMailer()->compose( self::MAIL_GROUP_MEMBER_JOIN, [ 'coreProperties' => $this->coreProperties, 'member' => $member, 'group' => $group, 'user' => $user ] )
			->setTo( $user->email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "Join Group Request | " . $this->coreProperties->getSiteName() )
			//->setTextBody( "text" )
			->send();
	}

	public function sendInviteGroupMemberMail( $member, $group, $user ) {

		$email		= $user->email;
		$fromEmail  = $this->mailProperties->getSenderEmail();
		$fromName   = $this->mailProperties->getSenderName();

		$label = 'Member';

		// Send Mail
		$this->getMailer()->compose( self::MAIL_GROUP_MEMBER_INVITE, [ 'coreProperties' => $this->coreProperties, 'member' => $member, 'group' => $group, 'user' => $user ] )
			->setTo( $email )
			->setFrom( [ $fromEmail => $fromName ] )
			->setSubject( "Become Group $label | " . $this->coreProperties->getSiteName() )
			->send();
	}

}
