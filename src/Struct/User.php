<?php

namespace TeamdriveManager\Struct;

class User
{
    public $mail;
    public $role;
    public $excluded;
    public $whitelist;

    public function __construct(string $mail, string $role, array $excluded, array $whitelist)
    {
        $this->mail = $mail;
        $this->role = $role;
        $this->excluded = $excluded;
        $this->whitelist = $whitelist;
    }

    public static function fromConfig(array $config): array
    {
        /** @var User[] $users */
        $users = [];
        foreach ($config['users'] as $mail => $role) {
            $blackList = [];
            foreach ($config['blacklist'] as $driveName => $mailList) {
                if (in_array($mail, $mailList, true)) {
                    $blackList[] = $driveName;
                }
            }

            $whiteList = [];
            foreach ($config['whitelist'] as $driveName => $mailList) {
                if (in_array($mail, $mailList, true)) {
                    $whiteList[] = $driveName;
                }
            }

            $users[] = new User($mail, $role, $blackList, $whiteList);
        }

        return $users;
    }
}
