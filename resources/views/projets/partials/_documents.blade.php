@php
    $role = auth()->user()->role;
    $routeDownload = collect(['admin', 'approbateur', 'porteur'])
        ->first(fn ($r) => $r === $role && Route::has($r.'.projets.documents.download'));
@endphp

<x-cards.info titre="Documents" icon="fa-paperclip" class="mb-3">

    @forelse ($projet->documents as $document)
        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-file text-muted"></i>
                <div>
                    <div class="small fw-semibold">{{ $document->nomFichier }}</div>
                    <div class="text-muted" style="font-size:.72rem;">
                        Ajouté le {{ optional($document->dateUpload)->format('d/m/Y') }} par {{ $document->uploader->nomComplet ?? '—' }}
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                @if ($routeDownload)
                    <x-buttons.link :href="route($routeDownload.'.projets.documents.download', [$projet, $document])" variant="ghost" size="sm" icon="fa-download">
                        Télécharger
                    </x-buttons.link>
                @endif
                @if ($role === 'porteur' && $projet->isEditable())
                    <form action="{{ route('porteur.projets.documents.destroy', [$projet, $document]) }}" method="POST" onsubmit="return confirm('Supprimer ce document ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link btn-sm text-danger text-decoration-none">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted small mb-0">Aucun document ajouté.</p>
    @endforelse

    @if ($role === 'porteur' && $projet->isEditable())
        <form action="{{ route('porteur.projets.documents.store', $projet) }}" method="POST" enctype="multipart/form-data" class="mt-3 pt-3 border-top">
            @csrf
            <label class="form-label small">Ajouter des documents (pdf, doc, xls, images — 10 Mo max chacun)</label>
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label small mb-1">Fichier</label>
                    <input type="file" name="documents[]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label small mb-1">Nom à afficher (optionnel)</label>
                    <input type="text" name="document_names[]" class="form-control form-control-sm" maxlength="255" placeholder="Ex. Rapport financier 2026">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2">
                <x-buttons.button type="submit" variant="outline" size="sm">Ajouter</x-buttons.button>
            </div>
        </form>
    @endif
</x-cards.info>
