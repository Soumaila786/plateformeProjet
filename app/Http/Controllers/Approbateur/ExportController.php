<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportPdf(Projet $projet)
    {
        $this->authorize('view', $projet);

        // Augmenter le temps d'exécution
        set_time_limit(300);

        // Optimiser la mémoire
        ini_set('memory_limit', '512M');

        // Charger les relations nécessaires
        $projet->load([
            'secteur',
            'porteur',
            'activites',
            'planification',
            'commentaires.utilisateur',
        ]);

        // Configuration Dompdf
        $pdf = Pdf::loadView('approbateur.exports.projet_pdf', [
            'projet'     => $projet,
            'exportedBy' => Auth::user(),
            'exportedAt' => now()->format('d/m/Y à H:i'),
        ]);

        // Configuration du papier et des options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'isPhpEnabled' => false,
            'isFontSubsettingEnabled' => true,
            'tempDir' => storage_path('app/temp'),
            'chroot' => base_path(),
            'logOutputFile' => storage_path('logs/dompdf.log'),
            'debugKeepTemp' => false,
        ]);

        // Télécharger le PDF
        return $pdf->download('projet-' . $projet->codeProjet . '.pdf');
    }
}
