<?php

namespace Alura\Pdo\Domain\Model;

class Student
{   
    /** @var Phone[]*/
    private array $phones = [];
    public function __construct(
        private ?int $id, 
        private string $name,
        private \DateTimeInterface $birthDate
    ) {
    }

    public function defineId(int $id): void 
    {
        if(!is_null($this->id)) {
            throw new \DomainException("Você Só pode definir o Id uma vez");
        }
        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }

    /** @return Phone[] */
    public function phones(): array 
    {
        return $this->phones;
    }

}
