@foreach ($menus as $menu)
  @if (empty($menu['childrens']))
    <li class=""><a href="{{ $menu['slug'] }}" title="{{ $menu['title'] }}">{{ $menu['name'] }}</a></li>
  @else
    <li class="dropdown">
      <a href="#" title="{{ $menu['title'] }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ $menu['name'] }} <span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">
        @foreach ($menu['childrens'] as $children)
          <li><a href="{{ $children['slug'] }}" title="{{ $children['title'] }}">{{ $children['name'] }}</a></li>
        @endforeach
      </ul>
    </li>
  @endif
@endforeach
