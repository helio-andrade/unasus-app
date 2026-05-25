<?php

namespace App\Services;

use App\Rules\ValidCpf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AlunoSpreadsheetImporter
{
    /**
     * @return array{
     *     summary: array{total: int, valid: int, invalid: int},
     *     rows: array<int, array{
     *         line: int,
     *         data: array{nome: string, cpf: string, email: string, telefone: string},
     *         valid: bool,
     *         errors: array<string, array<int, string>>
     *     }>
     * }
     */
    public function import(string $path): array
    {
        $reader = IOFactory::createReaderForFile($path);
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getSheet(0);
        $headers = $this->resolveHeaders($worksheet);

        $rows = [];
        $valid = 0;
        $invalid = 0;

        for ($line = 2; $line <= $worksheet->getHighestDataRow(); $line++) {
            $data = [
                'nome' => $this->cellValue($worksheet, $headers['nome'], $line),
                'cpf' => $this->cellValue($worksheet, $headers['cpf'], $line),
                'email' => $this->cellValue($worksheet, $headers['email'], $line),
                'telefone' => $this->cellValue($worksheet, $headers['telefone'], $line),
            ];

            if ($this->isBlankRow($data)) {
                continue;
            }

            $validator = Validator::make($data, [
                'nome' => ['bail', 'required', 'string'],
                'cpf' => ['bail', 'required', 'regex:/^\d{11}$/', new ValidCpf],
                'email' => ['bail', 'required', 'email', 'regex:/^[^@\s]+@[^@\s]+\.[^@\s]{2,}$/'],
                'telefone' => ['bail', 'required', 'regex:/^\d+$/'],
            ], [
                'nome.required' => 'Nome nao pode estar vazio.',
                'cpf.required' => 'CPF deve ser informado.',
                'cpf.regex' => 'CPF deve conter exatamente 11 digitos numericos.',
                'email.required' => 'E-mail deve ser informado.',
                'email.email' => 'E-mail possui formato invalido.',
                'email.regex' => 'E-mail deve conter dominio completo.',
                'telefone.required' => 'Telefone deve ser informado.',
                'telefone.regex' => 'Telefone deve conter apenas numeros.',
            ]);

            $rowIsValid = $validator->passes();
            $errors = $validator->errors()->toArray();

            $rowIsValid ? $valid++ : $invalid++;

            $rows[] = [
                'line' => $line,
                'data' => $data,
                'valid' => $rowIsValid,
                'errors' => $errors,
            ];
        }

        return [
            'summary' => [
                'total' => count($rows),
                'valid' => $valid,
                'invalid' => $invalid,
            ],
            'rows' => $rows,
        ];
    }

    /**
     * @return array{nome: int, cpf: int, email: int, telefone: int}
     */
    private function resolveHeaders(Worksheet $worksheet): array
    {
        $map = [];

        for ($column = 1; $column <= 10; $column++) {
            $header = $this->normalizeHeader($this->cellValue($worksheet, $column, 1));

            if ($header !== '') {
                $map[$header] = $column;
            }
        }

        $required = [
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'email' => 'Email',
            'telefone' => 'Telefone',
        ];

        $headers = [];

        foreach ($required as $key => $label) {
            if (! isset($map[$key])) {
                throw new InvalidArgumentException("Cabecalho obrigatorio ausente: {$label}.");
            }

            $headers[$key] = $map[$key];
        }

        return $headers;
    }

    private function normalizeHeader(string $header): string
    {
        return Str::of($header)
            ->ascii()
            ->lower()
            ->replace(['-', '_', ' '], '')
            ->toString();
    }

    private function cellValue(Worksheet $worksheet, int $column, int $row): string
    {
        $value = $worksheet->getCell([$column, $row])->getFormattedValue();

        return trim((string) $value);
    }

    /**
     * @param  array<string, string>  $data
     */
    private function isBlankRow(array $data): bool
    {
        foreach ($data as $value) {
            if ($value !== '') {
                return false;
            }
        }

        return true;
    }
}
