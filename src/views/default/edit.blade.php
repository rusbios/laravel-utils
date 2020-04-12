<?php /** @var \Illuminate\Database\Eloquent\Model $entity */ ?>

<form name="admin-edit" action="{{ $url_save }}" method="POST">
    @method('put')
    @foreach($entity->getFillable() ?: array_keys($entity->getAttributes()) as $key)
        @continue(array_search($key, $entity->getHidden()) !== false)
        <div class="form-group">
            <label for="exampleForm{{ $key }}">{{ $key }}</label>
            <input type="text" class="form-control" id="exampleForm{{ $key }}" placeholder="{{ $key }}" value="{{ $entity->getAttribute($key) }}">
        </div>
    @endforeach
</form>
