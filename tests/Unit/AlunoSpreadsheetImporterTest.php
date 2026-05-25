<?php

namespace Tests\Unit;

use App\Services\AlunoSpreadsheetImporter;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class AlunoSpreadsheetImporterTest extends TestCase
{
    public function test_it_validates_students_from_spreadsheet(): void
    {
        $path = $this->makeSpreadsheet([
            ['Nome', 'CPF', 'Email', 'Telefone'],
            ['Ana Silva', '12345678909', 'ana.silva@email.com', '98999990001'],
            ['Bruno Souza', '11111111111', 'bruno.souzaemail.com', '98999990002'],
            ['', '22222222222', 'carla@email.com', '98999990003'],
            ['Joao Pedro', '88888888888', 'joao@email', '98999990008'],
        ]);

        try {
            $report = app(AlunoSpreadsheetImporter::class)->import($path);
        } finally {
            @unlink($path);
        }

        $this->assertSame(4, $report['summary']['total']);
        $this->assertSame(1, $report['summary']['valid']);
        $this->assertSame(3, $report['summary']['invalid']);

        $this->assertTrue($report['rows'][0]['valid']);
        $this->assertArrayHasKey('cpf', $report['rows'][1]['errors']);
        $this->assertArrayHasKey('email', $report['rows'][1]['errors']);
        $this->assertArrayHasKey('nome', $report['rows'][2]['errors']);
        $this->assertArrayHasKey('email', $report['rows'][3]['errors']);
    }

    public function test_it_requires_expected_headers(): void
    {
        $path = $this->makeSpreadsheet([
            ['Nome', 'CPF', 'Email'],
            ['Ana Silva', '12345678909', 'ana.silva@email.com'],
        ]);

        try {
            $this->expectException(InvalidArgumentException::class);
            $this->expectExceptionMessage('Telefone');

            app(AlunoSpreadsheetImporter::class)->import($path);
        } finally {
            @unlink($path);
        }
    }

    /**
     * @param  array<int, array<int, string>>  $rows
     */
    private function makeSpreadsheet(array $rows): string
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($rows as $rowIndex => $row) {
            foreach ($row as $columnIndex => $value) {
                $sheet->setCellValue([$columnIndex + 1, $rowIndex + 1], $value);
            }
        }

        $path = sys_get_temp_dir().DIRECTORY_SEPARATOR.'alunos_'.uniqid().'.xlsx';

        (new Xlsx($spreadsheet))->save($path);
        $spreadsheet->disconnectWorksheets();

        return $path;
    }
}
