<?php
namespace cmsgears\community\common\components;

// Yii Imports
use \Yii;

/**
 * The mail component used for sending possible mails by the CMSGears core module. It must be initialised 
 * for app using the name cmgCoreMailer. It's used by various controllers to trigger mails.  
 */
class Mailer extends \cmsgears\core\common\base\Mailer {

	const MAIL_ACCOUNT_CREATE	= "account-create";	
	const MAIL_GROUP_INVITE		= "group-invite";		
	 
    public $htmlLayout 			= '@cmsgears/module-community/common/mails/layouts/html';
    public $textLayout 			= '@cmsgears/module-community/common/mails/layouts/text';
    public $viewPath 			= '@cmsgears/module-community/common/mails/views';

	/**
	 * The method sends mail for accounts created by group admin.
	 */
	public function sendCreateUserMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_ACCOUNT_CREATE, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
            ->setTo( $user->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Registration | " . $this->coreProperties->getSiteName() )
            //->setTextBody( "heroor" )
            ->send();
	}	
	
	/**
	 * The method sends mail for accounts created by group admin.
	 */
	public function sendInvitationMail( $user ) {

		$fromEmail 	= $this->mailProperties->getSenderEmail();
		$fromName 	= $this->mailProperties->getSenderName();

		// Send Mail
        $this->getMailer()->compose( self::MAIL_GROUP_INVITE, [ 'coreProperties' => $this->coreProperties, 'user' => $user ] )
            ->setTo( $user->email )
            ->setFrom( [ $fromEmail => $fromName ] )
            ->setSubject( "Registration | " . $this->coreProperties->getSiteName() )
            //->setTextBody( "heroor" )
            ->send();
	}	
}

?>