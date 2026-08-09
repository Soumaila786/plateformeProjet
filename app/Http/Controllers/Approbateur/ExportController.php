<?php

namespace App\Http\Controllers\Approbateur;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExportController extends Controller {

    public function exportPdf(Projet $projet) {

        try {
            $this->authorize('view', $projet);

            Log::info('Tentative d’exportation PDF d’un projet', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'user_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            set_time_limit(300);
            ini_set('memory_limit', '512M');

            // NOTE : 'planifications' retirée (relation supprimée, fusionnée dans 'activites',
            // déjà présente dans cette liste — c'était un doublon)
            $projet->load([
                'secteur',
                'porteur',
                'activites',
                'commentaires.utilisateur',
            ]);

            $pdf = Pdf::loadView('approbateur.exports.projet_pdf', [
                'projet'     => $projet,
                'exportedBy' => Auth::user(),
                'exportedAt' => now()->format('d/m/Y à H:i'),
            ]);

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

            Log::info('Exportation PDF réussie', [
                'projet_id' => $projet->id,
                'code_projet' => $projet->codeProjet,
                'user_id' => Auth::id(),
                'nom_fichier' => 'projet-' . $projet->codeProjet . '.pdf'
            ]);

            return $pdf->download('projet-' . $projet->codeProjet . '.pdf');

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {

            Log::warning('Tentative non autorisée d’exportation PDF', [
                'projet_id' => $projet->id,
                'user_id' => Auth::id(),
                'ip' => request()->ip()
            ]);

            abort(403, 'Accès non autorisé.');

        } catch (\Exception $e) {

            Log::error('Erreur lors de l’exportation du projet en PDF', [
                'projet_id' => $projet->id ?? null,
                'code_projet' => $projet->codeProjet ?? null,
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
                'ip' => request()->ip()
            ]);

            return back()->with('error', 'Une erreur est survenue lors de l’exportation du PDF.');
        }
    }
}
