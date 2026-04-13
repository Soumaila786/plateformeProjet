<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller {

    public function index(Request $request) {

        $path = storage_path('logs/laravel.log');

        if (!File::exists($path)) {
            return back()->with('error', 'Fichier de logs introuvable');
        }

        //  lire tout le fichier
        $lines = file($path);

        // inverser pour avoir les derniers logs en premier
        $lines = array_reverse($lines);

        $logs = [];

        foreach ($lines as $line) {

            // ignorer lignes vides
            if (trim($line) === '') continue;

            $logs[] = $this->parseLogLine($line);
        }

        //  FILTRE par type (INFO, ERROR, WARNING)
        if ($request->type) {
            $logs = array_filter($logs, function ($log) use ($request) {
                return isset($log['level']) && str_contains($log['level'], strtoupper($request->type));
            });
        }

        // recherche texte
        if ($request->search) {
            $search = $request->search;

            $logs = array_filter($logs, function ($log) use ($search) {
                return str_contains($log['message'], $search);
            });
        }

        // limiter affichage
        $logs = array_slice($logs, 0, 200);

        return view('admin.logs.index', compact('logs'));
    }

    //transformer une ligne brute Laravel en structure exploitable
    private function parseLogLine($line) {

        preg_match("/\[(.*?)\]\s(\w+)\.(\w+):\s(.*)/", $line, $matches);

        return [
            'date'    => $matches[1] ?? null,
            'env'     => $matches[2] ?? null,
            'level'   => $matches[3] ?? null,
            'message' => $matches[4] ?? $line,
        ];
    }
}
