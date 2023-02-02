<?php
declare(strict_types=1);
namespace Module\Core;

class Result
{
    public readonly bool $isError;
    private readonly array |string|null $error;
    private readonly mixed $value;
    function __construct(
        bool $isSuccess,
        mixed $value = null,
        array |string $error = null
    )
    {
        if ($isSuccess && $error) {
            throw new \ErrorException('OperacaoInvalida: O resultado nao pode ser valido e conter erro.');
        }


        if (!$isSuccess && !$error) {
            throw new \ErrorException('OperacaoInvalida: O resultado deve ser valido ou invalido.');
        }

        $this->error = $error;
        $this->isError = !$isSuccess;
        $this->value = $value;
    }

    public function getValue(): mixed
    {
        if ($this->isError)
            throw new \ErrorException('para retornar o erro, use a função getError.');
        return $this->value;
    }

    public static function ok(mixed $value = null): self
    {
        return new self(true, $value);
    }

    public static function fail(mixed $value): self
    {
        return new self(false, null, $value);
    }

    public static function combine(array $results): self
    {
        $errors = [];
        foreach ($results as $key => $result) {
            if ($result->isError) {
                $errors[] = ["arrayPosition" => $key, "error" => $result->getError()];
            }
        }

        return !empty($errors) ? self::fail($errors) : self::ok();
    }
}
