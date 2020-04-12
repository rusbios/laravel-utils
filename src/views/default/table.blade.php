<?php /** @var \RusBios\LUtils\Services\Table $table */ ?>
<form name="admin-form" action="" method="GET">
<table class="table table-hover">
    <thead>
    <tr>
        @foreach($table->getHeaders() as $header)
            <th scope="col">
                {{ $header['name'] }}
                @switch($header['order'])
                    @case('asc')
                    <a class="btn text-link" href="{{ $table->getUrl(['order' => [$header['key'] => 'desc']]) }}"><i class="fas fa-sort-down"></i></a>
                    @break

                    @case('desc')
                    <a class="btn text-link" href="{{ $table->getUrl(['order' => [$header['key'] => null]]) }}"><i class="fas fa-sort-up"></i></a>
                    @break

                    @default
                    <a class="btn btn-link" href="{{ $table->getUrl(['order' => [$header['key'] => 'asc']]) }}"><i class="fas fa-sort"></i></a>

                @endswitch
                <input type="hidden" name="order[{{ $header['key'] }}]" value="{{ $header['order'] }}">
                @if($header['from'])
                    <input onblur="console.log(document.getElementsByName('admin-form')[0].submit())"
                           type="{{ $header['from'] }}" name="search[{{ $header['key'] }}]" title="{{ $header['name'] }}"
                           value="{{ $header['search'] }}" class="form-control form-control-sm">
                @endif
            </th>
        @endforeach
        <th>
            <a href="" class="btn btn-outline-primary" title="Новая сущность"><i class="fas fa-plus-circle"></i></a>
            <button type="submit" class="btn btn-info" title="Обновить"><i class="fas fa-sync-alt"></i></button>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($table->getRows() as $key => $tr)
        <tr>
            <th scope="row">{{ $key }}</th>
            @foreach($tr as $td)
                <td>{!! $td !!}</td>
            @endforeach
            <td>
                @foreach($table->getButtons() as $button)
                    <a href="{{ sprintf($button['link_pattern'], $key) }}"
                       class="btn btn-{{ $button['color'] }} btn-sm" title="{{ $button['title'] }}">
                        {!! $button['icon'] ?: $button['title'] !!}
                    </a>
                @endforeach
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</form>

<?php $pagination = $table->getPagination() ?>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        @if($pagination)
        <li class="page-item @empty($pagination['left']) disabled @endif">
            <a class="page-link" href="{{ $pagination['left'] }}" aria-label="Назад" @empty($pagination['left']) tabindex="-1" aria-disabled="true" @endif>
                <i class="fas fa-angle-double-left"></i>
            </a>
        </li>
        @foreach($pagination['lists'] as $n => $link)
            <li class="page-item @if($pagination['list'] == $n) active @endif">
                <a class="page-link" href="{{ $link }}">{{ $n }}</a>
            </li>
        @endforeach
        <li class="page-item @empty($pagination['right']) disabled @endif">
            <a class="page-link" href="{{ $pagination['right'] }}" aria-label="Вперёд" @empty($pagination['right']) tabindex="-1" aria-disabled="true" @endif>
                <i class="fas fa-angle-double-right"></i>
            </a>
        </li>
        @endif
        <li>
            <p class="ml-5 pt-2">Всего найдено элементов: <strong>{{ $table->getAllCount() }}</strong></p>
        </li>
    </ul>
</nav>
