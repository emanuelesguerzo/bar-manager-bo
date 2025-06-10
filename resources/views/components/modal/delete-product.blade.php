@props(['product'])

<div class="modal fade" id="destroyModal-{{ $product->id }}" tabindex="-1" aria-labelledby="destroyModalLabel-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="destroyModalLabel-{{ $product->id }}">Elimina il Prodotto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Vuoi davvero eliminare il prodotto <strong>{{ $product->name }}</strong>?
                <p class="mb-0">Questa azione non può essere annullata.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn reset-btn" data-bs-dismiss="modal">Annulla</button>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn confirm-delete-btn" value="Elimina">
                </form>
            </div>
        </div>
    </div>
</div>