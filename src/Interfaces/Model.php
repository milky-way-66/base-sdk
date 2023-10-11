<?php 

namespace MilkyWay\BaseSdk\Interfaces;

interface Model {

    public function feilds(): array;

    public function validate(): bool;

    public function endpoint(): string;

    public function data():array;

    public function identify():array;
}