<?php

namespace App\Model;

interface TimestampedInterface
{
    public function getCreationDate(): ?\DateTimeInterface;

    public function setCreationDate(\DateTimeInterface $creation_date): self;

    public function getUpdateDate(): ?\DateTimeInterface;

    public function setUpdateDate(\DateTimeInterface $update_date): self;
}