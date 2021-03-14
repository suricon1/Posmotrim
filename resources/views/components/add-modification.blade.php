<div class="modal fade" id="modificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {{Form::open(['route' => 'products.modification.add', 'id' => 'modificAdd'])}}
            {{Form::hidden('product_id', $productId)}}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить модификацию продукта</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Модификация</label>
                    {{Form::select('modification_id',
                        $modifications,
                        null,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width: 100%',
                            'placeholder' => 'Выбрать модификацию'
                        ])
                    }}
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail2">Цена</label>
                    <input type="number" name="price" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail3">Колличество</label>
                    <input type="number" name="quantity" class="form-control" id="exampleInputEmail3" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
