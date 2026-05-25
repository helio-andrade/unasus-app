<?php

namespace App\Http\Controllers;

use App\Services\AlunoSpreadsheetImporter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;

class AlunoImportController extends Controller
{
    public function create(): View
    {
        return view('import.create');
    }

    public function store(Request $request, AlunoSpreadsheetImporter $importer): View
    {
        $data = $request->validate([
            'arquivo' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'arquivo.required' => 'Selecione um arquivo Excel.',
            'arquivo.file' => 'O upload deve ser um arquivo.',
            'arquivo.mimes' => 'Envie um arquivo .xlsx ou .xls.',
            'arquivo.max' => 'O arquivo deve ter no maximo 5 MB.',
        ]);

        try {
            $report = $importer->import($data['arquivo']->getRealPath());
        } catch (InvalidArgumentException|ReaderException $exception) {
            throw ValidationException::withMessages([
                'arquivo' => $exception->getMessage(),
            ]);
        }

        return view('import.result', [
            'filename' => $data['arquivo']->getClientOriginalName(),
            'report' => $report,
        ]);
    }
}
