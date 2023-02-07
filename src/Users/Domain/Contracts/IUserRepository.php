<?php
namespace Module\Users\Domain\Contracts;

use Module\Core\Infrastructure\Database\IBaseReaderRepository;
use Module\Core\Infrastructure\Database\IBaseWriterRepository;

interface IUserRepository extends IBaseReaderRepository,IBaseWriterRepository
{

}
