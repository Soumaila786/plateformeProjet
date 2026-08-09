<div id="modalUserForm" class="lp-modal-overlay">
    <div class="lp-modal-box lp-modal-lg">
        <div class="lp-modal-head">
            <h3 class="lp-modal-title" data-modal-titre>Nouvel utilisateur</h3>
            <button onclick="closeModal('modalUserForm')" class="lp-modal-close"><i class="fas fa-times"></i></button>
        </div>

        {{-- action/méthode basculés en JS selon "Nouveau" ou "Modifier" --}}
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <input type="hidden" name="_method" value="" data-modal-method>

            <div class="lp-modal-body">
                @include('users.partials._form')
            </div>

            <div class="lp-modal-foot">
                <button type="button" onclick="closeModal('modalUserForm')" class="btn btn-light btn-sm">Annuler</button>
                <button type="submit" class="btn btn-primary btn-sm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('js/users-form.js') }}"></script>
@endpush
