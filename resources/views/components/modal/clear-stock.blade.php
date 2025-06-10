@props(['product'])

<!-- Modal -->
<div class="modal fade" id="clearStockModal-{{ $product->id }}" tabindex="-1" aria-labelledby="clearStockModalLabel-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="clearStockModalLabel-{{ $product->id }}">
                    Svuota magazzino: {{ $product->name }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
            </div>
            <div class="modal-body">
                Sei sicuro di voler <strong>azzerare completamente</strong> lo stock di <strong>{{ $product->name }}</strong>?
                <p class="mb-0">Questa azione non può essere annullata.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn reset-btn" data-bs-dismiss="modal">Annulla</button>
                <form method="POST" action="{{ route('admin.products.clearStock', $product) }}">
                    @csrf
                    <button type="submit" class="btn confirm-delete-btn">Conferma svuotamento</button>
                </form>
            </div>
        </div>
    </div>
</div>