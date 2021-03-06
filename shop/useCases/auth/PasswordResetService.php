<?php

namespace shop\useCases\auth;

use DomainException;
use RuntimeException;
use shop\entities\User\User;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use shop\repositories\UserRepository;
use Yii;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $mailer;
    
    private $users;
    
    public function __construct(UserRepository $users, MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }
    
    public function request(PasswordResetRequestForm $form): void
    {
        $user = $this->users->getByEmail($form->email);
        
        if (!$user->isActive()) {
            throw new DomainException('User is not active.');
        }
        
        $user->requestPasswordReset();
        $this->users->save($user);
        
        $sent = $this->mailer
            ->compose(
                ['html' => 'auth/reset/confirm-html', 'text' => 'auth/reset/confirm-text'],
                ['user' => $user]
            )
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        
        if (!$sent) {
            throw new RuntimeException('Sending error.');
        }
    }
    
    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new DomainException('Password reset token cannot be blank.');
        }
        if (!$this->users->existsByPasswordResetToken($token)) {
            throw new DomainException('Wrong password reset token.');
        }
    }
    
    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }
    
    private function getByEmail(string $email): User
    {
        if (!$user = User::findOne(['email' => $email])) {
            throw new DomainException('User is not found.');
        }
        
        return $user;
    }
    
    private function existsByPasswordResetToken(string $token): User
    {
        return (bool)User::findByPasswordResetToken($token);
    }
    
    private function getByPasswordResetToken(string $token): User
    {
        if (!$user = User::findByPasswordResetToken($token)) {
            throw new DomainException('User is not found.');
        }
        
        return $user;
    }
    
    private function save(User $user): void
    {
        if (!$user->save()) {
            throw new RuntimeException('Saving error.');
        }
    }
}