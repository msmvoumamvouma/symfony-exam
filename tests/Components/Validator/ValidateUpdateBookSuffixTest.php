<?php

namespace App\Tests\Components\Validator;

use App\Model\UpdateBookSuffix;
use App\Service\FactorySerializer;
use App\Tests\Components\Utilities\ComponentFactory;
use App\Validator\BaseValidation;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ValidateUpdateBookSuffixTest extends TestCase
{
    private BaseValidation $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = new BaseValidation(ComponentFactory::createValidator(), UpdateBookSuffix::class, []);
    }

    /**
     * @throws Exception
     */
    private function makeDeserializeToUpdateBookSuffix(?string $stringJsonData): ?UpdateBookSuffix
    {
        $serializer = FactorySerializer::ofSerializerFromAnnotation();

        return $serializer->deserialize($stringJsonData, UpdateBookSuffix::class, 'json');
    }

    public function testRightData()
    {
        $stringJsonData = '{"suffix":"xx"}';
        $suffix = $this->makeDeserializeToUpdateBookSuffix($stringJsonData);

        $violationMessage = $this->validator->validate($suffix);
        self::assertCount(0, $violationMessage);
    }

    public function testWithoutPropertySuffix()
    {
        $stringJsonData = '{}';

        $suffix = $this->makeDeserializeToUpdateBookSuffix($stringJsonData);

        $violationMessage = $this->validator->validate($suffix);
        $errorMessage = ['suffix This value should not be null.'];

        self::assertEquals($errorMessage, array_values($violationMessage));
    }

    public function testWithoutBracket()
    {
        $this->expectException(NotEncodableValueException::class);
        $stringJsonData = '';

        $this->makeDeserializeToUpdateBookSuffix($stringJsonData);
    }

    public function testWithNullValueForJsonData()
    {
        $this->expectException(\TypeError::class);
        $stringJsonData = null;

        $this->makeDeserializeToUpdateBookSuffix($stringJsonData);
    }
}
