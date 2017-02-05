<?php
namespace ZeroConfig\Preacher\Tests\Generator;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit_Framework_MockObject_MockObject;
use Twig_Environment;
use ZeroConfig\Preacher\Generator\Generator;
use ZeroConfig\Preacher\Generator\OutputWriterInterface;
use ZeroConfig\Preacher\Generator\SourceReaderInterface;
use ZeroConfig\Preacher\Output\MetaDataInterface as OutputMetaData;
use ZeroConfig\Preacher\Output\Output;
use ZeroConfig\Preacher\Output\OutputFactoryInterface;
use ZeroConfig\Preacher\Output\OutputInterface;
use ZeroConfig\Preacher\Output\UpdatedOutput;
use ZeroConfig\Preacher\Source\MetaDataInterface as SourceMetaData;
use ZeroConfig\Preacher\Source\SourceInterface;
use ZeroConfig\Preacher\Template\TemplateFactoryInterface;
use ZeroConfig\Preacher\Template\TemplateInterface;

/**
 * @coversDefaultClass \ZeroConfig\Preacher\Generator\Generator
 */
class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Generator
     * @covers ::__construct
     */
    public function testConstructor(): Generator
    {
        /** @noinspection PhpParamsInspection */
        return new Generator(
            $this->createMock(OutputFactoryInterface::class),
            $this->createMock(TemplateFactoryInterface::class),
            $this->createMock(SourceReaderInterface::class),
            $this->createMock(Twig_Environment::class),
            $this->createMock(OutputWriterInterface::class)
        );
    }

    /**
     * @param DateTimeInterface $dateUpdated
     *
     * @return PHPUnit_Framework_MockObject_MockObject|SourceInterface
     */
    private function createSource(
        DateTimeInterface $dateUpdated
    ) {
        $source   = $this->createMock(SourceInterface::class);
        $metaData = $this->createMock(SourceMetaData::class);

        $source
            ->expects($this->once())
            ->method('getMetaData')
            ->willReturn($metaData);

        $metaData
            ->expects($this->once())
            ->method('getDateUpdated')
            ->willReturn($dateUpdated);

        return $source;
    }

    /**
     * @param DateTimeInterface $dateGenerated
     *
     * @return PHPUnit_Framework_MockObject_MockObject|OutputInterface
     */
    private function createOutput(
        DateTimeInterface $dateGenerated
    ) {
        $output   = $this->createMock(OutputInterface::class);
        $metaData = $this->createMock(OutputMetaData::class);

        $output
            ->expects($this->any())
            ->method('getMetaData')
            ->willReturn($metaData);

        $metaData
            ->expects($this->once())
            ->method('getDateGenerated')
            ->willReturn($dateGenerated);

        $metaData
            ->expects($this->any())
            ->method('getDatePublished')
            ->willReturn(new DateTimeImmutable());

        return $output;
    }

    /**
     * @param DateTimeInterface $dateUpdated
     * @param string|null       $path
     *
     * @return PHPUnit_Framework_MockObject_MockObject|TemplateInterface
     */
    private function createTemplate(
        DateTimeInterface $dateUpdated,
        string $path = null
    ) {
        $template = $this->createMock(TemplateInterface::class);

        $template
            ->expects($this->any())
            ->method('getDateUpdated')
            ->willReturn($dateUpdated);

        if ($path !== null) {
            $template
                ->expects($this->once())
                ->method('getPath')
                ->willReturn($path);
        }

        return $template;
    }

    /**
     * @param SourceInterface $source
     * @param OutputInterface $output
     *
     * @return PHPUnit_Framework_MockObject_MockObject|OutputFactoryInterface
     */
    private function createOutputFactory(
        SourceInterface $source,
        OutputInterface $output
    ) {
        $factory = $this->createMock(OutputFactoryInterface::class);

        $factory
            ->expects($this->once())
            ->method('createOutput')
            ->with($source)
            ->willReturn($output);

        return $factory;
    }

    /**
     * @param OutputInterface   $output
     * @param TemplateInterface $template
     *
     * @return PHPUnit_Framework_MockObject_MockObject|TemplateFactoryInterface
     */
    private function createTemplateFactory(
        OutputInterface $output,
        TemplateInterface $template
    ) {
        $factory = $this->createMock(TemplateFactoryInterface::class);

        $factory
            ->expects($this->once())
            ->method('createTemplate')
            ->with($output)
            ->willReturn($template);

        return $factory;
    }

    /**
     * @return Output|OutputInterface
     * @covers ::generate
     */
    public function testGenerateUpToDateOutput()
    {
        $writer = $this->createMock(OutputWriterInterface::class);
        $reader = $this->createMock(SourceReaderInterface::class);
        $twig   = $this->createMock(Twig_Environment::class);

        $writer->expects($this->never())->method('writeOutput');
        $reader->expects($this->never())->method('getContents');
        $twig->expects($this->never())->method('render');

        $source   = $this->createSource(new DateTimeImmutable('yesterday'));
        $template = $this->createTemplate(new DateTimeImmutable('yesterday'));
        $output   = $this->createOutput(new DateTimeImmutable('today'));

        $outputFactory   = $this->createOutputFactory($source, $output);
        $templateFactory = $this->createTemplateFactory($output, $template);

        /** @noinspection PhpParamsInspection */
        $generator = new Generator(
            $outputFactory,
            $templateFactory,
            $reader,
            $twig,
            $writer
        );

        return $generator->generate($source);
    }

    /**
     * @return UpdatedOutput|OutputInterface
     * @covers ::generate
     */
    public function testGenerateOutdatedOutput(): UpdatedOutput
    {
        $writer = $this->createMock(OutputWriterInterface::class);
        $reader = $this->createMock(SourceReaderInterface::class);
        $twig   = $this->createMock(Twig_Environment::class);

        $reader->expects($this->once())->method('getContents');
        $writer->expects($this->once())->method('writeOutput');

        $twig
            ->expects($this->once())
            ->method('render')
            ->with(
                $this->isType('string'),
                $this->isType('array')
            )
            ->willReturn('FooBarBaz');

        $source   = $this->createSource(new DateTimeImmutable('now'));
        $output   = $this->createOutput(new DateTimeImmutable('today'));
        $template = $this->createTemplate(
            new DateTimeImmutable('yesterday'),
            'default.html.twig'
        );

        $outputFactory   = $this->createOutputFactory($source, $output);
        $templateFactory = $this->createTemplateFactory($output, $template);

        /** @noinspection PhpParamsInspection */
        $generator = new Generator(
            $outputFactory,
            $templateFactory,
            $reader,
            $twig,
            $writer
        );

        return $generator->generate($source);
    }
}
