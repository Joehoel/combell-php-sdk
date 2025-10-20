<?php

namespace Joehoel\Combell\Resource;

use Joehoel\Combell\Requests\Mailboxes\ChangeMailboxPassword;
use Joehoel\Combell\Requests\Mailboxes\ConfigureMailboxAutoForward;
use Joehoel\Combell\Requests\Mailboxes\ConfigureMailboxAutoReply;
use Joehoel\Combell\Requests\Mailboxes\CreateMailbox;
use Joehoel\Combell\Requests\Mailboxes\DeleteMailbox;
use Joehoel\Combell\Requests\Mailboxes\GetMailbox;
use Joehoel\Combell\Requests\Mailboxes\GetMailboxes;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Mailboxes extends BaseResource
{
    /**
     * @param  string  $domainName  Obligated domain name for getting mailboxes.
     */
    public function getMailboxes(?string $domainName = null): Response
    {
        return $this->connector->send(new GetMailboxes($domainName));
    }

    public function createMailbox(): Response
    {
        return $this->connector->send(new CreateMailbox);
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function getMailbox(string $mailboxName): Response
    {
        return $this->connector->send(new GetMailbox($mailboxName));
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function deleteMailbox(string $mailboxName): Response
    {
        return $this->connector->send(new DeleteMailbox($mailboxName));
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function changeMailboxPassword(string $mailboxName): Response
    {
        return $this->connector->send(new ChangeMailboxPassword($mailboxName));
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function configureMailboxAutoReply(string $mailboxName): Response
    {
        return $this->connector->send(new ConfigureMailboxAutoReply($mailboxName));
    }

    /**
     * @param  string  $mailboxName  Mailbox name.
     */
    public function configureMailboxAutoForward(string $mailboxName): Response
    {
        return $this->connector->send(new ConfigureMailboxAutoForward($mailboxName));
    }
}
