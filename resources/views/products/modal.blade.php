<!-- Modal -->
<div class="container">
    <div class="modal fade" id="stockModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Iniciar Stock</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="{{route('product.stock')}}" method="POST">
                      @csrf
                      @method('PUT')
                      <input type="hidden" value="" name="id_product" id="id_product">
                      <div class="form-group">
                        <label for="stock">Cantidad Inicial</label>
                        <input type="number" class="form-control" id="stock" placeholder="00" name="stock">
                      </div>
                      @error('stock')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      <div class="form-group">
                        <label for="price">Precio de Venta</label>
                        <input type="number" class="form-control" id="price" placeholder="00" name="price">
                      </div>
                      @error('price')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      
                      <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </form>
                
            </div>
           
              
            
          </div>
        </div>
      </div>
</div>