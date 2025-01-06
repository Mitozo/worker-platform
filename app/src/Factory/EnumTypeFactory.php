<?php
namespace App\Factory;

use App\DBAL\EnumType;
use Doctrine\DBAL\Types\Type;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EnumTypeFactory
{
    private ParameterBagInterface $params;
    private LoggerInterface $logger;

    public function __construct(ParameterBagInterface $params, LoggerInterface $logger)
    {
        $this->params = $params;
        $this->logger = $logger;
    }

    public function registerEnumTypes(): void
    {
        $enumTypes = $this->params->get('enum_types'); // Fetch from parameters

        foreach ($enumTypes as $name => $values) {
            if (!Type::hasType($name)) {
                EnumType::registerEnumType($name, $values);
                $this->logger->info("Registered ENUM type: $name with values: ", $values);
            }
        }
    }
}

