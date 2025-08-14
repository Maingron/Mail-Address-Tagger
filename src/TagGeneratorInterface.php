<?php
namespace MailAddressTagger;

interface TagGeneratorInterface {
    public function generateTag(): string;
}
