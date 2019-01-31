<?php
// Yii Imports
use yii\helpers\Html;
use yii\helpers\Url;

$siteProperties = Yii::$app->controller->getSiteProperties();

$defaultIncludes = Yii::getAlias( '@cmsgears' ) . '/module-core/common/mails/views/includes';

$groupName	= Html::encode( $group->name );
$groupEmail	= Html::encode( $group->getEmail() );

$name	= Html::encode( $user->getName() );
$email	= Html::encode( $user->email );
$role	= Html::encode( $member->role->name );
$token	= Html::encode( $user->verifyToken );

$siteName	= Html::encode( $coreProperties->getSiteName() );
$logoUrl	= Url::to( "@web/images/" . $siteProperties->getMailAvatar(), true );
$siteUrl	= Html::encode( $coreProperties->getSiteUrl() );
$siteBkg	= "$siteUrl/images/" . $siteProperties->getMailBanner();
$homeUrl	= $siteUrl;

$confirmLink = "$siteUrl/activate-account?token=$token&email=$email";
?>
<?php include "$defaultIncludes/header.php"; ?>
<table cellspacing="0" cellpadding="0" border="0" margin="0" padding="0" width="80%" align="center" class="ctmax">
	<tr><td height="40"></td></tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">Dear <?= $name ?>,</font></td>
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td>
			<font face="Roboto, Arial, sans-serif">Your account is being created at <?= $siteName ?>. Your account details are as mentioned below:</font>
		</td>
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">Group Name: <?= $groupName ?></font></td>
	</tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">Group Email: <?= $groupEmail ?></font></td>
	</tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">User Name: <?= $name ?></font></td>
	</tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">User Email: <?= $email ?></font></td>
	</tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">Role in Group: <?= $role ?></font></td>
	</tr>
	<tr><td height="20"></td></tr>
	<tr>
		<td><font face="Roboto, Arial, sans-serif">Activation Link: <a href="<?= $confirmLink ?>">Activate Account</a></font></td>
	</tr>
	<tr><td height="40"></td></tr>
</table>
<?php include "$defaultIncludes/footer.php"; ?>
